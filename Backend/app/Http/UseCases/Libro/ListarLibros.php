<?php

namespace App\Http\UseCases\Libro;

use App\Repositories\Libro\LibroRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class ListarLibros {

    public function __construct(
        private LibroRepositoryInterface $librosRepository,
    ){}

    public function handle(): Collection{

        $libros = $this->librosRepository->getAll();

        return $libros;
    }

}

?>
