<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Genero\GeneroRepositoryInterface;

class LibrosDeGeneroController extends Controller
{
    public function __construct(
        private readonly GeneroRepositoryInterface $generosRepository
    ){}

    public function __invoke(Request $request, $id){

        $generoLibros= $this->generosRepository->getBooks($id);

        if(is_null($generoLibros)){
            return response()->json([
                "data" => null,
                "message" => "Genero no encontrado",
                "errors" => []
            ], 400);
        }

        return response()->json([
            "data" => $generoLibros,
            "message" => "Libros de género",
            "errors" => []
        ], 200);

    }
}
