<?php

namespace Database\Seeders;

use App\Models\Prestamo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrestamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Prestamo::create([
            "libro_id" => 1,
            "nombre_lector" => "Andres Villanueba",
            "email_lector" => "andresvillanueba@gmail.com",
            "fecha_prestamo" => "2025-09-29",
            "fecha_devolucion_prevista" => "2025-10-08",
            "fecha_devolucion_real" => "2025-10-07",
            "observaciones" => "Realiza un prestamo de un libro muy solicitado el cliente"
        ]);

        Prestamo::create([
            "libro_id" => 2,
            "nombre_lector" => "Jorge Castillo",
            "email_lector" => "jorgecastillo@gmail.com",
            "fecha_prestamo" => "2026-04-20",
            "fecha_devolucion_prevista" => "2026-04-30",
            "observaciones" => "El cliente realiza el prestamo del libro por unos cuantos dias"
        ]);
    }
}
