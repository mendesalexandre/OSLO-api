<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ONRConfiguracao extends Model
{
    public $table = 'onr_configuracao';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'uuid',
        'url',
        'chave',
        'id_parceiro',
        'certificado_subject',
        'certificado_issuer',
        'certificado_public_key',
        'certificado_serial_number',
        'certificado_valid_until',
        'cpf',
        'email',
        'id_parceiro_ws',
    ];

    public function casts()
    {
        return [
            'uuid' => 'string',
            'id_parceiro' => 'string',
            'certificado_subject' => 'string',
            'certificado_issuer' => 'string',
            'certificado_public_key' => 'string',
            'certificado_serial_number' => 'string',
            'certificado_valid_until' => 'date',
            'cpf' => 'string',
            'email' => 'string',
        ];
    }


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
