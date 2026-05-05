<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_autenticado_devuelve_datos(): void
    {
        $user = User::factory()->create();

        // Simula usuario autenticado
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/user');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at'
            ],
            'message'
        ]);

        $response->assertJsonPath('user.id', $user->id);
        $response->assertJsonPath('user.email', $user->email);
        $response->assertJsonPath('message', 'Usuario encontrado');
    }

    public function test_usuario_no_autenticado_devuelve_401(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }
}
