<?php

namespace App\Repositories\Genero;

use App\Models\Genero;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentGeneroRepository implements GeneroRepositoryInterface{

    public function getAll(): Collection{
        return Genero::all();
    }

    public function getById(int $id): ? Genero{
        return Genero::find($id);
    }

    public function store(array $data): Genero {
        return Genero::create($data);
    }

    public function update(Genero $genero, array $data): Genero {
        $genero= Genero::find($genero->id);
        return $genero->update($data);
    }

    public function delete(Genero $genero): void {
        $autor= Genero::find($genero->id);
        $autor->delete();
    }

    public function getBooks(Genero $genero): Collection {
        $genero = Genero::with('libros.generos')->find($genero->id);
        return $genero->libros;
    }

}
