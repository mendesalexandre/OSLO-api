<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onr_token', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->string('codigo')->unique();
            $table->timestamp('data_criacao')->nullable();
            $table->timestamp('data_validade')->nullable();
            $table->boolean('is_utilizado')->default(false);

            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('id_instituicao')->nullable();


            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onr_token');
    }
};
