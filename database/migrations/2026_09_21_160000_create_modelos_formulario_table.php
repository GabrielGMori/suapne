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
        Schema::create('modelos_formulario', function (Blueprint $table) {
            $table->id();

            $table->string('tipo');
            $table->json('removidos');
            $table->json('personalizados');

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

            $table->unique(['estudante_id', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelos_formulario');
    }
};
