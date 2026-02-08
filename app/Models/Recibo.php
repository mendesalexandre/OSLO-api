<?php

namespace App\Models;

use App\Traits\Auditavel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Recibo extends Model
{
    use SoftDeletes, Auditavel;

    protected $table = 'recibo';

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $fillable = [
        'protocolo_id',
        'numero',
        'ano',
        'usuario_id',
        'solicitante_nome',
        'solicitante_cpf_cnpj',
        'valor_total',
        'valor_isento',
        'valor_pago',
        'data_emissao',
        'observacao',
    ];

    protected $casts = [
        'valor_total' => 'decimal:2',
        'valor_isento' => 'decimal:2',
        'valor_pago' => 'decimal:2',
        'data_emissao' => 'datetime',
        'data_cadastro' => 'datetime',
        'data_alteracao' => 'datetime',
        'data_exclusao' => 'datetime',
    ];

    // Relacionamentos

    public function protocolo(): BelongsTo
    {
        return $this->belongsTo(Protocolo::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Helpers

    public static function gerarNumero(): string
    {
        $ano = now()->year;

        $ultimoNumero = DB::table('recibo')
            ->where('ano', $ano)
            ->max(DB::raw("CAST(SUBSTRING(numero FROM 7) AS INTEGER)"));

        $sequencial = ($ultimoNumero ?? 0) + 1;

        return sprintf('%d/R%06d', $ano, $sequencial);
    }
}
