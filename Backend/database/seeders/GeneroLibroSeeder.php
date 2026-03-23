<?php

namespace Database\Seeders;

use App\Models\Genero;
use App\Models\Libro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneroLibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $libro=Libro::find(1);
        $libro->generos()->attach([1,2]);

        $libro=Libro::find(2);
        $libro->generos()->attach([2,3]);

        $libro=Libro::find(3);
        $libro->generos()->attach([3,4]);

        $libro=Libro::find(4);
        $libro->generos()->attach([3,4]);

        $libro=Libro::find(5);
        $libro->generos()->attach([1,5]);

        /*$genero=Genero::find(1);
        $genero->libros()->attach([1,5]);

        $genero=Genero::find(2);
        $genero->libros()->attach([1,2]);

        $genero=Genero::find(3);
        $genero->libros()->attach([2,3]);

        $genero=Genero::find(4);
        $genero->libros()->attach([3,4]);

        $genero=Genero::find(5);
        $genero->libros()->attach([3,4]);*/


    }
}
