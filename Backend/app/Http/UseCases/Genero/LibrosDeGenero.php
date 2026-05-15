<?php

namespace App\Http\UseCases\Genero;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

final readonly class LibrosDeGenero {

    public function __construct(
        private GeneroRepositoryInterface $generoRepository,
    ){}

    public function handle(LibrosDeGeneroRequest $request): Collection{

        $genero = $this->generoRepository->getById($request->genero_id);

        if(is_null($genero)){
            throw new ModelNotFoundException('Genero no encontrado');
        }

        $libros = $this->generoRepository->getBooks($genero);

        return $libros;

    }

}

?>
