<?php

namespace Tests\Feature\LibroIndexacion;

use App\Models\Autor;
use App\Models\Libro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibroSinContenidoIndexacionTest extends TestCase
{
    use RefreshDatabase;


    private Autor $autor;


    protected function setUp(): void
    {
        parent::setUp();

        $this->autor = Autor::factory()->create();
    }


    public function test_libro_sin_contenido_no_rompe_indexacion(): void
    {

        $libro = Libro::factory()->create([
            'autor_id' => $this->autor->id,
            'contenido_path' => null,
        ]);


        $this->artisan('libros:indexar-contenidos')
            ->assertSuccessful();


        $this->assertDatabaseMissing('libro_fragmentos', [
            'libro_id' => $libro->id,
        ]);

    }

}
