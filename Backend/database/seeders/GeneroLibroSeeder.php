<?php

namespace Database\Seeders;

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
        $libro1=Libro::find(1);
        $libro2=Libro::find(2);
        $libro3=Libro::find(3);

        $libro1->generos()->attach([1,2,3]);
        $libro2->generos()->attach([2,3,4]);
        $libro3->generos()->attach([3,4,5]);

    }
}
