<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
{
    $search = $request->get('search');
    
    // Menggunakan query untuk pencarian dan paginasi
    $books = Book::when($search, function ($query, $search) {
        return $query->where('title', 'like', "%$search%")
                     ->orWhere('author', 'like', "%$search%")
                     ->orWhere('isbn', 'like', "%$search%");
    })->paginate(10);

    return view('books.index', compact('books'));
}


    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required',
            'title' => 'required',
            'author' => 'required',
            'year_published' => 'required|digits:4|integer',
            'quantity_available' => 'required|integer',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'isbn' => 'required',
            'title' => 'required',
            'author' => 'required',
            'year_published' => 'required|digits:4|integer',
            'quantity_available' => 'required|integer',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
