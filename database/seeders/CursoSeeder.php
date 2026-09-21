<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. Cursos Técnicos Integrados ao Ensino Médio (Anos/Séries)
        $integrados = [
            ['nome' => 'Técnico em Administração Integrado', 'periodos' => 3],
            ['nome' => 'Técnico em Contabilidade Integrado', 'periodos' => 3],
            ['nome' => 'Técnico em Eletrônica Integrado', 'periodos' => 3],
            ['nome' => 'Técnico em Informática Integrado', 'periodos' => 4],
            ['nome' => 'Técnico em Mecânica Integrado', 'periodos' => 3],
            ['nome' => 'Técnico em Petróleo e Gás Integrado', 'periodos' => 3],
            ['nome' => 'Técnico em Processos Fotográficos Integrado', 'periodos' => 3],
            ['nome' => 'Técnico em Programação de Jogos Digitais Integrado', 'periodos' => 4],
        ];

        // 2. Cursos Técnicos Subsequentes ao Ensino Médio (Semestres)
        $subsequentes = [
            ['nome' => 'Técnico em Condomínio Subsequente', 'periodos' => 3],
            ['nome' => 'Técnico em Edificações Subsequente', 'periodos' => 4],
            ['nome' => 'Técnico em Eletromecânica Subsequente', 'periodos' => 4],
            ['nome' => 'Técnico em Eletrotécnica Subsequente', 'periodos' => 4],
            ['nome' => 'Técnico em Enfermagem Subsequente', 'periodos' => 4],
            ['nome' => 'Técnico em Eventos Subsequente', 'periodos' => 3],
            ['nome' => 'Técnico em Massoterapia Subsequente', 'periodos' => 3],
            ['nome' => 'Técnico em Mecânica Subsequente', 'periodos' => 4],
            ['nome' => 'Técnico em Processos Fotográficos Subsequente', 'periodos' => 3],
            ['nome' => 'Técnico em Produção de Áudio e Vídeo Subsequente', 'periodos' => 3],
            ['nome' => 'Técnico em Prótese Dentária Subsequente', 'periodos' => 4],
            ['nome' => 'Técnico em Radiologia Subsequente', 'periodos' => 4],
            ['nome' => 'Técnico em Saúde Bucal Subsequente', 'periodos' => 3],
            ['nome' => 'Técnico em Telecomunicações Subsequente', 'periodos' => 4],
        ];

        // 3. Cursos de Graduação / Ensino Superior (Semestres)
        $graduacoes = [
            // Bacharelado
            ['nome' => 'Bacharelado em Ciências Contábeis', 'periodos' => 8],

            // Licenciaturas
            ['nome' => 'Licenciatura em Educação Física', 'periodos' => 8],
            ['nome' => 'Licenciatura em Pedagogia', 'periodos' => 8],

            // Cursos Superiores de Tecnologia (CST)
            ['nome' => 'Tecnologia em Gestão Pública', 'periodos' => 4],
            ['nome' => 'Tecnologia em Massoterapia', 'periodos' => 6],
            ['nome' => 'Tecnologia em Processos Escolares', 'periodos' => 5],
            ['nome' => 'Tecnologia em Processos Gerenciais', 'periodos' => 4],
            ['nome' => 'Tecnologia em Secretariado', 'periodos' => 5],
        ];

        $allCursos = array_merge($integrados, $subsequentes, $graduacoes);

        $records = array_map(fn ($curso) => [
            'nome' => $curso['nome'],
            'quantidade_periodos' => $curso['periodos'],
            'created_at' => $now,
            'updated_at' => $now,
        ], $allCursos);

        // Bulk insert em uma única query
        Curso::insert($records);
    }
}
