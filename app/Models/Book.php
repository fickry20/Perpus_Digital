<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'year_published',
        'quantity_available',
    ];

    /**
     * Get the borrowings for the book.
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'book_id');
    }
}
