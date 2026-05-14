<?php

namespace App\Http\UseCases\Autor;

use App\Models\Autor;

final readonly class LibrosDeAutorRequest
{
    public function __construct(
        public Autor $autor,
    ) {}
}
