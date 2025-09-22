<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onr_configuracao', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('url')->unique();
            $table->string('nome')->nullable();
            $table->integer('ambiente')->default(0); // 0 = Produção, 1 = Homologação
            $table->string('chave')->unique();
            $table->string('certificado_subject')->nullable();
            $table->string('certificado_issuer')->nullable();
            $table->string('certificado_public_key')->nullable();
            $table->string('certificado_serial_number')->nullable();
            $table->date('certificado_valid_until')->nullable();
            $table->string('cpf')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('id_parceiro_ws')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onr_configuracao');
    }
};
