<?php

namespace Database\Seeders;

use App\Models\Estudante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstudanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estudante::factory(7)->create(['situacao' => 'MATRICULADO']);
        Estudante::factory(2)->create(['situacao' => 'FORMADO']);
        Estudante::factory(1)->create(['situacao' => 'CANCELADO']);
    }
}
