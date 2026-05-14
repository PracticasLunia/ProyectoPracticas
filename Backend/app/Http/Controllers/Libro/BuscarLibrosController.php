<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\BuscarLibros;
use App\Http\UseCases\Libro\BuscarLibrosRequest;
use App\Http\Validators\Libro\BuscarLibrosValidator;

class BuscarLibrosController extends Controller
{

    public function __construct(
        private readonly BuscarLibros $buscar_libros
    ){}

    public function __invoke(BuscarLibrosValidator $request){

    $libros = $this->buscar_libros->handle(new BuscarLibrosRequest(
        titulo: $request->input('titulo'),
        isbn: $request->input('isbn'),
        publicacion: $request->input('publicacion'),
        sinopsis: $request->input('sinopsis'),
        num_paginas: $request->input('num_paginas'),
        disponible: $request->input('disponible'),
        autor: $request->input('autor'),
        genero_nombre: $request->input('genero_nombre'),
    ));

    return response()->json([
        'data' => $libros,
        'messsage' => 'Listado de libros',
        'errors' => [],
    ],200);

    }
}
