@extends('layouts.app')

@section('title', 'Edit Book')

@section('page-title', 'Edit Book')

@section('page-actions')
<a href="{{ route('books.index') }}" class="btn btn-sm btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Back to Books
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('books.update', $book->book_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                        @error('isbn')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $book->author) }}">
                        @error('author')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="year_published" class="form-label">Year Published</label>
                                <input type="number" class="form-control @error('year_published') is-invalid @enderror" id="year_published" name="year_published" value="{{ old('year_published', $book->year_published) }}" min="1000" max="{{ date('Y') }}">
                                @error('year_published')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity_available" class="form-label">Quantity Available <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity_available') is-invalid @enderror" id="quantity_available" name="quantity_available" value="{{ old('quantity_available', $book->quantity_available) }}" min="0" required>
                                @error('quantity_available')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('books.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection