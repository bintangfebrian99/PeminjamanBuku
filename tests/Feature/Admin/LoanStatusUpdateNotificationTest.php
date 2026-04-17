<?php

namespace Tests\Feature\Admin;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanStatusUpdateNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_store_with_pinjam_status_creates_notification_for_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $book = Book::factory()->create(['stok' => 3]);

        $response = $this->actingAs($admin)->post(route('admin.loans.store'), [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pinjam',
            'expected_return_date' => now()->addDay()->toDateString(),
            'expected_return_time' => '10:00',
            'alamat' => 'Bandung',
            'nomor_hp' => '08123456789',
        ]);

        $response->assertRedirect(route('admin.loans.index'));
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => (string) $user->id,
            'type' => \App\Notifications\LoanApproved::class,
        ]);
    }

    public function test_admin_update_to_rejected_creates_notification_for_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $book = Book::factory()->create(['stok' => 3]);
        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
            'alamat' => 'Bandung',
            'nomor_hp' => '08123456789',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.loans.update', $loan), [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'rejected',
            'expected_return_date' => now()->addDay()->toDateString(),
            'expected_return_time' => '10:00',
            'rejected_reason' => 'Permintaan belum bisa diproses.',
            'alamat' => 'Bandung',
            'nomor_hp' => '08123456789',
        ]);

        $response->assertRedirect(route('admin.loans.index'));
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => (string) $user->id,
            'type' => \App\Notifications\LoanRejected::class,
        ]);
    }
}
