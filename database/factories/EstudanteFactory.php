<?php

namespace Database\Factories;

use App\Models\Estudante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Estudante>
 */
class EstudanteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'curso' => $this->faker->randomElement(['Engenharia', 'Medicina', 'Direito', 'Arquitetura']),
            'periodo' => $this->faker->numberBetween(1, 4),
            'situacao' => $this->faker->randomElement(['Matriculado', 'Formado', 'Evadido']),
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode(fake()->name()) . '&color=7F9CF5&background=EBF4FF',
        ];
    }
}
