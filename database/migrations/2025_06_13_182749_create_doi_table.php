<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('doi', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->integer('doi_importacao_id');
            $table->string('numero_controle');
            $table->string('matricula')->nullable();
            $table->date('data_ato')->nullable();
            $table->json('data')->nullable();
            $table->timestamp('data_importacao')->nullable();
            $table->time('hora_importacao')->nullable();
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doi');
    }
};
