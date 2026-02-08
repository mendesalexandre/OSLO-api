<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\Auditavel;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, Auditavel;

    protected $table = 'usuario';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'is_ativo',
        'ultimo_login_em',
        'ultimo_login_ip',
    ];

    protected $hidden = [
        'senha',
    ];

    protected function casts(): array
    {
        return [
            'email_verificado_em' => 'datetime',
            'senha' => 'hashed',
        ];
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Map the password column for Laravel Auth.
     * The database column is 'senha', not 'password'.
     */
    public function getAuthPassword(): string
    {
        return $this->senha;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'uuid' => $this->uuid,
            'nome' => $this->nome,
        ];
    }

    // ==========================================
    // RELACIONAMENTOS DE PERMISSÃO
    // ==========================================

    public function grupos(): BelongsToMany
    {
        return $this->belongsToMany(Grupo::class, 'usuario_grupo', 'usuario_id', 'grupo_id')
            ->withPivot('data_cadastro');
    }

    public function permissoesIndividuais(): BelongsToMany
    {
        return $this->belongsToMany(Permissao::class, 'usuario_permissao', 'usuario_id', 'permissao_id')
            ->withPivot(['tipo', 'data_cadastro']);
    }

    // ==========================================
    // VERIFICAÇÃO DE PERMISSÕES
    // ==========================================

    /**
     * Verifica se o usuário tem a permissão.
     * Prioridade: negar individual > permitir individual > grupo.
     */
    public function temPermissao(string $nomePermissao): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        // Verifica permissão individual
        $individual = $this->permissoesIndividuais()
            ->where('permissao.nome', $nomePermissao)
            ->where('permissao.ativo', true)
            ->first();

        if ($individual) {
            return $individual->pivot->tipo === 'permitir';
        }

        // Verifica permissão via grupo
        $grupoIds = $this->grupos()->ativos()->pluck('grupo.id');

        if ($grupoIds->isEmpty()) {
            return false;
        }

        return Permissao::query()
            ->where('nome', $nomePermissao)
            ->where('ativo', true)
            ->whereHas('grupos', function ($query) use ($grupoIds) {
                $query->whereIn('grupo.id', $grupoIds);
            })
            ->exists();
    }

    public function temAlgumaPermissao(array $permissoes): bool
    {
        foreach ($permissoes as $permissao) {
            if ($this->temPermissao($permissao)) {
                return true;
            }
        }

        return false;
    }

    public function temTodasPermissoes(array $permissoes): bool
    {
        foreach ($permissoes as $permissao) {
            if (!$this->temPermissao($permissao)) {
                return false;
            }
        }

        return true;
    }

    public function pertenceAoGrupo(string $nomeGrupo): bool
    {
        return $this->grupos()
            ->where('grupo.nome', $nomeGrupo)
            ->where('grupo.ativo', true)
            ->exists();
    }

    public function isAdmin(): bool
    {
        return $this->pertenceAoGrupo('Administrador');
    }

    /**
     * Retorna todas as permissões efetivas (individuais + grupo, sem negadas).
     */
    public function obterPermissoes(): array
    {
        // Permissões individuais negadas
        $negadas = $this->permissoesIndividuais()
            ->where('ativo', true)
            ->wherePivot('tipo', 'negar')
            ->pluck('permissao.nome')
            ->toArray();

        // Permissões individuais permitidas
        $permitidas = $this->permissoesIndividuais()
            ->where('ativo', true)
            ->wherePivot('tipo', 'permitir')
            ->pluck('permissao.nome')
            ->toArray();

        // Permissões via grupos
        $grupoIds = $this->grupos()->ativos()->pluck('grupo.id');
        $doGrupo = [];

        if ($grupoIds->isNotEmpty()) {
            $doGrupo = Permissao::query()
                ->where('ativo', true)
                ->whereHas('grupos', function ($query) use ($grupoIds) {
                    $query->whereIn('grupo.id', $grupoIds);
                })
                ->pluck('nome')
                ->toArray();
        }

        // Merge: individuais permitidas + grupo, menos negadas
        $todas = array_unique(array_merge($permitidas, $doGrupo));
        $efetivas = array_diff($todas, $negadas);

        sort($efetivas);

        return array_values($efetivas);
    }

    /**
     * Retorna permissões agrupadas por módulo.
     */
    public function obterPermissoesPorModulo(): array
    {
        $permissoes = $this->obterPermissoes();

        if (empty($permissoes)) {
            return [];
        }

        return Permissao::query()
            ->whereIn('nome', $permissoes)
            ->where('ativo', true)
            ->orderBy('modulo')
            ->orderBy('nome')
            ->get()
            ->groupBy('modulo')
            ->map(fn ($grupo) => $grupo->pluck('nome')->toArray())
            ->toArray();
    }
}
