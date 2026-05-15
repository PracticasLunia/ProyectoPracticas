<?php

namespace App\Http\UseCases\Genero;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Support\Collection;

final readonly class ListarGeneros {

    public function __construct(
        private GeneroRepositoryInterface $generoRepository,
    ){}

    public function handle(): Collection {
        $generos = $this->generoRepository->getAll();
        return $generos;
    }

}

?>
