<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $loans = Loan::with('book')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('profile', [
            'user' => $user,
            'loans' => $loans,
            'stats' => [
                'total_loans' => Loan::where('user_id', $user->id)->count(),
                'active_loans' => Loan::where('user_id', $user->id)->where('status', 'pinjam')->count(),
                'returned_loans' => Loan::where('user_id', $user->id)->where('status', 'kembali')->count(),
            ]
        ]);
    }
}

