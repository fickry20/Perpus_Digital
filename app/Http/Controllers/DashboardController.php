<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $recentBorrowings = Borrowing::with(['book', 'member'])
                ->latest('borrow_date')
                ->take(5)
                ->get();
        } else {
            $recentBorrowings = Borrowing::with('book')
                ->where('member_id', Auth::id())
                ->latest('borrow_date')
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('recentBorrowings'));
    }
}
