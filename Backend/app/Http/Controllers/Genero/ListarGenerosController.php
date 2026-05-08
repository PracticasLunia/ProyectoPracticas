<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Genero\GeneroRepositoryInterface;

class ListarGenerosController extends Controller
{
    public function __construct(
        private readonly GeneroRepositoryInterface $generosRepository
    ){}

    public function __invoke(Request $request)
    {

        $listadoGeneros = $this->generosRepository->getAll();
        // $listadoGeneros= Genero::all();

        return response()->json([
            "data" => $listadoGeneros,
            "message" => "Listado de generos",
            "errors" => [],
        ], 200);

    }
}
