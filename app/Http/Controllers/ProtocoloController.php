<?php

namespace App\Http\Controllers;

use App\Models\Protocolo;
use Illuminate\Http\Request;

class ProtocoloController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|integer',
            'data_prevista' => 'nullable|date',
            'data_reingresso' => 'nullable|date',
            'data_limite' => 'nullable|date',
            'solicitante_id' => 'required|integer',
            'atendente_id' => 'nullable|integer',
            'cliente_id' => 'required|integer',
            'natureza_id' => 'required|integer',
            'reprotocolo_origem_id' => 'nullable|integer',
            'tipo_suspensao_id' => 'nullable|integer',
            'tipo_documento_id' => 'nullable|integer',
            'vinculo_id' => 'nullable|integer',
            'entregue' => 'boolean',
            'etapa_id' => 'nullable|integer',
            'etapa_usuario_id' => 'nullable|integer',
            'etapa_anterior_id' => 'nullable|integer',
            'finalizador_id' => 'nullable|integer',
            'motivo_cancelamento' => 'nullable|string',
            'interessado_id' => 'nullable|integer',
            'tomador_id' => 'nullable|integer',
            'dias' => 'integer',
            'is_digital' => 'boolean',
            'is_parado' => 'boolean',
            'pago' => 'boolean',
            'mesa' => 'boolean',
            'status' => 'string',
        ]);

        $protocolo = Protocolo::query()
            ->create($validated);

        return response()->json($protocolo, 201);
    }
}
