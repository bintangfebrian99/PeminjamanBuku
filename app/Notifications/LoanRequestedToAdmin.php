<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LoanRequestedToAdmin extends Notification
{
    use Queueable;

    public function __construct(protected Loan $loan)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $this->loan->loadMissing(['user', 'book']);

        return [
            'variant' => 'info',
            'title' => 'Permintaan Peminjaman Baru',
            'message' => $this->loan->user->name . ' mengajukan peminjaman buku "' . $this->loan->book->judul . '".',
            'loan_id' => $this->loan->id,
            'book_id' => $this->loan->book_id,
            'user_id' => $this->loan->user_id,
            'timestamp' => now()->toDateTimeString(),
        ];
    }
}
