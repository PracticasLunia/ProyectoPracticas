<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            return response()->json([
                "data" => $autorLibros,
                "message" => "Libros del Autor",
                "errors" => [],
            ], 200);

        }catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }
    }
}
