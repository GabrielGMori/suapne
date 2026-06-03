<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $integrados = [
            ['nome' => 'Administração', 'periodos' => 3],
            ['nome' => 'Contabilidade', 'periodos' => 3],
            ['nome' => 'Eletrônica', 'periodos' => 3],
            ['nome' => 'Mecânica', 'periodos' => 3],
            ['nome' => 'Informática', 'periodos' => 4],
            ['nome' => 'Petróleo e Gás', 'periodos' => 3],
            ['nome' => 'Processos Fotográficos', 'periodos' => 3],
            ['nome' => 'Programação de Jogos Digitais', 'periodos' => 4]
        ];

        $subsequentes = [
            ['nome' => 'Edificações', 'periodos' => 2],
            ['nome' => 'Eletrotécnica', 'periodos' => 2],
            ['nome' => 'Eletromecânica', 'periodos' => 2],
            ['nome' => 'Enfermagem', 'periodos' => 2],
            ['nome' => 'Eventos', 'periodos' => 2],
            ['nome' => 'Massoterapia', 'periodos' => 2],
            ['nome' => 'Mecânica', 'periodos' => 2],
            ['nome' => 'Processos Fotográficos', 'periodos' => 2],
            ['nome' => 'Prótese Dentária', 'periodos' => 2],
            ['nome' => 'Radiologia', 'periodos' => 2],
            ['nome' => 'Saúde Bucal', 'periodos' => 2],
            ['nome' => 'Telecomunicações', 'periodos' => 2],
            ['nome' => 'Condomínio', 'periodos' => 2]
        ];

        foreach ($integrados as $curso) {
            Curso::create([
                'nome' => 'Técnico em '. $curso['nome'] . ' Integrado',
                'quantidade_periodos' => $curso['periodos']
            ]);
        }

        foreach ($subsequentes as $curso) {
            Curso::create([
                'nome' => 'Técnico em '. $curso['nome'] . ' Subsequente',
                'quantidade_periodos' => $curso['periodos']
            ]);
        }
    }
}
