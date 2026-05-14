<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Prestamo\VerPrestamo;
use App\Http\UseCases\Prestamo\VerPrestamoRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VerPrestamoController extends Controller
{

    public function __construct(
        private readonly VerPrestamo $verPrestamo
    ){}

    public function __invoke(Request $request, int $id){

        try {

            $prestamo = $this->verPrestamo->handle(new VerPrestamoRequest(
                prestamo_id: $id
            ));

            return response()->json([
                'data' => $prestamo,
                'message' => 'Detalle del prestamo',
                'errors' => [],
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
