<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TipoServico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_servico';

    // Desabilita os timestamps padrão do Laravel
    public $timestamps = false;

    // Define os timestamps customizados
    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';

    protected $fillable = [
        'uuid',
        'is_ativo',
        'nome',
        'descricao',
        'valor',
        'opcoes',
    ];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'is_ativo' => 'boolean',
        'valor' => 'decimal:2',
        'opcoes' => 'array',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    protected $hidden = [
        'data_exclusao',
    ];

    /**
     * Boot method para gerar UUID automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });

        // Atualizar data_alteracao automaticamente
        static::updating(function ($model) {
            $model->data_alteracao = now();
        });
    }

    /**
     * Scope para buscar apenas registros ativos
     */
    public function scopeAtivo($query)
    {
        return $query->where('is_ativo', true);
    }

    /**
     * Scope para buscar apenas registros não excluídos
     */
    public function scopeNaoExcluido($query)
    {
        return $query->whereNull('data_exclusao');
    }

    /**
     * Scope para buscar registros ativos e não excluídos
     */
    public function scopeDisponivel($query)
    {
        return $query->ativo()->naoExcluido();
    }

    /**
     * Soft delete customizado
     */
    public function delete()
    {
        $this->data_exclusao = now();
        return $this->save();
    }

    /**
     * Restaurar registro excluído
     */
    public function restore()
    {
        $this->data_exclusao = null;
        return $this->save();
    }

    /**
     * Verificar se o registro foi excluído
     */
    public function isDeleted(): bool
    {
        return !is_null($this->data_exclusao);
    }

    /**
     * Formatar valor monetário
     */
    public function getValorFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->valor ?? 0, 2, ',', '.');
    }

    /**
     * Accessor para opcoes como array
     */
    public function getOpcoesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    /**
     * Mutator para opcoes
     */
    public function setOpcoesAttribute($value)
    {
        $this->attributes['opcoes'] = is_array($value) ? json_encode($value) : $value;
    }
}
