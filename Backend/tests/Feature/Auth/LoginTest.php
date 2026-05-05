<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    private $user;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        //Usuario registrado
        $this->user= User::factory()->create([
            'password' => 123
        ]);

    }

    public function test_usuario_logueado_con_credenciales_validas(): void {

        $response = $this->postJson('/api/login', [
            'name'                  => $this->user->name ,
            'email'                 => $this->user->email,
            'password'              => 123,
            'password_confirmation' => 123,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
            'token',
            'message',
        ]);
        $response->assertJsonPath('user.email', $this->user->email);
    }

    public function test_usuario_logueado_con_credenciales_invalidas(): void {

        $response = $this->postJson('/api/login', [
            'name'                  => 'Ejemplo' ,
            'email'                 => 'Prueba',
            'password'              => 123,
            'password_confirmation' => 123,
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'user',
            'token',
            'message',
        ]);
        $response->assertJsonPath('token', null);

    }
}
