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
        Schema::create('estado', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome', 100); // Definindo tamanho específico
            $table->string('sigla', 2); // UF sempre tem 2 caracteres
            $table->integer('ibge_codigo')->unsigned();

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('data_exclusao')->nullable();

            // ÍNDICES PARA OTIMIZAÇÃO
            // Índice para busca por nome (consultas frequentes)
            $table->index('nome', 'idx_estado_nome');

            // Índice único para sigla (UF é única)
            $table->unique('sigla', 'uk_estado_sigla');

            // Índice único para código IBGE (é único por estado)
            $table->unique('ibge_codigo', 'uk_estado_ibge_codigo');

            // Índice para filtros por status ativo
            $table->index('is_ativo', 'idx_estado_is_ativo');

            // Índice composto para consultas com filtro ativo + nome
            $table->index(['is_ativo', 'nome'], 'idx_estado_ativo_nome');

            // Índice para soft delete queries
            $table->index('data_exclusao', 'idx_estado_data_exclusao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado');
    }
};
