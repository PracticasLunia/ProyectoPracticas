<?php

namespace Tests\Feature\Autores;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListarAutoresTest extends TestCase
{

    use RefreshDatabase;

    public function test_devuelve_listado_con_estructura_esperada_200(): void {
        //Realiza peticion get esperando una respuesta en formato JSON
        $response = $this->getJson('/api/autores');

        //Afirmar el codigo de respuesta
        $response->assertStatus(200)
            //Afirme que la respuesta tiene una estructura JSON dada
            ->assertJsonStructure([
                'data',
                'message',
                'errors'
            ])
            //Afirme que la respuesta contiene los datos dados en la ruta especificada
            ->assertJsonPath('message', 'Listado de autores') ;
    }

    public function test_devuelve_array_vacio_cuando_no_hay_autores(): void {

        $response = $this->getJson('/api/autores');

        $response->assertStatus(200)
            //Afirma que la respuesta tiene un array por la clave dada, con el numero de elementos indicado
            ->assertJsonCount(0, 'data');

    }


}
