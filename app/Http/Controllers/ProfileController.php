<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Notifications\DatabaseNotification;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $loans = Loan::with('book')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $notifications = $user->notifications()->latest()->limit(10)->get();
        $unreadCount = $user->unreadNotifications()->count();

        return view('profile', [
            'user' => $user,
            'loans' => $loans,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'stats' => [
                'total_loans' => Loan::where('user_id', $user->id)->count(),
                'active_loans' => Loan::where('user_id', $user->id)->where('status', 'pinjam')->count(),
                'returned_loans' => Loan::where('user_id', $user->id)->where('status', 'kembali')->count(),
            ]
        ]);
    }

    public function markNotificationRead($id): JsonResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }
}

