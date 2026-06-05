@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Perpustakaan')

@section('content')
<div class="row">
    @if(auth()->user()->role == 'admin')
    <!-- Admin Dashboard Cards -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; opacity: 0.15; pointer-events: none;">
                <i class="fas fa-book"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Buku</p>
                        <h3 class="display-5 fw-extrabold mb-0">{{ \App\Models\Book::count() }}</h3>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-3">
                        <i class="fas fa-book fa-2x text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                <a href="{{ route('books.index') }}" class="text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.85rem;">
                    Lihat Selengkapnya <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #10b981 0%, #065f46 100%); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; opacity: 0.15; pointer-events: none;">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Anggota</p>
                        <h3 class="display-5 fw-extrabold mb-0">{{ \App\Models\User::where('role', 'member')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-3">
                        <i class="fas fa-users fa-2x text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                <a href="{{ route('members.index') }}" class="text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.85rem;">
                    Lihat Selengkapnya <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; opacity: 0.15; pointer-events: none;">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Peminjaman Aktif</p>
                        <h3 class="display-5 fw-extrabold mb-0">{{ \App\Models\Borrowing::where('status', 'borrowed')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-3">
                        <i class="fas fa-exchange-alt fa-2x text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                <a href="{{ route('borrowings.index') }}" class="text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.85rem;">
                    Lihat Selengkapnya <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Borrowings (Admin View) -->
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-clock me-2 text-primary"></i>Transaksi Peminjaman Terbaru</h5>
                <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $borrow)
                            <tr>
                                <td class="fw-bold">#TR-{{ $borrow->borrowing_id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="h-8 w-8 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center font-semibold" style="width: 30px; height: 30px; font-size: 0.75rem;">
                                            {{ substr($borrow->member->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $borrow->member->full_name ?? $borrow->member->name }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">{{ $borrow->member->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-slate-800">{{ $borrow->book->title }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">ISBN: {{ $borrow->book->isbn }}</div>
                                </td>
                                <td>{{ $borrow->borrow_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $borrow->status == 'borrowed' ? 'warning' : 'success' }}">
                                        {{ $borrow->status == 'borrowed' ? 'Dipinjam' : 'Dikembalikan' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('borrowings.index') }}?search={{ $borrow->borrowing_id }}" class="btn btn-sm btn-outline-secondary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                                    <p class="mb-0 font-medium">Belum ada transaksi peminjaman terbaru.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Member Dashboard Cards -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; opacity: 0.15; pointer-events: none;">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Sedang Saya Pinjam</p>
                        <h3 class="display-5 fw-extrabold mb-0">{{ \App\Models\Borrowing::where('member_id', auth()->id())->where('status', 'borrowed')->count() }} Buku</h3>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-3">
                        <i class="fas fa-book-reader fa-2x text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                <a href="{{ route('borrowings.index') }}" class="text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.85rem;">
                    Detail Peminjaman <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; opacity: 0.15; pointer-events: none;">
                <i class="fas fa-history"></i>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Transaksi Peminjaman</p>
                        <h3 class="display-5 fw-extrabold mb-0">{{ \App\Models\Borrowing::where('member_id', auth()->id())->count() }} Kali</h3>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-3">
                        <i class="fas fa-history fa-2x text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                <a href="{{ route('borrowings.history') }}" class="text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.85rem;">
                    Lihat Riwayat <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- My Borrowings (Member View) -->
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-bookmark me-2 text-primary"></i>Buku yang Sedang Saya Pinjam</h5>
                <a href="{{ route('books.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Pinjam Buku Lain</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tenggat Waktu</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $hasActive = false; @endphp
                            @foreach($recentBorrowings as $borrow)
                            @if($borrow->status === 'borrowed')
                            @php $hasActive = true; @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold text-slate-800">{{ $borrow->book->title }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">ISBN: {{ $borrow->book->isbn }} | Penulis: {{ $borrow->book->author }}</div>
                                </td>
                                <td>{{ $borrow->borrow_date->format('d M Y') }}</td>
                                <td>
                                    <span class="text-danger fw-semibold">{{ $borrow->due_date ? $borrow->due_date->format('d M Y') : 'Tanpa batas' }}</span>
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('borrowings.return', $borrow->borrowing_id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Kembalikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @if(!$hasActive)
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-book-open fa-3x mb-3"></i>
                                    <p class="mb-0 font-medium">Anda tidak sedang meminjam buku saat ini.</p>
                                    <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-primary mt-3">Pinjam Buku</a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection