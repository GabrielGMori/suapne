<?php

namespace Database\Factories;

use App\Models\Estudante;
use App\Models\ObservacaoEstudante;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ObservacaoEstudante>
 */
class ObservacaoEstudanteFactory extends Factory
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
        $user = User::query()->inRandomOrder('')->first()
            ?? User::factory()->create();

        return [
            'observacao' => $this->faker->realText(),
            'estudante_id' => $estudante->id,
            'user_id' => $user->id,
        ];
    }
}
