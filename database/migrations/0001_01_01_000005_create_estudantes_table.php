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
        Schema::create('estudantes', static function (Blueprint $table) {
            $table->id();

            $table->string('nome', 200);
            $table->string('nome_social', 200)->nullable();
            $table->string('matricula', 50);

            $table->string('cpf', 20);

            $table->smallInteger('ingresso_ano');
            $table->tinyInteger('ingresso_periodo');
            $table->tinyInteger('periodo');

            $table->string('email_pessoal', 255)->nullable();
            $table->string('email_academico', 255);

            $table->date('data_nascimento');

            $table->string('telefone', 20)->nullable();

            $table->text('necessidades');


            $table->enum('situacao', [
                'MATRICULADO',
                'FORMADO',
                'CANCELADO',
            ]);

            $table->enum('sexo', [
                'MASCULINO',
                'FEMININO',
            ]);

            $table->enum('etnia', [
                'BRANCA',
                'PRETA',
                'PARDA',
                'AMARELA',
                'INDIGENA',
                'NAO_DECLARADA',
            ])->nullable();

            $table->string('nacionalidade', 45)->nullable();
            $table->string('naturalidade', 45)->nullable();

            $table->string('nome_pai', 200)->nullable();
            $table->string('telefone_pai', 20)->nullable();

            $table->string('nome_mae', 200)->nullable();
            $table->string('telefone_mae', 20)->nullable();

            $table->string('nome_responsavel', 200)->nullable();
            $table->string('telefone_responsavel', 20)->nullable();
            $table->string('email_responsavel', 255)->nullable();

            $table->string('avatar', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('curso_id')
                ->constrained('cursos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudantes');
    }
};
