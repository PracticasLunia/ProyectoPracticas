<?php

namespace App\Http\UseCases\Prestamo;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;
use App\Exceptions\Domain\PrestamoYaDevueltoException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Prestamo;

final readonly class DevolverPrestamo {

    public function __construct(
        private PrestamoRepositoryInterface $prestamosRepository,
    ){}

    public function handle(DevolverPrestamoRequest $request): ?Prestamo {

        $prestamo = $this->prestamosRepository->getById($request->prestamo_id);

        if(is_null($prestamo)){
            throw new ModelNotFoundException('Libro no encontrado');
        }

        if($prestamo->fecha_devolucion_real != null){
            throw new PrestamoYaDevueltoException($request->prestamo_id);
        }

        $this->prestamosRepository->marcarDevuelto($prestamo);

        return $prestamo;

    }

}

?>
