@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('page-title', 'Manajemen Anggota')

@section('content')
<div class="card border-0">
    <div class="card-header bg-transparent border-0 d-flex flex-wrap justify-content-between align-items-center gap-3 pt-4 px-4">
        <h5 class="mb-0 fw-bold text-slate-800">Daftar Anggota Perpustakaan</h5>
        <div style="max-width: 350px; width: 100%;">
            <form action="{{ route('members.index') }}" method="GET">
                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                    <input type="text" class="form-control border-end-0 py-2" placeholder="Cari nama, username, email..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-light border border-start-0 py-2 px-3 text-slate-500" type="submit">
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
                        <th style="width: 80px;">ID</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Buku Dipinjam</th>
                        <th>Total Pinjam</th>
                        <th>Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr>
                        <td class="fw-bold">#MB-{{ $member->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="h-8 w-8 bg-emerald-100 text-emerald-800 rounded-full flex items-center justify-center font-semibold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    {{ substr($member->name, 0, 2) }}
                                </div>
                                <div class="fw-bold text-slate-800">{{ $member->full_name ?? $member->name }}</div>
                            </div>
                        </td>
                        <td><code style="font-size: 0.85rem;">{{ $member->username }}</code></td>
                        <td>{{ $member->email }}</td>
                        <td>
                            <span class="badge bg-{{ $member->borrowings()->where('status', 'borrowed')->count() > 0 ? 'warning' : 'light text-muted border' }}">
                                {{ $member->borrowings()->where('status', 'borrowed')->count() }} Buku
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ $member->borrowings()->count() }} Kali
                            </span>
                        </td>
                        <td>{{ $member->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h5 class="fw-bold">Tidak ada anggota ditemukan</h5>
                            <p class="mb-0">Tidak ada anggota perpustakaan terdaftar yang cocok dengan pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($members->hasPages())
    <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-4">
        {{ $members->appends(request()->except('page'))->links() }}
    </div>
    @endif
</div>
@endsection
