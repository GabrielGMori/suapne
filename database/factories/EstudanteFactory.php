<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Estudante;
use App\Enums\SituacaoEstudanteEnum;
use App\Enums\SexoEnum;
use App\Enums\EtniaEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Estudante>
 */
class EstudanteFactory extends Factory
{
    public function definition(): array
    {
        $curso = Curso::query()->inRandomOrder('')->first();

        return [
            'nome' => fake()->name(),
            'matricula' => fake()->unique()->numerify('202#####'),
            'ingresso_ano' => fake()->numberBetween(2020, 2026),
            'ingresso_periodo' => fake()->numberBetween(1, 2),
            'periodo' => fake()->numberBetween(
                1,
                $curso->quantidade_periodos
            ),
            'email_pessoal' => fake()->unique()->safeEmail(),
            'email_academico' => fake()->unique()->safeEmail(),
            'data_nascimento' => fake()->date('Y-m-d', '2008-01-01'),
            'telefone' => fake()->numerify('(##) 9####-####'),
            'necessidades' => fake()->paragraph(),
            'cpf' => fake()->unique()->numerify('###.###.###-##'),
            'situacao' => fake()->randomElement([
                SituacaoEstudanteEnum::MATRICULADO->value,
                SituacaoEstudanteEnum::FORMADO->value,
                SituacaoEstudanteEnum::CANCELADO->value
            ]),
            'sexo' => fake()->randomElement([
                SexoEnum::MASCULINO->value,
                SexoEnum::FEMININO->value
            ]),
            'etnia' => fake()->randomElement([
                EtniaEnum::BRANCA->value,
                EtniaEnum::PRETA->value,
                EtniaEnum::PARDA->value,
                EtniaEnum::AMARELA->value,
                EtniaEnum::INDIGENA->value,
                EtniaEnum::NAO_DECLARADA->value
            ]),
            'nacionalidade' => 'Brasileira',
            'naturalidade' => fake()->city(),
            'nome_pai' => fake()->name('male'),
            'telefone_pai' => fake()->numerify('(##) 9####-####'),
            'nome_mae' => fake()->name('female'),
            'telefone_mae' => fake()->numerify('(##) 9####-####'),
            'nome_responsavel' => fake()->name(),
            'telefone_responsavel' => fake()->numerify('(##) 9####-####'),
            'email_responsavel' => fake()->safeEmail(),
            'curso_id' => $curso->id,
            'avatar' =>
                'https://api.dicebear.com/7.x/adventurer/svg?backgroundColor=b6e3f4&seed=' .
                urlencode(fake()->userName()),
        ];
    }
}
