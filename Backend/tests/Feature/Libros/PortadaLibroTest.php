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


class PortadaLibroTest extends TestCase
{

    use RefreshDatabase;

    private $archivo;
    private $portada;
    private $autor;
    private $libro;
    private $genero1;
    private $genero2;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $this->archivo= UploadedFile::fake()->image('portada.jpg');
        $this->portada= UploadedFile::fake()->image('file.jpg');

        $this->autor = Autor::factory()->create();
        $this->genero1 = Genero::factory()->create();
        $this->genero2 = Genero::factory()->create();

    }

    public function test_libro_con_portada(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->libro = Libro::factory()->create([
            'portada_path'=> $this->portada->store('portadas', 'local'),
            'autor_id' => $this->autor->id,
        ]);
        $this->libro->generos()->attach([$this->genero1->id, $this->genero2->id]);

        $response = $this->get('api/libros/' . $this->libro->id . '/portada');

        $response->assertStatus(200);

    }

    public function test_libro_sin_portada(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->libro = Libro::factory()->create([
            //Path portada nula
            'autor_id' => $this->autor->id,
        ]);
        $this->libro->generos()->attach([$this->genero1->id, $this->genero2->id]);

        $response = $this->get('api/libros/' . $this->libro->id . '/portada');

        $response->assertStatus(404);

    }
}
