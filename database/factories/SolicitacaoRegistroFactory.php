<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Enums\StatusSolicitacaoRegistroEnum;
use App\Models\Disciplina;
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
        $nome = $this->faker->name();

        return [
            'nome' => $nome,
            'email' => str_replace(' ', '.', trim(str_replace('.', '', strtolower($nome)))) . '@exemplo.com',
            'password' => static::$password ??= Hash::make('password'),
            'role' => $this->faker->randomElement([RoleEnum::PROFESSOR_REGULAR, RoleEnum::TECNICO]),
            'status' => $this->faker->randomElement(StatusSolicitacaoRegistroEnum::cases()),
            'user_aprovador_id' => null,
            'user_criado_id' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (SolicitacaoRegistro $solicitacaoRegistro) {

            if ($solicitacaoRegistro->role !== RoleEnum::PROFESSOR_REGULAR) {
                return;
            }

            $disciplinas = Disciplina::inRandomOrder()
                ->limit(random_int(1, 5))
                ->pluck('id');

            $solicitacaoRegistro->disciplinas()->attach($disciplinas);
        });
    }
}
