<?php

namespace App\Repositories\Genero;

use App\Models\Genero;
use Illuminate\Support\Collection;

interface GeneroRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?Genero;

    public function store(array $data): Genero;

    public function update(Genero $genero, array $data): Genero;

    public function delete(Genero $genero): void;

    public function getBooks(Genero $genero): Collection;
}
