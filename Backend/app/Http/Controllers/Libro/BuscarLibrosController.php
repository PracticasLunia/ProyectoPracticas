<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
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
            'autor' => $request->input('autor'),
            'genero_nombre' => $request->input('genero_nombre'),
        ];


        $libros =
        Libro::where('titulo', 'LIKE', '%'.$parametros['titulo'].'%')
            ->where('isbn', 'LIKE', '%'.$parametros['isbn'].'%')
            ->where('publicacion', 'LIKE', '%'.$parametros['publicacion'].'%')
            ->where('sinopsis', 'LIKE', '%'.$parametros['sinopsis'].'%')
            ->where('num_paginas', 'LIKE', '%'.$parametros['num_paginas'].'%')
            ->where('disponible', 'LIKE', '%'.$parametros['disponible'].'%')

            ->whereHas('autor', function(Builder $query) use ($parametros){
                if(is_array($parametros['autor'])){
                    $query->whereIn('autores.nombre', $parametros['autor']);
                }
                elseif(!empty($parametros['autor'])){
                    $query->where('autores.nombre', 'LIKE', '%'.$parametros['autor'].'%');
                }
            })

            ->whereHas('generos', function(Builder $query) use($parametros){
                if(is_array($parametros['genero_nombre']))
                    {
                        $query->whereIn('generos.nombre',$parametros['genero_nombre']);
                    }elseif(!empty($parametros['genero_nombre'])){
                        $query->where('generos.nombre', $parametros['genero_nombre']);
                    }
            })
            ->get();
        return response()->json($libros, 200);
    }
}
