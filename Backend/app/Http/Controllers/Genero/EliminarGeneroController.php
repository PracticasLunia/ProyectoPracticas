<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Genero\GeneroRepositoryInterface;


class EliminarGeneroController extends Controller
{
    public function __construct(
        private readonly GeneroRepositoryInterface $generosRepository
    ){}

    public function __invoke(Request $request, $id)
    {

        $genero= $this->generosRepository->getById($id);

        if(is_null($genero)){
            return response()->json([
                'data'=>null,
                'message'=>'Genero no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $this->generosRepository->delete($genero);
        return response()->json([
            "data" => null,
            "message"=>"Genero eliminado",
            "errors" => []
        ], 200);

    }
}
