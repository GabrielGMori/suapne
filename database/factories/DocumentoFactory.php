<?php

namespace Database\Factories;

use App\Models\Documento;
use App\Models\Estudante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Documento>
 */
class DocumentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estudante = Estudante::query()->inRandomOrder('')->first();

        return [
            'tipo' => $this->faker->randomElement(['Documento', 'Entrevista_Estudante', 'Ficha_CPAE']),
            'nome' => $this->faker->words(3, true) . '.pdf',
            'path' => 'documentos/' . $this->faker->uuid() . '.pdf',
            'estudante_id' => $estudante->id,
        ];
    }
}
