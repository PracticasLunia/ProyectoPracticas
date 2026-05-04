<?php

namespace Tests\Feature\Autores;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;
use App\Models\Autor;
use App\Models\Libro;
use App\Models\Genero;

class LibrosDeAutorTest extends TestCase
{

    use RefreshDatabase;

    private $autor;
    private $libro;
    private $genero;

    #[Override]
    function setUp(): void
    {
        parent::setUp();

        $this->autor = Autor::factory()->create();
        $this->genero = Genero::factory()->create();
        $this->libro  = Libro::factory()->create([
            'autor_id' => $this->autor->id,
        ]);
        $this->libro->generos()->attach([$this->genero->id]);
    }

    public function test_devuelve_listado_de_libros_junto_genero_de_un_autor(): void {

        $data = $this->libro->toArray();

        $response = $this->getJson("api/autores/{$this->autor->id}/libros");

        $response->assertStatus(200);

        // Verifica la respuesta JSON
        $response->assertJsonStructure([
            'data'=>[
                // * Indica que se encuentra dentro de un array
                '*' => [
                    'titulo',
                    'isbn',
                    'generos' => [
                        '*' => ['id', 'descripcion', 'nombre']
                    ]
                ]
            ],
            'message',
            'errors'
        ]);

        $response->assertJsonFragment([
            'descripcion' => $this->genero->descripcion
        ]);

    }

    public function test_listado_de_libros_de_autor_no_existente_devuelve_404(): void {

        $response = $this->getJson("api/autores/90/libros");

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data',
            'message',
            'errors'
        ]);
        $response->assertJsonPath('message', 'Autor no encontrado');
    }

}
