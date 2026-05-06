<?php

namespace Tests\Feature\Libros;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;
use App\Models\Libro;
use App\Models\Autor;
use App\Models\Genero;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ContenidoLibroTest extends TestCase
{
    use RefreshDatabase;

    private $contenido;
    private $autor;
    private $libro;
    private $genero1;
    private $genero2;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $this->contenido= UploadedFile::fake()->image('contenido.jpg');

        $this->autor = Autor::factory()->create();
        $this->genero1 = Genero::factory()->create();
        $this->genero2 = Genero::factory()->create();

    }

    public function test_crear_libro_con_contenido(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->libro = Libro::factory()->create([
            'contenido_path'=> $this->contenido->store('contenidos', 'local'),
            'autor_id' => $this->autor->id,
        ]);
        $this->libro->generos()->attach([$this->genero1->id, $this->genero2->id]);

        $response = $this->get('api/libros/' . $this->libro->id . '/contenido');

        $response->assertStatus(200);
    }

    public function test_crear_libro_sin_contenido(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->libro = Libro::factory()->create([
            //Libro sin contenido
            'autor_id' => $this->autor->id,
        ]);
        $this->libro->generos()->attach([$this->genero1->id, $this->genero2->id]);

        $response = $this->get('api/libros/' . $this->libro->id . '/contenido');

        $response->assertStatus(404);
    }

}
