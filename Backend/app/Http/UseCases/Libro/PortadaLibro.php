<?php

namespace App\Http\UseCases\Libro;

use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

final readonly class PortadaLibro {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(int $id): StreamedResponse{

        $libro = $this->librosRepository->getById($id);

        //Si el libro no existe o no tiene portada
        if ($libro === null || $libro->portada_path === null) {
            throw new ModelNotFoundException('Libro no encontrado');
        }

        //Selecciona el disco (Privado storage/app), lee el archivo, detecta el tipo,
        //crea una respuesta http, envia el archivo al navegador
        return Storage::disk('local')->response($libro->portada_path);

    }

}

?>
