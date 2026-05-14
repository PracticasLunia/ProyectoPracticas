<?php

namespace App\Http\UseCases\Prestamo;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Prestamo;

final readonly class VerPrestamo {

    public function __construct(
        private PrestamoRepositoryInterface $prestamosRepository,
    ){}

    public function handle(VerPrestamoRequest $request): ?Prestamo {

        $prestamo = $this->prestamosRepository->getById($request->prestamo_id);

        if(is_null($prestamo)){
            throw new ModelNotFoundException('Libro no encontrado');
        }

        return $prestamo;
    }

}

?>
