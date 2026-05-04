<?php

namespace Tests\Feature\Autores;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Autor;
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

        $data= Autor::factory()->make()->toArray();

        $response = $this->postJson('api/autores', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('autores', [
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
        ]);
    }

    public function test_crear_autor_con_campos_invalidos(): void{



    }

}
