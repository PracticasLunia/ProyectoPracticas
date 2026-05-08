<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Http\Request;

class VerGeneroController extends Controller
{

    public function __construct(
        private readonly GeneroRepositoryInterface $generosRepository
    ){}

    public function __invoke(Request $request, $id){

        $genero = $this->generosRepository->getById($id);

        if(is_null($genero)){
            return response()->json([
                "data"=> null,
                "message"=>"Genero no encontrado",
                "errors" => []
            ], 404);
        }

        return response()->json([
            "data" => $genero,
            "message" => "Detalle del género"
        ], 200);

    }
}
