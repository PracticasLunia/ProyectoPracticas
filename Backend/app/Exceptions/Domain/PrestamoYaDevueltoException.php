<?php

namespace App\Exceptions\Domain;

use RuntimeException;

class PrestamoYaDevueltoException extends RuntimeException
{

    public function __construct(int $prestamoId = 0)
    {
        parent::__construct("El prestamo {$prestamoId} ya se ha sido resuelto anteriormente");
    }
}
