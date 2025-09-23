<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Natureza extends Model
{
    use HasFactory, AuditableTrait;

    protected $table = 'tipo_servico'; // Mantém a tabela atual

    // Desabilita os timestamps padrão do Laravel
    public $timestamps = false;

    // Define os timestamps customizados
    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';

    protected $fillable = [
        'uuid',
        'is_ativo',
        'nome',
        'descricao',
        'valor',
        'opcoes',
        'registro_ativo',
        'permitir_edicao_minuta',
        'permitir_isencao',
        'permitir_gerar_selo',
        'informar_valores_base_calculo',
        'nivel_dificuldade',
        'regra_custas',
        'base_calculo',
        'limite_base_calculo',
        'tipo_registro_averbacao',
        'tipo_ato_tribunal_cobranca',
        'titulo_ato_minuta',
        'base_calculo_opcoes',
        'livros',
        'tipos_documento',
        'categoria',
        'ordem_exibicao',
    ];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'is_ativo' => 'boolean',
        'registro_ativo' => 'boolean',
        'permitir_edicao_minuta' => 'boolean',
        'permitir_isencao' => 'boolean',
        'permitir_gerar_selo' => 'boolean',
        'informar_valores_base_calculo' => 'boolean',
        'nivel_dificuldade' => 'integer',
        'ordem_exibicao' => 'integer',
        'valor' => 'decimal:2',
        'opcoes' => 'array',
        'base_calculo_opcoes' => 'array',
        'livros' => 'array',
        'tipos_documento' => 'array',
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
        'valor_formatado',
        'auditoria',
        'nivel_dificuldade_texto',
        'configuracao_completa'
    ];

    /**
     * Boot method para gerar UUID automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });

        // Atualizar data_alteracao automaticamente
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

    public function scopeRegistroAtivo($query)
    {
        return $query->where('registro_ativo', true);
    }

    public function scopeNaoExcluido($query)
    {
        return $query->whereNull('data_exclusao');
    }

    public function scopeDisponivel($query)
    {
        return $query->ativo()->registroAtivo()->naoExcluido();
    }

    public function scopePorCategoria($query, string $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeOrdenadoPorExibicao($query)
    {
        return $query->orderBy('ordem_exibicao')->orderBy('nome');
    }

    public function scopeComSeloObrigatorio($query)
    {
        return $query->where('permitir_gerar_selo', true);
    }

    /**
     * Verificar se o registro foi excluído
     */
    public function isDeleted(): bool
    {
        return !is_null($this->data_exclusao);
    }

    /**
     * Formatar valor monetário
     */
    public function getValorFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->valor ?? 0, 2, ',', '.');
    }

    /**
     * Nível de dificuldade em texto
     */
    public function getNivelDificuldadeTextoAttribute(): string
    {
        return match ($this->nivel_dificuldade) {
            1 => 'Baixo',
            2 => 'Médio',
            3 => 'Alto',
            4 => 'Muito Alto',
            default => 'Não definido'
        };
    }

    /**
     * Verificar se a configuração está completa
     */
    public function getConfiguracaoCompletaAttribute(): array
    {
        $camposObrigatorios = [
            'nome' => !empty($this->nome),
            'nivel_dificuldade' => !is_null($this->nivel_dificuldade),
            'regra_custas' => !empty($this->regra_custas),
        ];

        return [
            'completa' => !in_array(false, $camposObrigatorios),
            'campos' => $camposObrigatorios,
            'percentual' => round((count(array_filter($camposObrigatorios)) / count($camposObrigatorios)) * 100)
        ];
    }

    /**
     * Accessors para arrays JSON
     */
    public function getOpcoesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    public function getBaseCalculoOpcoesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    public function getLivrosAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    public function getTiposDocumentoAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    /**
     * Mutators para arrays JSON
     */
    public function setOpcoesAttribute($value)
    {
        $this->attributes['opcoes'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setBaseCalculoOpcoesAttribute($value)
    {
        $this->attributes['base_calculo_opcoes'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setLivrosAttribute($value)
    {
        $this->attributes['livros'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setTiposDocumentoAttribute($value)
    {
        $this->attributes['tipos_documento'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Métodos helper para verificações específicas
     */
    public function podeGerarMinuta(): bool
    {
        return $this->permitir_edicao_minuta && !empty($this->titulo_ato_minuta);
    }

    public function temValorCalculado(): bool
    {
        return !empty($this->base_calculo) && !is_null($this->valor);
    }

    public function permiteIsencao(): bool
    {
        return $this->permitir_isencao;
    }

    public function permitirGerarSelo(): bool
    {
        return $this->permitir_gerar_selo;
    }

    /**
     * Constantes para opções do sistema
     */
    public static function getNiveiseDificuldade(): array
    {
        return [
            1 => 'Baixo',
            2 => 'Médio',
            3 => 'Alto',
            4 => 'Muito Alto'
        ];
    }

    public static function getOpcoesLivros(): array
    {
        return [
            'matricula' => 'Matrícula',
            'registro_auxiliar' => 'Registro Auxiliar',
            'transcricao' => 'Transcrição'
        ];
    }

    public static function getOpcoesTiposDocumento(): array
    {
        return [
            'normal' => 'Normal / Exame e Cálculo / Orçamento',
            'processo_interno' => 'Processo Interno'
        ];
    }

    public static function getOpcoesBaseCalculo(): array
    {
        return [
            'negocio_alienacao' => 'Negócio/Alienação',
            'avaliacao' => 'Avaliação',
            'divida' => 'Dívida',
            'imovel' => 'Imóvel',
            'mercados' => 'Mercados',
            'venal' => 'Venal',
            'magrao' => 'Magrão',
            'leilao' => 'Leilão',
            'recursos_proprios' => 'Recursos Próprios',
            'fgts' => 'FGTS',
            'fgts_desconto' => 'FGTS (Desconto)',
            'valor_total_imovel_vti' => 'Valor Total do Imóvel (VTI)',
            'valor_terra_nua_vtn' => 'Valor da Terra Nua (VTN)'
        ];
    }
}
