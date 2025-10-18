<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('caixa_movimento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caixa_id')->constrained('caixa')->onDelete('cascade');
            $table->foreignId('usuario_abertura_id')->constrained('usuario')->onDelete('cascade');
            $table->foreignId('usuario_fechamento_id')->nullable()->constrained('usuario')->onDelete('cascade');
            $table->timestamp('data_abertura');
            $table->timestamp('data_fechamento')->nullable();
            $table->decimal('saldo_inicial_informado', 10, 2)->comment('Saldo informado pelo operador na abertura');
            $table->decimal('saldo_inicial_sistema', 10, 2)->comment('Saldo registrado no sistema');
            $table->decimal('saldo_final_informado', 10, 2)->nullable()->comment('Saldo contado pelo operador no fechamento');
            $table->decimal('saldo_final_sistema', 10, 2)->nullable()->comment('Saldo calculado pelo sistema');
            $table->decimal('diferenca', 10, 2)->default(0)->comment('Diferença entre informado e sistema (+ sobra / - falta)');
            $table->decimal('total_entradas', 10, 2)->default(0);
            $table->decimal('total_saidas', 10, 2)->default(0);
            $table->text('observacao_abertura')->nullable();
            $table->text('observacao_fechamento')->nullable();
            $table->string('status', 20)->default('ABERTO');
            $table->timestamp('data_cadastro')->nullable();
            $table->timestamp('data_alteracao')->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixa_movimento');
    }
};
