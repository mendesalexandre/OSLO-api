<?php

namespace App\Models;

use App\Traits\Auditavel;
use App\Traits\TimestampsPortugues;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Grupo extends Model
{
    use SoftDeletes, Auditavel;
    use TimestampsPortugues {
        TimestampsPortugues::getDeletedAtColumn insteadof SoftDeletes;
    }

    protected $table = 'grupo';

    protected $fillable = [
        'nome',
        'descricao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // ==========================================
    // RELACIONAMENTOS
    // ==========================================

    public function permissoes(): BelongsToMany
    {
        return $this->belongsToMany(Permissao::class, 'grupo_permissao')
            ->withPivot('data_cadastro');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'usuario_grupo', 'grupo_id', 'usuario_id')
            ->withPivot('data_cadastro');
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }
}
