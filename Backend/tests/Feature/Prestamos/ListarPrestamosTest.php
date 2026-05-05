<?php

namespace Tests\Feature\Prestamos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\Autor;
use Override;

class ListarPrestamosTest extends TestCase
{

    use RefreshDatabase;

    private $libro;
    private $autor;
    private $prestamo;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->autor= Autor::factory()->create();

        $this->libro= Libro::factory()->create([
            'autor_id' => $this->autor->id
        ]);

    }

    public function test_listar_prestamos_con_estructura_esperada(): void
    {

        $this->prestamo = Prestamo::factory()->create([
            'libro_id' => $this->libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-05-05',
            'fecha_devolucion_real' => '2026-05-05',
        ]);

        $response = $this->getJson("api/prestamos");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'libro_id',
                    'nombre_lector',
                    'email_lector',
                    'fecha_prestamo',
                    'fecha_devolucion_prevista',
                    'fecha_devolucion_real',
                    'observaciones'
                ]
            ],
            'message',
            'errors',
        ]);

        $this->assertDatabaseCount('prestamos', 1);
    }

    public function test_listar_prestamos_sin_ninguno_registrado(): void {

        $response = $this->getJson("api/prestamos");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'message',
            'errors',
        ]);

        $this->assertDatabaseCount('prestamos', 0);
    }

}
