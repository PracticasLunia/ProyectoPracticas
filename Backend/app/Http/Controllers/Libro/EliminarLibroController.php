<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Libro;
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
            $libro=Libro::findOrFail($id);
            // Borrar el fichero de portada, si existe
            $rutaPortada = $libro->portada_path;
            $libro->delete();

            if ($rutaPortada) {
                Storage::disk('local')->delete($rutaPortada);
            }
            return response()->json(
                ["message"=>"Libro eliminado"], 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                ["message"=>$th->getMessage()], 400
            );
        }
    }
}
