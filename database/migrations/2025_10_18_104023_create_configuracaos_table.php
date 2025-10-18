<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracao', function (Blueprint $table) {
            $table->id();
            $table->string('chave', 100)->unique();
            $table->text('valor')->nullable();
            $table->string('tipo', 20)->default('string')->comment('string, boolean, integer, json');
            $table->string('descricao', 255)->nullable();
            $table->string('grupo', 50)->nullable()->comment('Para agrupar configurações');
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracao');
    }
};
