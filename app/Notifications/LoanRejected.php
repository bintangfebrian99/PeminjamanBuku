<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanRejected extends Notification
{
    use Queueable;

    public function __construct(protected Loan $loan)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Add 'mail' if email configured
    }

    public function toArray(object $notifiable): array
    {
        $this->loan->loadMissing('book');

        return [
            'variant' => 'danger',
            'title' => 'Peminjaman Buku Ditolak',
            'message' => 'Peminjaman buku "' . $this->loan->book->judul . '" telah ditolak oleh admin.',
            'reason' => $this->loan->rejected_reason,
            'loan_id' => $this->loan->id,
            'book_id' => $this->loan->book_id,
            'timestamp' => now()->toDateTimeString(),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Peminjaman Buku Ditolak')
            ->line('Peminjaman buku "' . $this->loan->book->judul . '" telah ditolak.')
            ->line('Alasan: ' . ($this->loan->rejected_reason ?? 'Tidak disebutkan'))
            ->action('Lihat Profile', url('/profile'));
    }
}

