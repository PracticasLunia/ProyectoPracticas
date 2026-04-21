<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Libro;

class PrestamosDeLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $libro=Libro::with('prestamos')->find($id);
        $prestamos=$libro->prestamos;

        return response()->json([
            "data" => $prestamos,
            "message" => "Prestamos de libro",
            "errors" => []
        ]);
    }
}
