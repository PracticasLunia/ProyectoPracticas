<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\VerLibro;
use App\Http\UseCases\Libro\VerLibroRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VerLibroController extends Controller
{

    public function __construct(
        private readonly VerLibro $ver_libro
    ){}

    public function __invoke(Request $request, int $id){

        try {
            $libro = $this->ver_libro->handle(new VerLibroRequest(
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
        'data' => $libro,
        'message' => 'Detalle del libro',
        'errors' => []
    ], 200);

    }
}
