<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->id();
            $table->foreignId('protocolo_id')->constrained('protocolo');
            $table->string('numero', 30)->unique();
            $table->integer('ano');
            $table->foreignId('usuario_id')->constrained('usuario');
            $table->string('tipo', 50);
            $table->text('descricao')->nullable();
            $table->string('matricula', 50)->nullable();
            $table->string('parte_nome', 200)->nullable();
            $table->string('parte_cpf_cnpj', 18)->nullable();
            $table->text('parte_qualificacao')->nullable();
            $table->date('data_entrada')->useCurrent();
            $table->date('data_previsao')->nullable();
            $table->date('data_conclusao')->nullable();
            $table->integer('prazo_dias')->nullable();
            $table->text('observacao')->nullable();
            $table->text('observacao_interna')->nullable();
            $table->string('status', 30)->default('pendente');
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrato');
    }
};
