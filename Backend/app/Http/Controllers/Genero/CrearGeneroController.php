<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Genero\CrearGenero;
use App\Http\UseCases\Genero\CrearGeneroRequest;
use App\Http\Validators\Genero\CrearGeneroValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CrearGeneroController extends Controller
{
    public function __construct(
        private readonly CrearGenero $crearGenero
    ){}


    public function __invoke(CrearGeneroValidator $request)
    {

    try {

        $genero = $this->crearGenero->handle( new CrearGeneroRequest(
            nombre: $request->input('nombre'),
            descripcion: $request->input('descripcion'),
        ));

        return response()->json([
            "data" => $genero,
            "message" => "Genero creado correctamente",
            "errors"=> [],
        ], 200);

    }catch (ValidationException $e) {
        return response()->json([
            'data'=>null,
            'message'=>'Error al intentar crear el genero',
            'errors'=>$e->errors(),
        ], 422);
    }

    }
}
