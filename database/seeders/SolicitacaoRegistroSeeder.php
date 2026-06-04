<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SolicitacaoRegistro;
class SolicitacaoRegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = now();

        SolicitacaoRegistro::factory(20)->create([
            'role' => RoleEnum::PROFESSOR_REGULAR,
            'created_at' => fn () => (clone $currentDate)->addMinutes(random_int(20, 180)),
        ]);
        SolicitacaoRegistro::factory(10)->create([
            'role' => RoleEnum::TECNICO,
            'created_at' => fn () => (clone $currentDate)->addMinutes(random_int(20, 180)),
        ]);
    }
}
