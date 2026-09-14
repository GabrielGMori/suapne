<?php

namespace Database\Factories;

use App\Enums\TipoDocumentoEnum;
use App\Models\Documento;
use App\Models\Estudante;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Documento>
 */
class DocumentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estudante = Estudante::query()->inRandomOrder()->first();
        $user = User::query()->inRandomOrder()->first();

        $disponiveis = [TipoDocumentoEnum::DOCUMENTO];
        if (! $estudante->documentos()->where('tipo', TipoDocumentoEnum::LAUDO)->exists()) {
            $disponiveis[] = TipoDocumentoEnum::LAUDO;
        }
        if (! $estudante->documentos()->where('tipo', TipoDocumentoEnum::ESTUDO_DE_CASO)->exists()) {
            $disponiveis[] = TipoDocumentoEnum::ESTUDO_DE_CASO;
        }
        if (! $estudante->documentos()->where('tipo', TipoDocumentoEnum::ENTREVISTA_ESTUDANTE)->exists()) {
            $disponiveis[] = TipoDocumentoEnum::ENTREVISTA_ESTUDANTE;
        }
        if (! $estudante->documentos()->where('tipo', TipoDocumentoEnum::FICHA_CPAE)->exists()) {
            $disponiveis[] = TipoDocumentoEnum::FICHA_CPAE;
        }

        $tipo = $this->faker->randomElement($disponiveis);

        return [
            'tipo' => $tipo,
            'nome_arquivo' => $this->faker->word(),
            'extensao' => 'pdf',
            'path' => 'documentos/' . $this->faker->uuid() . '.pdf',
            'estudante_id' => $estudante->id,
            'user_id' => $user->id,
        ];
    }
}
