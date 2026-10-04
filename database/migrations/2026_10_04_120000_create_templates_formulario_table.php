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
        Schema::create('templates_formulario', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 150);
            $table->string('tipo');
            $table->json('campos');
            $table->boolean('padrao')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index(['tipo', 'padrao']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates_formulario');
    }
};
