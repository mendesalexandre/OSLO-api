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
        Schema::create('tabela_custa', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->uuid('uuid')->unique()->index();
            $table->string('nome');
            $table->text('observacao')->nullable();
            $table->timestamp('vigencia_inicio')->nullable();
            $table->timestamp('vigencia_fim')->nullable();
            $table->year('ano');

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabela_custa');
    }
};
