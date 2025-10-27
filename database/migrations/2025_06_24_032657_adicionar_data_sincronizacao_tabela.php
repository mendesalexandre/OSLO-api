<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('doi', function (Blueprint $table) {
            $table->boolean('sincronizado')->default(false);
            $table->timestamp('data_sincronizacao')->nullable();
            $table->boolean('enviado')->default(false);
            $table->timestamp('data_envio')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('doi', function (Blueprint $table) {
            $table->dropColumn('data_sincronizacao');
            $table->dropColumn('sincronizado');
            $table->dropColumn('enviado');
            $table->dropColumn('data_envio');
        });
    }
};
