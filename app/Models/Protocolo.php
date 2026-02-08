<?php

namespace App\Models;

use App\Traits\Auditavel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Protocolo extends Model
{
    use SoftDeletes, Auditavel;

    protected $table = 'protocolo';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'numero',
        'ano',
        'data_prevista',
        'data_reingresso',
        'data_limite',
        'solicitante_id',
        'atendente_id',
        'cliente_id',
        'natureza_id',
        'reprotocolo_origem_id',
        'tipo_suspensao_id',
        'tipo_documento_id',
        'vinculo_id',
        'entregue',
        'etapa_id',
        'etapa_usuario_id',
        'etapa_anterior_id',
        'finalizador_id',
        'motivo_cancelamento',
        'interessado_id',
        'tomador_id',
        'dias',
        'is_digital',
        'is_parado',
        'pago',
        'mesa',
        'status',
        'ultima_interacao',
        'debug',
        'tags',
        'solicitante_nome',
        'solicitante_cpf_cnpj',
        'solicitante_telefone',
        'solicitante_email',
        'matricula',
        'observacao',
        'valor_total',
        'valor_desconto',
        'valor_isento',
        'valor_final',
        'valor_pago',
    ];

    protected $casts = [
        'ano' => 'integer',
        'data_prevista' => 'date',
        'data_reingresso' => 'date',
        'data_limite' => 'date',
        'entregue' => 'boolean',
        'dias' => 'integer',
        'is_digital' => 'boolean',
        'is_parado' => 'boolean',
        'pago' => 'boolean',
        'mesa' => 'boolean',
        'ultima_interacao' => 'datetime',
        'debug' => 'array',
        'tags' => 'array',
        'valor_total' => 'decimal:2',
        'valor_desconto' => 'decimal:2',
        'valor_isento' => 'decimal:2',
        'valor_final' => 'decimal:2',
        'valor_pago' => 'decimal:2',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    protected $appends = ['numero_protocolo_formatado'];

    // Accessors

    public function getNumeroProtocoloFormatadoAttribute(): string
    {
        return $this->numero ?? '';
    }

    // Relacionamentos

    public function atendente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'atendente_id');
    }

    public function natureza(): BelongsTo
    {
        return $this->belongsTo(Natureza::class);
    }

    public function itens(): HasMany
    {
        return $this->hasMany(ProtocoloItem::class);
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(ProtocoloPagamento::class);
    }

    public function isencoes(): HasMany
    {
        return $this->hasMany(ProtocoloIsencao::class);
    }

    public function contratos(): HasMany
    {
        return $this->hasMany(Contrato::class);
    }

    public function recibos(): HasMany
    {
        return $this->hasMany(Recibo::class);
    }

    // Métodos de negócio

    public function recalcularValores(): void
    {
        $this->valor_total = $this->itens()->sum('valor_total');
        $this->valor_isento = $this->isencoes()->sum('valor_isento');
        $this->valor_pago = $this->pagamentos()->confirmados()->sum('valor');
        $this->valor_final = $this->valor_total - $this->valor_desconto - $this->valor_isento;
        $this->save();

        $this->atualizarStatus();
    }

    public function estaPago(): bool
    {
        return $this->valor_pago >= $this->valor_final && $this->valor_final > 0;
    }

    public function temPagamentoParcial(): bool
    {
        return $this->valor_pago > 0 && $this->valor_pago < $this->valor_final;
    }

    public function eIsento(): bool
    {
        return $this->valor_isento >= $this->valor_total && $this->valor_total > 0;
    }

    public function valorRestante(): float
    {
        return max(0, $this->valor_final - $this->valor_pago);
    }

    public function atualizarStatus(): void
    {
        if ($this->status === 'cancelado') {
            return;
        }

        if ($this->eIsento()) {
            $this->status = 'isento';
        } elseif ($this->estaPago()) {
            $this->status = 'pago';
        } elseif ($this->temPagamentoParcial()) {
            $this->status = 'pago_parcial';
        }

        $this->saveQuietly();
    }

    public static function gerarNumero(): string
    {
        $ano = now()->year;

        $ultimoNumero = DB::table('protocolo')
            ->where('ano', $ano)
            ->max(DB::raw("CAST(SPLIT_PART(numero, '/', 2) AS INTEGER)"));

        $sequencial = ($ultimoNumero ?? 0) + 1;

        return sprintf('%d/%06d', $ano, $sequencial);
    }

    /**
     * Gera histórico de andamentos humanizado do protocolo.
     */
    public function gerarAndamentos(): array
    {
        $andamentos = [];

        // Criação do protocolo
        $andamentos[] = [
            'descricao' => 'Protocolo criado',
            'usuario' => $this->atendente ? ['id' => $this->atendente->id, 'nome' => $this->atendente->nome] : null,
            'data_cadastro' => $this->data_cadastro,
        ];

        // Itens adicionados (agrupado)
        if ($this->itens()->count() > 0) {
            $primeiroItem = $this->itens()->oldest('data_cadastro')->first();
            $totalItens = $this->itens()->count();
            $andamentos[] = [
                'descricao' => $totalItens === 1 ? '1 ato adicionado' : "{$totalItens} atos adicionados",
                'usuario' => $this->atendente ? ['id' => $this->atendente->id, 'nome' => $this->atendente->nome] : null,
                'data_cadastro' => $primeiroItem->data_cadastro,
            ];
        }

        // Pagamentos
        foreach ($this->pagamentos()->with('usuario')->orderBy('data_pagamento')->get() as $pagamento) {
            $andamentos[] = [
                'descricao' => "Pagamento " . ($pagamento->status === 'confirmado' ? 'confirmado' : $pagamento->status) . " - R$ " . number_format($pagamento->valor, 2, ',', '.'),
                'usuario' => $pagamento->usuario ? ['id' => $pagamento->usuario->id, 'nome' => $pagamento->usuario->nome] : null,
                'data_cadastro' => $pagamento->data_pagamento ?? $pagamento->data_cadastro,
            ];
        }

        // Cancelamento
        if ($this->status === 'cancelado') {
            $andamentos[] = [
                'descricao' => 'Protocolo cancelado' . ($this->motivo_cancelamento ? ': ' . $this->motivo_cancelamento : ''),
                'usuario' => null,
                'data_cadastro' => $this->data_alteracao,
            ];
        }

        // Ordenar por data
        usort($andamentos, fn($a, $b) => $a['data_cadastro'] <=> $b['data_cadastro']);

        return $andamentos;
    }
}
