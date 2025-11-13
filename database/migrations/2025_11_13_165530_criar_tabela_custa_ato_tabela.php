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
        Schema::create('tabela_custa_ato', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true)->index();
            $table->uuid('uuid')->unique()->index();


            $table->foreignId('tabela_custa_id')->nullable()->constrained('tabela_custa', 'id');
            // Identificação
            $table->string('codigo_ato')->index(); // Código do TJ
            $table->string('nome');
            $table->decimal('valor_servico', 20, 4)->default(0);
            $table->decimal('valor_gatilho', 20, 4)->default(0);
            $table->decimal('valor_acrescimo', 20, 4)->default(0);
            $table->decimal('valor_faixa', 20, 4)->default(0);
            $table->decimal('valor_iniciar_incremento', 20, 4)->default(0);
            $table->decimal('valor_maximo', 20, 4)->default(0);
            $table->timestamp('vigencia_inicio')->nullable();
            $table->timestamp('vigencia_fim')->nullable();
            $table->year('ano')->nullable();
            // NOVO: Tipo de cálculo (calculado automaticamente no seeder)
            $table->string('tipo_calculo')->default('FIXO')->index(); // FIXO, FAIXA_PROGRESSIVA, GRATUITO
            // Valores: 'fixo', 'faixa_progressiva', 'gratuito'
            // PERMITIR BASE DE CALCULO
            $table->boolean('permitir_base_calculo')->default(false);
            // DESCONTO
            $table->boolean('permitir_desconto')->default(false);
            // FUNAJURIS
            $table->boolean('permitir_funajuris')->default(false);
            // REGISTRO CIVIL
            $table->boolean('permitir_registro_civil')->default(false);
            // ISS
            $table->boolean('permitir_iss')->default(false);

            $table->foreignId('ato_pai_id')->nullable()->constrained('tabela_custa_ato');
            // $table->foreignId('plano_conta_id')->nullable()->constrained('plano_conta');
            $table->foreignId('estado_id')->nullable()->constrained('estado');
            $table->foreignId('cidade_id')->nullable()->constrained('cidade');


            // USUARIO CRIADOR E ATUALIADOR
            $table->foreignId('criador_id')->nullable()->constrained('usuario');
            $table->foreignId('alterador_id')->nullable()->constrained('usuario');
            $table->foreignId('excluidor_id')->nullable()->constrained('usuario');

            // NOVO: Relacionamento pai-filho
            $table->boolean('exige_ato_pai')->default(false);

            // NOVO: Configuração em JSON (para novos tipos futuros)
            $table->json('configuracao_calculo')->nullable();

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();

            // Índices compostos
            $table->index(['ano', 'is_ativo', 'estado_id']);
            $table->index(['tipo_calculo', 'is_ativo']);
            $table->index(['codigo_ato', 'ano']);
        });
    }

    public function down(): void
    {
        Schema::table('tabela_custa_ato', function (Blueprint $table) {
            Schema::dropIfExists('tabela_custa_ato');
        });
    }
};
