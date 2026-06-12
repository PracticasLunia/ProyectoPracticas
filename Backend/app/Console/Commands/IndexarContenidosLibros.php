<?php

namespace App\Console\Commands;

use App\Services\LibroIndexacionService;
use Illuminate\Console\Command;

class IndexarContenidosLibros extends Command
{
    protected $signature = 'libros:indexar-contenidos';

    protected $description = 'Indexa los contenidos de los libros';

    public function handle(): int
    {
        $service = app(LibroIndexacionService::class);

        $service->handle();

        $this->info('Indexación completada');

        return self::SUCCESS;
    }
}
