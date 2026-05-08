<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;

class ListarPrestamosController extends Controller
{

    public function __construct(
        private readonly PrestamoRepositoryInterface $prestamosRepository
    ){}

    public function __invoke(Request $request){

        $prestamos = $this->prestamosRepository->getAll();

        return response()->json([
            "data" => $prestamos,
            "message" => "Listado de prestamos",
            "errors" => [],
        ], 200);
    }
}
