<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use App\Notifications\LoanRequestedToAdmin;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function store(LoanRequest $request, Book $book): RedirectResponse
    {
        $userId = $request->user()->id;
        $loan = null;

        DB::transaction(function () use ($book, $userId, $request, &$loan) {
            $lockedBook = Book::query()->whereKey($book->id)->lockForUpdate()->firstOrFail();

            if ($lockedBook->stok < 1) {
                throw ValidationException::withMessages([
                    'book_id' => 'Stok buku habis.',
                ]);
            }

            $alreadyBorrowed = Loan::query()
                ->where('user_id', $userId)
                ->where('book_id', $book->id)
                ->whereIn('status', ['pinjam', 'pending'])
                ->exists();

            if ($alreadyBorrowed) {
                throw ValidationException::withMessages([
                    'book_id' => 'Kamu sudah mengajukan atau meminjam buku ini.',
                ]);
            }

            $loan = Loan::create([
                'user_id' => $userId,
                'book_id' => $book->id,
                'status' => 'pending',
                'expected_return_date' => $request->input('expected_return_date'),
                'expected_return_time' => $request->input('expected_return_time'),
                'alamat' => $request->input('alamat'),
                'nomor_hp' => $request->input('nomor_hp'),
                'borrowed_at' => null,
            ]);

            // Stock is reduced only after admin approval.
        });

        if ($loan) {
            $loan->loadMissing(['user', 'book']);

            User::query()
                ->where('role', 'admin')
                ->each(fn (User $admin) => $admin->notify(new LoanRequestedToAdmin($loan)));
        }

        return back()->with('success', 'Permintaan peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

    public function markReturned(Request $request, Loan $loan): RedirectResponse
    {
        abort_unless($loan->user_id === $request->user()->id || $request->user()->isAdmin(), 403);

        abort_if($loan->status !== 'pinjam', 403);

        DB::transaction(function () use ($loan) {
            $lockedLoan = Loan::query()->whereKey($loan->id)->lockForUpdate()->firstOrFail();

            abort_if($lockedLoan->status !== 'pinjam', 403);

            $lockedBook = Book::query()->whereKey($lockedLoan->book_id)->lockForUpdate()->firstOrFail();

            $lockedLoan->update([
                'status' => 'kembali',
                'returned_at' => now(),
            ]);

            $lockedBook->increment('stok');
        });

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
