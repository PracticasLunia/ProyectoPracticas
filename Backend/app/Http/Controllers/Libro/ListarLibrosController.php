<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Libro\LibroRepositoryInterface;

class ListarLibrosController extends Controller
{
    public function __construct(
        private readonly LibroRepositoryInterface $librosRepository
    ){}

    public function __invoke(Request $request){

        $listadoLibros = $this->librosRepository->getAll();

        return response()->json([
            'data' => $listadoLibros,
            'message' => 'Listado de libros',
        ], 200);
    }
}
