<?php

namespace App\Console\Commands;

use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Console\Command;

class AsociarUsersPrestamos extends Command
{
    protected $signature = 'prestamos:asociar-users';
    protected $description = 'Rellena el user_id de los préstamos existentes según el email_lector';

    public function handle(): int
    {
        $afectados = 0;

        Prestamo::whereNull('user_id')
            ->whereNotNull('email_lector')
            ->chunkById(100, function ($prestamos) use ($afectados) {
                foreach ($prestamos as $prestamo) {
                    $userId = User::where('email', $prestamo->email_lector)->value('id');
                    if ($userId) {
                        $prestamo->update(['user_id' => $userId]);
                        $afectados++;
                    }
                }
            });

        $this->info("Asociados {$afectados} préstamos a usuarios.");
        return self::SUCCESS;
    }
}
