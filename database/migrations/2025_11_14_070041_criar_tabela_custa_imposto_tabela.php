<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabela_custa_imposto', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->boolean('is_ativo')->default(true);

            $table->foreignId('tabela_custa_id')->constrained('tabela_custa', 'id')->cascadeOnDelete();
            $table->foreignId('cidade_id')->nullable()->constrained('cidade');

            // Identificação
            $table->string('codigo')->index(); // 'fundo_jud', 'registro_civil', 'issqn', 'taxa_jud', etc
            $table->string('nome');
            $table->text('descricao')->nullable();

            // Tipo e Valores
            $table->string('tipo_valor'); // 'fixo', 'percentual'
            $table->decimal('valor_fixo', 10, 4)->nullable();
            $table->decimal('percentual', 5, 2)->nullable();

            // Base de Cálculo
            $table->string('base_calculo')->nullable();
            // 'emolumento_bruto', 'emolumento_liquido', 'base_issqn'

            // Tipo de Recolhimento (NOVO!)
            $table->string('tipo_recolhimento')->nullable();
            // 'cartorio_para_tribunal' (Fundo Jud.), 'cliente_para_tribunal' (Taxa Jud.), 'cliente_para_prefeitura' (ISSQN)

            // Ordem de aplicação
            $table->integer('ordem_aplicacao')->default(0);
            $table->boolean('deduzir_da_base')->default(false);

            // Auditoria
            $table->foreignId('criador_id')->nullable()->constrained('usuario');
            $table->foreignId('alterador_id')->nullable()->constrained('usuario');
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('data_exclusao');

            $table->index(['tabela_custa_id', 'is_ativo']);
            $table->unique(['codigo', 'tabela_custa_id', 'cidade_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabela_custa_imposto');
    }
};
