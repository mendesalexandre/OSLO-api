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
        Schema::create('tipo_servico', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->json('opcoes')->nullable();

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();

            // Índices para melhor performance
            $table->index(['is_ativo']);
            $table->index(['nome']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_servico');
    }
};
