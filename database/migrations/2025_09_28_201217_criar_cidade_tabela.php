<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cidade', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome', 150); // Cidades podem ter nomes maiores
            $table->integer('ibge_estado_id')->unsigned();
            $table->integer('ibge_codigo')->unsigned();
            $table->foreignId('estado_id')->nullable()->constrained('estado');

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('data_exclusao')->nullable();

            // ÍNDICES PARA OTIMIZAÇÃO
            // Índice para busca por nome (consulta mais comum)
            $table->index('nome', 'idx_cidade_nome');

            // Índice para chave estrangeira (já criado automaticamente, mas explicitando)
            $table->index('estado_id', 'idx_cidade_estado_id');

            // Índice único para código IBGE (cada cidade tem código único)
            $table->unique('ibge_codigo', 'uk_cidade_ibge_codigo');

            // Índice para ibge_estado_id (consultas por estado via IBGE)
            $table->index('ibge_estado_id', 'idx_cidade_ibge_estado_id');

            // Índice para filtros por status ativo
            $table->index('is_ativo', 'idx_cidade_is_ativo');

            // Índices compostos para consultas frequentes
            // Buscar cidades ativas de um estado específico
            $table->index(['estado_id', 'is_ativo'], 'idx_cidade_estado_ativo');

            // Buscar cidades ativas por nome
            $table->index(['is_ativo', 'nome'], 'idx_cidade_ativo_nome');

            // Buscar cidades por estado e nome (muito comum em formulários)
            $table->index(['estado_id', 'nome'], 'idx_cidade_estado_nome');

            // Índice para soft delete queries
            $table->index('data_exclusao', 'idx_cidade_data_exclusao');

            // Índice composto para listagens completas (estado ativo + cidade ativa)
            $table->index(['estado_id', 'is_ativo', 'nome'], 'idx_cidade_estado_ativo_nome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cidade');
    }
};
