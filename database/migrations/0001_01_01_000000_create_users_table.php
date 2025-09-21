<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamp('email_verificado_em')->nullable();
            $table->string('senha');
            $table->string('foto')->nullable();

            $table->timestamp('ultimo_login_em')->nullable();
            $table->string('ultimo_login_ip')->nullable();

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();

            // Índices para melhor performance
            $table->index(['email', 'is_ativo']);
        });

        // Tabela para reset de senha (útil mesmo com Passport)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('password_reset_tokens');
    }
};
