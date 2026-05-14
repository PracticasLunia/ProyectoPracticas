<?php

namespace App\Http\UseCases\Autor;
use App\Http\UseCases\Autor\CrearAutorRequest;
use App\Models\Autor;
use App\Repositories\Autor\AutorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class ActualizarAutor {

    public function __construct(
        private AutorRepositoryInterface $autorRepository,
    ){}

    public function handle(ActualizarAutorRequest $request, int $id): Autor {

        $autor = $this->autorRepository->getById($id);

        if(is_null($autor)){
            throw new ModelNotFoundException('Autor no encontrado');
        }

        $autorActualizado = $this->autorRepository->update($autor,
        [
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'nacionalidad' => $request->nacionalidad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'biografia' => $request->biografia,
        ]);

        return $autorActualizado;
    }

}

?>
