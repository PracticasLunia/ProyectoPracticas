<?php

namespace Database\Seeders;

use App\Models\Libro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Libro::create([
            "titulo" => "Cien años de soledad",
            "isbn"=> "97884968",
            "publicacion"=> 2018,
            "sinopsis" => "se centra en la familia Buendía de Riohacha y la maldición que llevan con ellos, por involucrarse entre parientes",
            "num_paginas" => 450,
            "disponible" => true,
        ]);
        Libro::create([
            "titulo" => "Don Quijote de la Mancha",
            "isbn"=> "97884568",
            "publicacion"=> 2010,
            "sinopsis" => "La novela narra las aventuras de Alonso Quijano, un viejo caballero que de tanto leer historias de caballería pierde la razón y decide convertirse en caballero andante para salir a resolver problemas e impartir justicia.",
            "num_paginas" => 234,
            "disponible" => true,
        ]);
        Libro::create([
            "titulo" => "El señor de los anillos",
            "isbn"=> "1245679834",
            "publicacion"=> 2012,
            "sinopsis" => "La novela narra el viaje del protagonista principal, Frodo Bolsón, hobbit de la Comarca, para destruir el Anillo Único y la consiguiente guerra que provocará el enemigo para recuperarlo",
            "num_paginas" => 923,
            "disponible" => false,
        ]);
        Libro::create([
            "titulo" => "Cien años de soledad",
            "isbn"=> "978849643",
            "publicacion"=> 2018,
            "sinopsis" => "se centra en la familia Buendía de Riohacha y la maldición que llevan con ellos, por involucrarse entre parientes",
            "num_paginas" => 450,
            "disponible" => true,
        ]);
        Libro::create([
            "titulo" => "El guardian entre el centeno",
            "isbn"=> "9076352467",
            "publicacion"=> 2016,
            "sinopsis" => "Narra las experiencias de Holden Caulfield un adolescente de diecisiete años, perteneciente a una familia adinerada en los años 50 en los Estados Unidos, en plena recuperación de la guerra de Vietnam.",
            "num_paginas" => 125,
            "disponible" => true,
        ]);
    }
}
