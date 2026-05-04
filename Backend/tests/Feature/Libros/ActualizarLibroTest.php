<?php

namespace Tests\Feature\Libros;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;
use App\Models\Libro;
use App\Models\Autor;
use App\Models\Genero;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ActualizarLibroTest extends TestCase
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

    public function test_update_libro(): void
    {
        //$genero3= Genero::factory()->create();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = $this->libro->toArray();

        // Modificar los campos manteniendo los demas
        $data['titulo'] = 'Nuevo título';
        $data['sinopsis'] = 'Nueva sinopsis';
        //Enviar los id de generos de la relacion
        $data['genero_ids'] = $this->libro->generos()->pluck('generos.id')->toArray();

        $response = $this->putJson("api/libros/{$data['id']}", $data);

        $response->assertStatus(200);

        // Verifica la respuesta JSON
        $response->assertJson([
            'data' => [
                'titulo' => 'Nuevo título',
                'sinopsis' => 'Nueva sinopsis',
            ],
            'message' => 'Libro actualizado correctamente',
        ]);
    }

    public function test_validation_exception_return_422(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $ids= [10,11,12];

        $data = $this->libro->toArray();

        // Modificar los campos manteniendo los demas
        $data['titulo'] = 'Nuevo título';
        $data['num_paginas'] = 'Trescientas';
        //Enviar los id de generos de la relacion
        $data['genero_ids'] = $this->libro->generos()->pluck('generos.id')->toArray();

        $response = $this->putJson("api/libros/{$data['id']}", $data);

        $response->assertStatus(422);

        // Verifica la respuesta JSON
        $response->assertJson([
            'data' => null,
            'message' => 'Error al intentar actualizar el libro',
        ]);
    }

    /*public function test_actualizar_libro_no_existente_devuelve_404(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = $this->libro->toArray();

        // Modificar los campos manteniendo los demas
        $data['titulo'] = 'Nuevo título';
        $data['sinopsis'] = 'Nueva sinopsis';
        //Enviar los id de generos de la relacion
        $data['genero_ids'] = $this->libro->generos()->pluck('generos.id')->toArray();

        $response = $this->putJson("api/libros/{12}", $data);

        $response->assertStatus(404);

    }*/
}
