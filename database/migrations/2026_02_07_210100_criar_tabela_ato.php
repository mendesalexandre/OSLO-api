<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ato', function (Blueprint $table) {
            $table->id();
            $table->foreignId('natureza_id')->constrained('natureza');
            $table->string('codigo', 20)->unique();
            $table->string('nome', 200);
            $table->text('descricao')->nullable();
            $table->decimal('valor_fixo', 15, 2)->nullable();
            $table->decimal('percentual', 8, 4)->nullable();
            $table->decimal('valor_minimo', 15, 2)->nullable();
            $table->decimal('valor_maximo', 15, 2)->nullable();
            $table->string('tipo_calculo', 20)->default('fixo');
            $table->boolean('ativo')->default(true);
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ato');
    }
};
