<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('lote_doi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->timestamp('data_criacao')->useCurrent();
            $table->timestamp('data_envio_iniciado')->nullable();
            $table->timestamp('data_envio_concluido')->nullable();
            $table->enum('status', ['criado', 'enviando', 'concluido', 'erro'])->default('criado');
            $table->integer('total_doi')->default(0);
            $table->boolean('sucesso')->default(false);
            $table->text('erro')->nullable();
            $table->text('observacao')->nullable();

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lote_doi');
    }
};
