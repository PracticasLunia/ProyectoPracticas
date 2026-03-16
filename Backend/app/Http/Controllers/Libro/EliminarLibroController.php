<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Libro;

class EliminarLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //findOrFail return exception
        try {
            $libro=Libro::findOrFail($id);
            $libro->delete();
            return response()->json([
                "Libro eliminado", 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "Libro no encontrado", 404
            ]);
        }
    }
}
