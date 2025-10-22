<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caixa_operacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caixa_id')->constrained('caixa')->onDelete('cascade');
            $table->foreignId('caixa_destino_id')->nullable()->constrained('caixa')->onDelete('set null')
                ->comment('Usado apenas em transferências');
            $table->foreignId('caixa_operacao_vinculada_id')->nullable()->constrained('caixa_operacao')->onDelete('set null')
                ->comment('Vincula as duas operações em uma transferência');
            $table->string('tipo', 20)->comment('SANGRIA, REFORCO, TRANSFERENCIA');
            $table->decimal('valor', 10, 2);
            $table->string('descricao', 255);
            $table->text('observacao')->nullable();
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('cascade');
            $table->timestamp('data_operacao')->default(now());
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
        Schema::dropIfExists('caixa_operacao');
    }
};
