<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Repositories\Autor\AutorRepositoryInterface;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class VerAutorController extends Controller
{


    public function __construct(
        //El repositorio asume consultas a Eloquent, manejo de datos, relaciones, etc...
        private readonly AutorRepositoryInterface $autoresRepository
    ) {}

    public function __invoke(Request $request, $id){

        $autor= $this->autoresRepository->getById($id);

        if(is_null($autor)){
            return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[],
            ], 404);
        }

        return response()->json([
            'data' => $autor,
            "message" => "Detalle del Autor",
            "errors" => [],
        ], 200);

    }
}
