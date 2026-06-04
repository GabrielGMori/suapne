<?php

namespace Database\Factories;

use App\Models\Estudante;
use App\Models\PlanoFlexibilizacaoCurricular;
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
        $estudante = Estudante::query()
            ->whereDoesntHave('planosFlexibilizacaoCurricular')
            ->inRandomOrder()
            ->first() ?? Estudante::query()->inRandomOrder('')->first();

        return [
            'estudante_id' => $estudante->id,
            'periodo_inicio' => $this->faker->date('2026-01-01', '2026-05-20'),
            'periodo_fim' => $this->faker->date('2025-10-01', '2025-12-31'),
            'campos' => [],
        ];
    }
}
