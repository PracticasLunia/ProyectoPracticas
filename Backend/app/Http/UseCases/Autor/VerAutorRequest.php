<?php

namespace App\Http\UseCases\Autor;


final readonly class VerAutorRequest
{
    public function __construct(
        public int $autor_id,
    ) {}
}
