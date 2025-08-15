<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onr_certidao', function (Blueprint $table) {
            $table->string('status_batch', 50)->nullable()->index();
            $table->text('mensagem_batch')->nullable();
            $table->string('batch_id', 50)->nullable()->index();
            $table->timestamp('iniciado_em')->nullable()->index();
            $table->timestamp('finalizado_em')->nullable();
            $table->timestamp('validada_em')->nullable();
            $table->timestamp('processada_em')->nullable();
            $table->timestamp('devolvida_em')->nullable();
            $table->string('status_validacao', 50)->nullable();
            $table->text('mensagem_validacao')->nullable();
            // $table->string('status_envio', 50)->nullable();
            // $table->text('mensagem_erro_envio')->nullable();
            // $table->timestamp('ultima_tentativa_envio')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('onr_certidao', function (Blueprint $table) {
            $table->dropColumn(['status_batch', 'mensagem_batch', 'batch_id']);
        });
    }
};
