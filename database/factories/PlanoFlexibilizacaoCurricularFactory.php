<?php

namespace Database\Factories;

use App\Models\Estudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\User;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlanoFlexibilizacaoCurricular>
 */
class PlanoFlexibilizacaoCurricularFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estudante = Estudante::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        return [
            'estudante_id' => $estudante->id,
            'user_id' => $user->id,
            'periodo_inicio' => $this->faker->date('2026-01-01', '2026-05-20'),
            'periodo_fim' => $this->faker->date('2026-10-01', '2026-12-31'),
            'campos' => [],
        ];
    }
}
