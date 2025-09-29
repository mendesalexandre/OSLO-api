<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cidade extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $table = 'cidade';

    protected $fillable = [
        'nome',
        'ibge_estado_id',
        'ibge_codigo',
        'estado_id',
        'is_ativo',
    ];

    // Cast de tipos
    protected $casts = [
        'is_ativo' => 'boolean',
        'ibge_codigo' => 'integer',
        'ibge_estado_id' => 'integer',
        'estado_id' => 'integer',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    // Scopes para consultas comuns
    public function scopeAtiva($query)
    {
        return $query->where('is_ativo', true);
    }

    public function scopeInativa($query)
    {
        return $query->where('is_ativo', false);
    }

    public function scopeBuscarPorNome($query, $nome)
    {
        return $query->where('nome', 'like', '%' . $nome . '%');
    }

    public function scopePorEstado($query, $estadoId)
    {
        return $query->where('estado_id', $estadoId);
    }

    public function scopeComEstado($query)
    {
        return $query->with(['estado' => function ($q) {
            $q->select('id', 'nome', 'sigla');
        }]);
    }

    // Accessor para nome completo com estado
    public function getNomeCompletoAttribute()
    {
        return $this->nome . ' - ' . $this->estado?->sigla;
    }

    // Accessor para formatar nome
    public function getNomeFormatadoAttribute()
    {
        return Str::title($this->nome);
    }
}
