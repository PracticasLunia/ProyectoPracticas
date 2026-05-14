<?php

namespace App\Http\UseCases\Autor;
use App\Repositories\Autor\AutorRepositoryInterface;
use Illuminate\Support\Collection;

final readonly class ListarAutores {

    public function __construct(
        private AutorRepositoryInterface $autorRepository,
    ){}

    public function handle(): Collection {
        $autores = $this->autorRepository->getAll();
        return $autores;
    }

}

?>
