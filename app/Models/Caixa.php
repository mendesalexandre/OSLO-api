<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Caixa extends Model
{
    use SoftDeletes;

    protected $table = 'caixa';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'nome',
        'descricao',
        'is_ativo',
        'saldo_inicial',
        'saldo_atual',
        'requer_abertura',
    ];

    protected $casts = [
        'is_ativo' => 'boolean',
        // 'saldo_inicial' => 'decimal:2',
        // 'saldo_atual' => 'decimal:2',
        'saldo_inicial' => 'float',
        'saldo_atual' => 'float',
        'requer_abertura' => 'boolean',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos
    public function transacoes(): HasMany
    {
        return $this->hasMany(Transacao::class);
    }

    public function movimentos(): HasMany
    {
        return $this->hasMany(CaixaMovimento::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('is_ativo', true);
    }

    // Helpers - Configuração de Abertura
    public function requerAbertura(): bool
    {
        // Se tem configuração específica no caixa, usa ela
        if ($this->requer_abertura !== null) {
            return $this->requer_abertura;
        }

        // Senão, usa a configuração global
        return $this->getConfiguracaoGlobal();
    }

    protected function getConfiguracaoGlobal(): bool
    {
        $config = DB::table('configuracao')
            ->where('chave', 'caixa_requer_abertura')
            ->first();

        if (!$config) {
            return false; // Default: não requer
        }

        return filter_var($config->valor, FILTER_VALIDATE_BOOLEAN);
    }

    // Helpers - Movimento
    public function temMovimentoAberto(): bool
    {
        return $this->movimentoAtual() !== null;
    }

    public function movimentoAtual(): ?CaixaMovimento
    {
        return $this->movimentos()
            ->abertos()
            ->latest('data_abertura')
            ->first();
    }

    public function podeReceberTransacao(): bool
    {
        // Se não requer abertura, sempre pode receber
        if (!$this->requerAbertura()) {
            return true;
        }

        // Se requer abertura, precisa ter movimento aberto
        return $this->temMovimentoAberto();
    }

    public function ultimoMovimento(): ?CaixaMovimento
    {
        return $this->movimentos()
            ->latest('data_abertura')
            ->first();
    }

    // Helpers - Saldo
    public function calcularSaldo(): float
    {
        $entradas = $this->transacoes()
            ->entradas()
            ->pagas()
            ->sum('valor_pago');

        $saidas = $this->transacoes()
            ->saidas()
            ->pagas()
            ->sum('valor_pago');

        return (float) ($this->saldo_inicial + $entradas - $saidas);
    }

    public function recalcularSaldo(): void
    {
        $this->update([
            'saldo_atual' => $this->calcularSaldo()
        ]);
    }

    public function saldoEstaCorreto(): bool
    {
        $saldoCalculado = $this->calcularSaldo();
        $diferenca = abs($this->saldo_atual - $saldoCalculado);

        return $diferenca < 0.01; // Diferença menor que 1 centavo
    }

    // Helpers - Estatísticas
    public function totalEntradas($dataInicio = null, $dataFim = null): float
    {
        $query = $this->transacoes()
            ->entradas()
            ->pagas();

        if ($dataInicio) {
            $query->where('data_pagamento', '>=', $dataInicio);
        }

        if ($dataFim) {
            $query->where('data_pagamento', '<=', $dataFim);
        }

        return (float) $query->sum('valor_pago');
    }

    public function totalSaidas($dataInicio = null, $dataFim = null): float
    {
        $query = $this->transacoes()
            ->saidas()
            ->pagas();

        if ($dataInicio) {
            $query->where('data_pagamento', '>=', $dataInicio);
        }

        if ($dataFim) {
            $query->where('data_pagamento', '<=', $dataFim);
        }

        return (float) $query->sum('valor_pago');
    }

    public function getResumoFinanceiro(string $periodo = 'mes'): array
    {
        $dataInicio = match ($periodo) {
            'hoje' => now()->startOfDay(),
            'semana' => now()->startOfWeek(),
            'mes' => now()->startOfMonth(),
            'ano' => now()->startOfYear(),
            default => now()->startOfMonth(),
        };

        return [
            'saldo_atual' => $this->saldo_atual,
            'entradas' => $this->totalEntradas($dataInicio),
            'saidas' => $this->totalSaidas($dataInicio),
            'saldo_calculado' => $this->calcularSaldo(),
            'saldo_correto' => $this->saldoEstaCorreto(),
            'periodo' => $periodo,
            'data_inicio' => $dataInicio->format('d/m/Y'),
        ];
    }

    // Helpers - Validações
    public function podeSerExcluido(): bool
    {
        // Não pode excluir se tiver transações
        if ($this->transacoes()->count() > 0) {
            return false;
        }

        // Não pode excluir se tiver movimento aberto
        if ($this->temMovimentoAberto()) {
            return false;
        }

        return true;
    }
}
