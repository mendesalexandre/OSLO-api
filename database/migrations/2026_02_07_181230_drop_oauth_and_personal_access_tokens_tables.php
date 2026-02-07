<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove tabelas do Sanctum e Passport que não são mais utilizadas.
     */
    public function up(): void
    {
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('oauth_refresh_tokens');
        Schema::dropIfExists('oauth_access_tokens');
        Schema::dropIfExists('oauth_auth_codes');
        Schema::dropIfExists('oauth_device_codes');
        Schema::dropIfExists('oauth_clients');
    }

    /**
     * Reverse the migrations.
     * Para restaurar, reinstale Sanctum/Passport e rode suas migrations originais.
     */
    public function down(): void
    {
        // Tabelas pertencem a pacotes removidos.
        // Reinstale os pacotes para recriar.
    }
};
