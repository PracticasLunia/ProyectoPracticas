<?php

namespace App\Repositories\Autor;

use App\Models\Autor;
use Illuminate\Support\Collection;

interface AutorRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?Autor;

    public function store(array $data): Autor;

    public function update(Autor $autor, array $data): Autor;

    public function delete(Autor $autor): void;

    public function getBooks(Autor $autor): Collection;
}
