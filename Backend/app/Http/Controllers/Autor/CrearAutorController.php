<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Autor\CrearAutorRequest;
use App\Http\UseCases\Autor\CrearAutor;
use App\Http\Validators\Autor\CrearAutorValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CrearAutorController extends Controller
{

    public function __construct(
        private readonly CrearAutor $crearAutor
    ){}

    public function __invoke(CrearAutorValidator $request){

        try {

            $autor = $this->crearAutor->handle( new CrearAutorRequest(
                nombre: $request->input('nombre'),
                apellidos : $request->input('apellidos'),
                nacionalidad: $request->input('nacionalidad'),
                fecha_nacimiento : $request->input('fecha_nacimiento'),
                biografia: $request->input('biografia'),
            ));

            return response()->json([
                "data" => $autor,
                "message" => "Autor creado correctamente",
                "errors" => []
            ], 200);

        }
        catch (ValidationException $e) {
             return response()->json([
                'data'=>null,
                'message'=>'El autor no se pudo crear, errores de validación',
                'errors'=>$e->errors(),
            ], 422);
        }
    }
}
