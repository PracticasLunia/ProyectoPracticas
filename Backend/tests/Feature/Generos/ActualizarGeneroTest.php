<?php

namespace Tests\Feature\Generos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;
use App\Models\Genero;
use App\Models\User;
use Laravel\Sanctum\Sanctum;


class ActualizarGeneroTest extends TestCase
{
    use RefreshDatabase;

    private $genero;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->genero=Genero::factory()->create();

    }

    public function test_actualizar_genero_existente(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = $this->genero->toArray();
        $data['nombre']='Nuevo nombre';
        $data['descripcion']= 'Nueva descripcion';

        $response = $this->putJson("api/generos/{$data['id']}", $data);

        $response->assertStatus(200);

        // Verifica la respuesta JSON
        $response->assertJson([
            'data' => [
                'nombre' => 'Nuevo nombre',
                'descripcion' => 'Nueva descripcion',
            ],
            'message' => 'Genero actualizado correctamente',
        ]);
    }

    public function test_actualizar_genero_inexistente(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = $this->genero->toArray();
        $data['nombre']='Nuevo nombre';
        $data['descripcion']= 'Nueva descripcion';

        $response = $this->putJson("api/generos/5", $data);

        $response->assertStatus(404);

        // Verifica la respuesta JSON
        $response->assertJson([
            'data' => null,
            'message' => 'Genero no encontrado',
        ]);
    }

    public function test_actualizar_genero_con_campos_invalidos(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = $this->genero->toArray();
        $data['nombre']=123;

        $response = $this->putJson("api/generos/{$data['id']}", $data);

        $response->assertStatus(422);

        // Verifica la respuesta JSON
        $response->assertJson([
            'data' => null,
            'message' => 'Error al intentar actualizar el genero',
        ]);
    }
}
