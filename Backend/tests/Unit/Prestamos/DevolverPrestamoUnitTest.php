<?php

namespace Tests\Unit\Prestamos;

use Tests\TestCase;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Exceptions\Domain\PrestamoYaDevueltoException;
use App\Http\UseCases\Prestamo\DevolverPrestamo;
use App\Http\UseCases\Prestamo\DevolverPrestamoRequest;

class DevolverPrestamoUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_lanza_excepcion_si_el_prestamo_ya_fue_devuelto(): void
    {

        $autor = Autor::factory()->create();

        // Crear libro
        $libro = Libro::factory()->create([
            'autor_id' => $autor->id
        ]);

        // Crear prestamo ya devuelto
        $prestamo = Prestamo::factory()->create([
            'libro_id' => $libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-05-05',
            'fecha_devolucion_real' => '2026-05-01',
        ]);

        // Obtener caso de uso
        $useCase = app(DevolverPrestamo::class);

        // Esperar excepción
        $this->expectException(PrestamoYaDevueltoException::class);

        // Ejecutar
        $useCase->handle(
            new DevolverPrestamoRequest(
                prestamo_id: $prestamo->id
            )
        );
    }
}
