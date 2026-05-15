<?php

namespace App\Http\UseCases\Genero;
use App\Http\UseCases\Genero\EliminarGeneroRequest;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Genero;

final readonly class VerGenero {

    public function __construct(
        private GeneroRepositoryInterface $generoRepository,
    ){}

    public function handle(VerGeneroRequest $request): ?Genero{

        $genero = $this->generoRepository->getById($request->genero_id);

        if(is_null($genero)){
            throw new ModelNotFoundException('Genero no encontrado');
        }

        return $genero;

    }

}

?>
