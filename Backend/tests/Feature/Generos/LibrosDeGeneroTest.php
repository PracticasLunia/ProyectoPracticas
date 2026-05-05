<?php

namespace Tests\Feature\Generos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class LibrosDeGeneroTest extends TestCase
{

    use RefreshDatabase;

    

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

    }

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
