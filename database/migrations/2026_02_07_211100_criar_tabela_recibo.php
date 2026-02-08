<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recibo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('protocolo_id')->constrained('protocolo');
            $table->string('numero', 30)->unique();
            $table->integer('ano');
            $table->foreignId('usuario_id')->constrained('usuario');
            $table->string('solicitante_nome', 200);
            $table->string('solicitante_cpf_cnpj', 18)->nullable();
            $table->decimal('valor_total', 15, 2);
            $table->decimal('valor_isento', 15, 2)->default(0);
            $table->decimal('valor_pago', 15, 2);
            $table->timestamp('data_emissao')->useCurrent();
            $table->text('observacao')->nullable();
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recibo');
    }
};
