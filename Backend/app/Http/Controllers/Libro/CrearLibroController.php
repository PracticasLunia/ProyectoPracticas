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
            "autor_id"=> "required|exists:autores,id",
            "genero_ids" => "required|array"
        ]);

        $libro= Libro::create([
            "titulo"=>$request->titulo,
            "isbn"=>$request->isbn,
            "publicacion"=>$request->publicacion,
            "sinopsis"=>$request->sinopsis,
            "num_paginas"=>$request->num_paginas,
            "disponible"=>$request->disponible,
            "autor_id"=>$request->autor_id
        ]);
        //Create relations to generos
        $libro->generos()->attach($request->genero_ids);

        response()->json($libro, 200);
    }
}
