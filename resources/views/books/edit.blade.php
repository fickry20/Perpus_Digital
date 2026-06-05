@extends('layouts.app')

@section('title', 'Edit Buku')

@section('page-title', 'Edit Buku')

@section('page-actions')
<a href="{{ route('books.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Buku
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold text-slate-800 mb-0"><i class="fas fa-edit me-2 text-primary"></i>Formulir Edit Buku</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="isbn" class="form-label fw-semibold text-slate-700">Nomor ISBN</label>
                        <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" placeholder="Contoh: 978-602-03-3160-7">
                        @error('isbn')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold text-slate-700">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="author" class="form-label fw-semibold text-slate-700">Nama Penulis</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $book->author) }}">
                        @error('author')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="year_published" class="form-label fw-semibold text-slate-700">Tahun Terbit</label>
                                <input type="number" class="form-control @error('year_published') is-invalid @enderror" id="year_published" name="year_published" value="{{ old('year_published', $book->year_published) }}" min="1000" max="{{ date('Y') }}">
                                @error('year_published')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="quantity_available" class="form-label fw-semibold text-slate-700">Jumlah Buku Tersedia <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity_available') is-invalid @enderror" id="quantity_available" name="quantity_available" value="{{ old('quantity_available', $book->quantity_available) }}" min="0" required>
                                @error('quantity_available')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('books.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection