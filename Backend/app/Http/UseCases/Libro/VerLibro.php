<?php

namespace App\Http\UseCases\Libro;

use App\Models\Libro;
use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class VerLibro {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(VerLibroRequest $request): Libro{

        $libro = $this->librosRepository->getById($request->libro_id);

        if(is_null($libro)){
            throw new ModelNotFoundException('Libro no encontrado');
        }

        $libroCompleto = $this->librosRepository->libroCompleto($libro);

        return $libroCompleto;
    }

}

?>
