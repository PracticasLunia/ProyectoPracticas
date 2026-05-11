<?php

namespace App\Repositories\Libro;

use App\Models\Libro;
use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class EloquentLibroRepository implements LibroRepositoryInterface{

    public function getAll(): Collection{
        return Libro::all();
    }

    public function getById(int $id): ? Libro{

        $libro = Libro::find($id);

        if(is_null($libro)){
            return null;
        }

        return $libro;
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

    public function libroCompleto(Libro $libro): Libro {
        $libroCompleto = $libro->load('autor', 'generos');
        return $libroCompleto;
    }

    public function filter(array $data): Collection {

        $libros = Libro::where('titulo', 'LIKE', '%'.$data['titulo'].'%')
            ->where('isbn', 'LIKE', '%'.$data['isbn'].'%')
            ->where('publicacion', 'LIKE', '%'.$data['publicacion'].'%')
            ->where('sinopsis', 'LIKE', '%'.$data['sinopsis'].'%')
            ->where('num_paginas', 'LIKE', '%'.$data['num_paginas'].'%')
            ->where('disponible', 'LIKE', '%'.$data['disponible'].'%')

            ->whereHas('autor', function(Builder $query) use ($data){
                if(is_array($data['autor'])){
                    $query->whereIn('autores.nombre', $data['autor']);
                }
                elseif(!empty($data['autor'])){
                    $query->where('autores.nombre', 'LIKE', '%'.$data['autor'].'%');
                }
            })

            ->whereHas('generos', function(Builder $query) use($data){
                if(is_array($data['genero_nombre']))
                    {
                        $query->whereIn('generos.nombre',$data['genero_nombre']);
                    }elseif(!empty($data['genero_nombre'])){
                        $query->where('generos.nombre', $data['genero_nombre']);
                    }
            })
            ->get();

            return $libros;
    }

}
