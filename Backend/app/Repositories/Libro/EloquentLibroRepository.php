<?php

namespace App\Repositories\Autor;

use App\Models\Libro;
use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentAutorRepository implements LibroRepositoryInterface{

    public function getAll(): Collection{
        return Libro::all();
    }

    public function getById(int $id): ? Libro{
        return Libro::find($id);
    }

    public function store(array $data): Libro {
        return Libro::create($data);
    }

    public function update(Libro $libro, array $data): Libro {
        $libro->update($data);
        return $libro;
    }

    public function delete(Libro $libro): void {
        $libro->delete();
    }

    /*public function getBooks(Libro $libro): Collection {
        //Load se usa cuando ya tienes una instancia del modelo cargada.
        $librosAutor= $libro->load('libros.generos');
        return $librosAutor->libros;
    }*/

}
