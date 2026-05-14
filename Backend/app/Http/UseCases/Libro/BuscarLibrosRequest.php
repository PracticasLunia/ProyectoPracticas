<?php

namespace App\Http\UseCases\Libro;

use Illuminate\Http\UploadedFile;

final readonly class BuscarLibrosRequest
{
    public function __construct(
        public ?string $titulo,
        public ?string $isbn,
        public ?string $publicacion,
        public ?string $sinopsis,
        public ?int $num_paginas,
        public ?bool $disponible,
        public ?string $autor,
        public ?string $genero_nombre
    ) {}
}
