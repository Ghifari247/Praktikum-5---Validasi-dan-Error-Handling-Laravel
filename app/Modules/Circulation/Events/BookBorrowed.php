<?php

namespace Modules\Circulation\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookBorrowed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $borrowId,
        public int $bookId,
        public int $memberId,
        public int $quantity
    ) {}
}