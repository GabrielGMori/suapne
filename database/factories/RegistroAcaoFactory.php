<?php

namespace Database\Factories;

use App\Models\Estudante;
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
        $user = User::query()->inRandomOrder('')->first();
        $estudante = Estudante::query()->inRandomOrder('')->first();

        return [
            'tipo' => $this->faker->randomElement(['Criacao', 'Edicao', 'Exclusao']),
            'estudante_id' => $estudante->id,
            'atributo' => 'situacao',
            'atributo_valor' => 'Formado',
            'atributo_antigo_valor' => 'Matriculado',
            'atributo_tipo' => 'string',
            'user_id' => $user->id,
        ];
    }
}
