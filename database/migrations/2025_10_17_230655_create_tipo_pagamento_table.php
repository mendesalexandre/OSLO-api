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
        Schema::create('tipo_pagamento', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->integer('codigo')->nullable();
            $table->string('nome');
            $table->string('descricao');
            $table->timestamp('data_cadastro');
            $table->timestamp('data_alteracao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_pagamento');
    }
};
