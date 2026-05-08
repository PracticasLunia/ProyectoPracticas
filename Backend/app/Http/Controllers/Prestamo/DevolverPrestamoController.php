<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;

class DevolverPrestamoController extends Controller
{

    public function __construct(
        private readonly PrestamoRepositoryInterface $prestamosRepository
    ){}

    public function __invoke(Request $request, $id)
    {

        $prestamo = $this->prestamosRepository->getById($id);

        if(is_null($prestamo)){
            return response()->json([
                "data" => "",
                "message" => "No se pudo encontrar el prestamo",
                "errors" => [],
            ], 404);
        }

        $this->prestamosRepository->returnPrestamo($prestamo);

        return response()->json([
            "data" => $prestamo,
            "message" => "Estado del prestamo actualizado",
            "errors" => [],
        ], 200);
    }
}
