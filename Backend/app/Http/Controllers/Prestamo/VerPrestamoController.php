<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;

class VerPrestamoController extends Controller
{

    public function __construct(
        private readonly PrestamoRepositoryInterface $prestamosRepository
    ){}

    public function __invoke(Request $request, $id){

        $prestamo = $this->prestamosRepository->getById($id);

        if(is_null($prestamo)){
            return response()->json([
                'data'=>null,
                'message'=>'Prestamo no encontrado',
                'errors'=>[]
            ], 404);
        }

        return response()->json([
            'data' => $prestamo,
            'message' => 'Detalle del prestamo',
            'errors' => [],
        ], 200);

    }
}
