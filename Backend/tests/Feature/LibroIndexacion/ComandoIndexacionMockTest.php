<?php

namespace Tests\Feature\LibroIndexacion;

use App\Models\Autor;
use App\Models\Libro;
use App\Services\LibroIndexacionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Mockery;

class ComandoIndexacionMockTest extends TestCase
{
    use RefreshDatabase;


    private Autor $autor;
    private Libro $libro;


    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $this->autor = Autor::factory()->create();
    }


    public function test_comando_indexacion(): void
    {

        Storage::disk('local')->put(
            'contenidos/test.pdf',
            '%PDF-1.4
            1 0 obj
            <<
            >>
            endobj
            trailer
            <<
            >>
            %%EOF'
        );


        $this->libro = Libro::factory()->create([
            'autor_id' => $this->autor->id,
            'contenido_path' => 'contenidos/test.pdf',
        ]);


        $mockServicio = Mockery::mock(
            LibroIndexacionService::class
        );


        $mockServicio
            ->shouldReceive('handle')
            ->once()
            ->andReturn(null);

        $this->app->instance(
            LibroIndexacionService::class,
            $mockServicio
        );

        //Lanzar comando
        $this->artisan('libros:indexar-contenidos')
            ->assertSuccessful();


        $this->assertDatabaseHas('libros', [
            'id' => $this->libro->id,
            'contenido_path' => 'contenidos/test.pdf',
        ]);

    }


    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
