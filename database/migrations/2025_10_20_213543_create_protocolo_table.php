<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('protocolo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero');
            $table->date('data_prevista')->nullable();
            $table->date('data_reingresso')->nullable();
            $table->date('data_limite')->nullable();
            $table->unsignedBigInteger('solicitante_id');
            $table->unsignedBigInteger('atendente_id')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->foreignId('natureza_id')->constrained('natureza');
            $table->unsignedBigInteger('reprotocolo_origem_id')->nullable();
            $table->foreignId('tipo_suspensao_id')->nullable()->constrained('tipo_suspensao');
            $table->foreignId('tipo_documento_id')->nullable()->constrained('tipo_documento');
            $table->unsignedBigInteger('vinculo_id')->nullable();
            $table->boolean('entregue')->default(false);
            $table->unsignedBigInteger('etapa_id')->nullable();
            $table->unsignedBigInteger('etapa_usuario_id')->nullable();
            $table->unsignedBigInteger('etapa_anterior_id')->nullable();
            $table->foreignId('finalizador_id')->nullable()->constrained('usuario');
            $table->text('motivo_cancelamento')->nullable();
            $table->unsignedBigInteger('interessado_id')->nullable();
            $table->unsignedBigInteger('tomador_id')->nullable();
            $table->integer('dias')->default(0);
            $table->boolean('is_digital')->default(false);
            $table->boolean('is_parado')->default(false);
            $table->boolean('pago')->default(false);
            $table->boolean('mesa')->default(false);
            $table->string('status')->default('VIGENTE');
            $table->timestamp('ultima_interacao')->nullable();
            $table->json('debug')->nullable();
            $table->json('tags')->nullable();

            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protocolo');
    }
};
