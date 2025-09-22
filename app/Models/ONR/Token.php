<?php

namespace App\Models\ONR;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $table = 'onr_token';

    protected $fillable = [
        'is_ativo',
        'codigo',
        'data_criacao',
        'data_validade',
        'is_utilizado',
        'id_usuario',
        'id_instituicao',
        'data_utilizacao'
    ];
}
