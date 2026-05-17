<?php

namespace Database\Factories;

use App\Models\PlanoFlexibilizacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlanoFlexibilizacao>
 */
class PlanoFlexibilizacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomeEstudante' => $this->faker->name(),
            'disciplina' => $this->faker->randomElement(['Português', 'Matemática', "Artes", "Física", "História"]),
            'curso' => $this->faker->randomElement(['Engenharia', 'Medicina', 'Direito', 'Arquitetura']),
            'ano' => $this->faker->numberBetween(1, 5),
        ];
    }
}
