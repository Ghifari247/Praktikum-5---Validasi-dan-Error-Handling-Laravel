<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
</head>
<body>
    <h1>Perpustakaan - Daftar Buku</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <a href="{{ route('books.create') }}">Tambah Buku</a>
    <a href="{{ route('authors.index') }}">Daftar Penulis</a>

    <table border="1" cellpadding="10">
        <tr>
            <th>Judul</th>
            <th>ISBN</th>
            <th>Penulis</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->isbn }}</td>
            <td>{{ $book->author->name }}</td>
            <td>{{ $book->stock }}</td>
            <td>
                <form action="{{ route('books.borrow', $book) }}" method="POST">
                    @csrf
                    <button type="submit">Pinjam</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>