<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Prestamo\PrestamosDelLibro;
use App\Http\UseCases\Prestamo\PrestamosDelLibroRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestamosDeLibroController extends Controller
{

    public function __construct(
        private readonly PrestamosDelLibro $prestamosDelLibro
    ){}

    public function __invoke(Request $request, int $id){

        try {

            $prestamos = $this->prestamosDelLibro->handle( new PrestamosDelLibroRequest(
                libro_id: $id
            ));

            return response()->json([
                "data" => $prestamos,
                "message" => "Prestamos de libro",
                "errors" => []
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Prestamo no encontrado',
                'errors'=> $e->getMessage(),
            ], 404);
        }
    }
}
