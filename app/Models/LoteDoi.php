<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoteDoi extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $table = 'lote_doi';
    protected $fillable = [
        'usuario_id',
        'data_criacao',
        'data_envio_iniciado',
        'data_envio_concluido',
        'status',
        'total_doi',
        'sucesso',
        'erro',
        'observacao',
        'data_cadastro',
        'data_alteracao',
        'data_exclusao',
    ];

    public function declaracoes()
    {
        return $this->hasMany(Doi::class, 'lote_doi_id', 'id');
    }
}
