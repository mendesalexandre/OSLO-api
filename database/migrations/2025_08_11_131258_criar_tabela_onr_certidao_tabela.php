<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onr_certidao', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->string('protocolo_solicitacao')->unique();
            $table->string('status_solicitacao');
            $table->timestamp('data_pedido');
            $table->string('tipo_cobranca');
            $table->decimal('valor', 20, 2);

            $table->json('debug')->nullable();
            $table->integer('integrado_ordem_servico_id')->nullable();
            $table->integer('integrado_selo_prefixo')->nullable();
            $table->integer('integrado_selo_numero')->nullable();
            $table->integer('integrado_selo_codigo_atos')->nullable();
            $table->integer('integrado_selo_valor')->nullable();
            $table->timestamp('integrado_selo_data')->nullable();
            $table->time('integrador_selo_hora')->nullable();
            $table->json('contraditorio_debug')->nullable();
            $table->longText('tipo_finalidade')->nullable();
            $table->longText('observacao')->nullable();
            $table->string('numero_protocolo')->nullable();
            $table->string('solicitante_nome')->nullable();
            $table->string('solicitante_cpf_cnpj')->nullable();
            $table->string('solicitante_email')->nullable();
            $table->string('solicitante_telefone')->nullable();
            $table->string('solicitante_endereco')->nullable();
            $table->string('solicitante_cep')->nullable();
            $table->string('solicitante_tipo_logradouro')->nullable();
            $table->string('solicitante_numero')->nullable();
            $table->string('solicitante_complemento')->nullable();
            $table->string('solicitante_bairro')->nullable();
            $table->string('solicitante_cidade')->nullable();
            $table->string('solicitante_uf')->nullable();
            $table->string('certidao_tipo')->nullable();
            $table->string('certidao_pedido_por')->nullable();
            $table->string('certidao_matricula_numero')->nullable();
            $table->string('certidao_matricula_letra')->nullable();
            $table->string('certidao_matricula_mae')->nullable();
            $table->string('certidao_numero_ato')->nullable();
            $table->string('certidao_data_envio')->nullable();
            $table->string('certidao_arquivo_assinado')->nullable();
            $table->boolean('certidao_possui_contraditorio')->default(false);
            $table->string('status_envio')->nullable();
            $table->integer('tentativas_envio')->nullable();
            $table->longText('mensagem_erro_envio')->nullable();
            $table->string('onr_arquivo_assinado_web_id')->nullable();
            $table->string('onr_certidao_link_assinado')->nullable();
            $table->string('onr_caminho_arquivo_assinado')->nullable();
            $table->string('onr_nome_arquivo')->nullable();
            $table->string('certidao_matricula_cnm')->nullable();
            $table->string('metodo_envio')->nullable();
            $table->string('tamanho_arquivo_mb')->nullable();
            $table->timestamp('data_envio_sucesso')->nullable();
            $table->string('resultado_anexo')->nullable();
            $table->string('resultado_finalizacao')->nullable();
            $table->integer('total_paginas')->nullable();
            $table->integer('total_paginas_adicional')->nullable();
            $table->integer('valor_total_paginas_adicional')->nullable();
            $table->string('worker_job_id')->nullable();
            $table->timestamp('pdf_gerado_em')->nullable();
            $table->timestamp('job_disparado_em')->nullable();

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
        Schema::dropIfExists('onr_certidao');
    }
};
