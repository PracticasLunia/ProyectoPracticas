<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\ListarLibros;
use Illuminate\Http\Request;
use App\Repositories\Libro\LibroRepositoryInterface;

class ListarLibrosController extends Controller
{
    public function __construct(
        private readonly ListarLibros $listar_libros
    ){}

    public function __invoke(Request $request){

        $listadoLibros = $this->listar_libros->handle();

        return response()->json([
            'data' => $listadoLibros,
            'meta' => [
                'current_page' => $listadoLibros->currentPage(),
                'last_page'    => $listadoLibros->lastPage(),
                'per_page'     => $listadoLibros->perPage(),
                'total'        => $listadoLibros->total(),
            ],
            'message' => 'Listado de libros',
        ], 200);
    }
}
