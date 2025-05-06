@extends('layouts.app')

@section('title', $book->title)

@section('page-title', 'Book Details')

@section('page-actions')
<div class="btn-group" role="group">
    <a href="{{ route('books.index') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Books
    </a>
    @if(auth()->user()->role == 'admin')
    <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-sm btn-warning text-white">
        <i class="fas fa-edit me-1"></i> Edit
    </a>
    @endif
    @if(auth()->user()->role == 'member' && $book->quantity_available > 0)
    <a href="{{ route('borrowings.create', ['book_id' => $book->book_id]) }}" class="btn btn-sm btn-success">
        <i class="fas fa-book-reader me-1"></i> Borrow
    </a>
    @endif
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h4 class="card-title mb-0">{{ $book->title }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3 text-muted">Book ID</div>
                    <div class="col-md-9">{{ $book->book_id }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 text-muted">ISBN</div>
                    <div class="col-md-9">{{ $book->isbn ?? 'N/A' }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 text-muted">Author</div>
                    <div class="col-md-9">{{ $book->author ?? 'Unknown' }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 text-muted">Year Published</div>
                    <div class="col-md-9">{{ $book->year_published ?? 'Unknown' }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 text-muted">Available Copies</div>
                    <div class="col-md-9">
                        <span class="badge bg-{{ $book->quantity_available > 0 ? 'success' : 'danger' }} p-2">
                            {{ $book->quantity_available }}
                        </span>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 text-muted">Added to Library</div>
                    <div class="col-md-9">{{ $book->created_at->format('F d, Y') }}</div>
                </div>
            </div>

            @if(isset($borrowHistory) && count($borrowHistory) > 0)
            <div class="card-footer">
                <h5>Borrowing History</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Borrowed On</th>
                                <th>Returned On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowHistory as $history)
                            <tr>
                                <td>{{ $history->member->full_name }}</td>
                                <td>{{ $history->borrow_date }}</td>
                                <td>{{ $history->return_date ?? 'Not Returned' }}</td>
                                <td>
                                    <span class="badge bg-{{ $history->status == 'returned' ? 'success' : 'warning' }}">
                                        {{ ucfirst($history->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection