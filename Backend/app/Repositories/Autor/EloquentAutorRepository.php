<?php

namespace App\Repositories\Autor;

use App\Models\Autor;
use App\Repositories\Autor\AutorRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentAutorRepository implements AutorRepositoryInterface{

    public function getAll(): Collection{
        return Autor::all();
    }

    public function getById(int $id): ? Autor{
        return Autor::find($id);
    }

    public function store(array $data): Autor {
        return Autor::create($data);
    }

    public function update(Autor $autor, array $data): Autor {
        $autor->update($data);
        return $autor;
    }

    public function delete(Autor $autor): void {
        $autor->delete();
    }

    public function getBooks(Autor $autor): Collection {
        //Load se usa cuando ya tienes una instancia del modelo cargada.
        $librosAutor= $autor->load('libros.generos');
        return $librosAutor->libros;
    }

}
