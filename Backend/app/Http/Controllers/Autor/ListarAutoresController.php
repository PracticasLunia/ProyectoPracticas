<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Autor\ListarAutores;
use Illuminate\Http\Request;

class ListarAutoresController extends Controller
{

    public function __construct(
        private readonly ListarAutores $listarAutores
    ){}

    public function __invoke(Request $request) {

        $autores = $this->listarAutores->handle();

        return response()->json([
            "data" => $autores,
            "message" => "Listado de autores",
            "errors" => [],
        ], 200);

    }
}
