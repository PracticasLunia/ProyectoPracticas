<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActualizarGeneroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        try {
            //Validation
            $request->validate([
                "nombre" => "required|string|unique:generos,nombre,".$id,
                "descripcion" => "nullable",
            ]);

        } catch (ValidationException $e) {
             return response()->json([
                'data'=>null,
                'message'=>'Error al intentar actualizar el genero',
                'errors'=>$e->errors(),
            ], 422 );
        }

        try {
            $genero= Genero::find($id);
        }catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Genero no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $genero->update($request->all());
        return response()->json([
            "data" => $genero,
            "message" => "Genero actualizado correctamente",
            "errors" => []
        ], 200);
    }
}
