<?php

namespace App\Models\ONR;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificadoDigital extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'onr_certificado_digital';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'nome',
        'descricao',
        'arquivo_original',
        'senha_criptografada',
        'caminho_arquivo',
        'tamanho_bytes',
        'tamanho_formatado',
        'titular',
        'emissor',
        'serial',
        'algoritmo',
        'valido_de',
        'valido_ate',
        'ativo',
        'testado',
        'ultima_validacao',
        'erro_validacao',
        'criado_por',
        'atualizado_por',
        'certificado_base64',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'testado' => 'boolean',
        'valido_de' => 'datetime',
        'valido_ate' => 'datetime',
        'ultima_validacao' => 'datetime',
        'tamanho_bytes' => 'integer',
    ];

    protected $hidden = [
        'senha_criptografada',
    ];

    /**
     * Relacionamento com usuário que criou
     */
    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    /**
     * Relacionamento com usuário que atualizou
     */
    public function atualizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'atualizado_por');
    }

    /**
     * Obter certificado ativo atual
     */
    public static function ativo(): ?self
    {
        return self::where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Desativar todos os certificados
     */
    public static function desativarTodos(): void
    {
        self::where('ativo', true)->update(['ativo' => false]);
    }

    /**
     * Ativar este certificado (desativa os outros)
     */
    public function ativar(): void
    {
        self::desativarTodos();
        $this->update(['ativo' => true]);
    }

    /**
     * Obter senha descriptografada
     */
    public function getSenha(): string
    {
        return Crypt::decryptString($this->senha_criptografada);
    }

    /**
     * Definir senha (criptografa automaticamente)
     */
    public function setSenha(string $senha): void
    {
        $this->senha_criptografada = Crypt::encryptString($senha);
    }

    /**
     * Verificar se certificado está válido (não expirado)
     */
    public function isValido(): bool
    {
        return $this->valido_ate && $this->valido_ate->isFuture();
    }

    /**
     * Verificar se certificado está próximo do vencimento
     */
    public function isProximoVencimento(int $dias = 30): bool
    {
        if (!$this->valido_ate) {
            return false;
        }

        return $this->valido_ate->diffInDays(now()) <= $dias && $this->isValido();
    }

    /**
     * Obter dias até vencimento
     */
    public function diasAteVencimento(): ?int
    {
        if (!$this->valido_ate) {
            return null;
        }

        if ($this->valido_ate->isPast()) {
            return -$this->valido_ate->diffInDays(now());
        }

        return $this->valido_ate->diffInDays(now());
    }

    /**
     * Obter status do certificado
     */
    public function getStatus(): string
    {
        if (!$this->ativo) {
            return 'inativo';
        }

        if (!$this->isValido()) {
            return 'expirado';
        }

        if ($this->isProximoVencimento()) {
            return 'proximo_vencimento';
        }

        return 'valido';
    }

    /**
     * Obter cor do status para UI
     */
    public function getStatusCor(): string
    {
        return match ($this->getStatus()) {
            'valido' => 'success',
            'proximo_vencimento' => 'warning',
            'expirado' => 'danger',
            'inativo' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Scope para certificados válidos
     */
    public function scopeValidos($query)
    {
        return $query->where('valido_ate', '>', now())
            ->where('ativo', true);
    }

    /**
     * Scope para certificados próximos do vencimento
     */
    public function scopeProximosVencimento($query, int $dias = 30)
    {
        return $query->where('valido_ate', '>', now())
            ->where('valido_ate', '<=', now()->addDays($dias))
            ->where('ativo', true);
    }

    /**
     * Scope para certificados expirados
     */
    public function scopeExpirados($query)
    {
        return $query->where('valido_ate', '<=', now());
    }

    /**
     * Atualizar informações de validação
     */
    public function atualizarValidacao(bool $sucesso, ?string $erro = null): void
    {
        $this->update([
            'testado' => $sucesso,
            'ultima_validacao' => now(),
            'erro_validacao' => $erro,
        ]);
    }

    /**
     * Formatar informações para API
     */
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'arquivo_original' => $this->arquivo_original,
            'titular' => $this->titular,
            'emissor' => $this->emissor,
            'serial' => $this->serial,
            'algoritmo' => $this->algoritmo,
            'valido_de' => $this->valido_de?->format('d/m/Y H:i:s'),
            'valido_ate' => $this->valido_ate?->format('d/m/Y H:i:s'),
            'tamanho_formatado' => $this->tamanho_formatado,
            'tamanho_bytes' => $this->tamanho_bytes,
            'ativo' => $this->ativo,
            'testado' => $this->testado,
            'ultima_validacao' => $this->ultima_validacao?->format('d/m/Y H:i:s'),
            'status' => $this->getStatus(),
            'status_cor' => $this->getStatusCor(),
            'dias_ate_vencimento' => $this->diasAteVencimento(),
            'criado_em' => $this->created_at->format('d/m/Y H:i:s'),
            'criado_por' => $this->criadoPor?->name,
        ];
    }
}
