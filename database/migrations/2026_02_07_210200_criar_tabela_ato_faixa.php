<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ato_faixa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ato_id')->constrained('ato')->cascadeOnDelete();
            $table->decimal('valor_de', 15, 2);
            $table->decimal('valor_ate', 15, 2)->nullable();
            $table->decimal('valor_fixo', 15, 2)->nullable();
            $table->decimal('percentual', 8, 4)->nullable();
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ato_faixa');
    }
};
