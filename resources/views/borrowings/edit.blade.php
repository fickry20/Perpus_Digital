@extends('layouts.app')

@section('title', 'Edit Transaksi Peminjaman')

@section('page-title', 'Edit Transaksi Peminjaman')

@section('page-actions')
<a href="{{ route('borrowings.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
    <i class="fas fa-arrow-left"></i> Kembali
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold text-slate-800 mb-0"><i class="fas fa-edit me-2 text-primary"></i>Formulir Edit Peminjaman</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('borrowings.update', $borrowing->borrowing_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="bg-light p-3 rounded-3 mb-4" style="border-left: 4px solid var(--accent);">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <span class="text-muted small">Buku:</span>
                                <div class="fw-semibold text-slate-800">{{ $borrowing->book->title }}</div>
                            </div>
                            <div class="col-md-6">
                                <span class="text-muted small">Peminjam:</span>
                                <div class="fw-semibold text-slate-800">{{ $borrowing->member->full_name ?? $borrowing->member->name }}</div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <span class="text-muted small">Tanggal Pinjam:</span>
                                <div class="text-slate-700">{{ $borrowing->borrow_date->format('d M Y') }}</div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <span class="text-muted small">Status Transaksi:</span>
                                <div>
                                    <span class="badge bg-{{ $borrowing->status == 'borrowed' ? 'warning text-dark' : 'success' }}">
                                        {{ $borrowing->status == 'borrowed' ? 'Aktif (Dipinjam)' : 'Selesai (Dikembalikan)' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="form-label fw-semibold text-slate-700">Tenggat Waktu Pengembalian <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" 
                               value="{{ old('due_date', $borrowing->due_date ? $borrowing->due_date->format('Y-m-d') : '') }}" required>
                        @error('due_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-semibold text-slate-700">Catatan Peminjaman</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="Tambahkan catatan khusus seperti kondisi buku saat dipinjam...">{{ old('notes', $borrowing->notes) }}</textarea>
                        @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('borrowings.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Catatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
