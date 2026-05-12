<?php

namespace App\Http\UseCases\Libro;
use App\Models\Libro;
use App\Repositories\Libro\LibroRepositoryInterface;

final readonly class CrearLibro {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(CrearLibroRequest $request): Libro{

    //GESTIÓN DE ARCHIVOS-----------------------------

        //Gestion de portada------------------------------
        // Si viene un fichero de portada, lo guardamos en disco y obtenemos el path
        $portadaPath = null;
        if ($request->portada != null) {
            $portadaPath = $request->portada->store('portadas', 'local');
        }

        //Guardar un documento adjunto en el disco, y obtener su path en donde fue guardado, nombre y tamaño
        $contenidoPath=null;
        $contenidoNombre=null;
        $contenidoTamano=null;

        //Gestion de documento-----------------------------
        if($request->contenido != null){
            $file=$request->contenido;
            $contenidoPath= $file->store('contenidos', 'local');
            $contenidoNombre= $file->getClientOriginalName();
            $contenidoTamano= $file->getSize();
        }

        $libro = $this->librosRepository->store([
            "titulo"=>$request->titulo,
            "isbn"=>$request->isbn,
            "publicacion"=>$request->publicacion,
            "sinopsis"=>$request->sinopsis,
            "num_paginas"=>$request->num_paginas,
            "disponible"=>$request->disponible,
            "autor_id"=>$request->autor_id,
            "portada_path" => $portadaPath,
            "contenido_path"   => $contenidoPath,
            "contenido_nombre" => $contenidoNombre,
            "contenido_tamano" => $contenidoTamano,
        ]);

        //Create relations to generos
        $libro->generos()->attach($request->genero_ids);

        return $libro;
    }

}

?>
