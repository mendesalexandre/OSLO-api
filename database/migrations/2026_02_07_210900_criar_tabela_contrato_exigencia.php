<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contrato_exigencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contrato')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuario');
            $table->text('descricao');
            $table->integer('prazo_dias')->nullable();
            $table->date('data_cumprimento')->nullable();
            $table->boolean('cumprida')->default(false);
            $table->text('observacao')->nullable();
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrato_exigencia');
    }
};
