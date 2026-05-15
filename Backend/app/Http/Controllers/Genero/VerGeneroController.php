<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Genero\VerGenero;
use App\Http\UseCases\Genero\VerGeneroRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VerGeneroController extends Controller
{

    public function __construct(
        private readonly VerGenero $verGenero
    ){}

    public function __invoke(Request $request, int $id){

        try {

            $genero = $this->verGenero->handle( new VerGeneroRequest(
                genero_id: $id
            ));

            return response()->json([
                "data" => $genero,
                "message" => "Detalle del género"
            ], 200);

        } catch (ModelNotFoundException $e){
            return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404);

        }

    }
}
