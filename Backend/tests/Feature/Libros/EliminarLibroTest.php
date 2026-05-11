<?php

namespace Tests\Feature\Libros;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Libro;
use App\Models\Autor;
use App\Models\Genero;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Override;

class EliminarLibroTest extends TestCase
{
    use RefreshDatabase;

    private $autor;
    private $libro;
    private $genero1;
    private $genero2;

    #[Override]
    function setUp(): void
    {
        parent::setUp();

        $this->autor = Autor::factory()->create();
        $this->genero1 = Genero::factory()->create();
        $this->genero2 = Genero::factory()->create();
        $this->libro  = Libro::factory()->create([
            'autor_id' => $this->autor->id,
        ]);
        $this->libro->generos()->attach([$this->genero1->id, $this->genero2->id]);

    }

    /**
     * A basic feature test example.
     */
    public function test_eliminar_libro_existente(): void
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data= $this->libro->toArray() ;

        $response = $this->deleteJson("api/libros/{$data['id']}");

        $response->assertStatus(204);

    }

    public function test_eliminar_libro_no_existente(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson("api/libros/10");

        $response->assertStatus(404);

    }
}
