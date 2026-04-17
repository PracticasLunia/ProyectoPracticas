<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;

class CrearLibroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //

        $request->validate([
            "titulo" => "required|string",
            "isbn" => "required|unique:libros|string",
            "publicacion"=>"required|integer",
            "sinopsis"=>"nullable|max:255",
            "num_paginas"=>"required|integer",
            "disponible" => "boolean",
            "autor_id"=> "required|exists:autores,id",
            "genero_ids" => "required|array",
            //Validaciones archivos
            "portada" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
            "contenido"=>"nullable|file|mimes:pdf|max:20480",
        ]);

        //GESTIÓN DE ARCHIVOS-----------------------------

        //Gestion de portada------------------------------
        // Si viene un fichero de portada, lo guardamos en disco y obtenemos el path
        $portadaPath = null;
        if ($request->hasFile('portada')) {
            $portadaPath = $request->file('portada')->store('portadas', 'local');
        }

        //Guardar un documento adjunto en el disco, y obtener su path en donde fue guardado, nombre y tamaño
        $contenidoPath=null;
        $contenidoNombre=null;
        $contenidoTamano=null;

        //Gestion de documento-----------------------------
        if($request->hasFile('contenido')){
            $file=$request->file('contenido');
            $contenidoPath= $file->store('contenidos', 'local');
            $contenidoNombre= $file->getClientOriginalName();
            $contenidoTamano= $file->getSize();
        }

        $libro= Libro::create([
            "titulo"=>$request->titulo,
            "isbn"=>$request->isbn,
            "publicacion"=>$request->publicacion,
            "sinopsis"=>$request->sinopsis,
            "num_paginas"=>$request->num_paginas,
            "disponible"=>$request->disponible,
            "autor_id"=>$request->autor_id,
            //Crear con valores con lo resultante de los condicionantes anteriores
            "portada_path" => $portadaPath,
            "contenido_path"   => $contenidoPath,
            "contenido_nombre" => $contenidoNombre,
            "contenido_tamano" => $contenidoTamano,
        ]);
        //Create relations to generos
        $libro->generos()->attach($request->genero_ids);
        return response()->json($libro, 201);
    }
}
