<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ActualizarLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        try {
            //Validaciones
            $request->validate([
                "titulo" => "required|string",
                "isbn" => "required|string|unique:libros,isbn,".$id,
                "publicacion"=>"required|integer",
                "sinopsis"=>"nullable|max:255",
                "num_paginas"=>"required|integer|min:1|max:1000",
                "disponible" => "boolean",
                "autor_id"=> "required|exists:autores,id",
                "genero_ids" => "required|array",
                "portada" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
                "contenido"=>"nullable|file|mimes:pdf|max:20480",
            ]);
        } catch (ValidationException $e) {
             return response()->json([
                'data'=>null,
                'message'=>'Error al intentar actualizar el libro',
                'errors'=>$e->errors(),
            ], 422 );
        }

        try {
             $libro= Libro::findOrFail($id);
        } catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404 );
        }

        //GESTIÓN DE ARCHIVOS-----------------------------

        //Gestion de portada------------------------------
        // Caso 1: el usuario ha subido una nueva imagen
        if ($request->hasFile('portada')) {
            // Si había una anterior, la borramos del disco
            if ($libro->portada_path) {
                Storage::disk('local')->delete($libro->portada_path);
            }
            // Guardamos la nueva
            $libro->portada_path = $request->file('portada')->store('portadas', 'local');
        }

        // Caso 2: el usuario ha pulsado "Eliminar portada actual"
        elseif ($request->input('eliminar_portada') === '1') {
            if ($libro->portada_path) {
                Storage::disk('local')->delete($libro->portada_path);
            }
            $libro->portada_path = null;
        }

        //Gestion de contenido-------------------------------
        if($request->hasFile('contenido')){
            if($libro->contenido_path){
                Storage::disk('local')->delete($libro->contenido_path);
            }

            $libro->contenido_path=$request->file('contenido')->store('contenidos', 'local');
            $libro->contenido_nombre=$request->file('contenido')->getClientOriginalName();
            $libro->contenido_tamano=$request->file('contenido')->getSize();
        }
        elseif($request->input('eliminar_contenido')==='1'){
            if($libro->portada_path){
                Storage::disk('local')->delete($libro->contenido_path);
            }
            $libro->contenido_path=null;
        }

        //Caso 3: el usuario no ha tocado la portada o contenido
        //Actualización del resto de campos
        $libro->update([
            "titulo"       => $request->titulo,
            "isbn"         => $request->isbn,
            "publicacion"  => $request->publicacion,
            "sinopsis"     => $request->sinopsis,
            "num_paginas"  => $request->num_paginas,
            "disponible"   => $request->disponible,
            "autor_id"     => $request->autor_id,
            //Actualizar valores con lo resultante de los condicionantes anteriores
            "portada_path" => $libro->portada_path,
            "contenido_path" => $libro->contenido_path,
            "contenido_nombre" => $libro->contenido_nombre,
            "contenido_tamano" => $libro->contenido_tamano,
        ]);

        $libro->generos()->sync($request->genero_ids);
        return response()->json(
            [
                'data' => $libro,
                'message' => 'Libro actualizado correctamente',
                'errors' => []
            ]
        , 200);
    }
}
