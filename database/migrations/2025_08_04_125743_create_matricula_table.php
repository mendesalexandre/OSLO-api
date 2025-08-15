<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matricula', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->integer('numero');
            $table->string('lote')->nullable();
            $table->string('quadra')->nullable();
            $table->string('bairro')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->string('area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matricula');
    }
};
