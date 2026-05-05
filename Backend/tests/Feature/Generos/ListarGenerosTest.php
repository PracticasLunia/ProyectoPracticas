<?php

namespace Tests\Feature\Generos;

use App\Models\Genero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListarGenerosTest extends TestCase
{
    use RefreshDatabase;

    public function test_devuelve_listado_con_estructura_esperada(): void {

        $genero= Genero::factory()->create();

        $response = $this->getJson('/api/generos');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'message',
            'errors'
        ]);
        $response->assertJsonPath('message', 'Listado de generos');
        $response->assertJsonCount(1, 'data');
    }

    public function test_devuelve_listado_vacio_cuando_no_hay_generos(): void {

        $response = $this->getJson('/api/generos');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');

    }
}
