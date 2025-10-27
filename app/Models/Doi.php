<?php

namespace App\Models;

use App\Models\Doi\Adquirente;
use App\Models\Doi\Alienante;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doi extends Model
{
    use HasFactory, SoftDeletes;
    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $table = 'doi';
    protected $fillable = [
        'is_ativo',
        'doi_importacao_id',
        'numero_controle',
        'data_ato',
        'matricula',
        'data',
        'data_importacao',
        'debug',
        'sincronizado',
        'data_sincronizacao',
        'status',
        'status_processamento',
        'processado_em',
        'lote_doi_id',
        'data_geracao',
        'observacao',
        'usuario_id',
        'status_envio_individual'

    ];
    protected $casts = [
        'data' => 'json',
        'data_ato' => 'date',
        'numero_controle' => 'integer',
        'debug' => 'json',
    ];

    public function adquirentes()
    {
        return $this->hasMany(Adquirente::class, 'doi_id', 'id');
    }

    public function transmitentes()
    {
        return $this->hasMany(Alienante::class, 'doi_id', 'id');
    }

    public function alienantes()
    {
        return $this->hasMany(Alienante::class, 'doi_id', 'id');
    }

    public function lote()
    {
        return $this->belongsTo(LoteDoi::class, 'lote_doi_id');
    }
}
