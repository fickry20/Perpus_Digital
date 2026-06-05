@extends('layouts.app')

@section('title', 'Konfirmasi Peminjaman')

@section('page-title', 'Konfirmasi Peminjaman')

@section('page-actions')
<a href="{{ route('books.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
    <i class="fas fa-arrow-left"></i> Batal & Kembali
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden; position: relative;">
            <!-- Top design accent -->
            <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); height: 8px;"></div>
            
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="h-16 w-16 bg-emerald-50 text-emerald-600 rounded-circle flex items-center justify-center mx-auto mb-3" style="width: 64px; height: 64px; line-height: 64px; font-size: 1.75rem;">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h4 class="fw-bold text-slate-800 mb-1">Tiket Peminjaman Buku</h4>
                    <p class="text-muted small">Silakan periksa detail transaksi peminjaman Anda</p>
                </div>

                <!-- Ticket details block -->
                <div class="bg-light p-4 rounded-4 mb-4" style="border: 1px dashed #cbd5e1;">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Judul Buku</label>
                        <div class="fw-bold text-slate-800" style="font-size: 1.1rem;">{{ $book->title }}</div>
                        <div class="text-muted small">ISBN: {{ $book->isbn }} | Penulis: {{ $book->author }}</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Peminjam</label>
                            <div class="fw-semibold text-slate-800">{{ auth()->user()->full_name }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Status Ketersediaan</label>
                            <div>
                                <span class="badge bg-success">Tersedia ({{ $book->quantity_available }} Pcs)</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Tanggal Pinjam</label>
                            <div class="text-slate-800">{{ date('d M Y') }} (Hari ini)</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Tenggat Kembali</label>
                            <div class="text-danger fw-semibold">{{ date('d M Y', strtotime('+7 days')) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Confirm Form -->
                <form action="{{ route('borrowings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <div class="alert alert-warning-subtle text-slate-700 rounded-3 mb-4 p-3" style="font-size: 0.85rem; border: 1px solid #fef3c7; background-color: #fffbeb;">
                        <i class="fas fa-exclamation-triangle text-amber-500 me-2"></i>
                        Buku harus dikembalikan paling lambat dalam waktu 7 hari untuk menghindari denda atau penangguhan akun.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg py-3 d-flex align-items-center justify-content-center gap-2" style="font-size: 1rem;">
                            <i class="fas fa-check-circle"></i> Konfirmasi & Pinjam Buku
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-light btn-lg border py-2.5" style="font-size: 0.95rem;">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection