<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtoFaixa extends Model
{
    use SoftDeletes;

    protected $table = 'ato_faixa';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'ato_id',
        'valor_de',
        'valor_ate',
        'valor_fixo',
        'percentual',
    ];

    protected $casts = [
        'valor_de' => 'decimal:2',
        'valor_ate' => 'decimal:2',
        'valor_fixo' => 'decimal:2',
        'percentual' => 'decimal:4',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos

    public function ato(): BelongsTo
    {
        return $this->belongsTo(Ato::class);
    }
}
