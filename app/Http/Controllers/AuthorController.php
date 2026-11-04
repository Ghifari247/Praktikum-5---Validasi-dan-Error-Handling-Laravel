<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Exceptions\AuthorHasBooksException;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->get();

        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(StoreAuthorRequest $request)
    {
        Author::create($request->validated());

        return redirect()->route('authors.index')
            ->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function destroy(Author $author)
    {
        try {
            if ($author->books()->exists()) {
                throw new AuthorHasBooksException();
            }

            $author->delete();

            return back()->with('success', 'Penulis berhasil dihapus.');
        } catch (AuthorHasBooksException $e) {
            Log::error($e->getMessage());

            return back()->with('error', $e->getMessage());
        }
    }
}