<?php
// app/Models/TabelaCustaAto.php

namespace App\Models;

use App\Enums\TipoCalculoAto;
use App\Enums\TipoCalculoAtoEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TabelaCustaAto extends Model
{
    use SoftDeletes;

    protected $table = 'tabela_custa_ato';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'uuid',
        'tabela_custa_id',
        'estado_id',
        'cidade_id',
        'codigo_ato',
        'nome',
        'descricao',
        'ano',
        'vigencia_inicio',
        'vigencia_fim',
        'tipo_calculo',
        'valor_servico',
        'valor_gatilho',
        'valor_acrescimo',
        'valor_faixa',
        'valor_iniciar_incremento',
        'valor_maximo',
        'configuracao_calculo',
        'permitir_base_calculo',
        'permitir_desconto',
        'permitir_funajuris',
        'permitir_registro_civil',
        'permitir_iss',
        'ato_pai_id',
        'exige_ato_pai',
        'compartilha_selo',
        'is_ativo',
        'criador_id',
        'alterador_id',
        'excluidor_id',
    ];

    protected $casts = [
        'is_ativo' => 'boolean',
        'tipo_calculo' => TipoCalculoAtoEnum::class,
        'configuracao_calculo' => 'array',
        'permitir_base_calculo' => 'boolean',
        'permitir_desconto' => 'boolean',
        'permitir_funajuris' => 'boolean',
        'permitir_registro_civil' => 'boolean',
        'permitir_iss' => 'boolean',
        'exige_ato_pai' => 'boolean',
        'compartilha_selo' => 'boolean',
        'vigencia_inicio' => 'datetime',
        'vigencia_fim' => 'datetime',
        'valor_servico' => 'decimal:4',
        'valor_gatilho' => 'decimal:4',
        'valor_acrescimo' => 'decimal:4',
        'valor_faixa' => 'decimal:4',
        'valor_iniciar_incremento' => 'decimal:4',
        'valor_maximo' => 'decimal:4',
    ];

    // Gera UUID automaticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
            if (auth()->check()) {
                $model->criador_id = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->alterador_id = auth()->id();
            }
        });

        static::deleting(function ($model) {
            if (auth()->check()) {
                $model->excluidor_id = auth()->id();
                $model->save();
            }
        });
    }

    // Relacionamentos
    public function tabelaCusta(): BelongsTo
    {
        return $this->belongsTo(TabelaCusta::class);
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }

    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }

    public function atoPai(): BelongsTo
    {
        return $this->belongsTo(TabelaCustaAto::class, 'ato_pai_id');
    }

    public function atosFilhos(): HasMany
    {
        return $this->hasMany(TabelaCustaAto::class, 'ato_pai_id');
    }

    public function protocoloAtos(): HasMany
    {
        return $this->hasMany(ProtocoloAto::class);
    }

    public function criador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'criador_id');
    }

    public function alterador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'alterador_id');
    }

    // Scopes úteis
    public function scopeAtivos($query)
    {
        return $query->where('is_ativo', true);
    }

    public function scopeVigentes($query)
    {
        $hoje = now();
        return $query->where(function ($q) use ($hoje) {
            $q->where('vigencia_inicio', '<=', $hoje)
                ->where(function ($q2) use ($hoje) {
                    $q2->whereNull('vigencia_fim')
                        ->orWhere('vigencia_fim', '>=', $hoje);
                });
        });
    }

    public function scopePorAno($query, int $ano)
    {
        return $query->where('ano', $ano);
    }

    public function scopePrincipais($query)
    {
        return $query->where('exige_ato_pai', false);
    }

    public function scopeDependentes($query)
    {
        return $query->where('exige_ato_pai', true);
    }

    // Métodos auxiliares
    public function estaVigente(): bool
    {
        $hoje = now();

        if ($this->vigencia_inicio && $hoje->lt($this->vigencia_inicio)) {
            return false;
        }

        if ($this->vigencia_fim && $hoje->gt($this->vigencia_fim)) {
            return false;
        }

        return true;
    }

    public function getConfiguracao(): array
    {
        // Se tem JSON, usa ele; senão monta dos campos legados
        if ($this->configuracao_calculo) {
            return $this->configuracao_calculo;
        }

        // Fallback para campos legados
        return [
            'valor_inicial' => $this->valor_servico,
            'valor_inicio_incremento' => $this->valor_iniciar_incremento,
            'valor_gatilho' => $this->valor_gatilho,
            'valor_faixa' => $this->valor_faixa,
            'valor_acrescimo' => $this->valor_acrescimo,
            'valor_maximo' => $this->valor_maximo,
        ];
    }
}
