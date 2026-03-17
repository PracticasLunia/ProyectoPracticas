<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;

class BuscarLibrosController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        //Parametros de la url
        $parametros = [
            'titulo' => $request->input('titulo'),
            'isbn' => $request->input('isbn'),
            'publicacion' => $request->input('publicacion'),
            'sinopsis' => $request->input('sinopsis'),
            'num_paginas' => $request->input('num_paginas'),
            'disponible' => $request->input('disponible'),
        ];

        //Evaluacion
            /*if(empty(array_filter($parametros))){
                return  response() ->json(Libro::all(), 200) ;
            }
            if (!empty($parametros['titulo']) && empty($parametros['isbn'])&& empty($parametros['publicacion'])
                && empty($parametros['sinopsis']) && empty($parametros['numero_paginas']) && empty($parametros['disponible'])){
                $libros= Libro::where('titulo', 'LIKE', '%'.$parametros['titulo'].'%')->get();
                return response()->json($libros, 200);
            }
            if (!empty($parametros['titulo']) && !empty($parametros['isbn'])&& empty($parametros['publicacion'])
                && empty($parametros['sinopsis']) && empty($parametros['numero_paginas']) && empty($parametros['disponible'])){
                $libros= Libro::where('titulo', 'LIKE', '%'.$parametros['titulo'].'%')
                                ->where('isbn', 'LIKE', '%'.$parametros['isbn'].'%')
                                ->get();
                return response()->json($libros, 200);
            }
            else{
                return response()->json('Formato no compatible', 200);
            }*/

            $libros= Libro::where('titulo', 'LIKE', '%'.$parametros['titulo'].'%')
                ->where('isbn', 'LIKE', '%'.$parametros['isbn'].'%')
                ->where('publicacion', 'LIKE', '%'.$parametros['publicacion'].'%')
                ->where('sinopsis', 'LIKE', '%'.$parametros['sinopsis'].'%')
                ->where('num_paginas', 'LIKE', '%'.$parametros['num_paginas'].'%')
                ->where('disponible', 'LIKE', '%'.$parametros['disponible'].'%')
                ->get();
            return response()->json($libros, 200);
    }
}
