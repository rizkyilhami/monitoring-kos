<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_payment_history_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);

        $response = $this->actingAs($admin)->get('/admin/history');

        $response->assertStatus(200);
        $response->assertSee('Riwayat Pembayaran');
        $response->assertSee('Kamar 1');
    }
}
