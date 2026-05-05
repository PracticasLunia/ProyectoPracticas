<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DevolverPrestamoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {

        try {
            $prestamo=Prestamo::findOrFail($id);

            $prestamo->update([
                'fecha_devolucion_real' => now()
            ]);

            return response()->json([
                "data" => $prestamo,
                "message" => "Estado del prestamo actualizado",
                "errors" => [],
            ], 200);

        } catch (ModelNotFoundException) {
            return response()->json([
                "data" => "",
                "message" => "No se pudo encontrar el prestamo",
                "errors" => [],
            ], 404);
        }

    }
}
