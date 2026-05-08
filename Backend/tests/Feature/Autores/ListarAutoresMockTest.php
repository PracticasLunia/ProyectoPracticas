<?php

namespace Tests\Feature\Autores;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\Autor\AutorRepositoryInterface;
use Mockery;

class ListarAutoresMockTest extends TestCase
{
    public function test_listado_usa_repositorio_y_devuelve_200(): void {
        //crea un objeto falso
        $repo = Mockery::mock(AutorRepositoryInterface::class);

        //Cuando llame a ese metodo
        $repo->shouldReceive('getAll')
            ->once()
            //Devuelve esto
            ->andReturn(collect([
                ['id' => 1, 'nombre' => 'Isaac', 'apellidos' => 'Asimov'],
                ['id' => 2, 'nombre' => 'Ursula', 'apellidos' => 'Le Guin'],
            ]));

        //Le dice al contenedor, cuando alguien pida este repositorio, usa el mock
        $this->app->instance(AutorRepositoryInterface::class, $repo);

        //Hacer una peticion y flujo normal
        $response = $this->getJson('/api/autores');

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Listado de autores')
            ->assertJsonCount(2, 'data');
    }
}
