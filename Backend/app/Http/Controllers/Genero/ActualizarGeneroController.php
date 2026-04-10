<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class ActualizarGeneroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //
        $request->validate([
            "nombre" => "required|string|unique:generos,nombre".$id,
            "descripcion" => "nullable",
        ]);

        $genero= Genero::find($id);

        if($genero===null){
            return response()->json(["message"=>"Genero no encontrado"], 404);
        }
        else{
            $genero->update($request->all());
            return response()->json($genero, 200);
        }
    }
}
