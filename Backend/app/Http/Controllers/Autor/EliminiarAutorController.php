<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EliminiarAutorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //findOrFail return exception
        try {
            $autor=Autor::findOrFail($id);
            $autor->delete();
            return response()->json([
                "data" => $autor,
                "message" => "Autor eliminado",
                "errors"=>[],
            ], 200);

        }catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }
    }
}
