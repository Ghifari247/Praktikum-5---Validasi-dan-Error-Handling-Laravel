<?php

namespace Modules\Circulation\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Circulation\Events\BookBorrowed;

class BookBorrowedListener
{
    public function handle(BookBorrowed $event): void
    {
        Log::info('Buku berhasil dipinjam', [
            'borrow_id' => $event->borrowId,
            'book_id' => $event->bookId,
            'member_id' => $event->memberId,
            'quantity' => $event->quantity,
        ]);
    }
}