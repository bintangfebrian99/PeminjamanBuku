<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'createRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/books', [BookController::class, 'publicIndex'])->name('books.index');
    Route::get('/books/{book}/cover', [BookController::class, 'cover'])->name('books.cover');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [DashboardController::class, 'adminIndex'])->name('dashboard');
    Route::resource('books', BookController::class)->except(['show']);
    Route::resource('loans', AdminLoanController::class);
    Route::post('loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('loans.approve');
    Route::post('loans/{loan}/reject', [AdminLoanController::class, 'reject'])->name('loans.reject');
});

Route::middleware(['auth', 'role:user'])->group(function (): void {
    Route::post('/books/{book}/borrow', [LoanController::class, 'store'])->name('loans.store');
    Route::post('/loans/{loan}/return', [LoanController::class, 'markReturned'])->name('loans.return');
});
