<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onr_tabela_custa', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome');
            $table->integer('codigo')->index(); // precisa ser o mesmo código do integrado
            $table->integer('codigo_tj')->index();
            $table->string('descricao')->nullable();
            $table->decimal('valor', 20, 2)->default(0);
            $table->decimal('valor_maximo', 20, 2)->default(0);
            $table->decimal('valor_faixa', 20, 2)->default(0);
            $table->decimal('valor_inicio_faixa', 20, 2)->default(0);
            $table->decimal('valor_base_calculo', 20, 2)->default(0);
            $table->decimal('valor_base_calculo_issqn', 20, 2)->default(0);
            $table->decimal('valor_issqn', 20, 2)->default(0);
            $table->year('ano')->nullable();
            $table->timestamp('data_vigencia_inicio')->nullable();
            $table->timestamp('data_vigencia_fim')->nullable();

            $table->text('observacao')->nullable();

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_atualizacao')->useCurrent()->nullable();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onr_tabela_custa');
    }
};
