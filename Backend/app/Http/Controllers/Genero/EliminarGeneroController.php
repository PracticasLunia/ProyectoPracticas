<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Genero\EliminarGenero;
use App\Http\UseCases\Genero\EliminarGeneroRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EliminarGeneroController extends Controller
{
    public function __construct(
        private readonly EliminarGenero $eliminarGenero
    ){}

    public function __invoke(Request $request, int $id)
    {

        try {

            $this->eliminarGenero->handle( new EliminarGeneroRequest(
                genero_id: $id
            ));

            return response()->json([
                "data" => null,
                "message"=>"Genero eliminado",
                "errors" => []
            ], 200);

        }  catch (ModelNotFoundException $e){
            return response()->json([
                'data'=>null,
                'message'=>'Genero no encontrado',
                'errors'=>$e->getMessage()
            ], 404);
        }

    }
}
