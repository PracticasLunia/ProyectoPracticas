<?php

namespace App\Http\UseCases\Libro;
use App\Models\Libro;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Libro\LibroRepositoryInterface;

final readonly class ActualizarLibro {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(ActualizarLibroRequest $request): Libro{


        $libro = $this->librosRepository->getById($request->libro_id);

        //GESTIÓN DE ARCHIVOS-----------------------------

        //Gestion de portada------------------------------
        // Caso 1: el usuario ha subido una nueva imagen
        if ($request->portada != null) {
            // Si había una anterior, la borramos del disco
            if ($libro->portada_path) {
                Storage::disk('local')->delete($libro->portada_path);
            }
            // Guardamos la nueva
            $libro->portada_path = $request->portada->store('portadas', 'local');
        }

        // Caso 2: el usuario ha pulsado "Eliminar portada actual"
        elseif ($request->eliminar_portada === '1') {
            if ($libro->portada_path) {
                Storage::disk('local')->delete($libro->portada_path);
            }
            $libro->portada_path = null;
        }

        //Gestion de contenido-------------------------------
        if($request->contenido != null){
            if($libro->contenido_path){
                Storage::disk('local')->delete($libro->contenido_path);
            }

            $libro->contenido_path=$request->contenido->store('contenidos', 'local');
            $libro->contenido_nombre=$request->contenido->getClientOriginalName();
            $libro->contenido_tamano=$request->contenido->getSize();
        }
        elseif($request->eliminar_contenido ==='1'){
            if($libro->contenido_path){
                Storage::disk('local')->delete($libro->contenido_path);
            }
            $libro->contenido_path=null;
        }

        $libroActualizado = $this->librosRepository->update($libro,[
            "titulo"=>$request->titulo,
            "isbn"=>$request->isbn,
            "publicacion"=>$request->publicacion,
            "sinopsis"=>$request->sinopsis,
            "num_paginas"=>$request->num_paginas,
            "disponible"=>$request->disponible,
            "autor_id"=>$request->autor_id,
            "portada_path" => $libro->portada_path,
            "contenido_path"   => $libro->contenido_path,
            "contenido_nombre" =>  $libro->contenido_nombre,
            "contenido_tamano" => $libro->contenido_tamano,
        ]);

        //update relations to generos
        $libroActualizado->generos()->sync($request->genero_ids);

        return $libroActualizado;
    }

}

?>
