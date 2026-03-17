<?php

namespace Database\Seeders;

use App\Models\Autor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Autor::create([
            "nombre"=>"Miguel",
            "apellidos"=>"De Cervantes",
            "nacionalidad"=>"Española",
            "fecha_nacimiento"=>"1547-09-29",
            "biografia"=> "Novelista, poeta y dramaturgo español. Se cree que nació el 29 de septiembre de 1547 en Alcalá de Henares y murió el 22 de abril de 1616 en Madrid, pero fue enterrado el 23 de abril y popularmente se conoce esta fecha como la de su muerte."
        ]);

        Autor::create([
            "nombre"=>"Victor Marie",
            "apellidos"=>"Hugo",
            "nacionalidad"=>"Paris",
            "fecha_nacimiento"=>"1802-02-26",
            "biografia"=> "fue un poeta, dramaturgo y novelista romántico francés, considerado como uno de los más importantes en lengua francesa."
        ]);

        Autor::create([
            "nombre"=>"Gabriel",
            "apellidos"=>"Garcia Marquez",
            "nacionalidad"=>"Colombiana",
            "fecha_nacimiento"=>"1927-03-06",
            "biografia"=> "fue un escritor, guionista y periodista colombiano. Reconocido por sus novelas y cuentos, también escribió narrativa de no ficción, discursos, reportajes, críticas cinematográficas y memorias. "
        ]);
    }
}
