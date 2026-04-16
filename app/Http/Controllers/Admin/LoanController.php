<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Http\Requests\AdminLoanRequest;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function index(): View
    {
        $pendingLoans = Loan::with(['user', 'book'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $loans = Loan::with(['user', 'book'])
            ->latest()
            ->paginate(15);

        $stats = [
            'pending' => Loan::where('status', 'pending')->count(),
            'pinjam' => Loan::where('status', 'pinjam')->count(),
            'rejected' => Loan::where('status', 'rejected')->count(),
            'kembali' => Loan::where('status', 'kembali')->count(),
        ];

        return view('admin.loans.index', compact('pendingLoans', 'loans', 'stats'));
    }

    public function approve(Request $request, Loan $loan): RedirectResponse
    {
        abort_if($loan->status !== 'pending', 403);

        $validated = $request->validate([
            'expected_return_date' => ['required', 'date', 'after_or_equal:today'],
            'expected_return_time' => ['required', 'date_format:H:i'],
        ], [
            'expected_return_date.required' => 'Tanggal pengembalian harus diisi.',
            'expected_return_date.date' => 'Tanggal pengembalian tidak valid.',
            'expected_return_date.after_or_equal' => 'Tanggal pengembalian tidak boleh sebelum hari ini.',
            'expected_return_time.required' => 'Waktu pengembalian harus diisi.',
            'expected_return_time.date_format' => 'Format waktu tidak valid. Gunakan HH:MM.',
        ]);

        DB::transaction(function () use ($loan, $validated) {
            $lockedLoan = Loan::query()->whereKey($loan->id)->lockForUpdate()->firstOrFail();
            $lockedBook = Book::query()->whereKey($loan->book_id)->lockForUpdate()->firstOrFail();

            if ($lockedLoan->status !== 'pending') {
                abort(403);
            }

            if ($lockedBook->stok < 1) {
                throw ValidationException::withMessages([
                    'book' => 'Stok buku tidak mencukupi.',
                ]);
            }

            $lockedLoan->update([
                'status' => 'pinjam',
                'expected_return_date' => $validated['expected_return_date'],
                'expected_return_time' => $validated['expected_return_time'],
                'borrowed_at' => now(),
                'returned_at' => null,
            ]);

            $lockedBook->decrement('stok');
        });

        return redirect()->route('admin.loans.index')
            ->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Loan $loan): RedirectResponse
    {
        abort_if($loan->status !== 'pending', 403);

        $loan->update([
            'status' => 'rejected',
            'borrowed_at' => null,
            'returned_at' => null,
        ]);

        return redirect()->route('admin.loans.index')
            ->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function create(): View
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        $books = Book::where('stok', '>', 0)->orderBy('judul')->get();

        return view('admin.loans.create', compact('users', 'books'));
    }

    public function store(AdminLoanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $book = Book::lockForUpdate()->findOrFail($validated['book_id']);

            if ($validated['status'] === 'pinjam' && $book->stok < 1) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'book_id' => 'Stok buku tidak mencukupi.',
                ]);
            }

            $existing = Loan::where('user_id', $validated['user_id'])
                ->where('book_id', $validated['book_id'])
                ->whereIn('status', ['pending', 'pinjam'])
                ->exists();

            if ($existing && in_array($validated['status'], ['pending', 'pinjam'], true)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'book_id' => 'User sudah memiliki peminjaman aktif untuk buku ini.',
                ]);
            }

            Loan::create($validated + [
                'borrowed_at' => $validated['status'] === 'pinjam' ? now() : null,
                'returned_at' => $validated['status'] === 'kembali' ? now() : null,
            ]);

            if ($validated['status'] === 'pinjam') {
                $book->decrement('stok');
            }
        });

        return redirect()->route('admin.loans.index')
            ->with('success', 'Peminjaman baru berhasil dibuat.');
    }

    public function edit(Loan $loan): View
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        $books = Book::orderBy('judul')->get();

        return view('admin.loans.edit', compact('loan', 'users', 'books'));
    }

    public function update(AdminLoanRequest $request, Loan $loan): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($loan, $validated) {
            $lockedLoan = Loan::query()->whereKey($loan->id)->lockForUpdate()->firstOrFail();

            $existing = Loan::query()
                ->where('user_id', $validated['user_id'])
                ->where('book_id', $validated['book_id'])
                ->whereIn('status', ['pending', 'pinjam'])
                ->whereKeyNot($lockedLoan->id)
                ->exists();

            if ($existing && in_array($validated['status'], ['pending', 'pinjam'], true)) {
                throw ValidationException::withMessages([
                    'book_id' => 'User sudah memiliki peminjaman aktif untuk buku ini.',
                ]);
            }

            $bookIds = array_values(array_unique([$lockedLoan->book_id, $validated['book_id']]));
            $books = Book::query()
                ->whereIn('id', $bookIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $adjustments = [];

            if ($lockedLoan->status === 'pinjam') {
                $adjustments[$lockedLoan->book_id] = ($adjustments[$lockedLoan->book_id] ?? 0) + 1;
            }

            if ($validated['status'] === 'pinjam') {
                $adjustments[$validated['book_id']] = ($adjustments[$validated['book_id']] ?? 0) - 1;
            }

            foreach ($adjustments as $bookId => $delta) {
                if ($delta < 0 && $books[$bookId]->stok < abs($delta)) {
                    throw ValidationException::withMessages([
                        'book_id' => 'Stok buku tidak mencukupi.',
                    ]);
                }
            }

            foreach ($adjustments as $bookId => $delta) {
                if ($delta > 0) {
                    $books[$bookId]->increment('stok', $delta);
                }

                if ($delta < 0) {
                    $books[$bookId]->decrement('stok', abs($delta));
                }
            }

            $payload = $validated + [
                'borrowed_at' => match ($validated['status']) {
                    'pinjam' => $lockedLoan->status === 'pinjam'
                        ? ($lockedLoan->borrowed_at ?? now())
                        : now(),
                    'kembali' => $lockedLoan->borrowed_at ?? now(),
                    default => null,
                },
                'returned_at' => $validated['status'] === 'kembali' ? ($lockedLoan->returned_at ?? now()) : null,
            ];

            $lockedLoan->update($payload);
        });

        return redirect()->route('admin.loans.index')
            ->with('success', 'Peminjaman berhasil diupdate.');
    }

    public function destroy(Loan $loan): RedirectResponse
    {
        DB::transaction(function () use ($loan) {
            if ($loan->status === 'pinjam') {
                $book = Book::lockForUpdate()->findOrFail($loan->book_id);
                $book->increment('stok');
            }
            $loan->delete();
        });

        return redirect()->route('admin.loans.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }
}
