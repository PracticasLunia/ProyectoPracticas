<?php

namespace Tests\Feature\Autores;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Autor;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Override;

class CrearAutorTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    function setUp(): void
    {
        parent::setUp();

    }

    public function test_creacion_de_nuevo_autor_y_lo_devuelve_junto_a_mensaje(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data= Autor::factory()->make()->toArray();

        $response = $this->postJson('api/autores', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('autores', [
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
        ]);
    }

    public function test_crear_autor_con_campos_invalidos(): void{

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $data= Autor::factory()->make([
            "nombre" => 123,
        ])->toArray();

        $response = $this->postJson('api/autores', $data);

        $response->assertStatus(422)

            /*->assertJsonStructure([
                'data',
                'message',
                'errors'
            ])
            //Afirme que la respuesta contiene los datos dados en la ruta especificada
            ->assertJsonPath('message', 'El autor no se pudo crear, errores de validación')*/
            ;
    }

}
