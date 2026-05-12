<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\CrearLibroRequest;
use App\Http\Validators\Libro\CrearLibroValidator;
use App\Http\UseCases\Libro\CrearLibro;

class CrearLibroController extends Controller
{

    public function __construct(
        private readonly CrearLibro $crearLibro
    ){}

    public function __invoke(CrearLibroValidator $request){

        $libro = $this->crearLibro->handle(new CrearLibroRequest(
            titulo: $request->input('titulo'),
            isbn : $request->input('isbn'),
            publicacion: $request->input('publicacion'),
            sinopsis : $request->input('sinopsis'),
            num_paginas: $request->input('num_paginas'),
            disponible : $request->input('disponible'),
            autor_id: $request->input('autor_id'),
            genero_ids : $request->input('genero_ids'),
            portada: $request->file('portada'),
            contenido: $request->file('contenido')
        ));

        return response()->json([
            'data'=>$libro,
            'message'=>'Libro creado exitosamente',
            'errors' => [],
        ], 201);

    }
}
