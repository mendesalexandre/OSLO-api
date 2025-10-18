<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transacao', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->foreignId('caixa_id')->constrained('caixa')->onDelete('set null');
            $table->string('tipo', 20);
            $table->string('natureza', 50);
            $table->foreignId('categoria_id')->nullable()->constrained('categoria')->onDelete('set null');
            $table->foreignId('tipo_pagamento_id')->nullable()->constrained('tipo_pagamento')->onDelete('set null');
            $table->foreignId('meio_pagamento_id')->nullable()->constrained('meio_pagamento')->onDelete('set null');
            $table->string('descricao', 255);
            $table->decimal('valor', 10, 2);
            $table->decimal('valor_pago', 10, 2)->default(0);
            $table->decimal('taxa', 10, 2)->default(0)->comment('Taxa do meio de pagamento');
            $table->decimal('valor_liquido', 10, 2)->default(0)->comment('Valor após descontar taxa');
            $table->string('status', 20)->default('PENDENTE');
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->text('observacao')->nullable();
            $table->string('documento', 100)->nullable();
            $table->foreignId('pessoa_id')->nullable()->constrained('indicador_pessoal')->onDelete('set null');
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('cascade');
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
        Schema::dropIfExists('transacao');
    }
};
