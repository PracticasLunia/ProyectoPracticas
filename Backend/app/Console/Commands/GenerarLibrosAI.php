<?php

namespace App\Console\Commands;

use App\Services\LibroAIService;
use Illuminate\Console\Command;

class GenerarLibrosAI extends Command
{
    protected $signature = 'libros:seed-ia';
    protected $description = 'Genera libros con IA y los guarda en la BD';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $service = app(LibroAIService::class);

        $service->generarLibros();

        $this->info('Libros generados correctamente');

        return Command::SUCCESS;
    }
}
