<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Autor\AutorRepositoryInterface;

class ActualizarAutorController extends Controller
{

    public function __construct(
        private readonly AutorRepositoryInterface $autoresRepository
    ){}

    public function __invoke(Request $request, $id)
    {
        try {
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

        $data = $request->validated();
        $autor=$this->autoresRepository->update($id, $request->all());

        if(is_null($autor)){
            return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }
        return response()->json([
            "data" => $autor,
            "message" => "Autor actualizado correctamente",
            "errors" => [],
        ], 200);


        /*try {
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
        ], 200);*/
    }
}
