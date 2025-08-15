<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onr_configuracao', function (Blueprint $table) {
            $table->foreignId('certificado_digital_id')
                ->nullable()
                ->constrained('onr_certificado_digital')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('onr_configuracao', function (Blueprint $table) {
            $table->dropForeign(['certificado_digital_id']);
            $table->dropColumn('certificado_digital_id');
        });
    }
};
