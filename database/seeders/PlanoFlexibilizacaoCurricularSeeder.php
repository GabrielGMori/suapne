<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanoFlexibilizacaoCurricular;

class PlanoFlexibilizacaoCurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanoFlexibilizacaoCurricular::factory(5)->create();
    }
}
