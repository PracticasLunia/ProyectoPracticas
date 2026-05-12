<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\ContenidoLibro;
use App\Http\UseCases\Libro\ContenidoLibroRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContenidoLibroController extends Controller
{
    public function __construct(
        private readonly ContenidoLibro $contenido_libro
    ){}

    public function __invoke(Request $request, int $id)
    {
        try {
            $contenido = $this->contenido_libro->handle(new ContenidoLibroRequest(
                download: $request->download
            ), $id);
            return $contenido;
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404);
        }
    }
}
