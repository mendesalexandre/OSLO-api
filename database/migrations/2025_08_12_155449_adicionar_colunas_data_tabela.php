<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onr_configuracao', function (Blueprint $table) {
            $table->string('diretorio_imagem_tiff')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('onr_configuracao', function (Blueprint $table) {
            $table->dropColumn('diretorio_imagem_tiff');
        });
    }
};
