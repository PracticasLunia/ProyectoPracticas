<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Libro\LibroRepositoryInterface;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;

class PrestamosDeLibroController extends Controller
{

    public function __construct(
        private readonly PrestamoRepositoryInterface $prestamosRepository,
        private readonly LibroRepositoryInterface $librosRepository
    ){}

    public function __invoke(Request $request, $id){

        $libro = $this->librosRepository->getById($id);

        if(is_null($libro)){
            return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404);
        }

        $prestamos = $this->prestamosRepository->prestamosDeLibro($libro);

        return response()->json([
            "data" => $prestamos,
            "message" => "Prestamos de libro",
            "errors" => []
        ], 200);
    }
}
