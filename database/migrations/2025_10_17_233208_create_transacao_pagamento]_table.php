<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transacao_pagamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transacao_id')->constrained('transacao')->onDelete('cascade');
            $table->foreignId('tipo_pagamento_id')->nullable()->constrained('tipo_pagamento')->onDelete('set null');
            $table->foreignId('meio_pagamento_id')->nullable()->constrained('meio_pagamento')->onDelete('set null');
            $table->decimal('valor_pago', 10, 2);
            $table->decimal('taxa', 10, 2)->default(0);
            $table->decimal('valor_liquido', 10, 2)->default(0);
            $table->boolean('is_pago')->default(false);
            $table->date('data_pagamento')->nullable();
            $table->foreignId('pessoa_id')->nullable()->constrained('indicador_pessoal')->onDelete('set null')->comment('Quem pagou');
            $table->text('observacao')->nullable();
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transacao_pagamento');
    }
};
