<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
</head>
<body>
    <h1>Tambah Buku Baru</h1>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif

    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        <p>Judul Buku</p>
        <input name="title" value="{{ old('title') }}">

        <p>ISBN</p>
        <input name="isbn" value="{{ old('isbn') }}">

        <p>Tahun Terbit</p>
        <input type="number" name="publication_year" value="{{ old('publication_year') }}">

        <p>Harga</p>
        <input type="number" name="price" value="{{ old('price') }}">

        <p>Stok</p>
        <input type="number" name="stock" value="{{ old('stock') }}">

        <p>Penulis</p>
        <select name="author_id">
            <option value="">Pilih Penulis</option>
            @foreach($authors as $author)
                <option value="{{ $author->id }}">{{ $author->name }}</option>
            @endforeach
        </select>

        <br><br>
        <button type="submit">Simpan Buku</button>
    </form>

    <a href="{{ route('books.index') }}">Kembali</a>
</body>
</html>