<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('onr_certidao', function (Blueprint $table) {
            $table->string('chave_formatada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onr_certidao', function (Blueprint $table) {
            $table->dropColumn('chave_formatada');
        });
    }
};
