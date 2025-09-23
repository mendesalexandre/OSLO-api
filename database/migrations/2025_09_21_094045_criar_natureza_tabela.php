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
        Schema::create('natureza', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome');
            $table->text('descricao')->nullable();


            $table->integer('natureza_protocolo_id')->nullable();
            $table->integer('natureza_doi_id')->nullable();
            $table->$table->integer('prazo_validade_legal')->default(0);
            $table->boolean('prenotacao_permitir_dias_corridos')->default(true);
            $table->boolean('prenotacao_permitir_dias_uteis')->default(false);
            $table->boolean('prenotacao_permitir_prorrogacao')->default(false);
            $table->boolean('prenotacao_permitir_suspender_cadastro')->default(false);
            $table->longText('anotacao_personalizada_suspensao')->nullable();

            $table->boolean('qualificacao_permitir_dias_corridos')->default(true);
            $table->boolean('qualificacao_permitir_dias_uteis')->default(false);
            $table->boolean('qualificacao_permitir_prorrogacao')->default(false);
            $table->boolean('qualificacao_permitir_suspender_cadastro')->default(false);

            $table->boolean('reingresso_permitir_dias_corridos')->default(true);
            $table->boolean('reingresso_permitir_dias_uteis')->default(false);
            $table->boolean('reingresso_permitir_prorrogacao')->default(false);
            $table->boolean('reingresso_permitir_suspender_cadastro')->default(false);

            $table->unsignedBigInteger('usuario_criacao_id')->nullable()->after('data_exclusao');
            $table->unsignedBigInteger('usuario_alteracao_id')->nullable()->after('usuario_criacao_id');
            $table->unsignedBigInteger('usuario_exclusao_id')->nullable()->after('usuario_alteracao_id');

            $table->string('nivel_dificuldade')->nullable();
            // Índices para performance
            $table->index('usuario_criacao_id');
            $table->index('usuario_alteracao_id');
            $table->index('usuario_exclusao_id');

            // Foreign keys (assumindo que a tabela de usuários se chama 'users')
            $table->foreign('usuario_criacao_id')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('usuario_alteracao_id')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('usuario_exclusao_id')->references('id')->on('usuario')->onDelete('set null');

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->nullable();
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
        Schema::dropIfExists('natureza');
    }
};
