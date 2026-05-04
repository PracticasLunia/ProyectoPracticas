<?php

namespace Tests\Feature\Autores;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;
use App\Models\Autor;

class VerAutorTest extends TestCase
{

   use RefreshDatabase;

    private $autor;

    #[Override]
    function setUp(): void
    {
        parent::setUp();
        $this->autor= Autor::factory()->create();
    }

    public function test_ver_autor_existente(): void {

        $data = $this->autor->toArray();

        $response = $this->getJson("api/autores/{$data['id']}");

        $response->assertStatus(200);
    }

    public function test_ver_autor_no_existente(): void {

        $data = $this->autor->toArray();

        $response = $this->getJson("api/autores/34");

        $response->assertStatus(404);
    }
}
