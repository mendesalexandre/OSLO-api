<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etapa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'etapa';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'is_ativo',
        'nome',
        'descricao',
        'pode_finalizar',
        'pode_voltar',
        'pode_redistruibuir',
        'forcar_troca_usuario',
        'contar_prazo',
        'priorizar_usuario_anterior',
        'cor',
        'tipo_atribuicao',
        'data_cadastro',
        'data_alteracao',
        'data_exclusao',
    ];
}
