<?php

namespace App\Models;

use App\Enums\TransacaoStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transacao extends Model
{
    use SoftDeletes;

    protected $table = 'transacao';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'caixa_id',
        'tipo',
        'categoria',
        'descricao',
        'valor',
        'valor_pago',
        'status',
        'data_vencimento',
        'data_pagamento',
        'observacao',
        'documento',
        'pessoa_id',
        'usuario_id',
        'is_ativo',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'valor_pago' => 'decimal:2',
        'is_ativo' => 'boolean',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos
    public function caixa(): BelongsTo
    {
        return $this->belongsTo(Caixa::class);
    }

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(IndicadorPessoal::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(TransacaoPagamento::class);
    }

    // Scopes
    public function scopeEntradas($query)
    {
        return $query->where('tipo', 'ENTRADA');
    }

    public function scopeSaidas($query)
    {
        return $query->where('tipo', 'SAIDA');
    }

    public function scopePagas($query)
    {
        return $query->where('status', 'PAGO');
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'PENDENTE');
    }

    public function scopeVencidas($query)
    {
        return $query->where('status', 'PENDENTE')
            ->where('data_vencimento', '<', now());
    }

    // Helpers
    public function isPago(): bool
    {
        return $this->status === 'PAGO';
    }

    public function isPendente(): bool
    {
        return $this->status === 'PENDENTE';
    }

    public function isCancelado(): bool
    {
        return $this->status === 'CANCELADO';
    }

    public function isEntrada(): bool
    {
        return $this->tipo === 'ENTRADA';
    }

    public function isSaida(): bool
    {
        return $this->tipo === 'SAIDA';
    }

    public function valorRestante(): float
    {
        return (float) ($this->valor - $this->valor_pago);
    }

    // Métodos de pagamento
    public function totalPago(): float
    {
        return (float) $this->pagamentos()->pagos()->sum('valor_pago');
    }

    public function valorRestantePagar(): float
    {
        return (float) ($this->valor - $this->totalPago());
    }

    public function isParcialmentePago(): bool
    {
        $totalPago = $this->totalPago();
        return $totalPago > 0 && $totalPago < $this->valor;
    }

    public function isTotalmentePago(): bool
    {
        return $this->totalPago() >= $this->valor;
    }

    public function verificarStatusPagamento(): void
    {
        if ($this->isTotalmentePago()) {
            $this->update([
                'status' => TransacaoStatusEnum::PAGO,
                'valor_pago' => $this->totalPago(),
                'data_pagamento' => now(),
            ]);
        }
    }
}
