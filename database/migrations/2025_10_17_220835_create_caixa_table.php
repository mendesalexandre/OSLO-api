<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caixa', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome', 100);
            $table->string('descricao', 255)->nullable();
            $table->decimal('saldo_inicial', 15, 2)->default(0);
            $table->timestamp('data_saldo_inicial')->useCurrent();
            $table->decimal('saldo_atual', 15, 2)->default(0);
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->nullable()->default(null);
            $table->timestamp('data_exclusao')->nullable()->default(null);

            $table->unique('nome');
            $table->index('nome');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('caixa');
    }
};
