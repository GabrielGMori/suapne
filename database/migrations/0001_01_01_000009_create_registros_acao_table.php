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
        Schema::create('registros_acao', function (Blueprint $table) {
            $table->id();

            $table->enum('tipo', [
                'Criacao',
                'Edicao',
                'Exclusao',
            ]);

            $table->foreignId('estudante_id')
                ->constrained('estudantes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('atributo', 200);
            $table->string('atributo_valor', 200);
            $table->string('atributo_antigo_valor', 200);
            $table->string('atributo_tipo', 200);

            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('registros_acao');
    }
};
