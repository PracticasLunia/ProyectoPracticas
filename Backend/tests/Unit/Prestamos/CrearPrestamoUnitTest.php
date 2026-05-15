<?php

namespace Tests\Unit\Prestamos;

use Tests\TestCase;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Exceptions\Domain\LibroYaPrestadoException;
use App\Http\UseCases\Prestamo\CrearPrestamo;
use App\Http\UseCases\Prestamo\CrearPrestamoRequest;

class CrearPrestamoUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_lanza_excepcion_si_el_libro_ya_esta_prestado(): void
    {

        $autor = Autor::factory()->create();

        // Crear libro
        $libro = Libro::factory()->create([
            'autor_id' => $autor->id
        ]);

        // Crear préstamo ACTIVO
        Prestamo::factory()->create([
            'libro_id' => $libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-05-05',
            'fecha_devolucion_real' => null,
        ]);

        // Obtener el caso de uso
        $useCase = app(CrearPrestamo::class);

        // Esperar excepción
        $this->expectException(LibroYaPrestadoException::class);

        // Ejecutar
        $useCase->handle(
            new CrearPrestamoRequest(
                libro_id: $libro->id,
                nombre_lector: 'Juan',
                email_lector: 'juan@test.com',
                fecha_prestamo: now(),
                fecha_devolucion_prevista: now()->addDays(7),
                fecha_devolucion_real: null,
                observaciones: 'Test'
            )
        );
    }
}
