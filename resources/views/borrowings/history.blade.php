@extends('layouts.app')

@section('title', 'Borrowing History')

@section('page-title', 'My Borrowing History')

@php use Illuminate\Support\Str; @endphp


@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title mb-0">All Book Transactions</h5>
            </div>
            <div class="col-md-6">
                <form action="{{ route('borrowings.history') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <select name="status" class="form-select" style="max-width: 150px;">
                            <option value="">All Status</option>
                            <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        </select>
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
                        <th>Book</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                    <tr>
                        <td>{{ $borrowing->borrowing_id }}</td>
                        <td>
                            <a href="{{ route('books.show', $borrowing->book_id) }}">
                                {{ $borrowing->book->title }}
                            </a>
                        </td>
                        <td>{{ $borrowing->borrow_date }}</td>
                        <td>{{ $borrowing->return_date ?? 'Not returned yet' }}</td>
                        <td>
                            @if($borrowing->return_date)
                            @php
                            $borrow = \Carbon\Carbon::parse($borrowing->borrow_date);
                            $return = \Carbon\Carbon::parse($borrowing->return_date);
                            $days = $borrow->diffInDays($return);
                            @endphp
                            {{ $days }} {{ \Str::plural('day', $days) }}
                            @else
                            @php
                            $borrow = \Carbon\Carbon::parse($borrowing->borrow_date);
                            $now = \Carbon\Carbon::now();
                            $days = $borrow->diffInDays($now);
                            @endphp
                            {{ $days }} {{ \Str::plural('day', $days) }} (ongoing)
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $borrowing->status == 'borrowed' ? 'warning' : 'success' }}">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <h5>No borrowing history found</h5>
                                <p class="text-muted">You haven't borrowed any books yet.</p>
                                <a href="{{ route('books.index') }}" class="btn btn-primary">
                                    <i class="fas fa-book me-1"></i> Browse Books
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Showing {{ $borrowings->firstItem() ?? 0 }} to {{ $borrowings->lastItem() ?? 0 }} of {{ $borrowings->total() }} entries</small>
            </div>
            <div>
                {{ $borrowings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection