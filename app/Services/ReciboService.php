<?php

namespace App\Services;

use App\Models\Protocolo;
use App\Models\Recibo;
use Illuminate\Validation\ValidationException;

class ReciboService
{
    public function gerar(Protocolo $protocolo): Recibo
    {
        if ($protocolo->valor_pago <= 0 && !$protocolo->eIsento()) {
            throw ValidationException::withMessages([
                'protocolo' => ['Protocolo não possui pagamentos confirmados nem isenção.'],
            ]);
        }

        return Recibo::create([
            'protocolo_id' => $protocolo->id,
            'numero' => Recibo::gerarNumero(),
            'ano' => now()->year,
            'usuario_id' => auth('api')->id(),
            'solicitante_nome' => $protocolo->solicitante_nome,
            'solicitante_cpf_cnpj' => $protocolo->solicitante_cpf_cnpj,
            'valor_total' => $protocolo->valor_total,
            'valor_isento' => $protocolo->valor_isento,
            'valor_pago' => $protocolo->valor_pago,
            'data_emissao' => now(),
        ]);
    }
}
