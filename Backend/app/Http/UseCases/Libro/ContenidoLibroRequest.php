<?php

namespace App\Http\UseCases\Libro;

use Illuminate\Http\UploadedFile;

final readonly class ContenidoLibroRequest
{
    public function __construct(
        public ?string $download,
    ) {}
}
