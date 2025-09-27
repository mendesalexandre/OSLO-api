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
        Schema::create('sequencia', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);

            // Relacionamento com domínio
            $table->string('dominio_codigo', 50); // PROTOCOLO_RI, OFICIO, etc.
            $table->integer('ano');
            $table->integer('numero_atual')->default(0);

            // Configurações de formato
            $table->string('prefixo')->nullable(); // "OF-", "PROT-"
            $table->string('sufixo')->nullable(); // "/2025"
            $table->string('formato')->nullable(); // "{prefixo}{numero}{sufixo}" ou custom
            $table->integer('tamanho_numero')->default(0); // Quantos zeros à esquerda (001, 0001)
            $table->boolean('apenas_numero')->default(false); // Para matrícula (só número)

            // Controle de reinício
            $table->boolean('reinicia_ano')->default(true);
            $table->integer('inicio_contagem')->default(1); // Começa de 1 ou outro número

            // Auditoria e timestamps
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();

            $table->unsignedBigInteger('usuario_criacao_id')->nullable();
            $table->unsignedBigInteger('usuario_alteracao_id')->nullable();
            $table->unsignedBigInteger('usuario_exclusao_id')->nullable();

            // Índices e constraints
            $table->unique(['dominio_codigo', 'ano'], 'sequencia_dominio_ano_unique');
            $table->index(['dominio_codigo']);
            $table->index(['ano']);
            $table->index(['is_ativo']);

            // Foreign keys
            $table->foreign('dominio_codigo')->references('codigo')->on('dominio')->onDelete('cascade');
            $table->foreign('usuario_criacao_id')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('usuario_alteracao_id')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('usuario_exclusao_id')->references('id')->on('usuario')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sequencia');
    }
};
