<?php

namespace Tests\Feature\Generos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Genero;

class CrearGeneroTest extends TestCase
{
    use RefreshDatabase;

    public function test_creacion_nuevo_genero_devuelve_200_y_genero(): void
    {
        $data=Genero::factory()->make()->toArray();

        $response = $this->postJson('api/generos', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('generos', [
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
        ]);
    }

    public function test_creacion_de_genero_con_excepcion_de_validacion_devuelve_422(): void {

        $data=Genero::factory()->make([
            "nombre"=> 123
        ])
        ->toArray();

        $response = $this->postJson('api/generos', $data);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'Error al intentar crear el genero');
        //Verificar que no se inserto en la bd
        $this->assertDatabaseCount('generos', 0);
    }
}
