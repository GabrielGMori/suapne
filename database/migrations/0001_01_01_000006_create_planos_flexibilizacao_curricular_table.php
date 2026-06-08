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
        Schema::create('planos_flexibilizacao_curricular', function (Blueprint $table) {
            $table->id();

            $table->date('periodo_inicio');
            $table->date('periodo_fim');

            $table->json('campos');

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('estudante_id')
                ->constrained('estudantes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planos_flexibilizacao_curricular');
    }
};
