<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPagamento extends Model
{
    protected $table = 'tipo_pagamento';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'is_ativo',
        'nome',
        'descricao',
        'taxa_percentual',
        'taxa_fixa',
        'prazo_compensacao',
    ];

    protected $casts = [
        'taxa_percentual' => 'decimal:2',
        'taxa_fixa' => 'decimal:2',
        'prazo_compensacao' => 'integer',
        'is_ativo' => 'boolean',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];
}
