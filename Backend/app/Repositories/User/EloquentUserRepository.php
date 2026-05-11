<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Override;

class EloquentUserRepository implements UserRepositoryInterface{

    public function getAll(): Collection{
        return User::all();
    }

    public function getById(int $id): ? User{
        return User::find($id);
    }

    public function update(User $user, array $data): User {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): void {
        $user->delete();
    }

    public function getBooks(User $user): Collection {
        //Load se usa cuando ya tienes una instancia del modelo cargada.
        $librosGeneros = $user->load('libros.autores');
        return $librosGeneros->libros;
    }

    public function store(array $data): User {
        return User::create($data);
    }

    public function getByEmail(string $email): ? User {
        return User::where('email', $email)->first();
    }

}
