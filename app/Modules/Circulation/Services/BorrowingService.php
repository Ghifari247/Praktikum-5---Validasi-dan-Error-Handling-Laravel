<?php

namespace Modules\Circulation\Services;

use Illuminate\Support\Facades\DB;
use RuntimeException;
use Modules\Circulation\Models\Borrowing;
use Modules\Circulation\Models\BorrowingDetail;
use Modules\Circulation\Events\BookBorrowed;
use Modules\Shared\Contracts\BookServiceInterface;
use Modules\Shared\ValueObjects\Fine;
use Modules\Membership\Models\Member;

class BorrowingService
{
    public function __construct(
        private BookServiceInterface $bookService
    ) {}

    // MEMBUAT PEMINJAMAN
    public function createBorrowing(int $memberId, array $items): Borrowing
    {
        $member = Member::find($memberId);

        if (!$member || $member->status !== 'active') {
            throw new RuntimeException(
                'Anggota tidak ditemukan atau tidak aktif'
            );
        }

        $borrowedItems = [];

        $borrowing = DB::transaction(function () use (
            $memberId,
            $items,
            &$borrowedItems
        ) {
            $borrowing = Borrowing::create([
                'member_id' => $memberId,
                'borrowed_at' => now(),
                'due_date' => now()->addDays(7),
                'status' => 'borrowed',
                'fine_amount' => 0,
            ]);

            foreach ($items as $item) {
                $book = $this->bookService->getBookForBorrowing(
                    $item['book_id']
                );

                if (!$book) {
                    throw new RuntimeException('Buku tidak ditemukan');
                }

                if (!$this->bookService->isStockAvailable(
                    $item['book_id'],
                    $item['quantity']
                )) {
                    throw new RuntimeException(
                        'Stok buku tidak mencukupi: ' . $book['title']
                    );
                }

                if (!$this->bookService->reduceStock(
                    $item['book_id'],
                    $item['quantity']
                )) {
                    throw new RuntimeException(
                        'Gagal mengurangi stok buku'
                    );
                }

                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'book_id' => $book['id'],
                    'book_title' => $book['title'],
                    'book_isbn' => $book['isbn'],
                    'quantity' => $item['quantity'],
                ]);

                $borrowedItems[] = [
                    'book_id' => $book['id'],
                    'quantity' => $item['quantity'],
                ];
            }

            return $borrowing;
        });

        foreach ($borrowedItems as $item) {
            event(new BookBorrowed(
                $borrowing->id,
                $item['book_id'],
                $memberId,
                $item['quantity']
            ));
        }

        return $borrowing;
    }

    // MENGEMBALIKAN BUKU DAN MENGHITUNG DENDA
    public function returnBorrowing(int $borrowingId): Borrowing
    {
        return DB::transaction(function () use ($borrowingId) {

            $borrowing = Borrowing::with('details')
                ->lockForUpdate()
                ->find($borrowingId);

            if (!$borrowing) {
                throw new RuntimeException(
                    'Data peminjaman tidak ditemukan'
                );
            }

            if ($borrowing->status !== 'borrowed') {
                throw new RuntimeException(
                    'Buku sudah dikembalikan'
                );
            }

            $daysLate = 0;

            if ($borrowing->due_date->lt(now()->startOfDay())) {
                $daysLate = (int) $borrowing->due_date
                    ->diffInDays(now()->startOfDay());
            }

            $fine = new Fine(2000);
            $fineAmount = $fine->calculate($daysLate);

            foreach ($borrowing->details as $detail) {
                $success = $this->bookService->increaseStock(
                    $detail->book_id,
                    $detail->quantity
                );

                if (!$success) {
                    throw new RuntimeException(
                        'Gagal mengembalikan stok buku'
                    );
                }
            }

            $borrowing->update([
                'status' => 'returned',
                'fine_amount' => $fineAmount,
            ]);

            return $borrowing;
        });
    }

    // MENGAMBIL RIWAYAT PEMINJAMAN
    public function getBorrowingHistory()
    {
        return Borrowing::withRelations()
            ->latest()
            ->get();
    }
}
