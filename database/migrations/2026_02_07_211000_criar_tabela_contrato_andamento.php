<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contrato_andamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contrato')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuario');
            $table->string('status_anterior', 30)->nullable();
            $table->string('status_novo', 30);
            $table->text('descricao');
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrato_andamento');
    }
};
