<?php

namespace Database\Seeders;

use App\Enums\StatusPlanoTrabalhoEnum;
use Illuminate\Database\Seeder;
use App\Models\PlanoTrabalhoEstudante;

class PlanoTrabalhoEstudanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanoTrabalhoEstudante::factory(8)->create(['status' => StatusPlanoTrabalhoEnum::PENDENTE]);
        PlanoTrabalhoEstudante::factory(6)->create(['status' => StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO]);
        PlanoTrabalhoEstudante::factory(2)->create(['status' => StatusPlanoTrabalhoEnum::DEVOLVIDO]);
        PlanoTrabalhoEstudante::factory(12)->create(['status' => StatusPlanoTrabalhoEnum::APROVADO]);
    }
}
