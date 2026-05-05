<?php

namespace Tests\Feature\Prestamos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\Autor;
use Override;

class VerPrestamoTest extends TestCase
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

        $this->prestamo = Prestamo::factory()->create([
            'libro_id' => $this->libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-05-05',
            'fecha_devolucion_real' => '2026-05-05',
        ]);
    }

    public function test_ver_prestamo_existente(): void {
        $response = $this->getJson("api/prestamos/{$this->prestamo->id}");

        $response->assertStatus(200);

        //Verificar datos claves, sin necesidad de comparar objeto y array
        $response->assertJsonPath('data.id', $this->prestamo->id);
        $response->assertJsonPath('data.libro_id', $this->prestamo->libro_id);
        $response->assertJsonPath('message', 'Detalle del prestamo');
    }

    public function test_ver_prestamo_no_existente(): void {

        $response = $this->getJson("api/prestamos/10");

        $response->assertStatus(404);
        $response->assertJsonPath('data', null);
        $response->assertJsonPath('message', 'Prestamo no encontrado');
    }
}
