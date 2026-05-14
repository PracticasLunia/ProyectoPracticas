<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Prestamo\ListarPrestamos;
use Illuminate\Http\Request;

class ListarPrestamosController extends Controller
{

    public function __construct(
        private readonly ListarPrestamos $listarPrestamos
    ){}

    public function __invoke(Request $request){

        $prestamos = $this->listarPrestamos->handle();

        return response()->json([
            "data" => $prestamos,
            "message" => "Listado de prestamos",
            "errors" => [],
        ], 200);
    }
}
