<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function PHPSTORM_META\map;

class VerPrestamoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $prestamo=Prestamo::findOrFail($id);
            return response()->json([
                'data' => $prestamo,
                'message' => 'Detalle del prestamo',
                'errors' => [],
            ]);
        } catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404 );
        }
    }
}
