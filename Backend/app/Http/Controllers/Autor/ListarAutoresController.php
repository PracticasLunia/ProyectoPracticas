<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class ListarAutoresController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $listadoAutores= Autor::all();
        return response()->json([
                "data" => $listadoAutores,
                "message" => "Listado de autores",
                "errors" => [],
            ]
        , 200);
    }
}
