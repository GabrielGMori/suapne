<?php

namespace Database\Factories;

use App\Enums\TipoDocumentoEnum;
use App\Models\Documento;
use App\Models\Estudante;
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
        $estudante = Estudante::query()->inRandomOrder('')->first();

        $disponiveis = [TipoDocumentoEnum::Documento];
        if (! $estudante->documentos()->where('tipo', TipoDocumentoEnum::Laudo)->exists()) {
            $disponiveis[] = TipoDocumentoEnum::Laudo;
        }
        if (! $estudante->documentos()->where('tipo', TipoDocumentoEnum::Estudo_de_Caso)->exists()) {
            $disponiveis[] = TipoDocumentoEnum::Estudo_de_Caso;
        }
        if (! $estudante->documentos()->where('tipo', TipoDocumentoEnum::Entrevista_Estudante)->exists()) {
            $disponiveis[] = TipoDocumentoEnum::Entrevista_Estudante;
        }
        if (! $estudante->documentos()->where('tipo', TipoDocumentoEnum::Ficha_CPAE)->exists()) {
            $disponiveis[] = TipoDocumentoEnum::Ficha_CPAE;
        }

        $tipo = $this->faker->randomElement($disponiveis);

        return [
            'tipo' => $tipo,
            'nome' => $this->faker->words(3, true) . '.pdf',
            'path' => 'documentos/' . $this->faker->uuid() . '.pdf',
            'estudante_id' => $estudante->id,
        ];
    }
}
