<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Autor\ActualizarAutor;
use App\Http\UseCases\Autor\ActualizarAutorRequest;
use App\Http\Validators\Autor\ActualizarAutorValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ActualizarAutorController extends Controller
{

    public function __construct(
        private readonly ActualizarAutor $actualizarAutor
    ){}

    public function __invoke(ActualizarAutorValidator $request, int $id){

        try {
            $autorActualizado = $this->actualizarAutor->handle( new ActualizarAutorRequest(
                nombre: $request->input('nombre'),
                apellidos: $request->input('apellidos'),
                nacionalidad: $request->input('nacionalidad'),
                fecha_nacimiento: $request->input('fecha_nacimiento'),
                biografia: $request->input('biografia'),
            ), $id);

            return response()->json([
                "data" => $autorActualizado,
                "message" => "Autor actualizado correctamente",
                "errors" => [],
            ], 200);

        } catch (ModelNotFoundException $e){
            return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404);

        } catch (ValidationException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Error al intentar actualizar el autor',
                'errors'=>$e->errors(),
            ], 422);
        }


        /*try {
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
        ], 200);*/
    }
}
