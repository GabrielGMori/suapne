<?php

namespace Database\Seeders;

use App\Models\Estudante;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\Curso;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\AtendimentoSemanal;
use App\Models\Disciplina;
use App\Models\RegistroAcao;
use App\Models\SolicitacaoRegistro;
use App\Models\Documento;
use App\Models\EntrevistaFamiliar;
use App\Models\ObservacaoEstudante;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Curso::factory(20)->create();
        Disciplina::factory(40)->create();
        User::factory(15)->create();
        Estudante::factory(7)->create();
        PlanoFlexibilizacaoCurricular::factory(5)->create();
        PlanoTrabalhoEstudante::factory(30)->create();
        AtendimentoSemanal::factory(30)->create();
        RegistroAcao::factory(30)->create();
        SolicitacaoRegistro::factory(30)->create();
        Documento::factory(30)->create();
        EntrevistaFamiliar::factory(30)->create();
        ObservacaoEstudante::factory(30)->create();

        User::factory()->create([
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'DOCENTE_ESPECIAL',
        ]);
    }
}
