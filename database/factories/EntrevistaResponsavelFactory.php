<?php

namespace Database\Factories;

use App\Models\EntrevistaResponsavel;
use App\Models\Estudante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EntrevistaResponsavel>
 */
class EntrevistaResponsavelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estudante = Estudante::query()->inRandomOrder('')->first()
            ?? Estudante::factory()->create();

        return [
            'estudante_id' => $estudante->id,
            'campos' => [
                'data_entrevista' => $this->faker->date(),
                'responsavel_entrevistado' => $this->faker->name(),
                'parentesco' => $this->faker->randomElement(['Pai', 'Mãe', 'Tio', 'Avô', 'Avó']),
                'relato' => $this->faker->paragraph(),
            ],
        ];
    }
}
