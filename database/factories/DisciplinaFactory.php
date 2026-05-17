<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Disciplina;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Disciplina>
 */
class DisciplinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $curso = Curso::query()->inRandomOrder('')->first();

        return [
            'nome' => $this->faker->words(3, true),
            'ementa' => $this->faker->paragraph(),
            'curso_id' => $curso->id,
        ];
    }
}
