<?php

namespace Database\Factories;

use App\Models\Estudante;
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
        $estudante = Estudante::query()->inRandomOrder('')->first();

        return [
            'estudante_id' => $estudante->id,
            'campos' => [
                'disciplina' => $this->faker->randomElement(['Português', 'Matemática', "Artes", "Física", "História"]),
                'ano' => $this->faker->numberBetween(2020, 2026),
                'necessidades' => $this->faker->paragraph(),
            ],
        ];
    }
}
