<?php

namespace App\Http\UseCases\Libro;
use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\throwException;

final readonly class EliminarLibro {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(EliminarLibroRequest $request){

        $libro = $this->librosRepository->getById($request->libro_id);

        if(is_null($libro)){
            throw new ModelNotFoundException('Libro no encontrado');
        }

        $rutaPortada = $libro->portada_path;

        $this->librosRepository->delete($libro);

        //Eliminar la ruta de la portada asociada, si la tiene
        if ($rutaPortada) {
            Storage::disk('local')->delete($rutaPortada);
        }
    }

}

?>
