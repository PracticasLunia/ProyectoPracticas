<?php

namespace App\Http\UseCases\Libro;

use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class BuscarLibros {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(BuscarLibrosRequest $request): LengthAwarePaginator{


        $libros = $this->librosRepository->filter([
            "titulo"=>$request->titulo,
            "isbn"=>$request->isbn,
            "publicacion"=>$request->publicacion,
            "sinopsis"=>$request->sinopsis,
            "num_paginas"=>$request->num_paginas,
            "disponible"=>$request->disponible,
            "autor" =>$request->autor,
            "genero_nombre" => $request->genero_nombre,
            "page" => $request->page
        ]);

        return $libros;
    }

}

?>
