<?php

namespace App\Http\UseCases\Libro;

use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class BuscarLibros {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(BuscarLibrosRequest $request): Collection{


        $libros = $this->librosRepository->filter([
            "titulo"=>$request->titulo,
            "isbn"=>$request->isbn,
            "publicacion"=>$request->publicacion,
            "sinopsis"=>$request->sinopsis,
            "num_paginas"=>$request->num_paginas,
            "disponible"=>$request->disponible,
            "autor" =>$request->autor,
            "genero_nombre" => $request->genero_nombre
        ]);

        return $libros;
    }

}

?>
