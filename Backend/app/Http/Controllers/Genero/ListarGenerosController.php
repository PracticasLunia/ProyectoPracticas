<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Genero\ListarGeneros;
use Illuminate\Http\Request;

class ListarGenerosController extends Controller
{
    public function __construct(
        private readonly ListarGeneros $listarGeneros
    ){}

    public function __invoke(Request $request){

        $listadoGeneros = $this->listarGeneros->handle();

        return response()->json([
            "data" => $listadoGeneros,
            "message" => "Listado de generos",
            "errors" => [],
        ], 200);

    }
}
