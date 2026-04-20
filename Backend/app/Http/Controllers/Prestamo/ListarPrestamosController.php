<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;

class ListarPrestamosController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $prestamos=Prestamo::all();

        return response()->json([
            "data" => $prestamos,
            "message" => "Listado de prestamos",
            "errors" => [],
        ], 200);
    }
}
