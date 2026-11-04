<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penulis</title>
</head>
<body>
    <h1>Tambah Penulis</h1>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif

    <form action="{{ route('authors.store') }}" method="POST">
        @csrf

        <p>Nama Penulis</p>
        <input name="name" value="{{ old('name') }}">

        <p>Email</p>
        <input type="email" name="email" value="{{ old('email') }}">

        <p>Bio</p>
        <textarea name="bio">{{ old('bio') }}</textarea>

        <br><br>
        <button type="submit">Simpan Penulis</button>
    </form>

    <a href="{{ route('authors.index') }}">Kembali</a>
</body>
</html>