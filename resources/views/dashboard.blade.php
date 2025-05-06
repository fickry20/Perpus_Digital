@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    @if(auth()->user()->role == 'admin')
    <!-- Admin Dashboard -->
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Books</h5>

                    </div>
                    <i class="fas fa-book fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('books.index') }}" class="text-white text-decoration-none">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Members</h5>

                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('members.index') }}" class="text-white text-decoration-none">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Active Borrowings</h5>

                    </div>
                    <i class="fas fa-exchange-alt fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('borrowings.index') }}" class="text-white text-decoration-none">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Recent Borrowings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Borrowings</h5>
                    <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Member</th>
                                <th>Book</th>
                                <th>Borrow Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $borrow)
                            <tr>
                                <td>{{ $borrow->id }}</td>
                                <td>{{ $borrow->member->full_name }}</td>
                                <td>{{ $borrow->book->title }}</td>
                                <td>{{ $borrow->borrow_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $borrow->status == 'borrowed' ? 'warning' : 'success' }}">
                                        {{ ucfirst($borrow->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('borrowings.edit', $borrow->id) }}" class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No recent borrowings found.</td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Member Dashboard -->
    <div class="col-md-6 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">My Active Borrowings</h5>

                    </div>
                    <i class="fas fa-book-reader fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('borrowings.index') }}" class="text-white text-decoration-none">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Books Borrowed</h5>

                    </div>
                    <i class="fas fa-history fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="#undira" class="text-white text-decoration-none">View History</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- My Borrowings -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Current Borrowings</h5>
                    <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Book</th>
                                <th>Borrowed On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $borrow)
                            @if($borrow->status === 'borrowed')
                            <tr>
                                <td>{{ $borrow->book->title }}</td>
                                <td>{{ $borrow->borrow_date->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('borrowings.return', $borrow->id) }}" class="btn btn-sm btn-success">
                                        Return
                                    </a>
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No current borrowings.</td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection