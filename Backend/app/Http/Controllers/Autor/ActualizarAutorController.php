<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActualizarAutorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        try {
            //Validaciones
            $request->validate([
                "nombre" => "required|string",
                "apellidos" => "required|string",
                "nacionalidad" => "nullable|string",
                "fecha_nacimiento"=>"nullable|date",
                "biografia"=>"nullable|string",
            ]);
        } catch (ValidationException $e) {
             return response()->json([
                'data'=>null,
                'message'=>'Error al intentar actualizar el autor',
                'errors'=>$e->errors(),
            ], 422 );
        }


        try {
             $autor= Autor::findOrFail($id);
        } catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $autor->update($request->all());
        return response()->json([
            "data" => $autor,
            "message" => "Autor actualizado correctamente",
            "errors" => [],
        ], 200);
    }
}
