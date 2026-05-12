<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\EliminarLibro;
use App\Http\UseCases\Libro\EliminarLibroRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EliminarLibroController extends Controller
{
    public function __construct(
        private readonly EliminarLibro $eliminar_libro
    ){}

    public function __invoke(Request $request, int $id){

    try {
        $this->eliminar_libro->handle(new EliminarLibroRequest(
            libro_id: $id
        ));
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'data'=>null,
            'message'=>'Libro no encontrado',
            'errors'=>[]
        ], 404);
    }

    return response()->json([
        "data"=>null,
        "message"=>"Libro eliminado",
        "errors"=>[],
    ], 204);

    }
}
