<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'borrowing_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'member_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'borrow_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    /**
     * Get the book associated with the borrowing.
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    /**
     * Get the member who borrowed the book.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Check if the borrowing is overdue.
     *
     * @return bool
     */
    public function isOverdue()
    {
        return $this->status === 'borrowed' && 
               $this->due_date && 
               Carbon::now()->gt($this->due_date);
    }

    /**
     * Get the remaining days before the due date.
     *
     * @return int|null
     */
    public function remainingDays()
    {
        if (!$this->due_date || $this->status === 'returned') {
            return null;
        }
        
        $now = Carbon::now();
        if ($now->gt($this->due_date)) {
            return -$now->diffInDays($this->due_date); // Returns negative number for overdue days
        }
        
        return $now->diffInDays($this->due_date);
    }
}