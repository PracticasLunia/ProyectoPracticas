<?php

namespace App\Http\UseCases\Autor;
use App\Models\Autor;
use App\Repositories\Autor\AutorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class VerAutor {

    public function __construct(
        private AutorRepositoryInterface $autorRepository,
    ){}

    public function handle(VerAutorRequest $request): Autor {

        $autor = $this->autorRepository->getById($request->autor_id);

        if(is_null($autor)){
            throw new ModelNotFoundException('Libro no encontrado');
        }

        return $autor;
    }

}

?>
