<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CursoSeeder::class,
            DisciplinaSeeder::class,
            UserSeeder::class,
            EstudanteSeeder::class,
            PlanoFlexibilizacaoCurricularSeeder::class,
            PlanoTrabalhoEstudanteSeeder::class,
            AtendimentoSemanalSeeder::class,
            SolicitacaoRegistroSeeder::class,
            DocumentoSeeder::class,
            EntrevistaFamiliarSeeder::class,
            ObservacaoEstudanteSeeder::class,
        ]);
    }
}
