<?php

namespace App\Http\Controllers\Prestamo;

use App\Exceptions\Domain\PrestamoYaDevueltoException;
use App\Http\Controllers\Controller;
use App\Http\UseCases\Prestamo\DevolverPrestamo;
use App\Http\UseCases\Prestamo\DevolverPrestamoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DevolverPrestamoController extends Controller
{

    public function __construct(
        private readonly DevolverPrestamo $devolverPrestamo
    ){}

    public function __invoke(Request $request, int $id){

        try {

            $prestamo = $this->devolverPrestamo->handle(new DevolverPrestamoRequest(
                prestamo_id: $id
            ));
            return response()->json([
                "data" => $prestamo,
                "message" => "Estado del prestamo actualizado",
                "errors" => [],
            ], 200);

        } catch (PrestamoYaDevueltoException $e) {
            return response()->json([
                "data" => null,
                "message" => "No se pudo crear el prestamo",
                "errors" => $e->getMessage(),
            ], 409);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "data" => null,
                "message" => "No se pudo encontrar el prestamo",
                "errors" => $e->getMessage(),
            ], 422);
        }
    }
}
