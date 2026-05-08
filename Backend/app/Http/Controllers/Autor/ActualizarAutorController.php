<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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

        $autor = $this->autoresRepository->getById($id);

        if(is_null($autor)){
            return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $data = [
            'nombre' => $request->input('nombre'),
            'apellidos' => $request->input('apellidos'),
            'nacionalidad' =>$request->input('nacionalidad'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'biografia' => $request->input('biografia'),
        ];

        $autorActualizado=$this->autoresRepository->update($autor, $data);

        return response()->json([
            "data" => $autorActualizado,
            "message" => "Autor actualizado correctamente",
            "errors" => [],
        ], 200);
    }
}
