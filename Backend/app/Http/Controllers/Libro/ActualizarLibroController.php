<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\ActualizarLibro;
use App\Http\UseCases\Libro\ActualizarLibroRequest;
use App\Http\Validators\Libro\ActualizarLibroValidator;

class ActualizarLibroController extends Controller
{
    public function __construct(
        private readonly ActualizarLibro $actualizar_libro
    ){}
    public function __invoke(ActualizarLibroValidator $request, int $id){

        $libroActualizado = $this->actualizar_libro->handle(new ActualizarLibroRequest(
            libro_id: $id,

            titulo: $request->input('titulo'),
            isbn : $request->input('isbn'),
            publicacion: $request->input('publicacion'),
            sinopsis : $request->input('sinopsis'),
            num_paginas: $request->input('num_paginas'),
            disponible : $request->input('disponible'),
            autor_id: $request->input('autor_id'),
            genero_ids : $request->input('genero_ids'),
            portada: $request->file('portada'),
            contenido: $request->file('contenido'),
            eliminar_portada: $request->input('eliminar_portada'),
            eliminar_contenido: $request->input('eliminar_contenido'),
        ));

        // $libro = $this->librosRepository->getById($id);

        /*if(is_null($libro)){
            return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404);
        }*/

        //GESTIÓN DE ARCHIVOS-----------------------------

        //Gestion de portada------------------------------
        // Caso 1: el usuario ha subido una nueva imagen
        /*if ($request->hasFile('portada')) {
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

        $data = [
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
        ];

        $libroActualizado = $this->librosRepository->update($libro, $data);

        $libroActualizado->generos()->sync($request->genero_ids);*/

        return response()->json([
            'data' => $libroActualizado,
            'message' => 'Libro actualizado correctamente',
            'errors' => []
        ], 200);
    }
}
