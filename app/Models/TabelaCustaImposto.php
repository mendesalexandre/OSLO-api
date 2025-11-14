<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class TabelaCustaImposto extends Model
{
    use SoftDeletes;

    protected $table = 'tabela_custa_imposto';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'uuid',
        'tabela_custa_id',
        'cidade_id',
        'codigo',
        'nome',
        'descricao',
        'tipo_valor',
        'valor_fixo',
        'percentual',
        'base_calculo',
        'ordem_aplicacao',
        'deduzir_da_base',
        'is_ativo',
    ];

    protected $casts = [
        'is_ativo' => 'boolean',
        'deduzir_da_base' => 'boolean',
        'valor_fixo' => 'decimal:4',
        'percentual' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    // Relacionamentos
    public function tabelaCusta(): BelongsTo
    {
        return $this->belongsTo(TabelaCusta::class);
    }

    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }

    public function atos(): BelongsToMany
    {
        return $this->belongsToMany(
            TabelaCustaAto::class,
            'tabela_custa_ato_imposto',
            'tabela_custa_imposto_id',
            'tabela_custa_ato_id'
        )
            ->withPivot('aplicavel')
            ->withTimestamps();
    }

    // Helpers
    public function calcularValor(float $baseCalculo, int $quantidade = 1): float
    {
        if ($this->tipo_valor === 'fixo') {
            return $this->valor_fixo * $quantidade;
        }

        if ($this->tipo_valor === 'percentual') {
            return ($baseCalculo * $this->percentual / 100) * $quantidade;
        }

        return 0;
    }
}
