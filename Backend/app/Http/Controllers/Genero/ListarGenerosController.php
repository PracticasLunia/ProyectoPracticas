<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class ListarGenerosController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $listadoGeneros= Genero::all();
        return response()->json($listadoGeneros, 200);
    }
}
