<?php

namespace Tests\Feature\Admin;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_approval_creates_notification_for_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $book = Book::factory()->create(['stok' => 3]);
        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.loans.approve', $loan), [
            'expected_return_date' => now()->addDay()->toDateString(),
            'expected_return_time' => '10:00',
        ]);

        $response->assertRedirect(route('admin.loans.index'));
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => (string) $user->id,
            'type' => \App\Notifications\LoanApproved::class,
        ]);
    }

    public function test_admin_rejection_creates_notification_for_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $book = Book::factory()->create(['stok' => 3]);
        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.loans.reject', $loan), [
            'rejected_reason' => 'Stok sedang diprioritaskan.',
        ]);

        $response->assertRedirect(route('admin.loans.index'));
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => (string) $user->id,
            'type' => \App\Notifications\LoanRejected::class,
        ]);
    }
}
