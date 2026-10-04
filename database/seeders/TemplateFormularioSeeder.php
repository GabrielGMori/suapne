<?php

namespace Database\Seeders;

use App\Enums\TipoFormularioEnum;
use App\Models\TemplateFormulario;
use App\Models\User;
use App\Support\CamposTemplate;
use Illuminate\Database\Seeder;

class TemplateFormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autor = User::orderBy('id')->first();

        foreach (TipoFormularioEnum::cases() as $tipo) {
            if (TemplateFormulario::where('tipo', $tipo)->where('padrao', true)->exists()) {
                continue;
            }

            TemplateFormulario::create([
                'nome' => 'Template padrão',
                'tipo' => $tipo,
                'campos' => CamposTemplate::campos($tipo),
                'padrao' => true,
                'user_id' => $autor->id,
            ]);
        }
    }
}
