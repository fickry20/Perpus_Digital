<div class="mb-3">
    <label>ISBN</label>
    <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}">
</div>

<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}">
</div>

<div class="mb-3">
    <label>Penulis</label>
    <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}">
</div>

<div class="mb-3">
    <label>Tahun Terbit</label>
    <input type="text" name="year_published" class="form-control" value="{{ old('year_published', $book->year_published) }}">
</div>

<div class="mb-3">
    <label>Jumlah Tersedia</label>
    <input type="number" name="quantity_available" class="form-control" value="{{ old('quantity_available', $book->quantity_available) }}">
</div>

<button class="btn btn-success" type="submit">Simpan</button>
<a href="{{ route('books.index') }}" class="btn btn-secondary">Batal</a>
