<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeioPagamento extends Model
{
    use SoftDeletes;

    protected $table = 'meio_pagamento';

    public $timestamps = false;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'forma_pagamento_id',
        'nome',
        'descricao',
        'identificador',
        'taxa_percentual',
        'taxa_fixa',
        'prazo_compensacao',
        'is_ativo',
    ];

    protected $casts = [
        'taxa_percentual' => 'decimal:2',
        'taxa_fixa' => 'decimal:2',
        'prazo_compensacao' => 'integer',
        'is_ativo' => 'boolean',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos

    public function formaPagamento(): BelongsTo
    {
        return $this->belongsTo(FormaPagamento::class);
    }

    public function transacoes(): HasMany
    {
        return $this->hasMany(Transacao::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('is_ativo', true);
    }

    // Helpers
    public function calcularTaxa(float $valor): float
    {
        $taxaPercentual = ($valor * $this->taxa_percentual) / 100;
        return $taxaPercentual + $this->taxa_fixa;
    }

    public function calcularValorLiquido(float $valor): float
    {
        return $valor - $this->calcularTaxa($valor);
    }

    public function temTaxa(): bool
    {
        return $this->taxa_percentual > 0 || $this->taxa_fixa > 0;
    }
}
