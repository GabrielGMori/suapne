<?php

use App\Models\TemplateFormulario;
use Database\Seeders\TemplateFormularioSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new TemplateFormularioSeeder())->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        TemplateFormulario::withTrashed()->where('padrao', true)->forceDelete();
    }
};
