<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Libro;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class EliminarLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //findOrFail return exception
        try {
            //Eliminar el libro
            $libro=Libro::findOrFail($id);
            $rutaPortada = $libro->portada_path;
            $libro->delete();

            //Eliminar la ruta de la portada asociada, si la tiene
            if ($rutaPortada) {
                Storage::disk('local')->delete($rutaPortada);
            }
            return response()->json(
                [   "data"=>$libro,
                    "message"=>"Libro eliminado",
                    "errors"=>[],
                ], 204
            );
        //Manejo de excepcion
        } catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404 );
        }
    }
}
