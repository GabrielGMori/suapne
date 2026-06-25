<?php

namespace Database\Factories;

use App\Models\Estudante;
use App\Models\RegistroAcao;
use App\Models\User;
use App\Enums\TipoRegistroAcaoEnum;
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
        $user = User::query()->inRandomOrder()->first();
        $estudante = Estudante::query()->inRandomOrder()->first();

        return [
            'tipo' => $this->faker->randomElement(TipoRegistroAcaoEnum::cases()),
            'estudante_id' => $estudante->id,
            'user_id' => $user->id,
            'atributo' => $estudante->getFillable()[array_rand($estudante->getFillable())],
            'atributo_valor' => 'Formado',
            'atributo_antigo_valor' => 'Matriculado',
            'atributo_tipo' => 'string',
        ];
    }
}
