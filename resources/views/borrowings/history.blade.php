@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya')

@section('page-title', 'Riwayat Peminjaman')

@section('page-actions')
<a href="{{ route('books.index') }}" class="btn btn-primary d-flex align-items-center gap-2">
    <i class="fas fa-book"></i> Cari & Pinjam Buku
</a>
@endsection

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="card border-0">
    <div class="card-header bg-transparent border-0 d-flex flex-wrap justify-content-between align-items-center gap-3 pt-4 px-4">
        <h5 class="mb-0 fw-bold text-slate-800">Daftar Transaksi Peminjaman Saya</h5>
        <div style="max-width: 450px; width: 100%;">
            <form action="{{ route('borrowings.history') }}" method="GET" class="d-flex gap-2">
                <select name="status" class="form-select shadow-sm" style="max-width: 140px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                <div class="input-group shadow-sm rounded-3 overflow-hidden flex-fill">
                    <input type="text" class="form-control border-end-0" placeholder="Cari buku..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-light border border-start-0 px-3 text-slate-500" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Durasi Peminjaman</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                    <tr>
                        <td class="fw-bold text-slate-800">#TR-{{ $borrowing->borrowing_id }}</td>
                        <td>
                            <div class="fw-semibold text-slate-800">
                                <a href="{{ route('books.show', $borrowing->book_id) }}" class="text-decoration-none text-slate-900 hover:text-primary">
                                    {{ $borrowing->book->title }}
                                </a>
                            </div>
                            <div class="text-muted" style="font-size: 0.75rem;">ISBN: {{ $borrowing->book->isbn }}</div>
                        </td>
                        <td>{{ $borrowing->borrow_date->format('d M Y') }}</td>
                        <td>
                            @if($borrowing->return_date)
                            {{ $borrowing->return_date->format('d M Y') }}
                            @else
                            <span class="text-muted small">Belum dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            @if($borrowing->return_date)
                            @php
                            $borrow = \Carbon\Carbon::parse($borrowing->borrow_date);
                            $return = \Carbon\Carbon::parse($borrowing->return_date);
                            $days = $borrow->diffInDays($return);
                            @endphp
                            {{ $days }} Hari
                            @else
                            @php
                            $borrow = \Carbon\Carbon::parse($borrowing->borrow_date);
                            $now = \Carbon\Carbon::now();
                            $days = $borrow->diffInDays($now);
                            @endphp
                            {{ $days }} Hari (Sedang berjalan)
                            @endif
                        </td>
                        <td>
                            @if($borrowing->status == 'borrowed')
                                @if(isset($borrowing->due_date) && now()->gt($borrowing->due_date))
                                <span class="badge bg-danger">Terlambat</span>
                                @else
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                                @endif
                            @else
                            <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-history fa-3x mb-3"></i>
                            <h5 class="fw-bold">Tidak ada riwayat peminjaman</h5>
                            <p>Anda belum meminjam atau mengembalikan buku apa pun.</p>
                            <a href="{{ route('books.index') }}" class="btn btn-sm btn-primary mt-3">Jelajahi Buku</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($borrowings->hasPages())
    <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-4">
        {{ $borrowings->appends(request()->except('page'))->links() }}
    </div>
    @endif
</div>
@endsection