<?php

namespace Database\Factories;

use App\Models\SolicitacaoRegistro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<SolicitacaoRegistro>
 */
class SolicitacaoRegistroFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => $this->faker->randomElement(['PROFESSOR_REGULAR', 'DOCENTE_ESPECIAL', 'TECNICO']),
            'status' => $this->faker->randomElement(['PENDENTE', 'ACEITA', 'RECUSADA']),
            'user_aprovador_id' => null,
            'user_criado_id' => null,
        ];
    }
}
