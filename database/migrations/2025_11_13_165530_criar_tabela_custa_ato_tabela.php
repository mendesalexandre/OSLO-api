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
            $table->uuid('uuid')->unique()->index();
            $table->boolean('is_ativo')->default(true)->index();

            // Relacionamentos
            $table->foreignId('tabela_custa_id')->constrained('tabela_custa', 'id');
            $table->foreignId('estado_id')->nullable()->constrained('estado');
            $table->foreignId('cidade_id')->nullable()->constrained('cidade');

            // Identificação
            $table->string('codigo_ato')->index();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->year('ano')->index();

            // Vigência
            $table->timestamp('vigencia_inicio')->nullable();
            $table->timestamp('vigencia_fim')->nullable();

            // Tipo de Cálculo
            $table->string('tipo_calculo')->default('FIXO')->index();
            $table->decimal('valor_servico', 20, 4)->default(0);

            // Configurações de Faixa Progressiva
            $table->decimal('valor_inicio_incremento', 20, 4)->nullable();
            $table->decimal('valor_faixa', 20, 4)->nullable();
            $table->decimal('valor_acrescimo', 20, 4)->nullable();
            $table->decimal('valor_maximo', 20, 4)->nullable();

            // ÚNICA flag necessária
            $table->boolean('permitir_base_calculo')->default(false);
            $table->boolean('permitir_desconto')->default(false);

            // Relacionamento pai-filho
            $table->foreignId('ato_pai_id')->nullable()->constrained('tabela_custa_ato')->nullOnDelete();
            $table->boolean('exige_ato_pai')->default(false);

            $table->decimal('percentual_cobrado', 5, 2)->default(100.00); // 50% = cobrar metade

            // Auditoria
            $table->foreignId('criador_id')->nullable()->constrained('usuario');
            $table->foreignId('alterador_id')->nullable()->constrained('usuario');
            $table->foreignId('excluidor_id')->nullable()->constrained('usuario');
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('data_exclusao');

            // Índices
            $table->index(['ano', 'is_ativo', 'tipo_calculo']);
            $table->index(['codigo_ato', 'ano']);
            $table->unique(['codigo_ato', 'ano', 'tabela_custa_id']);
        });
    }

    public function down(): void
    {
        Schema::table('tabela_custa_ato', function (Blueprint $table) {
            Schema::dropIfExists('tabela_custa_ato');
        });
    }
};
