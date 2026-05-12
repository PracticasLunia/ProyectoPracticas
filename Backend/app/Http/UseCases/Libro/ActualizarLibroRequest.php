<?php

namespace App\Http\UseCases\Libro;

use Illuminate\Http\UploadedFile;

final readonly class ActualizarLibroRequest
{
    public function __construct(
        public string $titulo,
        public string $isbn,
        public int $publicacion,
        public ?string $sinopsis,
        public int $num_paginas,
        public bool $disponible,
        public int $autor_id,
        public array $genero_ids,
        public ?UploadedFile $portada,
        public ?UploadedFile $contenido,

        public ?string $eliminar_portada,
        public ?string $eliminar_contenido,
        public int $libro_id,
    ) {}
}
