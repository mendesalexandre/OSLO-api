<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('meio_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('descricao', 255)->nullable();
            $table->decimal('taxa_percentual', 5, 2)->default(0)->comment('Taxa em percentual');
            $table->decimal('taxa_fixa', 10, 2)->default(0)->comment('Taxa fixa por transação');
            $table->integer('prazo_compensacao')->default(0)->comment('Dias até compensação');
            $table->boolean('is_ativo')->default(true);
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meio_pagamento');
    }
};
