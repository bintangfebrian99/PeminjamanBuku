<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanApproved extends Notification
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
            'variant' => 'success',
            'title' => 'Peminjaman Buku Disetujui',
            'message' => 'Peminjaman buku "' . $this->loan->book->judul . '" telah disetujui oleh admin.',
            'loan_id' => $this->loan->id,
            'book_id' => $this->loan->book_id,
            'timestamp' => now()->toDateTimeString(),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Peminjaman Buku Disetujui')
            ->line('Peminjaman buku "' . $this->loan->book->judul . '" telah disetujui.')
            ->action('Lihat Profile', url('/profile'));
    }
}

