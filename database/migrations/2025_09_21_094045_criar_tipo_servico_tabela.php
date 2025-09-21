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
            $table->decimal('valor', 10, 2)->nullable();
            $table->json('opcoes')->nullable();

            $table->unsignedBigInteger('usuario_criacao_id')->nullable()->after('data_exclusao');
            $table->unsignedBigInteger('usuario_alteracao_id')->nullable()->after('usuario_criacao_id');
            $table->unsignedBigInteger('usuario_exclusao_id')->nullable()->after('usuario_alteracao_id');

            // Índices para performance
            $table->index('usuario_criacao_id');
            $table->index('usuario_alteracao_id');
            $table->index('usuario_exclusao_id');

            // Foreign keys (assumindo que a tabela de usuários se chama 'users')
            $table->foreign('usuario_criacao_id')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('usuario_alteracao_id')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('usuario_exclusao_id')->references('id')->on('usuario')->onDelete('set null');

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
        Schema::dropIfExists('natureza');
    }
};
