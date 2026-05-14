<?php

namespace App\Http\UseCases\Prestamo;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Prestamo;
use App\Repositories\Libro\LibroRepositoryInterface;

final readonly class PrestamosDelLibro {

    public function __construct(
        private PrestamoRepositoryInterface $prestamosRepository,
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(PrestamosDelLibroRequest $request): ? Collection {

        $libro = $this->librosRepository->getById($request->libro_id);

        if(is_null($libro)){
            throw new ModelNotFoundException('Libro no encontrado');
        }

        $prestamos = $this->prestamosRepository->prestamosDeLibro($libro);

        return $prestamos;
    }

}

?>
