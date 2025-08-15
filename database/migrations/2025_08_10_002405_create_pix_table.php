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
        Schema::create('pix', function (Blueprint $table) {
            $table->id();
            $table->integer('ordem_servico_id')->nullable();
            $table->string('chave_pix')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pix');
    }
};
