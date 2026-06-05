@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('page-title', 'Peminjaman Buku')

@section('page-actions')
@if(auth()->user()->role == 'member')
<a href="{{ route('books.index') }}" class="btn btn-primary d-flex align-items-center gap-2">
    <i class="fas fa-book"></i> Cari & Pinjam Buku
</a>
@endif
@endsection

@section('content')
<div class="card border-0">
    <div class="card-header bg-transparent border-0 d-flex flex-wrap justify-content-between align-items-center gap-3 pt-4 px-4">
        <h5 class="mb-0 fw-bold text-slate-800">
            {{ auth()->user()->role == 'admin' ? 'Semua Log Transaksi' : 'Transaksi Peminjaman Saya' }}
        </h5>
        <div style="max-width: 450px; width: 100%;">
            <form action="{{ route('borrowings.index') }}" method="GET" class="d-flex gap-2">
                <select name="status" class="form-select shadow-sm" style="max-width: 140px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                <div class="input-group shadow-sm rounded-3 overflow-hidden flex-fill">
                    <input type="text" class="form-control border-end-0" placeholder="Cari transaksi..." name="search" value="{{ request('search') }}">
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
                        @if(auth()->user()->role == 'admin')
                        <th>Anggota</th>
                        @endif
                        <th>Tanggal Pinjam</th>
                        <th>Tenggat Kembali</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
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
                        @if(auth()->user()->role == 'admin')
                        <td>
                            @if(isset($borrowing->member))
                            <div class="fw-semibold">{{ $borrowing->member->full_name ?? $borrowing->member->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $borrowing->member->email }}</div>
                            @else
                            <span class="text-muted">Tidak Diketahui</span>
                            @endif
                        </td>
                        @endif
                        <td>{{ $borrowing->borrow_date->format('d M Y') }}</td>
                        <td>
                            @if($borrowing->due_date)
                            <span class="{{ now()->gt($borrowing->due_date) && $borrowing->status == 'borrowed' ? 'text-danger fw-bold' : '' }}">
                                {{ $borrowing->due_date->format('d M Y') }}
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($borrowing->return_date)
                            {{ $borrowing->return_date->format('d M Y') }}
                            @else
                            <span class="text-muted" style="font-size: 0.85rem;">Belum dikembalikan</span>
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
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                @if($borrowing->status == 'borrowed')
                                <form action="{{ route('borrowings.return', $borrowing->borrowing_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-undo me-1"></i> Kembalikan
                                    </button>
                                </form>
                                @endif

                                @if(auth()->user()->role == 'admin')
                                <a href="{{ route('borrowings.edit', $borrowing->borrowing_id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('borrowings.destroy', $borrowing->borrowing_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif

                                @if($borrowing->status == 'returned' && auth()->user()->role != 'admin')
                                <span class="text-muted small" style="font-size: 0.8rem;">Dikembalikan</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'admin' ? '8' : '7' }}" class="text-center py-5 text-muted">
                            <i class="fas fa-history fa-3x mb-3"></i>
                            <h5 class="fw-bold">Tidak ada riwayat transaksi</h5>
                            <p>Tidak ada transaksi peminjaman buku yang tercatat.</p>
                            @if(auth()->user()->role == 'member')
                            <a href="{{ route('books.index') }}" class="btn btn-sm btn-primary mt-3">Pinjam Buku</a>
                            @endif
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