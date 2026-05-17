<?php

namespace Database\Factories;

use App\Models\RegistroAcao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RegistroAcao>
 */
class RegistroAcaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()->inRandomOrder('')->first()
            ?? User::factory()->create();

        return [
            'tipo' => $this->faker->randomElement(['Criacao', 'Edicao', 'Exclusao']),
            'entidade' => 'Estudante',
            'entidade_id' => $this->faker->numberBetween(1, 50),
            'atributo' => 'situacao',
            'atributo_valor' => 'Formado',
            'atributo_antigo_valor' => 'Matriculado',
            'atributo_tipo' => 'string',
            'user_id' => $user->id,
        ];
    }
}
