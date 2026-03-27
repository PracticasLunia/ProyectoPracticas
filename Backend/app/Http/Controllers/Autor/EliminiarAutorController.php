<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

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
            return response()->json(
                ["message"=>"Autor eliminado"], 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                ["message"=>"Autor no encontrado"], 404
            );
        }
    }
}
