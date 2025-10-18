<?php

namespace App\Models;

use App\Enums\CategoriaTipoEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    protected $table = 'categoria';

    public $timestamps = false;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'nome',
        'descricao',
        'tipo',
        'cor',
        'icone',
        'is_ativo',
    ];

    protected $casts = [
        'tipo' => CategoriaTipoEnum::class,
        'is_ativo' => 'boolean',
    ];

    // Relacionamentos
    public function transacoes(): HasMany
    {
        return $this->hasMany(Transacao::class);
    }

    // Scopes
    public function scopeDespesas($query)
    {
        return $query->where('tipo', CategoriaTipo::DESPESA);
    }

    public function scopeReceitas($query)
    {
        return $query->where('tipo', CategoriaTipo::RECEITA);
    }

    public function scopeAtivas($query)
    {
        return $query->where('is_ativo', true);
    }

    // Helpers
    public function isDespesa(): bool
    {
        return $this->tipo === CategoriaTipo::DESPESA;
    }

    public function isReceita(): bool
    {
        return $this->tipo === CategoriaTipo::RECEITA;
    }
}
