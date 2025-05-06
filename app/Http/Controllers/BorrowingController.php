<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the borrowings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['book', 'member']);
        
        // Filter by role
        if (Auth::user()->role === 'member') {
            $query->where('member_id', Auth::id());
        }
        
        // Filter by status if provided
        if ($request->filled('status') && in_array($request->status, ['borrowed', 'returned'])) {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
            
            // If admin, also search by member name
            if (Auth::user()->role === 'admin') {
                $query->orWhereHas('member', function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
        }
        
        // Order by most recent borrowings first
        $query->orderBy('borrow_date', 'desc');
        
        // Paginate results
        $borrowings = $query->paginate(10);
        
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for borrowing a book.
     */
    public function create(Book $book)
{
    // Cek jika buku tersedia
    if ($book->available_copies <= 0) {
        return redirect()->route('books.index')->with('error', 'This book is currently unavailable.');
    }

    return view('borrowings.confirm', compact('book'));
}


    /**
     * Store a newly created borrowing in storage.
     */
    public function store(Request $request)
{
    // Validasi input untuk memastikan book_id valid
    $validated = $request->validate([
        'book_id' => 'required|exists:books,book_id',
    ]);

    // Ambil buku berdasarkan book_id yang terpilih
    $book = Book::findOrFail($validated['book_id']);

    // Cek apakah buku tersedia
    if ($book->available_copies < 1) {
        return redirect()->back()->with('error', 'Book is not available.');
    }

    // Mulai transaksi untuk memastikan atomic operation
    DB::beginTransaction();

    try {
        // Simpan data peminjaman buku
        Borrowing::create([
            'book_id' => $book->book_id,
            'member_id' => Auth::id(),
            'borrow_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(7), // Peminjaman 7 hari
            'status' => 'borrowed',
        ]);

        // Kurangi jumlah buku yang tersedia
        $book->update([
            'available_copies' => $book->available_copies - 1
        ]);

        // Commit transaksi
        DB::commit();

        // Redirect ke halaman borrowings.index dengan pesan sukses
        return redirect()->route('borrowings.index')->with('success', 'Book borrowed successfully.');

    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();
        return redirect()->back()->with('error', 'An error occurred. Please try again later.');
    }
}

    /**
     * Show the form for editing the specified borrowing.
     *
     * @param  \App\Models\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrowing $borrowing)
    {
        // Cek apakah user memiliki akses untuk mengedit
        $this->authorize('update', $borrowing);
        
        return view('borrowings.edit', compact('borrowing'));
    }

    /**
     * Update the specified borrowing in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        // Cek apakah user memiliki akses untuk mengedit
        $this->authorize('update', $borrowing);
        
        $validated = $request->validate([
            'due_date' => 'nullable|date|after:borrow_date',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $borrowing->update($validated);
        
        return redirect()->route('borrowings.index')
            ->with('success', 'Borrowing details updated successfully.');
    }

    /**
     * Return the borrowed book.
     *
     * @param  \App\Models\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function returnBook(Borrowing $borrowing)
    {
        // Check if the borrowing is still in 'borrowed' status
        if ($borrowing->status !== 'borrowed') {
            return redirect()->route('borrowings.index')
                ->with('error', 'This book has already been returned.');
        }
        
        // Check if user is authorized to return this book
        if (Auth::user()->role !== 'admin' && $borrowing->member_id !== Auth::id()) {
            return redirect()->route('borrowings.index')
                ->with('error', 'You are not authorized to return this book.');
        }
        
        // Update the borrowing record
        $borrowing->update([
            'status' => 'returned',
            'return_date' => Carbon::now(),
        ]);
        
        // Update book availability
        $book = Book::find($borrowing->book_id);
        if ($book) {
            $book->update([
                'available_copies' => $book->available_copies + 1
            ]);
        }
        
        return redirect()->route('borrowings.index')
            ->with('success', 'Book returned successfully.');
    }
}
