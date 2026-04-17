<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanRequestAdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_loan_request_creates_notification_for_each_admin(): void
    {
        $adminA = User::factory()->create(['role' => 'admin']);
        $adminB = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $book = Book::factory()->create(['stok' => 3]);

        $response = $this->actingAs($user)->post(route('loans.store', $book), [
            'expected_return_date' => now()->addDay()->toDateString(),
            'expected_return_time' => '10:00',
            'alamat' => 'Bandung',
            'nomor_hp' => '081234567890',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => (string) $adminA->id,
            'type' => \App\Notifications\LoanRequestedToAdmin::class,
        ]);
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => (string) $adminB->id,
            'type' => \App\Notifications\LoanRequestedToAdmin::class,
        ]);
    }
}
