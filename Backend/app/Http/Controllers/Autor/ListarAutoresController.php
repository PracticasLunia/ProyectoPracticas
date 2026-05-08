<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;
use App\Repositories\Autor\AutorRepositoryInterface;

class ListarAutoresController extends Controller
{

    public function __construct(
        private readonly AutorRepositoryInterface $autoresRepository
    ){}

    public function __invoke(Request $request) {

        $listadoAutores= $this->autoresRepository->getAll();

        return response()->json([
                "data" => $listadoAutores,
                "message" => "Listado de autores",
                "errors" => [],
        ], 200);

    }
}
