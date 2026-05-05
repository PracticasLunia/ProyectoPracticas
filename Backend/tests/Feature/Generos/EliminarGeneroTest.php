<?php

namespace Tests\Feature\Generos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Genero;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Override;

class EliminarGeneroTest extends TestCase
{
    use RefreshDatabase;

    private $genero;

    #[Override]
    function setUp(): void
    {
        parent::setUp();
        $this->genero=Genero::factory()->create();
    }

    public function test_eliminar_genero_existente_devuelve_200(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data= $this->genero->toArray() ;

        $response = $this->deleteJson("api/generos/{$data['id']}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'message',
            'errors',
        ]);
        $response->assertJsonPath('message', 'Genero eliminado');
        $this->assertDatabaseCount('generos', 0);
    }

    public function test_eliminar_genero_no_existente_devuelve_404(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data= $this->genero->toArray() ;

        $response = $this->deleteJson("api/generos/9");
        $response->assertStatus(404);
        $this->assertDatabaseCount('generos', 1);
    }
}
