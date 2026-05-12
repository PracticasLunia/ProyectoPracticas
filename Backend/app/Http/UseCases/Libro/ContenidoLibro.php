<?php

namespace App\Http\UseCases\Libro;

use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

final readonly class ContenidoLibro {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(ContenidoLibroRequest $request, int $id): StreamedResponse{

        $libro = $this->librosRepository->getById($id);

        if($libro===null || $libro->contenido_path ===null){
           throw new ModelNotFoundException('Libro no encontrado');
        }


        //Devuelve el documento descargado y para asignarle su nombre con el que fue guardado
        if ($request->download === '1') {
            return Storage::disk('local')->download(
                $libro->contenido_path,
                $libro->contenido_nombre
            );
        }

        // Por defecto → inline (el navegador lo abre en su visor)
        return Storage::disk('local')->response($libro->contenido_path);

    }

}

?>
