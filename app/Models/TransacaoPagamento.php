<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransacaoPagamento extends Model
{
    use SoftDeletes;

    protected $table = 'transacao_pagamento';

    public $timestamps = false;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'transacao_id',
        'tipo_pagamento_id',
        'meio_pagamento_id',
        'valor_pago',
        'taxa',
        'valor_liquido',
        'is_pago',
        'data_pagamento',
        'pessoa_id',
        'observacao',
    ];

    protected $casts = [
        'valor_pago' => 'decimal:2',
        'taxa' => 'decimal:2',
        'valor_liquido' => 'decimal:2',
        'is_pago' => 'boolean',
        'data_pagamento' => 'date',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos
    public function transacao(): BelongsTo
    {
        return $this->belongsTo(Transacao::class);
    }

    public function tipoPagamento(): BelongsTo
    {
        return $this->belongsTo(TipoPagamento::class);
    }

    public function meioPagamento(): BelongsTo
    {
        return $this->belongsTo(MeioPagamento::class);
    }

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    // Scopes
    public function scopePagos($query)
    {
        return $query->where('is_pago', true);
    }

    public function scopePendentes($query)
    {
        return $query->where('is_pago', false);
    }

    // Helpers
    public function marcarComoPago(): void
    {
        $this->update([
            'is_pago' => true,
            'data_pagamento' => now(),
        ]);

        // Verificar se a transação foi totalmente paga
        $this->transacao->verificarStatusPagamento();
    }

    public function calcularTaxa(): void
    {
        if ($this->meioPagamento) {
            $taxa = $this->meioPagamento->calcularTaxa($this->valor_pago);
            $valorLiquido = $this->valor_pago - $taxa;

            $this->update([
                'taxa' => $taxa,
                'valor_liquido' => $valorLiquido,
            ]);
        }
    }
}
