<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoExigencia extends Model
{
    use SoftDeletes;

    protected $table = 'contrato_exigencia';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'contrato_id',
        'usuario_id',
        'descricao',
        'prazo_dias',
        'data_cumprimento',
        'cumprida',
        'observacao',
    ];

    protected $casts = [
        'prazo_dias' => 'integer',
        'data_cumprimento' => 'date',
        'cumprida' => 'boolean',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos

    public function contrato(): BelongsTo
    {
        return $this->belongsTo(Contrato::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
