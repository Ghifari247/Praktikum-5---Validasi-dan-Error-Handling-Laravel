<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penulis</title>
</head>
<body>
    <h1>Daftar Penulis</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <a href="{{ route('authors.create') }}">Tambah Penulis</a>
    <a href="{{ route('books.index') }}">Daftar Buku</a>

    @foreach($authors as $author)
        <hr>
        <p>Nama: {{ $author->name }}</p>
        <p>Email: {{ $author->email }}</p>
        <p>Jumlah Buku: {{ $author->books_count }}</p>

        <form action="{{ route('authors.destroy', $author) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus Penulis</button>
        </form>
    @endforeach
</body>
</html>