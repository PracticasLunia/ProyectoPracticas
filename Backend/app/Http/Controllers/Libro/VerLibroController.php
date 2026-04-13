<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Libro;

class VerLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //
        //findOrFail return exception
        try {
            $libro = Libro::with('autor', 'generos')
                ->findOrFail($id);

            /*$respuesta = [
                'id' => $libro['id'],
                'created_at' => $libro['created_at'],
                'updated_at' => $libro['updated_at'],
                'titulo' => $libro['titulo'],
                'isbn' => $libro['isbn'],
                'autor_id' => $libro['autor_id'],
                'publicacion' => $libro['publicacion'],
                'sinopsis' => $libro['sinopsis'],
                'num_paginas' => $libro['num_paginas'],
                'disponible' => $libro['disponible'],
                'nombre_autor' => $libro['autor']['nombre'],
                'generos'=>$libro['generos']
            ];*/

            return response()->json(
                $libro , 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                ["message"=>"Libro no encontrado"], 404);
        }
    }
}
