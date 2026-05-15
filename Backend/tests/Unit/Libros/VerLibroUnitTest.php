<?php

namespace Tests\Unit\Libros;

use Tests\TestCase;
use Mockery;
use App\Models\Libro;
use App\Http\UseCases\Libro\VerLibro;
use App\Http\UseCases\Libro\VerLibroRequest;
use App\Repositories\Libro\LibroRepositoryInterface;

class VerLibroUnitTest extends TestCase
{
    public function test_devuelve_un_libro_completo(): void
    {
        // Mock del repositorio
        $repositoryMock = Mockery::mock(LibroRepositoryInterface::class);

        // Libro falso
        $libro = new Libro([
            'id' => 1,
            'titulo' => 'Ejemplo',
        ]);

        // Simular getById()
        $repositoryMock
            ->shouldReceive('getById')
            ->once()
            ->with(1)
            ->andReturn($libro);

        // Simular libroCompleto()
        $repositoryMock
            ->shouldReceive('libroCompleto')
            ->once()
            ->with($libro)
            ->andReturn($libro);

        // Crear UseCase con mock
        $useCase = new VerLibro($repositoryMock);

        // Ejecutar
        $resultado = $useCase->handle(
            new VerLibroRequest(
                libro_id: 1
            )
        );

        $this->assertInstanceOf(Libro::class, $resultado);
        $this->assertEquals(
            'Ejemplo',
            $resultado->titulo
        );
    }
}
