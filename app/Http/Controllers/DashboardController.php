<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $books = Book::latest()->take(6)->get();
        $activeLoans = Loan::with('book')
            ->where('user_id', $user->id)
            ->where('status', 'pinjam')
            ->latest()
            ->get();

        $recentLoans = $user->isAdmin()
            ? Loan::with(['book', 'user'])->latest()->take(5)->get()
            : collect();

        return view('dashboard', [
            'books' => $books,
            'activeLoans' => $activeLoans,
            'activeLoanBookIds' => $activeLoans->pluck('book_id')->all(),
            'recentLoans' => $recentLoans,
            'stats' => [
                'books' => Book::count(),
                'available_books' => Book::where('stok', '>', 0)->count(),
                'active_loans' => Loan::where('status', 'pinjam')->count(),
                'returned_loans' => Loan::where('status', 'kembali')->count(),
                'users' => User::count(),
            ],
            'isAdmin' => $user->isAdmin(),
            'userName' => $user->name,
        ]);
    }

    public function adminIndex(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'books' => Book::count(),
            'available_books' => Book::where('stok', '>', 0)->count(),
            'active_loans' => Loan::where('status', 'pinjam')->count(),
            'returned_loans' => Loan::where('status', 'kembali')->count(),
            'users' => User::count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
            'user' => $user,
        ]);
    }
}
