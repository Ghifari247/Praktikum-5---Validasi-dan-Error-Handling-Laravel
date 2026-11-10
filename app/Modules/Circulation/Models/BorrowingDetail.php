<?php

namespace Modules\Circulation\Models;


use Modules\Catalog\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowingDetail extends Model
{
    protected $table = 'borrowing_details';

    public function book(): BelongsTo
    {
    return $this->belongsTo(Book::class);
    }

    protected $fillable = [
        'borrowing_id',
        'book_id',
        'book_title',
        'book_isbn',
        'quantity',
    ];

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }
}