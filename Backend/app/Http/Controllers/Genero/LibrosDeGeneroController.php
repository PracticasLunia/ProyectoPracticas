<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genero;

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
            return response()->json($generoLibros, 200);

        } catch (\Throwable $th) {
            return response()->json(
                ["message"=>"Genero no encontrado"], 400);
        }
    }
}
