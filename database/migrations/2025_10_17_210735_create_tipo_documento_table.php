<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_documento', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome', 100);
            $table->string('descricao', 255)->nullable();
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_documento');
    }
};
