<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('doi', function (Blueprint $table) {
            $table->string('status')->default('pendente')->nullable();
            $table->enum('status_processamento', [
                'pendente',
                'processando',
                'concluido',
                'pausado_sessao'
            ])->default('pendente')->after('data_importacao');

            $table->timestamp('processado_em')->nullable()->after('status_processamento');
        });
    }

    public function down(): void
    {
        Schema::table('doi', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('status_processamento');
            $table->dropColumn('processado_em');
        });
    }
};
