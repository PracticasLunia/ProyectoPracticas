<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Genero::create([
            "nombre"=>"Suspenso",
            "descripcion"=>"Suspenso a lo largo de la trama con misterio e intriga"
        ]);

        Genero::create([
            "nombre"=>"Aventuras",
            "descripcion"=>"Aventuras a lo largo de la toda la historia con grandes momentos"
        ]);

        Genero::create([
            "nombre"=>"Terror",
            "descripcion"=>"Terror durante toda la trama +18"
        ]);
        Genero::create([
            "nombre"=>"Entretenimiento",
            "descripcion"=>"Entretenimiento diversion y risas durante cada acto"
        ]);
        Genero::create([
            "nombre"=>"Narrativo",
            "descripcion"=>"Narra con entusiasmo y calma cada uno de los sucesos acontecidos"
        ]);

    }
}
