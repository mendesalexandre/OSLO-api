<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sequencia extends Model
{
    use HasFactory, AuditableTrait;

    protected $table = 'sequencia';

    // Desabilita os timestamps padrão do Laravel
    public $timestamps = false;

    // Define os timestamps customizados
    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'is_ativo',
        'dominio_codigo',
        'ano',
        'numero_atual',
        'prefixo',
        'sufixo',
        'formato',
        'tamanho_numero',
        'apenas_numero',
        'reinicia_ano',
        'inicio_contagem',
    ];

    protected $casts = [
        'id' => 'integer',
        'is_ativo' => 'boolean',
        'ano' => 'integer',
        'numero_atual' => 'integer',
        'tamanho_numero' => 'integer',
        'apenas_numero' => 'boolean',
        'reinicia_ano' => 'boolean',
        'inicio_contagem' => 'integer',
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
        'proximo_numero_formatado'
    ];

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->data_alteracao = now();
        });
    }

    /**
     * Relacionamentos
     */
    public function dominio()
    {
        return $this->belongsTo(Dominio::class, 'dominio_codigo', 'codigo');
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

    public function scopePorDominio($query, string $dominoCodigo)
    {
        return $query->where('dominio_codigo', $dominoCodigo);
    }

    public function scopePorAno($query, int $ano)
    {
        return $query->where('ano', $ano);
    }

    public function scopeAnoAtual($query)
    {
        return $query->where('ano', now()->year);
    }

    /**
     * Verificar se o registro foi excluído
     */
    public function isDeleted(): bool
    {
        return !is_null($this->data_exclusao);
    }

    /**
     * Formatar número com zeros à esquerda
     */
    public function formatarNumero(int $numero): string
    {
        if ($this->tamanho_numero > 0) {
            return str_pad($numero, $this->tamanho_numero, '0', STR_PAD_LEFT);
        }

        return (string) $numero;
    }

    /**
     * Gerar sequência formatada
     */
    public function gerarSequenciaFormatada(int $numero): string
    {
        if ($this->apenas_numero) {
            return (string) $numero;
        }

        $numeroFormatado = $this->formatarNumero($numero);

        // Substituir {ano} no prefixo e sufixo ANTES de usar
        $prefixo = str_replace('{ano}', (string)$this->ano, $this->prefixo ?? '');
        $sufixo = str_replace('{ano}', (string)$this->ano, $this->sufixo ?? '');

        // Se tem formato customizado
        if ($this->formato) {
            return str_replace([
                '{prefixo}',
                '{numero}',
                '{sufixo}',
                '{ano}'
            ], [
                $prefixo,
                $numeroFormatado,
                $sufixo,
                $this->ano
            ], $this->formato);
        }

        // Formato padrão: prefixo + numero + sufixo (já com {ano} substituído)
        return $prefixo . $numeroFormatado . $sufixo;
    }

    /**
     * Accessor para próximo número formatado (preview)
     */
    public function getProximoNumeroFormatadoAttribute(): string
    {
        $proximoNumero = $this->numero_atual + 1;
        return $this->gerarSequenciaFormatada($proximoNumero);
    }

    /**
     * Incrementar e retornar próximo número
     */
    public function proximoNumero(): string
    {
        $this->increment('numero_atual');
        return $this->gerarSequenciaFormatada($this->numero_atual);
    }

    /**
     * Resetar contador para novo ano
     */
    public function resetarParaNovoAno(int $novoAno): self
    {
        $this->update([
            'ano' => $novoAno,
            'numero_atual' => $this->inicio_contagem - 1, // -1 porque será incrementado
        ]);

        return $this;
    }

    /**
     * Verificar se precisa criar sequência para novo ano
     */
    public function precisaRenovarAno(): bool
    {
        return $this->reinicia_ano && $this->ano < now()->year;
    }

    /**
     * Métodos estáticos de conveniência
     */
    public static function buscarOuCriar(string $dominoCodigo, int $ano = null): self
    {
        $ano = $ano ?? now()->year;

        return self::firstOrCreate([
            'dominio_codigo' => $dominoCodigo,
            'ano' => $ano
        ], [
            'numero_atual' => 0,
            'is_ativo' => true,
            'reinicia_ano' => true,
            'inicio_contagem' => 1,
        ]);
    }

    /**
     * Configurações padrão por tipo de domínio
     */
    public static function configuracoesPadrao(): array
    {
        return [
            'PROTOCOLO_RI' => [
                'prefixo' => 'PROT-',
                'sufixo' => '/{ano}',
                'tamanho_numero' => 4,
                'apenas_numero' => false,
            ],
            'OFICIO' => [
                'prefixo' => 'OF-',
                'sufixo' => '/{ano}',
                'tamanho_numero' => 2,
                'apenas_numero' => false,
            ],
            'PROTOCOLO_NOTAS' => [
                'prefixo' => 'TN-',
                'sufixo' => '/{ano}',
                'tamanho_numero' => 3,
                'apenas_numero' => false,
            ],
            'ESCRITURA' => [
                'apenas_numero' => true, // Só número sequencial
                'tamanho_numero' => 0,
            ],
            'PROCURACAO' => [
                'apenas_numero' => true,
                'tamanho_numero' => 0,
            ],
            // Adicionar outros conforme necessário
        ];
    }

    /**
     * Aplicar configurações padrão
     */
    public function aplicarConfiguracoesPadrao(): self
    {
        $configuracoes = self::configuracoesPadrao();

        if (isset($configuracoes[$this->dominio_codigo])) {
            $config = $configuracoes[$this->dominio_codigo];

            foreach ($config as $campo => $valor) {
                $this->$campo = $valor;
            }

            $this->save();
        }

        return $this;
    }
}
