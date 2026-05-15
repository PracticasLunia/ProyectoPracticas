<?php

namespace Tests\Feature\Generos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Genero;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class CrearGeneroTest extends TestCase
{
    use RefreshDatabase;

    public function test_creacion_nuevo_genero_devuelve_200_y_genero(): void
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data=Genero::factory()->make()->toArray();

        $response = $this->postJson('api/generos', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('generos', [
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
        ]);
    }

    public function test_creacion_nuevo_genero_sin_login_devuelve_401(): void{

        $data=Genero::factory()->make()->toArray();

        $response = $this->postJson('api/generos', $data);

        $response->assertStatus(401);
        $this->assertDatabaseCount('generos',0);

    }

    public function test_creacion_de_genero_con_excepcion_de_validacion_devuelve_422(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data=Genero::factory()->make([
            "nombre"=> 123
        ])
        ->toArray();

        $response = $this->postJson('api/generos', $data);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'El nombre debe ser un texto');
        //Verificar que no se inserto en la bd
        $this->assertDatabaseCount('generos', 0);
    }
}
