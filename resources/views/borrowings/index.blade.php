@extends('layouts.app')

@section('title', 'Borrowings')

@section('page-title', 'Book Borrowings')

@section('page-actions')
@if(auth()->user()->role == 'member')
<a href="{{ route('books.index') }}" class="btn btn-sm btn-primary">
    <i class="fas fa-book me-1" aria-hidden="true"></i> Browse Books
</a>

@section('page-actions')
@if(auth()->user()->role == 'admin')
<a href="{{ route('borrowings.create') }}" class="btn btn-sm btn-success">
    <i class="fas fa-plus me-1"></i> Add Borrowing
</a>
@endif

@if(auth()->user()->role == 'member')
<a href="{{ route('books.index') }}" class="btn btn-sm btn-primary">
    <i class="fas fa-book me-1"></i> Browse Books
</a>
@endif
@endsection

@endif
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="card-title mb-0">
                    @if(auth()->user()->role == 'admin')
                    All Borrowings
                    @else
                    My Borrowings
                    @endif
                </h5>
            </div>
            <div class="col-md-6">
                <form action="{{ route('borrowings.index') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <select name="status" class="form-select" style="max-width: 150px;" aria-label="Filter by status">
                            <option value="">All Status</option>
                            <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                        <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ request('search') }}" aria-label="Search borrowings">
                        <button class="btn btn-outline-secondary" type="submit" aria-label="Search">
                            <i class="fas fa-search" aria-hidden="true"></i>
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
                        <th scope="col">ID</th>
                        <th scope="col">Book</th>
                        @if(auth()->user()->role == 'admin')
                        <th scope="col">Member</th>
                        @endif
                        <th scope="col">Borrow Date</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Return Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                    <tr>
                        <td>{{ $borrowing->borrowing_id }}</td>
                        <td>
                            <a href="{{ route('books.show', $borrowing->book_id) }}" class="text-decoration-none">
                                {{ $borrowing->book->title }}
                            </a>
                        </td>
                        @if(auth()->user()->role == 'admin')
                        <td>
                            @if(isset($borrowing->member))
                            {{ $borrowing->member->full_name }}
                            @else
                            <span class="text-muted">Unknown member</span>
                            @endif
                        </td>
                        @endif
                        <td>{{ $borrowing->borrow_date->format('M d, Y') }}</td>
                        <td>
                            @if($borrowing->due_date)
                            <span class="{{ now()->gt($borrowing->due_date) && $borrowing->status == 'borrowed' ? 'text-danger fw-bold' : '' }}">
                                {{ $borrowing->due_date->format('M d, Y') }}
                            </span>
                            @else
                            <span class="text-muted">Not set</span>
                            @endif
                        </td>
                        <td>{{ $borrowing->return_date ? $borrowing->return_date->format('M d, Y') : 'Not returned yet' }}</td>
                        <td>
                            @if($borrowing->status == 'borrowed')
                            @if(isset($borrowing->due_date) && now()->gt($borrowing->due_date))
                            <span class="badge bg-danger">Overdue</span>
                            @else
                            <span class="badge bg-warning text-dark">Borrowed</span>
                            @endif
                            @else
                            <span class="badge bg-success">Returned</span>
                            @endif
                        </td>
                        <td>
                            @if($borrowing->status == 'borrowed')
                            <form action="{{ route('borrowings.return', $borrowing->borrowing_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success" aria-label="Return book">
                                    <i class="fas fa-undo me-1" aria-hidden="true"></i> Return
                                </button>
                            </form>
                        <td>
                            @if($borrowing->status == 'borrowed')
                            <form action="{{ route('borrowings.return', $borrowing->borrowing_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success" aria-label="Return book">
                                    <i class="fas fa-undo me-1"></i> Return
                                </button>
                            </form>
                            @endif

                            @if(auth()->user()->role == 'admin')
                            <a href="{{ route('borrowings.edit', $borrowing->borrowing_id) }}" class="btn btn-sm btn-primary ms-1" aria-label="Edit borrowing">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('borrowings.destroy', $borrowing->borrowing_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" aria-label="Delete borrowing">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @endif

                            @if($borrowing->status == 'returned' && auth()->user()->role != 'admin')
                            <span class="text-muted">Returned on {{ $borrowing->return_date->format('M d, Y') }}</span>
                            @endif
                        </td>

                        @if(auth()->user()->role == 'admin')
                        <a href="{{ route('borrowings.edit', $borrowing->borrowing_id) }}" class="btn btn-sm btn-primary ms-1" aria-label="Edit borrowing">
                            <i class="fas fa-edit" aria-hidden="true"></i>
                        </a>
                        @endif
                        @else
                        <span class="text-muted">Returned on {{ $borrowing->return_date->format('M d, Y') }}</span>
                        @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'admin' ? '8' : '7' }}" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-book fa-3x text-muted mb-3" aria-hidden="true"></i>
                                <h5>No borrowings found</h5>
                                @if(auth()->user()->role == 'member')
                                <p class="text-muted">You haven't borrowed any books yet.</p>
                                <a href="{{ route('books.index') }}" class="btn btn-primary">
                                    <i class="fas fa-book me-1" aria-hidden="true"></i> Browse Books
                                </a>
                                @else
                                <p class="text-muted">There are no book borrowings in the system yet.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($borrowings->hasPages())
    <div class="card-footer">
        <div class="d-flex justify-content-center">
            {{ $borrowings->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @endif
</div>
@endsection