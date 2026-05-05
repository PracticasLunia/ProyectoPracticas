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

class CrearLibroTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    private $autor;
    private $libro;
    //private $generos = [];
    private $genero1;
    private $genero2;

    //Funcion que se ejecuta para preparar cada test
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->autor = Autor::factory()->create();
        $this->genero1 = Genero::factory()->create();
        $this->genero2 = Genero::factory()->create();

    }


    public function test_return_201_code(): void
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->libro  = Libro::factory()->make([
            'autor_id' => $this->autor->id,
            'genero_ids' => [$this->genero1->id, $this->genero2->id]
        ]);
        $data = $this->libro->toArray();

        $response = $this->postJson('api/libros', $data);

        $response->assertStatus(201);
    }

    public function test_exists_in_database(){

        $this->assertDatabaseCount('libros',0);

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->libro  = Libro::factory()->make([
            'autor_id' => $this->autor->id,
            'genero_ids' => [$this->genero1->id, $this->genero2->id]
        ]);

        $data = $this->libro->toArray();

        $response = $this->postJson('api/libros', $data);

        $this->assertDatabaseCount('libros',1);
    }

    public function test_validation_exception(){

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->libro  = Libro::factory()->make([
            'autor_id' => 10,
            'genero_ids' => [$this->genero1->id, $this->genero2->id]
        ]);

        $data = $this->libro->toArray();

        $response = $this->postJson('api/libros', $data);

        $response->assertStatus(422)

            ->assertJsonStructure([
                'data',
                'message',
                'errors'
            ])
            //Afirme que la respuesta contiene los datos dados en la ruta especificada
            ->assertJsonPath('message', 'Error al intentar crear el libro') ;

    }
}
