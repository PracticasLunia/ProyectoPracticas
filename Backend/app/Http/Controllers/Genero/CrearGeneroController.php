<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CrearGeneroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
        $request->validate([
            "nombre" => "required|string|unique:generos",
            "descripcion" => "nullable",
        ]);
        }catch (ValidationException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Error al intentar crear el genero',
                'errors'=>$e->errors(),
            ], 422 );
        }

        $genero=Genero::create($request->all());

        return response()->json([
            "data" => $genero,
            "message" => "Genero creado correctamente",
            "errors"=> [],
        ], 200);
    }
}
