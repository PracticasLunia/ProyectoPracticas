<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Libro\LibroRepositoryInterface;

class BuscarLibrosController extends Controller
{

    public function __construct(
        private readonly LibroRepositoryInterface $librosRepository
    ){}

    public function __invoke(Request $request){

        //Parametros de la url
        $data = [
            'titulo' => $request->input('titulo'),
            'isbn' => $request->input('isbn'),
            'publicacion' => $request->input('publicacion'),
            'sinopsis' => $request->input('sinopsis'),
            'num_paginas' => $request->input('num_paginas'),
            'disponible' => $request->input('disponible'),
            'autor' => $request->input('autor'),
            'genero_nombre' => $request->input('genero_nombre'),
        ];

        $libros = $this->librosRepository->filter($data);

        return response()->json([
            'data' => $libros,
            'messsage' => 'Listado de libros',
            'errors' => [],
        ],200);
    }
}
