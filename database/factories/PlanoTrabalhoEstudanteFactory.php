<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\User;
use App\Enums\StatusPlanoTrabalhoEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlanoTrabalhoEstudante>
 */
class PlanoTrabalhoEstudanteFactory extends Factory
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
        $professor = User::query()->where('funcao', RoleEnum::PROFESSOR_REGULAR)->inRandomOrder('')->first();
        $disciplina = Disciplina::query()->where('curso_id', $estudante->curso_id)->inRandomOrder('')->first();

        return [
            'status' => $this->faker->randomElement([StatusPlanoTrabalhoEnum::PENDENTE->value, StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO->value, StatusPlanoTrabalhoEnum::DEVOLVIDO->value, StatusPlanoTrabalhoEnum::APROVADO->value]),
            'periodo_inicio' => $this->faker->date('2026-01-01', '2026-05-20'),
            'periodo_fim' => $this->faker->date('2025-10-01', '2025-12-31'),
            'campos' => [],
            'estudante_id' => $estudante->id,
            'user_id' => $user->id,
            'disciplina_id' => $disciplina->id,
            'user_professor_id' => $user->id,
        ];
    }
}
