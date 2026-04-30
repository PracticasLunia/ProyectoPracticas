<?php

namespace Tests\Feature\Auth;

use App\Mail\BienvenidoMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registra_usuario_devuelve_token_y_envia_email(): void
    {
        //Es una forma de simular peticiones HTTP externas en tests.
        Mail::fake();

        $respuesta = $this->postJson('/api/register', [
            'name'                  => 'Pepe Lector',
            'email'                 => 'pepe@test.local',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        //Afirme el estado de la respuesta y la estructura de la misma y cierto contenido
        $respuesta->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email'],
                'token',
                'message',
            ])
            ->assertJsonPath('user.email', 'pepe@test.local');

        /*Afirme que una tabla en la base de datos contiene registros que coinciden con las
        restricciones de clave / consulta de valor dadas: */
        $this->assertDatabaseHas('users', [
            'email' => 'pepe@test.local',
            'name'  => 'Pepe Lector',
        ]);

        //Inpeccionar la solicitud que recibe el cliente para asegurarse que esta enviando los datos correctos
        //Devuelve un booleano si cumple las expectativas
        Mail::assertSent(BienvenidoMail::class, function ($mail) {
            return $mail->hasTo('pepe@test.local');
        });
    }

    public function test_falla_con_422_si_el_email_ya_existe(): void
    {

        \App\Models\User::factory()->create([
            'email' => 'duplicado@test.local',
        ]);

        $respuesta = $this->postJson('/api/register', [
            'name'                  => 'Otro',
            'email'                 => 'duplicado@test.local',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        // Afirme que la respuesta tiene los errores de validación JSON dados para las claves dadas.
        $respuesta->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
