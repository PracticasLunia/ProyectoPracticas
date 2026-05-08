<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\Genero\GeneroRepositoryInterface;


class ActualizarGeneroController extends Controller
{

    public function __construct(
        private readonly GeneroRepositoryInterface $generosRepository
    ){}

    public function __invoke(Request $request, $id)
    {
        try {
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

        $genero = $this->generosRepository->getById($id);

        if(is_null($genero)){
            return response()->json([
                'data'=>null,
                'message'=>'Genero no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $data = [
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ];

        $generoActualizado = $this->generosRepository->update($genero, $data);

        return response()->json([
            'data'=>$generoActualizado,
            'message'=>'Genero actualizado correctamente',
            'errors'=>[]
        ], 200 );

    }
}
