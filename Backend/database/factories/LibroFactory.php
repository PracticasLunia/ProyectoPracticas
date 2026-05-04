<?php

namespace Database\Factories;

use App\Models\Libro;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Autor;

/**
 * @extends Factory<Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(3),
            'isbn' => fake()->isbn13(),
            'publicacion' => fake()->year(),
            'sinopsis' => fake()->text(200),
            'num_paginas' => fake()->numberBetween(50, 1000),
            'disponible' => fake()->boolean(),

            'autor_id' => null,

            'portada_path' => null,
            'contenido_path' => null,
            'contenido_nombre' => null,
            'contenido_tamano' => null,
        ];
    }
}
