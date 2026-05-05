<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class LogoutTest extends TestCase
{

    use RefreshDatabase;

    public function test_logout_usuario_autenticado(): void {

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Logout correcto');
        $this->assertDatabaseCount('personal_access_tokens', 0);

    }
}
