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
        //validate
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

        $libro= Libro::find($id);

        if($libro===null){
            return response()->json("Libro no encontrado", 404);
        }
        //update model
        else{
            $libro->update([
                "titulo"=>$request->titulo,
                "isbn"=>$request->isbn,
                "publicacion"=>$request->publicacion,
                "sinopsis"=>$request->sinopsis,
                "num_paginas"=>$request->num_paginas,
                "disponible"=>$request->disponible,
                "autor_id"=>$request->autor_id
            ]);
            //Update relations to generos
            $libro->generos()->sync($request->genero_ids);

            //$libroGeneros= $libro->generos;
            return response()->json(
                $libro
            , 200);
        }
    }
}
