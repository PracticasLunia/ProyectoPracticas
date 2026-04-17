<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class CrearAutorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $request->validate([
            "nombre" => "required|string",
            "apellidos" => "required|string",
            "nacionalidad" => "nullable|string",
            "fecha_nacimiento"=>"nullable|date",
            "biografia"=>"nullable|string",
        ]);

        $autor = Autor::create($request->all());

        return response()->json(
            $autor,200
        );
    }
}
