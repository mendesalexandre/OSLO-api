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
        Schema::table('caixa', function (Blueprint $table) {
            $table->boolean('requer_abertura')->nullable()
                ->comment('null = usa config global, true = sempre requer, false = nunca requer');
        });
    }

    public function down(): void
    {
        Schema::table('caixa', function (Blueprint $table) {
            $table->dropColumn('requer_abertura');
        });
    }
};
