<?php

namespace App\Models;

use App\Traits\Auditavel;
use App\Traits\TimestampsPortugues;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permissao extends Model
{
    use SoftDeletes, Auditavel;
    use TimestampsPortugues {
        TimestampsPortugues::getDeletedAtColumn insteadof SoftDeletes;
    }

    protected $table = 'permissao';

    protected $fillable = [
        'nome',
        'descricao',
        'modulo',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // ==========================================
    // RELACIONAMENTOS
    // ==========================================

    public function grupos(): BelongsToMany
    {
        return $this->belongsToMany(Grupo::class, 'grupo_permissao')
            ->withPivot('data_cadastro');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'usuario_permissao', 'permissao_id', 'usuario_id')
            ->withPivot(['tipo', 'data_cadastro']);
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorModulo($query, string $modulo)
    {
        return $query->where('modulo', $modulo);
    }

    // ==========================================
    // MÉTODOS ESTÁTICOS
    // ==========================================

    public static function modulos(): array
    {
        return static::query()
            ->select('modulo')
            ->distinct()
            ->orderBy('modulo')
            ->pluck('modulo')
            ->toArray();
    }
}
