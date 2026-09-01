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
        Schema::create('entrevistas_familiar', function (Blueprint $table) {
            $table->id();

            $table->date('data');
            $table->string('responsavel_preenchimento', 200);

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
        Schema::dropIfExists('entrevistas_familiar');
    }
};
