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
        Schema::create('feriado', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome');
            $table->date('data');
            $table->string('descricao')->nullable();
            $table->json('configuracao')->nullable();

            $table->boolean('is_recorrente')->default(false);

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();

            // Índices para melhor performance
            $table->index(['nome', 'data', 'is_ativo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feriado');
    }
};
