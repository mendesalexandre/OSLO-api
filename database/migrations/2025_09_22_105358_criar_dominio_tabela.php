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
        Schema::create('dominio', function (Blueprint $table) {
            // Campos básicos
            $table->id();
            $table->boolean('is_ativo')->default(true);

            // Informações do domínio
            $table->string('codigo', 100)->unique(); // PROTOCOLO_RI, CERTIDAO_RI, etc.
            $table->string('nome', 100); // Nome curto
            $table->string('nome_completo'); // Nome completo
            $table->string('tipo', 50); // PROTOCOLO, PEDIDO_CERTIDAO, AUXILIAR
            $table->string('atribuicao', 20); // RI, RTD, RCPJ, NOTAS, GERAL
            $table->string('genero', 1); // 'o' ou 'a' para artigos

            // Campos opcionais para configuração
            $table->text('descricao')->nullable();
            $table->integer('ordem_exibicao')->default(0);



            // Campos de auditoria
            $table->unsignedBigInteger('usuario_criacao_id')->nullable();
            $table->unsignedBigInteger('usuario_alteracao_id')->nullable();
            $table->unsignedBigInteger('usuario_exclusao_id')->nullable();

            // Índices para performance
            $table->index(['is_ativo']);
            $table->index(['tipo']);
            $table->index(['atribuicao']);
            $table->index(['codigo']);
            $table->index(['ordem_exibicao']);
            $table->index(['is_ativo', 'tipo']);
            $table->index(['is_ativo', 'atribuicao']);

            // Foreign keys
            $table->foreign('usuario_criacao_id')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('usuario_alteracao_id')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('usuario_exclusao_id')->references('id')->on('usuario')->onDelete('set null');

            // Timestamps customizados
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dominio');
    }
};
