<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Http\Requests\StoreBookRequest;
use App\Exceptions\BookNotAvailableException;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function store(StoreBookRequest $request)
    {
        Book::create($request->validated());

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function borrow(Book $book)
    {
        try {
            if ($book->stock <= 0) {
                throw new BookNotAvailableException();
            }

            $book->decrement('stock');

            return back()->with('success', 'Buku berhasil dipinjam.');
        } catch (BookNotAvailableException $e) {
            Log::error($e->getMessage());

            return back()->with('error', $e->getMessage());
        }
    }
}