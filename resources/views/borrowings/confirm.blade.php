@extends('layouts.app')

@section('title', 'Borrow Book')

@section('page-title', 'Borrow Book')

@section('page-actions')
<a href="{{ route('books.index') }}" class="btn btn-sm btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Back to Books
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Confirm Book Borrowing</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    You are about to borrow the following book. Please confirm to proceed.
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 text-muted">Book Title</div>
                    <div class="col-md-9"><strong>{{ $book->title }}</strong></div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 text-muted">Author</div>
                    <div class="col-md-9">{{ $book->author ?? 'Unknown' }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 text-muted">Available Copies


                        @section('page-title', 'Borrow Book')

                        @section('page-actions')
                        <a href="{{ route('books.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Books
                        </a>
                        @endsection

                        @section('content')
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="card shadow">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">Confirm Book Borrowing</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            You are about to borrow the following book. Please confirm to proceed.
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-3 text-muted">Book Title</div>
                                            <div class="col-md-9"><strong>{{ $book->title }}</strong></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-3 text-muted">Author</div>
                                            <div class="col-md-9">{{ $book->author ?? 'Unknown' }}</div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-3 text-muted">Available Copies</div>
                                            <div class="col-md-9">
                                                <span class="badge bg-{{ $book->available_copies > 0 ? 'success' : 'danger' }} p-2">
                                                    {{ $book->available_copies }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-3 text-muted">Borrower</div>
                                            <div class="col-md-9">{{ auth()->user()->full_name }}</div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-3 text-muted">Borrow Date</div>
                                            <div class="col-md-9">{{ date('Y-m-d') }} (Today)</div>
                                        </div>

                                        <form action="{{ route('borrowings.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->book_id }}">

                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <a href="{{ route('books.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-book-reader me-1"></i> Confirm Borrowing
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endsection