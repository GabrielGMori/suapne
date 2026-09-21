<?php

use App\Enums\EtniaEnum;
use App\Enums\RoleEnum;
use App\Enums\SexoEnum;
use App\Enums\SituacaoEstudanteEnum;
use App\Enums\StatusPlanoTrabalhoEnum;
use App\Enums\StatusSolicitacaoRegistroEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TipoDocumentoEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change();
        });
        Schema::table('estudantes', function (Blueprint $table) {
            $table->string('situacao')->change();
            $table->string('sexo')->change();
            $table->string('etnia')->nullable()->change();
        });
        Schema::table('planos_trabalho_estudante', function (Blueprint $table) {
            $table->string('status')->change();
        });
        Schema::table('solicitacoes_registro', function (Blueprint $table) {
            $table->string('role')->change();
            $table->string('status')->nullable()->change();
        });
        Schema::table('documentos', function (Blueprint $table) {
            $table->string('tipo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', RoleEnum::values())->change();
        });
        Schema::table('estudantes', function (Blueprint $table) {
            $table->enum('situacao', SituacaoEstudanteEnum::values())->change();
            $table->enum('sexo', SexoEnum::values())->change();
            $table->enum('etnia', EtniaEnum::values())->nullable()->change();
        });
        Schema::table('planos_trabalho_estudante', function (Blueprint $table) {
            $table->enum('status', StatusPlanoTrabalhoEnum::values())->change();
        });
        Schema::table('solicitacoes_registro', function (Blueprint $table) {
            $table->enum('role', RoleEnum::values())->change();
            $table->enum('status', StatusSolicitacaoRegistroEnum::values())->nullable()->change();
        });
        Schema::table('documentos', function (Blueprint $table) {
            $table->enum('tipo', TipoDocumentoEnum::values())->change();
        });
    }
};
