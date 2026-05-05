<?php

namespace Tests\Feature\Prestamos;

use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class DevolverPrestamoTest extends TestCase
{
    use RefreshDatabase;

    private $libro;
    private $autor;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->autor= Autor::factory()->create();

        $this->libro= Libro::factory()->create([
            'autor_id' => $this->autor->id
        ]);
    }

    public function test_devolver_prestamo_existente(): void
    {
        $prestamo = Prestamo::factory()->create([

            'libro_id' => $this->libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-05-05',
            'fecha_devolucion_real' => null,

        ]);

        $data= $prestamo->toArray();

        $response = $this->putJson("api/prestamos/{$data['id']}/devolver");

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Estado del prestamo actualizado');
    }

    public function test_devolver_prestamo_no_existente(): void {

        $response = $this->putJson("api/prestamos/10/devolver");

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'No se pudo encontrar el prestamo');
        
    }
}
