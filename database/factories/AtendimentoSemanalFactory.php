<?php

namespace Database\Factories;

use App\Models\AtendimentoSemanal;
use App\Models\Estudante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AtendimentoSemanal>
 */
class AtendimentoSemanalFactory extends Factory
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
                'data_atendimento' => $this->faker->date(),
                'descricao' => $this->faker->paragraph(),
                'encaminhamentos' => $this->faker->paragraph(),
            ],
        ];
    }
}
