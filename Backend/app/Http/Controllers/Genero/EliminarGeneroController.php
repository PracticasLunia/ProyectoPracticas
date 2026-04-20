<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EliminarGeneroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //findOrFail return exception
        try {
            $genero=Genero::findOrFail($id);
            $genero->delete();
            return response()->json([
                "data" => null,
                "message"=>"Genero eliminado",
                "errors" => []
            ], 200);
        }catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Genero no encontrado',
                'errors'=>[]
            ], 404 );
        }
    }
}
