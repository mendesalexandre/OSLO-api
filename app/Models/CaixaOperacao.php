<?php

namespace App\Models;

use App\Enums\CaixaOperacaoTipoEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaixaOperacao extends Model
{
    use SoftDeletes;

    protected $table = 'caixa_operacao';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'caixa_id',
        'caixa_destino_id',
        'caixa_operacao_vinculada_id',
        'tipo',
        'valor',
        'descricao',
        'observacao',
        'usuario_id',
        'data_operacao',
    ];

    protected $casts = [
        'tipo' => CaixaOperacaoTipoEnum::class,
        'valor' => 'decimal:2',
        'data_operacao' => 'datetime',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos
    public function caixa(): BelongsTo
    {
        return $this->belongsTo(Caixa::class, 'caixa_id');
    }

    public function caixaDestino(): BelongsTo
    {
        return $this->belongsTo(Caixa::class, 'caixa_destino_id');
    }

    public function operacaoVinculada(): BelongsTo
    {
        return $this->belongsTo(CaixaOperacao::class, 'caixa_operacao_vinculada_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Scopes
    public function scopeSangrias($query)
    {
        return $query->where('tipo', CaixaOperacaoTipoEnum::SANGRIA);
    }

    public function scopeReforcos($query)
    {
        return $query->where('tipo', CaixaOperacaoTipoEnum::REFORCO);
    }

    public function scopeTransferencias($query)
    {
        return $query->where('tipo', CaixaOperacaoTipoEnum::TRANSFERENCIA);
    }

    public function scopeDoCaixa($query, $caixaId)
    {
        return $query->where('caixa_id', $caixaId)
            ->orWhere('caixa_destino_id', $caixaId);
    }

    public function scopeRecentes($query)
    {
        return $query->orderBy('data_operacao', 'desc');
    }

    // Helpers de Tipo
    public function isSangria(): bool
    {
        return $this->tipo === CaixaOperacaoTipoEnum::SANGRIA;
    }

    public function isReforco(): bool
    {
        return $this->tipo === CaixaOperacaoTipoEnum::REFORCO;
    }

    public function isTransferencia(): bool
    {
        return $this->tipo === CaixaOperacaoTipoEnum::TRANSFERENCIA;
    }

    // Helpers de Informação
    public function temOperacaoVinculada(): bool
    {
        return $this->caixa_operacao_vinculada_id !== null;
    }

    public function getDescricaoCompleta(): string
    {
        return match ($this->tipo) {
            CaixaOperacaoTipoEnum::SANGRIA => "Sangria: {$this->descricao}",
            CaixaOperacaoTipoEnum::REFORCO => "Reforço: {$this->descricao}",
            CaixaOperacaoTipoEnum::TRANSFERENCIA => "Transferência: {$this->caixa->nome} → {$this->caixaDestino->nome}",
        };
    }

    public function getTipoLabel(): string
    {
        return match ($this->tipo) {
            CaixaOperacaoTipoEnum::SANGRIA => '💸 Sangria',
            CaixaOperacaoTipoEnum::REFORCO => '💰 Reforço',
            CaixaOperacaoTipoEnum::TRANSFERENCIA => '🔄 Transferência',
        };
    }

    // Validações
    public function podeSerEstornada(): bool
    {
        // Não pode estornar se for uma transferência já vinculada
        if ($this->isTransferencia() && $this->temOperacaoVinculada()) {
            // Precisa estornar as duas operações juntas
            return false;
        }

        return true;
    }

    // Resumo
    public function getResumo(): array
    {
        $resumo = [
            'id' => $this->id,
            'tipo' => $this->tipo->value,
            'tipo_label' => $this->getTipoLabel(),
            'caixa_origem' => $this->caixa->nome,
            'valor' => $this->valor,
            'descricao' => $this->descricao,
            'usuario' => $this->usuario->name,
            'data_operacao' => $this->data_operacao->format('d/m/Y H:i'),
        ];

        if ($this->isTransferencia()) {
            $resumo['caixa_destino'] = $this->caixaDestino->nome;
            $resumo['operacao_vinculada_id'] = $this->caixa_operacao_vinculada_id;
        }

        return $resumo;
    }
}
