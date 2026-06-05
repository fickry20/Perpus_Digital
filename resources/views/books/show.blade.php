@extends('layouts.app')

@section('title', $book->title)

@section('page-title', 'Detail Buku')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('books.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    @if(auth()->user()->role == 'admin')
    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning text-white d-flex align-items-center gap-2">
        <i class="fas fa-edit"></i> Edit Buku
    </a>
    @endif
    @if(auth()->user()->role == 'member')
        @if($book->quantity_available > 0)
        <a href="{{ route('borrowings.create', ['book' => $book->id]) }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-book-reader"></i> Pinjam Buku Ini
        </a>
        @else
        <button class="btn btn-danger d-flex align-items-center gap-2" disabled>
            <i class="fas fa-times-circle"></i> Buku Tidak Tersedia
        </button>
        @endif
    @endif
</div>
@endsection

@section('content')
<div class="row">
    <!-- Left Column: Visual Cover Placeholder -->
    <div class="col-lg-4 mb-4">
        @php
            $gradients = [
                'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)', // Slate
                'linear-gradient(135deg, #065f46 0%, #022c22 100%)', // Green
                'linear-gradient(135deg, #1e3a8a 0%, #172554 100%)', // Blue
                'linear-gradient(135deg, #581c87 0%, #3b0764 100%)', // Purple
                'linear-gradient(135deg, #701a75 0%, #4a044e 100%)', // Fuchsia
            ];
            $gradient = $gradients[strlen($book->title) % count($gradients)];
        @endphp
        <div class="card border-0 shadow-sm text-white p-5 text-center d-flex flex-column justify-content-center align-items-center" style="background: {{$gradient}}; min-height: 380px; border-radius: 1.25rem;">
            <div class="mb-4 bg-white bg-opacity-10 p-4 rounded-circle">
                <i class="fas fa-book fa-4x text-white"></i>
            </div>
            <h4 class="fw-bold mb-2 text-white">{{ $book->title }}</h4>
            <p class="text-white-50 mb-4">{{ $book->author }}</p>
            <span class="badge bg-white bg-opacity-20 text-white px-3 py-2" style="font-size: 0.85rem;">
                ISBN: {{ $book->isbn }}
            </span>
        </div>
    </div>

    <!-- Right Column: Book Metadata and Details -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold text-slate-800 mb-0">Informasi Katalog Buku</h5>
            </div>
            <div class="card-body px-4">
                <div class="row py-3 border-bottom align-items-center">
                    <div class="col-sm-3 text-muted fw-semibold">ID Buku</div>
                    <div class="col-sm-9 fw-bold text-slate-800">#{{ $book->id }}</div>
                </div>

                <div class="row py-3 border-bottom align-items-center">
                    <div class="col-sm-3 text-muted fw-semibold">Nomor ISBN</div>
                    <div class="col-sm-9 text-slate-800"><code style="font-size: 0.95rem;">{{ $book->isbn ?? 'N/A' }}</code></div>
                </div>

                <div class="row py-3 border-bottom align-items-center">
                    <div class="col-sm-3 text-muted fw-semibold">Nama Penulis</div>
                    <div class="col-sm-9 text-slate-800 fw-semibold">{{ $book->author ?? 'Tidak Diketahui' }}</div>
                </div>

                <div class="row py-3 border-bottom align-items-center">
                    <div class="col-sm-3 text-muted fw-semibold">Tahun Terbit</div>
                    <div class="col-sm-9 text-slate-800">{{ $book->year_published ?? 'Tidak Diketahui' }}</div>
                </div>

                <div class="row py-3 border-bottom align-items-center">
                    <div class="col-sm-3 text-muted fw-semibold">Status Ketersediaan</div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $book->quantity_available > 0 ? 'success' : 'danger' }} px-3 py-2">
                            {{ $book->quantity_available > 0 ? $book->quantity_available . ' Tersedia' : 'Habis / Dipinjam' }}
                        </span>
                    </div>
                </div>

                <div class="row py-3 align-items-center">
                    <div class="col-sm-3 text-muted fw-semibold">Ditambahkan Pada</div>
                    <div class="col-sm-9 text-slate-600">{{ $book->created_at->format('d F Y (H:i)') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Borrowing History (Only loaded if available and user is admin) -->
@if(auth()->user()->role == 'admin')
@php
    $borrowHistory = $book->borrowings()->with('member')->orderBy('borrow_date', 'desc')->get();
@endphp
@if(count($borrowHistory) > 0)
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-transparent border-0 pt-4 px-4">
        <h5 class="fw-bold text-slate-800 mb-0"><i class="fas fa-history me-2 text-primary"></i>Riwayat Transaksi Peminjaman</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowHistory as $history)
                    <tr>
                        <td>
                            <div class="fw-semibold text-slate-800">{{ $history->member->full_name ?? $history->member->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $history->member->email }}</div>
                        </td>
                        <td>{{ $history->borrow_date->format('d M Y (H:i)') }}</td>
                        <td>
                            @if($history->return_date)
                                {{ $history->return_date->format('d M Y (H:i)') }}
                            @else
                                <span class="text-danger">Belum Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $history->status == 'returned' ? 'success' : 'warning' }}">
                                {{ $history->status == 'returned' ? 'Dikembalikan' : 'Dipinjam' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endif
@endsection