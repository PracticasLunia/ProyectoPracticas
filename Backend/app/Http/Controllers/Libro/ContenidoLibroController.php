<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContenidoLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $libro=Libro::find($id);

        if($libro===null || $libro->contenido_path ===null){
            return response()->json("Contenido no encontrado", 404);
        }

        //Devuelve el documento descargado y para asignarle su nombre con el que fue guardado
        if ($request->query('download') === '1') {
            return Storage::disk('local')->download(
                $libro->contenido_path,
                $libro->contenido_nombre
            );
        }

        // Por defecto → inline (el navegador lo abre en su visor)
        return Storage::disk('local')->response($libro->contenido_path);
    }
}
