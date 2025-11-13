<?php

namespace App\Models;

use Illuminate\Support\Str;
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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
