<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContratoAndamento extends Model
{
    protected $table = 'contrato_andamento';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';

    protected $fillable = [
        'contrato_id',
        'usuario_id',
        'status_anterior',
        'status_novo',
        'descricao',
    ];

    protected $casts = [
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
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
