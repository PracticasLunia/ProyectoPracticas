<?php

namespace App\Http\UseCases\Libro;

use Illuminate\Http\UploadedFile;

final readonly class EliminarLibroRequest
{
    public function __construct(
        public int $libro_id,
    ) {}
}
