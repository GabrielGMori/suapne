<?php

use App\Enums\RoleEnum;
use App\Enums\StatusSolicitacaoRegistroEnum;
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
        Schema::create('solicitacoes_registro', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 200);
            $table->string('email', 200);
            $table->string('password', 200);
            $table->json('campos')->nullable();

            $table->enum('role', RoleEnum::values());
            $table->enum('status', StatusSolicitacaoRegistroEnum::values())->nullable();
            
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('user_aprovador_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('user_criado_id')
                ->nullable()
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
        Schema::dropIfExists('solicitacoes_registro');
    }
};
