<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\TipoRegistroAcaoEnum;
use App\Models\Estudante;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

use App\Models\RegistroAcao;
class RegistroAcaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudantes = Estudante::all();
        $users = User::where('role', RoleEnum::DOCENTE_ESPECIAL);

        $currentDate = now()->subDays(30);

        foreach ($estudantes as $estudante) {
            RegistroAcao::create([
                'tipo' => TipoRegistroAcaoEnum::CRIACAO_ESTUDANTE,
                'estudante_id' => $estudante->id,
                'user_id' => $users->inRandomOrder()->first()->id,
                'created_at' => $currentDate,
            ]);
            $currentDate->addMinutes(random_int(10, 120));
        }

        RegistroAcao::factory(20)->create([
            'tipo' => TipoRegistroAcaoEnum::EDICAO_ESTUDANTE,
            'created_at' => fn () => (clone $currentDate)->addMinutes(random_int(20, 180)),
        ]);
    }
}
