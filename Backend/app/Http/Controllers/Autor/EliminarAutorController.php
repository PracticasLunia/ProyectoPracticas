<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Autor\EliminarAutor;
use App\Http\UseCases\Autor\EliminarAutorRequest;
use Illuminate\Http\Request;
use App\Repositories\Autor\AutorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EliminarAutorController extends Controller
{

    public function __construct(
        private readonly EliminarAutor $eliminarAutor
    ){}

    public function __invoke(Request $request, int $id){

        try {

            $this->eliminarAutor->handle( new EliminarAutorRequest(
                autor_id:$id
            ));

            return response()->json([
                "data" => null,
                "message" => "Autor eliminado",
                "errors"=>[],
            ], 204);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>$e->getMessage(),
            ], 404);
        }
        
    }
}
