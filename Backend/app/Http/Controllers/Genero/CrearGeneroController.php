<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\Genero\GeneroRepositoryInterface;


class CrearGeneroController extends Controller
{
    public function __construct(
        private readonly GeneroRepositoryInterface $generosRepository
    ){}


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

        $data = [
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ];

        $genero = $this->generosRepository->store($data);

        return response()->json([
            "data" => $genero,
            "message" => "Genero creado correctamente",
            "errors"=> [],
        ], 200);

    }
}
