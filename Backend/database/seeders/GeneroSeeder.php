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
        $genero= Genero::create([
            "nombre"=>"Suspenso",
            "descripcion"=>"Suspenso a lo largo de la trama con misterio e intriga"
        ]);
        //$genero->libros()->attach([1,5]);

        $genero= Genero::create([
            "nombre"=>"Aventuras",
            "descripcion"=>"Aventuras a lo largo de la toda la historia con grandes momentos"
        ]);
        //$genero->libros()->attach([1,2]);

        $genero=Genero::create([
            "nombre"=>"Terror",
            "descripcion"=>"Terror durante toda la trama +18"
        ]);
        //$genero->libros()->attach([2,3]);

        $genero=Genero::create([
            "nombre"=>"Entretenimiento",
            "descripcion"=>"Entretenimiento diversion y risas durante cada acto"
        ]);
        //$genero->libros()->attach([3,4]);

        $genero=Genero::create([
            "nombre"=>"Narrativo",
            "descripcion"=>"Narra con entusiasmo y calma cada uno de los sucesos acontecidos"
        ]);
        //$genero->libros()->attach([3,4]);

    }
}
