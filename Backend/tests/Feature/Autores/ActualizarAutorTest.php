<?php

namespace Tests\Feature\Autores;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Autor;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Override;

class ActualizarAutorTest extends TestCase
{

    use RefreshDatabase;

    private $autor;

    #[Override]
    function setUp(): void
    {
        parent::setUp();
        $this->autor = Autor::factory()->create();
    }

    public function test_actualizar_autor_devuelve_200(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = $this->autor->toArray();
        // Modificar los campos manteniendo los demas
        $data['nombre'] = 'Nuevo nombre';
        $data['apellidos'] = 'Nuevo apellido';

        $response = $this->putJson("api/autores/{$data['id']}", $data);

        $response->assertStatus(200)
            // Verifica la respuesta JSON
            ->assertJson([
                'data' => [
                    'nombre' => 'Nuevo nombre',
                    'apellidos' => 'Nuevo apellido',
                ],
                'message' => 'Autor actualizado correctamente',
            ]);
    }

    public function tests_actualizar_autor_con_campos_invalidos_devuelve_422(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = $this->autor->toArray();
        // Modificar los campos manteniendo los demas
        $data['nombre'] = 123;
        $data['apellidos'] = 456;

        $response = $this->putJson("api/autores/{$data['id']}", $data);

        $response->assertStatus(422)
            // Verifica la respuesta JSON
            ->assertJson([
                'data' => null,
                'message' => 'Error al intentar actualizar el autor',
            ]);
    }

    public function tests_actualizar_autor_no_existente(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);

       $data = $this->autor->toArray();
        // Modificar los campos manteniendo los demas
        $data['nombre'] = 'Nuevo nombre';
        $data['apellidos'] = 'Nuevo apellido';

        $response = $this->putJson("api/autores/20", $data);

        $response->assertStatus(404)
            // Verifica la respuesta JSON
            ->assertJson([
                'data' => null,
                'message' => 'Autor no encontrado',
            ]);
    }

}
