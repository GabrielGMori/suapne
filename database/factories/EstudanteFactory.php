<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Estudante;
use App\Enums\SituacaoEstudanteEnum;
use App\Enums\SexoEnum;
use App\Enums\EtniaEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
/**
 * @extends Factory<Estudante>
 */
class EstudanteFactory extends Factory
{
    public function definition(): array
    {
        $curso = Curso::query()->inRandomOrder('')->first();
        $nome = $this->faker->name();
        $matricula = $this->faker->unique()->numerify('202#####');

        return [
            'nome' => $nome,
            'matricula' => $matricula,
            'ingresso_ano' => $this->faker->numberBetween(2020, 2026),
            'ingresso_periodo' => $this->faker->numberBetween(1, 2),
            'periodo' => $this->faker->numberBetween(
                1,
                $curso->quantidade_periodos
            ),
            'email_pessoal' => str_replace(' ', '.', trim(str_replace('.', '', strtolower($nome)))) . '@exemplo.com',
            'email_academico' => str_replace(' ', '.', trim(str_replace('.', '', strtoupper($matricula)))) . '@estudantes.ifpr.edu.br',
            'data_nascimento' => $this->faker->dateTimeBetween('-20 year', 'now'),
            'telefone' => $this->faker->numerify('(##) 9####-####'),
            'necessidades' => "O aluno possui... [Texto de exemplo]",
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'situacao' => $this->faker->randomElement([
                SituacaoEstudanteEnum::MATRICULADO->value,
                SituacaoEstudanteEnum::FORMADO->value,
                SituacaoEstudanteEnum::CANCELADO->value
            ]),
            'sexo' => $this->faker->randomElement([
                SexoEnum::MASCULINO->value,
                SexoEnum::FEMININO->value
            ]),
            'etnia' => $this->faker->randomElement([
                EtniaEnum::BRANCA->value,
                EtniaEnum::PRETA->value,
                EtniaEnum::PARDA->value,
                EtniaEnum::AMARELA->value,
                EtniaEnum::INDIGENA->value,
                EtniaEnum::NAO_DECLARADA->value
            ]),
            'nacionalidade' => 'Brasileira',
            'naturalidade' => $this->faker->city(),
            'nome_pai' => $this->faker->name('male'),
            'telefone_pai' => $this->faker->numerify('(##) 9####-####'),
            'nome_mae' => $this->faker->name('female'),
            'telefone_mae' => $this->faker->numerify('(##) 9####-####'),
            'nome_responsavel' => $this->faker->name(),
            'telefone_responsavel' => $this->faker->numerify('(##) 9####-####'),
            'email_responsavel' => $this->faker->safeEmail(),
            'curso_id' => $curso->id,
            'avatar' =>
                'https://api.dicebear.com/7.x/adventurer/svg?backgroundColor=b6e3f4&seed=' .
                urlencode($this->faker->userName()),
        ];
    }
}
