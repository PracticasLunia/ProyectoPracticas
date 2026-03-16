<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;

class CrearLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //

        $request->validate([
            "titulo" => "required|string",
            "isbn" => "required|unique:libros|string",
            "publicacion"=>"required|integer",
            "sinopsis"=>"nullable|max:255",
            "num_paginas"=>"required|integer",
            "disponible" => "boolean",
        ]);

        Libro::create($request->all());
    }
}
