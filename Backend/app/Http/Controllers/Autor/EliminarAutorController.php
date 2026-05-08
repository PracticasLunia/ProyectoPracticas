<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Autor\AutorRepositoryInterface;

class EliminarAutorController extends Controller
{

    public function __construct(
        private readonly AutorRepositoryInterface $autoresRepository
    ){}

    public function __invoke(Request $request, $id){

        $autor = $this->autoresRepository->getById($id);

        if(is_null($autor)){
            return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $this->autoresRepository->delete($autor);

        return response()->json([
            "data" => null,
            "message" => "Autor eliminado",
            "errors"=>[],
        ], 204);

    }
}
