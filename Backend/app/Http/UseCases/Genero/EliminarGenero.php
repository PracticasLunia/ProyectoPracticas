<?php

namespace App\Http\UseCases\Genero;
use App\Http\UseCases\Genero\EliminarGeneroRequest;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class EliminarGenero {

    public function __construct(
        private GeneroRepositoryInterface $generoRepository,
    ){}

    public function handle(EliminarGeneroRequest $request) {

        $genero = $this->generoRepository->getById($request->genero_id);

        if(is_null($genero)){
            throw new ModelNotFoundException('Genero no encontrado');
        }

        $this->generoRepository->delete($genero);

    }

}

?>
