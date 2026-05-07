<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Autor\AutorRepositoryInterface;

class EliminarAutorController extends Controller
{

    public function __construct(
        private readonly AutorRepositoryInterface $autoresRepository
    ){}

    public function __invoke(Request $request, $id){

        //

        try {
            /*$autor=Autor::findOrFail($id);
            $autor->delete();*/
            $this->autoresRepository->delete($id);
            return response()->json([
                "data" => null,
                "message" => "Autor eliminado",
                "errors"=>[],
            ], 204);

        }catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }
    }
}
