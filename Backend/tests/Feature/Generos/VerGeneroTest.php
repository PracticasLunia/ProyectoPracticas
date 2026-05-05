<?php

namespace Tests\Feature\Generos;

use App\Models\Genero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class VerGeneroTest extends TestCase
{
    use RefreshDatabase;

    private $genero;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->genero= Genero::factory()->create();
    }

    public function test_ver_genero_existente(): void{
        $data = $this->genero->toArray();

        $response = $this->getJson("api/generos/{$data['id']}");

        $response->assertStatus(200);
        $this->assertDatabaseCount('generos', 1);
    }

    public function test_ver_genero_no_existente(): void {
        $data = $this->genero->toArray();

        $response = $this->getJson("api/generos/10");

        $response->assertStatus(404);
        $this->assertDatabaseCount('generos', 1);
    }
}
