<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class CrearGeneroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $request->validate([
            "nombre" => "required|string|unique",
            "descripcion" => "nullable",
        ]);

        Genero::create($request->all());

        return response()->json(
            ["message"=>"Genero creado"],
            200
        );
    }
}
