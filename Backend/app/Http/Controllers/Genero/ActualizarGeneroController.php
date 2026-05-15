<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Genero\ActualizarGenero;
use App\Http\UseCases\Genero\ActualizarGeneroRequest;
use App\Http\Validators\Genero\CrearGeneroValidator;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActualizarGeneroController extends Controller
{

    public function __construct(
        private readonly ActualizarGenero $actualizarGenero
    ){}

    public function __invoke(CrearGeneroValidator $request, int $id)
    {

        try {

            $generoActualizado = $this->actualizarGenero->handle( new ActualizarGeneroRequest(
                nombre: $request->input('nombre'),
                descripcion: $request->input('descripcion'),
                genero_id: $id
            ));

            return response()->json([
                'data'=>$generoActualizado,
                'message'=>'Genero actualizado correctamente',
                'errors'=>[]
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Error al intentar actualizar el genero',
                'errors'=>$e->errors(),
            ], 422 );
        } catch( ModelNotFoundException $e ){
            return response()->json([
                'data'=>null,
                'message'=>'Genero no encontrado',
                'errors'=>[]
            ], 404);
        }

    }
}
