<?php

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
        Schema::table('templates_formulario', function (Blueprint $table) {
            $table->boolean('ativo')->default(false)->after('padrao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates_formulario', function (Blueprint $table) {
            $table->dropColumn('ativo');
        });
    }
};
