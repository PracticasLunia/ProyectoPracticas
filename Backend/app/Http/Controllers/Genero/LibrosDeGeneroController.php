<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Genero\LibrosDeGenero;
use App\Http\UseCases\Genero\LibrosDeGeneroRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class LibrosDeGeneroController extends Controller
{
    public function __construct(
        private readonly LibrosDeGenero $librosDeGenero
    ){}

    public function __invoke(Request $request, int $id){

        try {

            $libros = $this->librosDeGenero->handle( new LibrosDeGeneroRequest(
                genero_id: $id
            ));

            return response()->json([
                "data" => $libros,
                "message" => "Libros de género",
                "errors" => []
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                "data" => null,
                "message" => "Genero no encontrado",
                "errors" => $e->getMessage()
            ], 404);
        }

    }
}
