<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('onr_certificado_digital', function (Blueprint $table) {
            // ALTERAR NOME DAS COLUNAS updated_at e created_at e adicionar o data_exclusao
            $table->renameColumn('created_at', 'data_cadastro');
            $table->renameColumn('updated_at', 'data_alteracao');
            $table->date('data_exclusao')->nullable();
            $table->longText('certificado_base64')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('onr_certificado_digital', function (Blueprint $table) {});
    }
};
