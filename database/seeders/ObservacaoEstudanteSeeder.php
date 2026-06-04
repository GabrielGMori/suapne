<?php

namespace Database\Seeders;

use App\Models\ObservacaoEstudante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObservacaoEstudanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ObservacaoEstudante::factory(30)->create();
    }
}
