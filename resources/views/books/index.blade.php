@extends('layouts.app')

@section('title', 'Koleksi Buku')

@section('page-title', 'Koleksi Buku Perpustakaan')

@section('page-actions')
@if(auth()->user()->role == 'admin')
<a href="{{ route('books.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
    <i class="fas fa-plus"></i> Tambah Buku Baru
</a>
@endif
@endsection

@section('content')
<div class="card border-0 mb-4">
    <div class="card-header bg-transparent border-0 d-flex flex-wrap justify-content-between align-items-center gap-3 pt-4 px-4">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 fw-bold text-slate-800">Daftar Buku</h5>
            <!-- Grid/Table Toggle Buttons -->
            <div class="btn-group shadow-sm rounded-3" role="group">
                <button type="button" class="btn btn-sm btn-light py-1.5 px-3 border" id="btn-grid" onclick="toggleView('grid')">
                    <i class="fas fa-th-large me-1 text-slate-600"></i> Grid
                </button>
                <button type="button" class="btn btn-sm btn-light py-1.5 px-3 border" id="btn-table" onclick="toggleView('table')">
                    <i class="fas fa-list me-1 text-slate-600"></i> List
                </button>
            </div>
        </div>
        <div style="max-width: 350px; width: 100%;">
            <form action="{{ route('books.index') }}" method="GET">
                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                    <input type="text" class="form-control border-end-0 py-2" placeholder="Cari buku, penulis, ISBN..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-light border border-start-0 py-2 px-3 text-slate-500" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Grid View Container -->
    <div class="card-body p-4" id="books-grid">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($books as $book)
            <div class="col">
                <div class="card h-100 border shadow-sm hover-card" style="transition: all 0.2s ease;">
                    <!-- Book Cover Placeholder with Title/Author and dynamic gradient -->
                    @php
                        $gradients = [
                            'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)', // Slate
                            'linear-gradient(135deg, #065f46 0%, #022c22 100%)', // Green
                            'linear-gradient(135deg, #1e3a8a 0%, #172554 100%)', // Blue
                            'linear-gradient(135deg, #581c87 0%, #3b0764 100%)', // Purple
                            'linear-gradient(135deg, #701a75 0%, #4a044e 100%)', // Fuchsia
                        ];
                        // Select a gradient deterministically based on book title length
                        $gradient = $gradients[strlen($book->title) % count($gradients)];
                    @endphp
                    <div class="p-4 d-flex flex-column justify-content-between text-white" style="background: {{$gradient}}; height: 200px; border-top-left-radius: 1.25rem; border-top-right-radius: 1.25rem; position: relative;">
                        <span class="badge bg-white bg-opacity-20 text-white-50 text-uppercase align-self-start fw-semibold" style="font-size: 0.65rem;">ISBN: {{ $book->isbn }}</span>
                        <div class="my-2">
                            <h5 class="fw-bold line-clamp-2 mb-1" style="font-size: 1.1rem; line-height: 1.3;">{{ $book->title }}</h5>
                            <p class="text-white-50 small mb-0">{{ $book->author }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-white-50">{{ $book->year_published }}</small>
                            <span class="badge bg-white bg-opacity-20 text-white font-bold">
                                {{ $book->quantity_available }} Pcs
                            </span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-end p-3 bg-white">
                        <div class="d-grid gap-2">
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                            
                            @if(auth()->user()->role == 'member')
                                @if($book->quantity_available > 0)
                                <a href="{{ route('borrowings.create', ['book' => $book->id]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-book-reader me-1"></i> Pinjam Buku
                                </a>
                                @else
                                <button class="btn btn-sm btn-danger" disabled>
                                    <i class="fas fa-times-circle me-1"></i> Buku Habis
                                </button>
                                @endif
                            @endif

                            @if(auth()->user()->role == 'admin')
                            <div class="d-flex gap-2">
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning flex-fill text-white">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger flex-fill" data-bs-toggle="modal" data-bs-target="#deleteModalGrid{{ $book->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal for Grid -->
                            <div class="modal fade" id="deleteModalGrid{{ $book->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow border-0" style="border-radius: 1.25rem;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-slate-800">Hapus Buku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-slate-600 py-3">
                                            Apakah Anda yakin ingin menghapus buku <strong>"{{ $book->title }}"</strong>? Tindakan ini tidak dapat dibatalkan.
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center text-muted">
                <i class="fas fa-book-open fa-3x mb-3"></i>
                <h5>Buku tidak ditemukan</h5>
                <p>Tidak ada koleksi buku yang cocok dengan pencarian Anda.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Table List View (Hidden by default) -->
    <div class="card-body p-0 d-none" id="books-table">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>ISBN</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Tersedia</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td class="fw-bold">#{{ $book->id }}</td>
                        <td><code style="font-size: 0.85rem;">{{ $book->isbn }}</code></td>
                        <td>
                            <a href="{{ route('books.show', $book->id) }}" class="fw-bold text-slate-800 text-decoration-none">
                                {{ $book->title }}
                            </a>
                        </td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->year_published }}</td>
                        <td>
                            <span class="badge bg-{{ $book->quantity_available > 0 ? 'success' : 'danger' }}">
                                {{ $book->quantity_available }} Buku
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if(auth()->user()->role == 'member')
                                    @if($book->quantity_available > 0)
                                    <a href="{{ route('borrowings.create', ['book' => $book->id]) }}" class="btn btn-sm btn-primary">
                                        Pinjam
                                    </a>
                                    @else
                                    <button class="btn btn-sm btn-danger" disabled>Habis</button>
                                    @endif
                                @endif

                                @if(auth()->user()->role == 'admin')
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalList{{ $book->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>

                            @if(auth()->user()->role == 'admin')
                            <!-- Delete Modal for List -->
                            <div class="modal fade" id="deleteModalList{{ $book->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow border-0" style="border-radius: 1.25rem;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-slate-800">Hapus Buku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-slate-600 py-3">
                                            Apakah Anda yakin ingin menghapus buku <strong>"{{ $book->title }}"</strong>? Tindakan ini tidak dapat dibatalkan.
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-book-open fa-3x mb-3"></i>
                            <p class="mb-0 font-medium">Buku tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Footer -->
    <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-4">
        {{ $books->links() }}
    </div>
</div>

<script>
    // View state manager (saved to localStorage for persistence)
    function toggleView(view) {
        const gridView = document.getElementById('books-grid');
        const tableView = document.getElementById('books-table');
        const btnGrid = document.getElementById('btn-grid');
        const btnTable = document.getElementById('btn-table');

        if (view === 'grid') {
            gridView.classList.remove('d-none');
            tableView.classList.add('d-none');
            btnGrid.classList.add('btn-primary', 'text-white');
            btnGrid.classList.remove('btn-light');
            btnTable.classList.add('btn-light');
            btnTable.classList.remove('btn-primary', 'text-white');
            localStorage.setItem('library-view', 'grid');
        } else {
            gridView.classList.add('d-none');
            tableView.classList.remove('d-none');
            btnGrid.classList.add('btn-light');
            btnGrid.classList.remove('btn-primary', 'text-white');
            btnTable.classList.add('btn-primary', 'text-white');
            btnTable.classList.remove('btn-light');
            localStorage.setItem('library-view', 'table');
        }
    }

    // Set initial view state on load
    document.addEventListener('DOMContentLoaded', () => {
        const preferredView = localStorage.getItem('library-view') || 'grid';
        toggleView(preferredView);
    });
</script>

<style>
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(15, 23, 42, 0.08) !important;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection