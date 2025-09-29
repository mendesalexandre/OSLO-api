<?php

use Database\Seeders\NaturezaSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('natureza', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->uuid();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->string('codigo')->nullable()->unique();
            // $table->string('slug')->unique();

            // DOI
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('natureza');
    }
};
