<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Libro;

class PortadaLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {

    $libro = Libro::find($id);

        //Si el libro no existe o no tiene portada
        if ($libro === null || $libro->portada_path === null) {
            return response()->json("Portada no encontrada", 404);
        }

        //Selecciona el disco (Privado storage/app), lee el archivo, detecta el tipo,
        //crea una respuesta http, envia el archivo al navegador
        return Storage::disk('local')->response($libro->portada_path);

    }
}
