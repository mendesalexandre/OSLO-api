<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doi', function (Blueprint $table) {
            $table->string('codigo_ibge', 7)->nullable();
            $table->timestamp('data_geracao')->nullable();
            // $table->foreignId('usuario_id')->nullable()->constrained('usuario')->nullOnDelete();
            // $table->foreignIdFor(User::class, 'usuario_id')->nullable()->constrained('usuario')->nullOnDelete();
        });
    }


    public function down(): void
    {
        Schema::table('doi', function (Blueprint $table) {
            $table->dropColumn('codigo_ibge');
            $table->dropColumn('data_geracao');
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
        });
    }
};
