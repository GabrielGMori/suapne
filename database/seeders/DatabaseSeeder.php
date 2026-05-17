<?php

namespace Database\Seeders;

use App\Models\Estudante;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlanoFlexibilizacao;
use App\Models\Curso;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\AtendimentoSemanal;
use App\Models\RegistroAcao;
use App\Models\SolicitacaoRegistro;
use App\Models\Documento;
use App\Models\EntrevistaResponsavel;
use App\Models\ObservacaoEstudante;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        Curso::factory(20)->create();
        Estudante::factory(7)->create();
        PlanoFlexibilizacao::factory(30)->create();
        PlanoTrabalhoEstudante::factory(30)->create();
        AtendimentoSemanal::factory(30)->create();
        RegistroAcao::factory(30)->create();
        SolicitacaoRegistro::factory(30)->create();
        Documento::factory(30)->create();
        EntrevistaResponsavel::factory(30)->create();
        ObservacaoEstudante::factory(30)->create();

        User::factory()->create([
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'DOCENTE_ESPECIAL',
        ]);
    }
}
