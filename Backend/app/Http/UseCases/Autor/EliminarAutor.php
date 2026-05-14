<?php

namespace App\Http\UseCases\Autor;
use App\Repositories\Autor\AutorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class EliminarAutor {

    public function __construct(
        private AutorRepositoryInterface $autorRepository,
    ){}

    public function handle(EliminarAutorRequest $request) {

        $autor = $this->autorRepository->getById($request->autor_id);

        if(is_null($autor)){
            throw new ModelNotFoundException('Autor no encontrado');
        }

        $this->autorRepository->delete($autor);

    }

}

?>
