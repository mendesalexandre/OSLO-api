<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $table = 'estado';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'sigla',
        'ibge_codigo',
        'is_ativo',
    ];

    // Cast de tipos
    protected $casts = [
        'is_ativo' => 'boolean',
        'ibge_codigo' => 'integer',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamento com cidades
    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'estado_id');
    }

    // Relacionamento apenas com cidades ativas
    public function cidadesAtivas()
    {
        return $this->hasMany(Cidade::class, 'estado_id')->where('is_ativo', true);
    }

    // Scopes para consultas comuns
    public function scopeAtivo($query)
    {
        return $query->where('is_ativo',  '=', true);
    }

    public function scopeInativo($query)
    {
        return $query->where('is_ativo', '=', false);
    }

    public function scopeBuscarPorNome($query, $nome)
    {
        return $query->where('nome', 'like', '%' . $nome . '%');
    }

    public function scopeBuscarPorSigla($query, $sigla)
    {
        return $query->where('sigla', strtoupper($sigla));
    }

    // Accessor para formatar sigla sempre em maiúsculo
    public function getSiglaAttribute($value)
    {
        return strtoupper($value);
    }

    // Mutator para garantir que sigla seja salva em maiúsculo
    public function setSiglaAttribute($value)
    {
        $this->attributes['sigla'] = strtoupper($value);
    }
}
