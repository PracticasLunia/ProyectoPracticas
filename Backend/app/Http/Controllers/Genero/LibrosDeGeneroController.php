<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genero;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LibrosDeGeneroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //findOrFail return exception
        try {

            $generos=Genero::with('libros.autor')->findOrFail($id);
            $generoLibros=$generos->libros;

            //Devuelve unicamente los libros de aquel genero
            return response()->json([
                "data" => $generoLibros,
                "message" => "Libros de género",
                "errors" => []
            ], 200);

        } catch (ModelNotFoundException) {
            return response()->json([
                "data" => null,
                "message" => "Genero no encontrado",
                "errors" => []
            ], 400);
        }
    }
}
