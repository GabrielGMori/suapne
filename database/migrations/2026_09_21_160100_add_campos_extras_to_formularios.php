<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tabelas = [
        'planos_flexibilizacao_curricular',
        'planos_trabalho_estudante',
        'atendimentos_semanais',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tabelas as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                $table->json('campos_extras')->nullable()->after('campos');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tabelas as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                $table->dropColumn('campos_extras');
            });
        }
    }
};
