<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('planos_trabalho_estudante', static function (Blueprint $table) {
            $table->id();

            $table->enum('status', [
                'PENDENTE',
                'AGUARDANDO_REVISAO',
                'DEVOLVIDO',
                'APROVADO',
            ]);

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

            $table->foreignId('disciplina_id')
                ->constrained('disciplinas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('user_professor_id')
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
        Schema::dropIfExists('planos_trabalho_estudante');
    }
};
