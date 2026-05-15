<?php

namespace App\Http\UseCases\Genero;
use App\Models\Genero;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class ActualizarGenero {

    public function __construct(
        private GeneroRepositoryInterface $generoRepository,
    ){}

    public function handle(ActualizarGeneroRequest $request): Genero {

        $genero = $this->generoRepository->getById($request->genero_id);

        if(is_null($genero)){
            throw new ModelNotFoundException('Genero no encontrado');
        }

        $generoActualizado = $this->generoRepository->update($genero,
        [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return $generoActualizado;
    }

}

?>
