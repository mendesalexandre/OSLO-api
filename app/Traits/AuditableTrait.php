<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AuditableTrait
{
    /**
     * Boot the auditable trait for a model.
     */
    public static function bootAuditableTrait(): void
    {
        // Ao criar um registro
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->usuario_criacao_id = Auth::id();
            }
        });

        // Ao atualizar um registro
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->usuario_alteracao_id = Auth::id();
            }
        });

        // Não podemos usar "deleting" para soft delete customizado
        // então vamos sobrescrever o método delete no model
    }

    /**
     * Sobrescrever o método delete para auditoria
     */
    public function delete()
    {
        if (Auth::check()) {
            $this->usuario_exclusao_id = Auth::id();
        }

        $this->data_exclusao = now();
        return $this->save();
    }

    /**
     * Relacionamento com usuário que criou
     */
    public function usuarioCriacao()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_criacao_id');
    }

    /**
     * Relacionamento com usuário que alterou
     */
    public function usuarioAlteracao()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_alteracao_id');
    }

    /**
     * Relacionamento com usuário que excluiu
     */
    public function usuarioExclusao()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_exclusao_id');
    }

    /**
     * Scope para incluir dados de auditoria
     */
    public function scopeComAuditoria($query)
    {
        return $query->with([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email',
            'usuarioExclusao:id,nome,email'
        ]);
    }

    /**
     * Accessor para dados de auditoria formatados
     */
    public function getAuditoriaAttribute(): array
    {
        return [
            'criado_por' => $this->usuarioCriacao ? [
                'id' => $this->usuarioCriacao->id,
                'nome' => $this->usuarioCriacao->nome,
                'email' => $this->usuarioCriacao->email,
            ] : null,
            'alterado_por' => $this->usuarioAlteracao ? [
                'id' => $this->usuarioAlteracao->id,
                'nome' => $this->usuarioAlteracao->nome,
                'email' => $this->usuarioAlteracao->email,
            ] : null,
            'excluido_por' => $this->usuarioExclusao ? [
                'id' => $this->usuarioExclusao->id,
                'nome' => $this->usuarioExclusao->nome,
                'email' => $this->usuarioExclusao->email,
            ] : null,
            'data_criacao' => $this->data_cadastro?->format('d/m/Y H:i:s'),
            'data_alteracao' => $this->data_alteracao?->format('d/m/Y H:i:s'),
            'data_exclusao' => $this->data_exclusao?->format('d/m/Y H:i:s'),
        ];
    }

    /**
     * Verificar se foi criado pelo usuário atual
     */
    public function foiCriadoPor(?int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        return $this->usuario_criacao_id === $userId;
    }

    /**
     * Verificar se foi alterado pelo usuário atual
     */
    public function foiAlteradoPor(?int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        return $this->usuario_alteracao_id === $userId;
    }

    /**
     * Verificar se foi excluído pelo usuário atual
     */
    public function foiExcluidoPor(?int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        return $this->usuario_exclusao_id === $userId;
    }

    /**
     * Restaurar registro excluído com auditoria
     */
    public function restore()
    {
        $this->data_exclusao = null;
        $this->usuario_exclusao_id = null;

        if (Auth::check()) {
            $this->usuario_alteracao_id = Auth::id();
        }

        return $this->save();
    }
}
