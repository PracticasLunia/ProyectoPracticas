<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Libro;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VerLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //
        //findOrFail return exception
        try {
            $libro = Libro::with('autor', 'generos')
                ->findOrFail($id);

            $respuesta = [
                'id' => $libro['id'],
                'created_at' => $libro['created_at'],
                'updated_at' => $libro['updated_at'],
                'titulo' => $libro['titulo'],
                'isbn' => $libro['isbn'],
                'autor_id' => $libro['autor_id'],
                'publicacion' => $libro['publicacion'],
                'sinopsis' => $libro['sinopsis'],
                'num_paginas' => $libro['num_paginas'],
                'disponible' => $libro['disponible'],
                'nombre_autor' => $libro['autor']['nombre'],
                'generos'=>$libro['generos'],
                'autor'=>$libro['autor'],
                'tiene_portada'=>$libro['tiene_portada'],
                'tiene_contenido'=>$libro['tiene_contenido'],
            ];

            $libro->esta_prestado = $libro->prestamos()
                ->whereNull('fecha_devolucion_real')
                ->exists();

            $libro->prestamo_activo= $libro->prestamos()
            ->whereNull('fecha_devolucion_real')
            ->first();


            return response()->json([
                'data' => $libro,
                'message' => 'Detalle del libro',
                'errors' => []
                ]
            );
        } catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404 );
        }
    }
}
