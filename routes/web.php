<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Books routes
    Route::resource('books', BookController::class);
    
    // Borrowings routes
    Route::get('/borrowings/confirm/{book}', [BorrowingController::class, 'create'])->name('borrowings.create');
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrowings/{borrowing}/edit', [BorrowingController::class, 'edit'])->name('borrowings.edit');
    Route::put('/borrowings/{borrowing}', [BorrowingController::class, 'update'])->name('borrowings.update');
    Route::put('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
    Route::put('/borrowings/return/{borrowing}', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

});

require __DIR__ . '/auth.php';