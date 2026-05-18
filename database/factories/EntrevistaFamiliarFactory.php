<?php

namespace Database\Factories;

use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EntrevistaFamiliar>
 */
class EntrevistaFamiliarFactory extends Factory
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
                'data_entrevista' => $this->faker->date(),
                'familiar_entrevistado' => $this->faker->name(),
                'parentesco' => $this->faker->randomElement(['Pai', 'Mãe', 'Tio', 'Avô', 'Avó']),
                'relato' => $this->faker->paragraph(),
            ],
        ];
    }
}
