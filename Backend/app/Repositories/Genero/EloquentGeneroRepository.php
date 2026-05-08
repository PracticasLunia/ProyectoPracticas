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
        $genero->update($data);
        return $genero;
    }

    public function delete(Genero $genero): void {
        $genero->delete();
    }

    public function getBooks(Genero $genero): Collection {
        //Load se usa cuando ya tienes una instancia del modelo cargada.
        $librosGeneros = $genero->load('libros.autores');
        return $librosGeneros->libros;
    }

}
