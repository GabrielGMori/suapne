<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use App\Models\Curso;
use Illuminate\Database\Seeder;

class DisciplinaSeeder extends Seeder
{
    private function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disciplinas = [
            ['nome' => 'Português', 'anos' => 4],
            ['nome' => 'Matemática', 'anos' => 5],
            ['nome' => 'Física', 'anos' => 3],
            ['nome' => 'Biologia', 'anos' => 3],
            ['nome' => 'Química', 'anos' => 3],
            ['nome' => 'História', 'anos' => 3],
            ['nome' => 'Geografia', 'anos' => 3],
            ['nome' => 'Sociologia', 'anos' => 3],
            ['nome' => 'Filosofia', 'anos' => 3],
            ['nome' => 'Inglês', 'anos' => 2],
            ['nome' => 'Espanhol', 'anos' => 2],
            ['nome' => 'Educação Física', 'anos' => 3],
            ['nome' => 'Artes', 'anos' => 4],
        ];

        foreach ($disciplinas as $disciplina) {
            foreach (Curso::all() as $curso) {
                for ($ano = 1; $ano <= $disciplina['anos'] && $ano <= $curso->quantidade_periodos; $ano++) {
                    Disciplina::create([
                        'nome' => $disciplina['nome'] . " " . $this->numberToRomanRepresentation($ano),
                        'ementa' => "Ementa da disciplina de " . $disciplina['nome'] . " para o " . $ano . "º ano do Curso " . $curso->nome,
                        'curso_periodo' => $ano,
                        'curso_id' => $curso->id,
                    ]);
                }
            }
        }
    }
}
