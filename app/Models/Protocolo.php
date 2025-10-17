<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protocolo extends Model
{
    protected $table = 'protocolo';

    protected $fillable = [
        'numero',
        'data_prevista',
        'data_reingresso',
        'data_limite',
        'solicitante_id',
        'atendente_id',
        'cliente_id',
        'natureza_id',
        'reprotocolo_origem_id',
        'tipo_suspensao_id',
        'tipo_documento_id',
        'vinculo_id',
        'entregue',
        'etapa_id',
        'etapa_usuario_id',
        'etapa_anterior_id',
        'finalizador_id',
        'motivo_cancelamento',
        'interessado_id',
        'tomador_id',
        'dias',
        'is_digital',
        'is_parado',
        'pago',
        'mesa',
        'status',
        'ultima_interacao',
        'debug',
        'tags',
        'data_cadastro',
        'data_alteracao',
        'data_exclusao'
    ];
}
