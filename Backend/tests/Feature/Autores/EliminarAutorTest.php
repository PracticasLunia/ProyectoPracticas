<?php

namespace Tests\Feature\Autores;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Autor;

class EliminarAutorTest extends TestCase
{
    use RefreshDatabase;

    private $autor;

    #[Override]
    function setUp(): void
    {
        parent::setUp();
        $this->autor = Autor::factory()->create();

    }

    public function test_eliminar_autor_existente(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data= $this->autor->toArray() ;

        $response = $this->deleteJson("api/autores/{$data['id']}");

        $response->assertStatus(204);

    }

    public function test_eliminar_autor_no_existente(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data= $this->autor->toArray() ;

        $response = $this->deleteJson("api/autores/45");

        $response->assertStatus(404);

    }
}
