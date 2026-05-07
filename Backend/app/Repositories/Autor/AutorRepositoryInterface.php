<?php

namespace App\Repositories\Autor;

use App\Models\Autor;
use Illuminate\Support\Collection;

interface AutorRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?Autor;

    public function store(array $data): Autor;

    public function update(int $id, array $data): ?Autor;

    public function delete(int $id): void;

    public function getBooks(int $id): ? Collection;
}
