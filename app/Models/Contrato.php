<?php

namespace App\Models;

use App\Traits\Auditavel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Contrato extends Model
{
    use SoftDeletes, Auditavel;

    protected $table = 'contrato';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'protocolo_id',
        'numero',
        'ano',
        'usuario_id',
        'tipo',
        'descricao',
        'matricula',
        'parte_nome',
        'parte_cpf_cnpj',
        'parte_qualificacao',
        'data_entrada',
        'data_previsao',
        'data_conclusao',
        'prazo_dias',
        'observacao',
        'observacao_interna',
        'status',
    ];

    protected $casts = [
        'data_entrada' => 'date',
        'data_previsao' => 'date',
        'data_conclusao' => 'date',
        'prazo_dias' => 'integer',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos

    public function protocolo(): BelongsTo
    {
        return $this->belongsTo(Protocolo::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function exigencias(): HasMany
    {
        return $this->hasMany(ContratoExigencia::class);
    }

    public function andamentos(): HasMany
    {
        return $this->hasMany(ContratoAndamento::class)->orderByDesc('data_cadastro');
    }

    // Helpers

    public static function gerarNumero(): string
    {
        $ano = now()->year;

        $ultimoNumero = DB::table('contrato')
            ->where('ano', $ano)
            ->max(DB::raw("CAST(SUBSTRING(numero FROM 7) AS INTEGER)"));

        $sequencial = ($ultimoNumero ?? 0) + 1;

        return sprintf('%d/C%06d', $ano, $sequencial);
    }

    public function temExigenciaPendente(): bool
    {
        return $this->exigencias()->where('cumprida', false)->exists();
    }

    public function registrarAndamento(string $statusNovo, string $descricao, int $usuarioId): ContratoAndamento
    {
        return $this->andamentos()->create([
            'usuario_id' => $usuarioId,
            'status_anterior' => $this->status,
            'status_novo' => $statusNovo,
            'descricao' => $descricao,
        ]);
    }
}
