<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'valor_inicio_incremento',
        'valor_faixa',
        'valor_acrescimo',
        'valor_maximo',
        'permitir_base_calculo',
        'permitir_desconto',
        'ato_pai_id',
        'exige_ato_pai',
        'is_ativo',
    ];

    protected $casts = [
        'is_ativo' => 'boolean',
        'permitir_base_calculo' => 'boolean',
        'permitir_desconto' => 'boolean',
        'exige_ato_pai' => 'boolean',
        'vigencia_inicio' => 'datetime',
        'vigencia_fim' => 'datetime',
    ];

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
    }

    // Relacionamentos
    public function tabelaCusta(): BelongsTo
    {
        return $this->belongsTo(TabelaCusta::class);
    }

    public function impostos(): BelongsToMany
    {
        return $this->belongsToMany(
            TabelaCustaImposto::class,
            'tabela_custa_ato_imposto',
            'tabela_custa_ato_id',
            'tabela_custa_imposto_id'
        )
            ->withPivot('aplicavel')
            ->withTimestamps()
            ->orderBy('ordem_aplicacao');
    }

    public function atoPai(): BelongsTo
    {
        return $this->belongsTo(TabelaCustaAto::class, 'ato_pai_id');
    }

    // Helpers
    public function temImposto(string $codigo): bool
    {
        return $this->impostos()
            ->where('codigo', $codigo)
            ->wherePivot('aplicavel', true)
            ->exists();
    }

    public function getImposto(string $codigo): ?TabelaCustaImposto
    {
        return $this->impostos()
            ->where('codigo', $codigo)
            ->wherePivot('aplicavel', true)
            ->first();
    }
}
