<?php

namespace App\Http\UseCases\Autor;
use App\Models\Autor;
use App\Repositories\Autor\AutorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class LibrosDeAutor {

    public function __construct(
        private AutorRepositoryInterface $autorRepository,
    ){}

    public function handle(LibrosDeAutorRequest $request): Collection {
        $libros = $this->autorRepository->getBooks($request->autor);
        return $libros;
    }

}

?>
