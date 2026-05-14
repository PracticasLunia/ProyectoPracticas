<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\PortadaLibro;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PortadaLibroController extends Controller
{

    public function __construct(
        private readonly PortadaLibro $portada_libro
    ){}

    public function __invoke(Request $request, int $id){

        try{
            $portada = $this->portada_libro->handle($id);
            return $portada;
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404);
        }
    }
}
