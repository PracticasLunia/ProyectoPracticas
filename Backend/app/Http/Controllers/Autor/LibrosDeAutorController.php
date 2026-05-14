<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Autor\LibrosDeAutor;
use App\Http\UseCases\Autor\LibrosDeAutorRequest;
use App\Http\UseCases\Autor\VerAutor;
use App\Http\UseCases\Autor\VerAutorRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LibrosDeAutorController extends Controller
{

    public function __construct(
        private readonly VerAutor $verAutor,
        private readonly LibrosDeAutor $librosDeAutor
    ){}

    public function __invoke(Request $request, int $id){

        try {
            $autor = $this->verAutor->handle( new VerAutorRequest(
                autor_id: $id
            ));

            $librosDeAutor = $this->librosDeAutor->handle( new LibrosDeAutorRequest(
                autor:$autor
            ));

            return response()->json([
                "data" => $librosDeAutor,
                "message" => "Libros del Autor",
                "errors" => [],
            ], 200);

        } catch (ModelNotFoundException $e) {
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404);
        }

    }
}
