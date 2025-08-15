<?php

namespace App\Models\ONR;

use Illuminate\Database\Eloquent\Model;
use ONRStatusEnum;

class Certidao extends Model
{
    protected $table = 'onr_certidao';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'is_ativo',
        'protocolo_solicitacao',
        'status_solicitacao',
        'data_pedido',
        'tipo_cobranca',
        'valor',
        'debug',
        'integrado_ordem_servico_id',
        'integrado_selo_prefixo',
        'integrado_selo_numero',
        'integrado_selo_codigo_atos',
        'integrado_selo_valor',
        'integrado_selo_data',
        'integrador_selo_hora',
        'contraditorio_debug',
        'tipo_finalidade',
        'observacao',
        'numero_protocolo',
        'solicitante_nome',
        'solicitante_cpf_cnpj',
        'solicitante_email',
        'solicitante_telefone',
        'solicitante_endereco',
        'solicitante_cep',
        'solicitante_tipo_logradouro',
        'solicitante_numero',
        'solicitante_complemento',
        'solicitante_bairro',
        'solicitante_cidade',
        'solicitante_uf',
        'certidao_tipo',
        'certidao_pedido_por',
        'certidao_matricula_numero',
        'certidao_matricula_letra',
        'certidao_matricula_mae',
        'certidao_numero_ato',
        'certidao_data_envio',
        'certidao_arquivo_assinado',
        'certidao_possui_contraditorio',
        'status_envio',
        'tentativas_envio',
        'mensagem_erro_envio',
        'onr_arquivo_assinado_web_id',
        'onr_certidao_link_assinado',
        'onr_caminho_arquivo_assinado',
        'onr_nome_arquivo',
        'certidao_matricula_cnm',
        'metodo_envio',
        'tamanho_arquivo_mb',
        'data_envio_sucesso',
        'resultado_anexo',
        'resultado_finalizacao',
        'total_paginas',
        'total_paginas_adicional',
        'valor_total_paginas_adicional',
        'worker_job_id',
        'pdf_gerado_em',
        'job_disparado_em',
        'status_batch',
        'mensagem_batch',
        'batch_id',
        'iniciado_em',
        'finalizado_em',
        'validada_em',
        'processada_em',
        'devolvida_em',
        'status_validacao',
        'mensagem_validacao',
    ];

    public function casts(): array
    {
        return [
            'status' => ONRStatusEnum::class
        ];
    }
}
