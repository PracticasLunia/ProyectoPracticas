<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?User;

    public function store(array $data): User;

    public function update(User $autor, array $data): User;

    public function delete(User $autor): void;

    public function getByEmail(string $email): ? User;


}

