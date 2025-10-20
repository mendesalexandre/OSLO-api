<?php

namespace App\Models;

use App\Enums\CaixaMovimentoStatus;
use App\Enums\CaixaMovimentoStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaixaMovimento extends Model
{
    use SoftDeletes;

    protected $table = 'caixa_movimento';

    public $timestamps = false;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'caixa_id',
        'usuario_abertura_id',
        'usuario_fechamento_id',
        'data_abertura',
        'data_fechamento',
        'saldo_inicial_informado',
        'saldo_inicial_sistema',
        'saldo_final_informado',
        'saldo_final_sistema',
        'diferenca',
        'total_entradas',
        'total_saidas',
        'observacao_abertura',
        'observacao_fechamento',
        'status',
    ];

    protected $casts = [
        'saldo_inicial_informado' => 'decimal:2',
        'saldo_inicial_sistema' => 'decimal:2',
        'saldo_final_informado' => 'decimal:2',
        'saldo_final_sistema' => 'decimal:2',
        'diferenca' => 'decimal:2',
        'total_entradas' => 'decimal:2',
        'total_saidas' => 'decimal:2',
        'status' => CaixaMovimentoStatusEnum::class,
        'data_abertura' => 'datetime',
        'data_fechamento' => 'datetime',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos
    public function caixa(): BelongsTo
    {
        return $this->belongsTo(Caixa::class);
    }

    public function usuarioAbertura(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_abertura_id');
    }

    public function usuarioFechamento(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_fechamento_id');
    }

    public function transacoes(): HasMany
    {
        return $this->hasMany(Transacao::class);
    }

    // Scopes
    public function scopeAbertos($query)
    {
        return $query->where('status', CaixaMovimentoStatus::ABERTO);
    }

    public function scopeFechados($query)
    {
        return $query->where('status', CaixaMovimentoStatus::FECHADO);
    }

    public function scopeComDiferenca($query)
    {
        return $query->where('diferenca', '!=', 0);
    }

    public function scopeDoCaixa($query, $caixaId)
    {
        return $query->where('caixa_id', $caixaId);
    }

    // Helpers de Status
    public function isAberto(): bool
    {
        return $this->status === CaixaMovimentoStatus::ABERTO;
    }

    public function isFechado(): bool
    {
        return $this->status === CaixaMovimentoStatus::FECHADO;
    }

    public function isConferido(): bool
    {
        return $this->status === CaixaMovimentoStatus::CONFERIDO;
    }

    // Cálculos
    public function calcularTotais(): void
    {
        $this->total_entradas = $this->transacoes()
            ->entradas()
            ->pagas()
            ->sum('valor_pago');

        $this->total_saidas = $this->transacoes()
            ->saidas()
            ->pagas()
            ->sum('valor_pago');

        $this->saldo_final_sistema = $this->saldo_inicial_sistema + $this->total_entradas - $this->total_saidas;

        $this->saveQuietly(); // Salva sem disparar eventos
    }

    public function calcularDiferenca(): float
    {
        if ($this->saldo_final_informado === null) {
            return 0;
        }

        return (float) ($this->saldo_final_informado - $this->saldo_final_sistema);
    }

    public function temDiferenca(): bool
    {
        return abs($this->diferenca) > 0.01; // Considera diferença acima de 1 centavo
    }

    public function temSobra(): bool
    {
        return $this->diferenca > 0.01;
    }

    public function temFalta(): bool
    {
        return $this->diferenca < -0.01;
    }

    // Ações
    public function fechar(float $saldoFinalInformado, ?string $observacao = null): void
    {
        $this->calcularTotais();

        $this->update([
            'data_fechamento' => now(),
            'usuario_fechamento_id' => auth()->id(),
            'saldo_final_informado' => $saldoFinalInformado,
            'diferenca' => $saldoFinalInformado - $this->saldo_final_sistema,
            'observacao_fechamento' => $observacao,
            'status' => CaixaMovimentoStatus::FECHADO,
        ]);

        // Atualizar saldo do caixa com o valor informado (real)
        $this->caixa->update([
            'saldo_atual' => $saldoFinalInformado
        ]);
    }

    public function conferir(): void
    {
        if (!$this->isFechado()) {
            throw new \Exception('Movimento precisa estar fechado para ser conferido');
        }

        $this->update([
            'status' => CaixaMovimentoStatus::CONFERIDO
        ]);
    }

    public function reabrir(?string $motivo = null): void
    {
        if (!$this->isFechado()) {
            throw new \Exception('Apenas movimentos fechados podem ser reabertos');
        }

        $this->update([
            'data_fechamento' => null,
            'usuario_fechamento_id' => null,
            'saldo_final_informado' => null,
            'saldo_final_sistema' => null,
            'diferenca' => 0,
            'observacao_fechamento' => $motivo ? "REABERTO: {$motivo}" : null,
            'status' => CaixaMovimentoStatus::ABERTO,
        ]);
    }

    // Relatórios
    public function getTempoAberto(): string
    {
        if (!$this->data_fechamento) {
            $diff = now()->diff($this->data_abertura);
        } else {
            $diff = $this->data_fechamento->diff($this->data_abertura);
        }

        return sprintf('%dh %dmin', $diff->h + ($diff->days * 24), $diff->i);
    }

    public function getResumo(): array
    {
        return [
            'saldo_inicial' => $this->saldo_inicial_informado,
            'entradas' => $this->total_entradas,
            'saidas' => $this->total_saidas,
            'saldo_calculado' => $this->saldo_final_sistema,
            'saldo_contado' => $this->saldo_final_informado,
            'diferenca' => $this->diferenca,
            'tem_diferenca' => $this->temDiferenca(),
            'tipo_diferenca' => $this->temSobra() ? 'SOBRA' : ($this->temFalta() ? 'FALTA' : 'OK'),
        ];
    }
}
