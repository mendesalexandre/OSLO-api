<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Natureza;

class Dominio extends Model
{
    use HasFactory, AuditableTrait;

    protected $table = 'dominio';

    // Desabilita os timestamps padrão do Laravel
    public $timestamps = false;

    // Define os timestamps customizados
    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';

    protected $fillable = [
        'is_ativo',
        'codigo',
        'nome',
        'nome_completo',
        'tipo',
        'atribuicao',
        'genero',
        'descricao',
        'configuracoes',
        'ordem_exibicao',
    ];

    protected $casts = [
        'id' => 'integer',
        'is_ativo' => 'boolean',
        'configuracoes' => 'array',
        'ordem_exibicao' => 'integer',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
        'usuario_criacao_id' => 'integer',
        'usuario_alteracao_id' => 'integer',
        'usuario_exclusao_id' => 'integer',
    ];

    protected $hidden = [
        'data_exclusao',
        'usuario_exclusao_id',
    ];

    protected $appends = [
        'auditoria',
        'nome_com_artigo'
    ];

    /**
     * Boot method para atualizar data_alteracao automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->data_alteracao = now();
        });
    }

    /**
     * Scopes
     */
    public function scopeAtivo($query)
    {
        return $query->where('is_ativo', true);
    }

    public function scopeNaoExcluido($query)
    {
        return $query->whereNull('data_exclusao');
    }

    public function scopeDisponivel($query)
    {
        return $query->ativo()->naoExcluido();
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePorAtribuicao($query, string $atribuicao)
    {
        return $query->where('atribuicao', $atribuicao);
    }

    public function scopeProtocolos($query)
    {
        return $query->where('tipo', 'PROTOCOLO');
    }

    public function scopeCertidoes($query)
    {
        return $query->where('tipo', 'PEDIDO_CERTIDAO');
    }

    public function scopeAuxiliares($query)
    {
        return $query->where('tipo', 'AUXILIAR');
    }

    public function scopeOrdenadoPorExibicao($query)
    {
        return $query->orderBy('ordem_exibicao')->orderBy('nome');
    }

    /**
     * Verificar se o registro foi excluído
     */
    public function isDeleted(): bool
    {
        return !is_null($this->data_exclusao);
    }

    /**
     * Accessor para nome com artigo
     */
    public function getNomeComArtigoAttribute(): string
    {
        $artigo = $this->genero === 'a' ? 'a' : 'o';
        return "{$artigo} {$this->nome}";
    }

    /**
     * Accessor para configurações como array
     */
    public function getConfiguracoesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    /**
     * Mutator para configurações
     */
    public function setConfiguracoesAttribute($value)
    {
        $this->attributes['configuracoes'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Relacionamentos
     */

    /**
     * Relacionamento com naturezas (se houver vínculo)
     */
    public function naturezas()
    {
        return $this->hasMany(Natureza::class, 'dominio_id');
    }

    /**
     * Métodos helper
     */
    public function isProtocolo(): bool
    {
        return $this->tipo === 'PROTOCOLO';
    }

    public function isCertidao(): bool
    {
        return $this->tipo === 'PEDIDO_CERTIDAO';
    }

    public function isAuxiliar(): bool
    {
        return $this->tipo === 'AUXILIAR';
    }

    public function isRI(): bool
    {
        return $this->atribuicao === 'RI';
    }

    public function isRTD(): bool
    {
        return $this->atribuicao === 'RTD';
    }

    public function isRCPJ(): bool
    {
        return $this->atribuicao === 'RCPJ';
    }

    public function isNotas(): bool
    {
        return $this->atribuicao === 'NOTAS';
    }

    public function isGeral(): bool
    {
        return $this->atribuicao === 'GERAL';
    }

    /**
     * Constantes do sistema
     */
    public static function getTipos(): array
    {
        return [
            'PROTOCOLO' => 'Protocolo',
            'PEDIDO_CERTIDAO' => 'Pedido de Certidão',
            'AUXILIAR' => 'Auxiliar'
        ];
    }

    public static function getAtribuicoes(): array
    {
        return [
            'RI' => 'Registro de Imóveis',
            'RTD' => 'Registro de Títulos e Documentos',
            'RCPJ' => 'Registro Civil de Pessoas Jurídicas',
            'NOTAS' => 'Tabelionato de Notas',
            'GERAL' => 'Geral'
        ];
    }

    public static function getGeneros(): array
    {
        return [
            'o' => 'Masculino (o)',
            'a' => 'Feminino (a)'
        ];
    }

    /**
     * Obter domínios por atribuição
     */
    public static function getPorAtribuicao(string $atribuicao): Collection
    {
        return self::disponivel()
            ->porAtribuicao($atribuicao)
            ->ordenadoPorExibicao()
            ->get();
    }

    /**
     * Obter domínios agrupados por atribuição
     */
    public static function getAgrupadoPorAtribuicao(): Collection
    {
        return self::disponivel()
            ->ordenadoPorExibicao()
            ->get()
            ->groupBy('atribuicao');
    }

    /**
     * Validar se código é único
     */
    public static function codigoExiste(string $codigo, ?int $excludeId = null): bool
    {
        $query = self::where('codigo', $codigo);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
