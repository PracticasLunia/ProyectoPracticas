<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Libro\LibroRepositoryInterface;

class VerLibroController extends Controller
{

    public function __construct(
        private readonly LibroRepositoryInterface $librosRepository
    ){}

    public function __invoke(Request $request, $id){

        $libro = $this->librosRepository->getById($id);

        if(is_null($libro)){
            return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $respuesta = $this->librosRepository->libroCompleto($libro);

        return response()->json([
            'data' => $respuesta,
            'message' => 'Detalle del libro',
            'errors' => []
        ], 200);
    }
}
