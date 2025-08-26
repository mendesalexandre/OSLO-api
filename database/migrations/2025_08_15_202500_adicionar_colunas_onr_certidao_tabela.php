<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('onr_certidao', function (Blueprint $table) {
            $table->renameColumn('integrador_selo_hora', 'integrado_selo_hora');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onr_certidao', function (Blueprint $table) {
            $table->renameColumn('integrado_selo_hora', 'integrador_selo_hora');
        });
    }
};
