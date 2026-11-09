<?php

use App\Enums\TipoFormularioEnum;
use App\Models\TemplateFormulario;
use Database\Seeders\TemplateFormularioSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entrevistas_familiar', function (Blueprint $table) {
            $table->json('campos_extras')->nullable()->after('campos');

            $table->foreignId('template_formulario_id')
                ->nullable()
                ->constrained('templates_formulario')
                ->nullOnDelete();
        });

        (new TemplateFormularioSeeder())->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entrevistas_familiar', function (Blueprint $table) {
            $table->dropConstrainedForeignId('template_formulario_id');
            $table->dropColumn('campos_extras');
        });

        TemplateFormulario::withTrashed()
            ->where('tipo', TipoFormularioEnum::ENTREVISTA_FAMILIAR)
            ->forceDelete();
    }
};
