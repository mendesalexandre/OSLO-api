<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabelaCusta extends Model
{

    public const CREATED_AT = 'data_cadastro';
    public const UPDATED_AT = 'data_alteracao';
    public const DELETED_AT = 'data_exclusao';

    protected $table = 'tabela_custa';


    protected $fillable = [
        'is_ativo',
        'uuid',
        'nome',
        'emolumento',
        'valor',
        'observacao',
        'vigencia_inicio',
        'vigencia_fim',
        'ano',
        'data_cadastro',
        'data_alteracao',
        'data_exclusao',
    ];
}
