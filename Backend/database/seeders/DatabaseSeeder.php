<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //Orden de llamada respentado las relaciones entre tablas
        $this->call([
            GeneroSeeder::class,
            AutorSeeder::class,
            LibroSeeder::class,
            GeneroLibroSeeder::class,
            PrestamoSeeder::class,
            UserSeeder::class,
        ]);
    }
}
