<?php

namespace App\Http\UseCases\Autor;
use App\Http\UseCases\Autor\CrearAutorRequest;
use App\Models\Autor;
use App\Repositories\Autor\AutorRepositoryInterface;

final readonly class CrearAutor {

    public function __construct(
        private AutorRepositoryInterface $autorRepository,
    ){}

    public function handle(CrearAutorRequest $request): Autor {

        $autor = $this->autorRepository->store([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'nacionalidad' => $request->nacionalidad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'biografia' => $request->biografia,
        ]);

        return $autor;
    }

}

?>
