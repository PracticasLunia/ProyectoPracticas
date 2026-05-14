<?php

namespace App\Http\UseCases\Autor;


final readonly class EliminarAutorRequest
{
    public function __construct(
        public int $autor_id,
    ) {}
}
