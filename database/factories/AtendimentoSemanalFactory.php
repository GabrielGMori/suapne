<?php

namespace Database\Factories;

use App\Models\AtendimentoSemanal;
use App\Models\Estudante;
use App\Models\User;
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
        $user = User::query()->inRandomOrder('')->first();

        return [
            'estudante_id' => $estudante->id,
            'user_id' => $user->id,
            'local' => $this->faker->company(),
            'data' => $this->faker->dateTime(),
            'campos' => [
                'descricao' => $this->faker->paragraph(),
                'encaminhamentos' => $this->faker->paragraph(),
            ],
        ];
    }
}
