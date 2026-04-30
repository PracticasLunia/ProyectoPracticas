<?php

namespace Tests\Feature\Libros;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListarLibrosTest extends TestCase
{

    /* solo ejecutará la prueba dentro de una transacción de base de datos, por cada test*/
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_devuelve_200_y_estructura_esperada(): void {
        //Realiza peticion get esperando una respuesta en formato JSON
        $response = $this->getJson('/api/libros');

        //Afirmar el codigo de respuesta
        $response->assertStatus(200)
            //Afirme que la respuesta tiene una estructura JSON dada
            ->assertJsonStructure([
                'data',
                'message',
            ])
            //Afirme que la respuesta contiene los datos dados en la ruta especificada
            ->assertJsonPath('message', 'Listado de libros') ;
    }

    public function test_devuelve_array_vacio_cuando_no_hay_libros(): void {
        $response = $this->getJson('/api/libros');

        $response->assertStatus(200)
            //Afirma que la respuesta tiene un array por la clave dada, con el numero de elementos indicado
            ->assertJsonCount(0, 'data');
    }




}
