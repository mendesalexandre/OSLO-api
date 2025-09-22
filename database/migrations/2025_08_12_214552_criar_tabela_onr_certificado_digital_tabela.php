<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('onr_certificado_digital', function (Blueprint $table) {
            $table->id();

            // Identificação
            $table->string('nome')->nullable();
            $table->text('descricao')->nullable();
            $table->string('arquivo_original')->nullable();

            // Dados do certificado
            $table->text('senha_criptografada');
            $table->string('caminho_arquivo');
            $table->bigInteger('tamanho_bytes');
            $table->string('tamanho_formatado');

            // Informações do certificado
            $table->string('titular')->nullable();
            $table->string('emissor')->nullable();
            $table->string('serial')->nullable();
            $table->string('algoritmo')->nullable();
            $table->timestamp('valido_de')->nullable();
            $table->timestamp('valido_ate')->nullable();

            // Status e controle
            $table->boolean('ativo')->default(true);
            $table->boolean('testado')->default(false);
            $table->timestamp('ultima_validacao')->nullable();
            $table->text('erro_validacao')->nullable();

            // Auditoria
            $table->unsignedBigInteger('criado_por')->nullable();
            $table->unsignedBigInteger('atualizado_por')->nullable();
            $table->timestamps();

            // Índices
            $table->index('ativo');
            $table->index('valido_ate');
            $table->index(['ativo', 'valido_ate']);

            // Chaves estrangeiras
            $table->foreign('criado_por')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('atualizado_por')->references('id')->on('usuario')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onr_certificado_digital');
    }
};
