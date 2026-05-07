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

    public function update(int $id, array $data): ?Autor {
        $autor= Autor::find($id);
        if(is_null($autor)){
            return null;
        }
        $autor->update($data);

        return $autor;
    }

    public function delete(int $id): void {
        $autor= Autor::findOrFail($id);
        $autor->delete();
    }

    public function getBooks(int $id): ? Collection {
        $autor = Autor::with('libros.generos')->find($id);
        if(is_null($autor)){
            return null;
        }
        return $autor->libros;
    }

}
