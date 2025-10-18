<?php

namespace App\Models;

use App\Enums\CategoriaTipoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'categoria';

    public $timestamps = false;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'is_ativo',
        'nome',
        'descricao',
        'tipo',
        'cor',
        'icone',
    ];

    protected $casts = [
        'is_ativo' => 'boolean',
        'tipo' => CategoriaTipoEnum::class,
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
