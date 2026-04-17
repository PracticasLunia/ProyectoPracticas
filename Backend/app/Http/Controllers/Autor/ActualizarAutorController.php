<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class ActualizarAutorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //
        $request->validate([
            "nombre" => "required|string",
            "apellidos" => "required|string",
            "nacionalidad" => "nullable|string",
            "fecha_nacimiento"=>"nullable|date",
            "biografia"=>"nullable|string",
        ]);

        $autor= Autor::find($id);

        if($autor===null){
            return response()->json(["message"=>"Autor no encontrado"], 404);
        }
        else{
            $autor->update($request->all());
            return response()->json($autor, 200);
        }
    }
}
