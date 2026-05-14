<?php

namespace App\Http\UseCases\Prestamo;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class ListarPrestamos {

    public function __construct(
        private PrestamoRepositoryInterface $prestamosRepository,
    ){}

    public function handle(): Collection {
        $prestamos = $this->prestamosRepository->getAll();
        return $prestamos;
    }

}

?>
