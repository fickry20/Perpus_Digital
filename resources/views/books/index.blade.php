@extends('layouts.app')

@section('title', 'Books')

@section('page-title', 'Book Collection')

@section('page-actions')
@if(auth()->user()->role == 'admin')
<a href="{{ route('books.create') }}" class="btn btn-sm btn-primary">
    <i class="fas fa-plus me-1"></i> Add New Book
</a>
@endif
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title mb-0">All Books</h5>
            </div>
            <div class="col-md-6">
                <form action="{{ route('books.index') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search books..." name="search" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Year</th>
                        <th>Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td>{{ $book->book_id }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->year_published }}</td>
                        <td>
                            <span class="badge bg-{{ $book->quantity_available > 0 ? 'success' : 'danger' }}">
                                {{ $book->quantity_available }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('borrowings.create', ['book' => $book->id]) }}" class="btn btn-primary">
                                    Borrow this book
                                </a>


                                @if(auth()->user()->role == 'admin')
                                <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $book->book_id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif

                                @if(auth()->user()->role == 'member' && $book->quantity_available > 0)
                                <a href="{{ route('borrowings.create', ['book_id' => $book->book_id]) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-book-reader"></i> Borrow
                                </a>
                                @endif
                            </div>

                            <!-- Delete Modal -->
                            @if(auth()->user()->role == 'admin')
                            <div class="modal fade" id="deleteModal{{ $book->book_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $book->book_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $book->book_id }}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete the book "{{ $book->title }}"?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('books.destroy', $book->book_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                <h5>No books found</h5>
                                <p class="text-muted">There are no books available in the library yet.</p>
                                @if(auth()->user()->role == 'admin')
                                <a href="{{ route('books.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> Add Book
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-center">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection