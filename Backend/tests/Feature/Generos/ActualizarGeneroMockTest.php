<?php

namespace Tests\Feature\Generos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Genero;
use App\Repositories\Genero\GeneroRepositoryInterface;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Mockery;

class ActualizarGeneroMockTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_actualizar_genero_devuelve_200(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $genero = Genero::factory()->make();

        $mock = Mockery::mock(GeneroRepositoryInterface::class);

        $mock->shouldReceive('getById')
            ->once()
            ->andReturn($genero);

        $mock->shouldReceive('update')
            ->once()
            ->andReturn($genero);

        $this->app->instance(
            GeneroRepositoryInterface::class,
            $mock
        );

        $response = $this->putJson('/api/generos/1', [
            'nombre' => 'Nuevo',
            'descripcion' => 'Nuevo',
        ]);

        $response->assertStatus(200);
    }
}
