<?php

namespace App\Repositories\Prestamo;

use App\Models\Prestamo;
use App\Models\Libro;
use Illuminate\Support\Collection;

interface PrestamoRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?Prestamo;

    public function store(array $data): Prestamo;

    public function marcarDevuelto(Prestamo $prestamo): Prestamo;

    public function existePrestamoActivo(int $libroId): bool;

    public function prestamosDeLibro(Libro $libro): Collection;

}
