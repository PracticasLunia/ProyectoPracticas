<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;

class ActualizarLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
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

        $libro= Libro::find($id);

        if($libro===null){
            return response()->json("Libro no encontrado", 404);
        }
        else{
            $libro->update($request->all());
            return response()->json($libro, 200);
        }
    }
}
