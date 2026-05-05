<?php

namespace Database\Factories;

use App\Models\Prestamo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Prestamo>
 */
class PrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'libro_id' => null,
            'nombre_lector' => $this->faker->name(),
            'email_lector' => $this->faker->unique()->safeEmail(),
            'fecha_prestamo' => null,
            'fecha_devolucion_prevista' => null,
            'fecha_devolucion_real' => null,
            'observaciones' => $this->faker->optional()->sentence(),
        ];
    }
}
