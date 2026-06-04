<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AtendimentoSemanal;

class AtendimentoSemanalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AtendimentoSemanal::factory(30)->create(['local' => 'CNAPNE']);
    }
}
