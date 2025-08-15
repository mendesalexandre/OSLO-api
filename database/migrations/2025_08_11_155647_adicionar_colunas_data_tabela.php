<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('onr_configuracao', function (Blueprint $table) {
            $table->boolean('pode_gerar_certidao_feriado')->default(false);
            $table->time('atendimento_inicio')->nullable()->default('08:00');
            $table->time('atendimento_fim')->nullable()->default('17:00');
            $table->string('chave_assinador_onr_web')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onr_configuracao', function (Blueprint $table) {
            //
        });
    }
};
