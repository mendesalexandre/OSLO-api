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
        Schema::table('onr_configuracao', function (Blueprint $table) {
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onr_configuracao', function (Blueprint $table) {
            $table->dropColumn('data_cadastro');
            $table->dropColumn('data_alteracao');
            $table->dropColumn('data_exclusao');
        });
    }
};
