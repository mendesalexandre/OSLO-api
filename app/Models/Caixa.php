<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caixa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'caixa';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'is_ativo',
        'nome',
        'descricao',
        'saldo_inicial',
        'data_saldo_inicial',
        'saldo_atual',
    ];
}
