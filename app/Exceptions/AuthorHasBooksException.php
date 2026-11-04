<?php

namespace App\Exceptions;

use Exception;

class AuthorHasBooksException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Penulis tidak bisa dihapus karena masih memiliki buku.'
        );
    }
}