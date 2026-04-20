<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CrearAutorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {

        $request->validate([
            "nombre" => "required|string",
            "apellidos" => "required|string",
            "nacionalidad" => "nullable|string",
            "fecha_nacimiento"=>"nullable|date",
            "biografia"=>"nullable|string",
        ]);

        }catch (ValidationException $e) {
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>$e->errors(),
            ], 404 );
        }

        $autor = Autor::create($request->all());

        return response()->json([
                "data" => $autor,
                "message" => "Autor creado correctamente",
                "errors" => []
            ],200
        );
    }
}
