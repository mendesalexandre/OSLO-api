<?php

namespace App\Models;

use App\Traits\Auditavel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ato extends Model
{
    use SoftDeletes, Auditavel;

    protected $table = 'ato';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'natureza_id',
        'codigo',
        'nome',
        'descricao',
        'valor_fixo',
        'percentual',
        'valor_minimo',
        'valor_maximo',
        'tipo_calculo',
        'ativo',
    ];

    protected $casts = [
        'valor_fixo' => 'decimal:2',
        'percentual' => 'decimal:4',
        'valor_minimo' => 'decimal:2',
        'valor_maximo' => 'decimal:2',
        'ativo' => 'boolean',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos

    public function natureza(): BelongsTo
    {
        return $this->belongsTo(Natureza::class);
    }

    public function faixas(): HasMany
    {
        return $this->hasMany(AtoFaixa::class)->orderBy('valor_de');
    }

    public function itensProtocolo(): HasMany
    {
        return $this->hasMany(ProtocoloItem::class);
    }

    // Scopes

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    // Helpers

    public function calcularValor(?float $baseCalculo = null): float
    {
        $valor = match ($this->tipo_calculo) {
            'fixo' => (float) $this->valor_fixo,
            'percentual' => $baseCalculo ? ($baseCalculo * $this->percentual / 100) : 0,
            'faixa' => $this->calcularPorFaixa($baseCalculo),
            'manual' => 0,
            default => 0,
        };

        if ($this->valor_minimo !== null && $valor < $this->valor_minimo) {
            $valor = (float) $this->valor_minimo;
        }

        if ($this->valor_maximo !== null && $valor > $this->valor_maximo) {
            $valor = (float) $this->valor_maximo;
        }

        return round($valor, 2);
    }

    private function calcularPorFaixa(?float $baseCalculo): float
    {
        if ($baseCalculo === null) {
            return 0;
        }

        $faixa = $this->faixas()
            ->where('valor_de', '<=', $baseCalculo)
            ->where(function ($query) use ($baseCalculo) {
                $query->where('valor_ate', '>=', $baseCalculo)
                    ->orWhereNull('valor_ate');
            })
            ->first();

        if (!$faixa) {
            return 0;
        }

        if ($faixa->valor_fixo !== null) {
            return (float) $faixa->valor_fixo;
        }

        if ($faixa->percentual !== null) {
            return $baseCalculo * $faixa->percentual / 100;
        }

        return 0;
    }
}
