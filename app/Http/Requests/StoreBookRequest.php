<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'isbn' => ['required', 'regex:/^(97[89])?\d{9}[\dX]$/', 'unique:books,isbn'],
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'author_id' => 'required|exists:authors,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul buku wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'isbn.required' => 'ISBN wajib diisi.',
            'isbn.regex' => 'Format ISBN tidak valid.',
            'isbn.unique' => 'ISBN sudah digunakan.',
            'publication_year.required' => 'Tahun terbit wajib diisi.',
            'publication_year.integer' => 'Tahun harus berupa angka.',
            'publication_year.min' => 'Tahun minimal 1900.',
            'publication_year.max' => 'Tahun tidak boleh melebihi tahun sekarang.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus bilangan bulat.',
            'stock.min' => 'Stok tidak boleh negatif.',
            'author_id.required' => 'Penulis wajib dipilih.',
            'author_id.exists' => 'Penulis tidak ditemukan.',
        ];
    }
}