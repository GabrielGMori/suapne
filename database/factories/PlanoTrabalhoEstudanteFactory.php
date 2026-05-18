<?php

namespace Database\Factories;

use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\User;
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
        $disciplina = Disciplina::query()->inRandomOrder('')->first();

        return [
            'status' => $this->faker->randomElement(['Pendente', 'Aguardando_revisao', 'Devolvido', 'Aprovado']),
            'campos' => [
                'objetivos' => $this->faker->paragraph(),
                'metodologia' => $this->faker->paragraph(),
                'avaliacao' => $this->faker->paragraph(),
            ],
            'estudante_id' => $estudante->id,
            'disciplina_id' => $disciplina->id,
            'user_professor_id' => $user->id,
        ];
    }
}
