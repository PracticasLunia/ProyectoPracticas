<?php

namespace App\Http\UseCases\Genero;
use App\Http\UseCases\Genero\CrearGeneroRequest;
use App\Models\Genero;
use App\Repositories\Genero\GeneroRepositoryInterface;

final readonly class CrearGenero {

    public function __construct(
        private GeneroRepositoryInterface $generoRepository,
    ){}

    public function handle(CrearGeneroRequest $request): Genero {

        $genero = $this->generoRepository->store([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return $genero;
    }

}

?>
