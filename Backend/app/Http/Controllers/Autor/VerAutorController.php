<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Autor\VerAutor;
use App\Http\UseCases\Autor\VerAutorRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class VerAutorController extends Controller
{


    public function __construct(
        //El repositorio asume consultas a Eloquent, manejo de datos, relaciones, etc...
        //private readonly AutorRepositoryInterface $autoresRepository
        private readonly VerAutor $verAutor
    ) {}

    public function __invoke(Request $request, int $id){

        try {

            $autor = $this->verAutor->handle( new VerAutorRequest(
                autor_id: $id
            ));

            return response()->json([
                'data' => $autor,
                "message" => "Detalle del Autor",
                "errors" => [],
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[],
            ], 404);
        }

    }
}
