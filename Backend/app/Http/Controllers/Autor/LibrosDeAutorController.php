<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class LibrosDeAutorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //findOrFail return exception
        try {

            $autor=Autor::with('libros')->findOrFail($id);
            $autorLibros=$autor->libros()->with('generos')->get();

            //Devuelve unicamente los libros, con sus generos relacionados, de aquel autor
            return response()->json($autorLibros, 200);

        } catch (\Throwable $th) {
            return response()->json(
                ["message"=>"Autor no encontrado"], 400);
        }
    }
}
