<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('etapa', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome', 100);
            $table->string('descricao', 255)->nullable();
            $table->boolean('contar_prazo')->default(false);
            $table->boolean('pode_finalizar')->default(false);
            $table->boolean('pode_voltar')->default(false);
            $table->boolean('pode_redistruibuir')->default(false);
            $table->boolean('forcar_troca_usuario')->default(false);
            $table->boolean('priorizar_usuario_anterior')->default(false);
            $table->string('cor', 7)->default('#FFFFFF');
            $table->string('tipo_atribuicao')->default('SORTEIO');
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapa');
    }
};
