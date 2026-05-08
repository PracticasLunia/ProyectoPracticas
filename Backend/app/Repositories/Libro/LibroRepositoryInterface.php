<?php

namespace App\Repositories\Libro;

use App\Models\Libro;
use Illuminate\Support\Collection;

interface LibroRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?Libro;

    public function store(array $data): Libro;

    public function update(Libro $libro, array $data): Libro;

    public function delete(Libro $libro): void;

    public function libroCompleto(Libro $libro): Libro;

}
