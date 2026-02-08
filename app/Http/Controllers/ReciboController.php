<?php

namespace App\Http\Controllers;

use App\Models\Protocolo;
use App\Models\Recibo;
use App\Services\ReciboService;
use App\Traits\RespostaApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReciboController extends Controller
{
    use RespostaApi;

    public function __construct(
        private ReciboService $reciboService
    ) {}

    public function listar(Request $request): JsonResponse
    {
        $query = Recibo::with(['protocolo:id,numero', 'usuario:id,nome']);

        if ($request->filled('protocolo_id')) {
            $query->where('protocolo_id', $request->protocolo_id);
        }

        if ($request->filled('data_inicio')) {
            $query->where('data_emissao', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('data_emissao', '<=', $request->data_fim . ' 23:59:59');
        }

        if ($request->filled('numero')) {
            $query->where('numero', 'ilike', "%{$request->numero}%");
        }

        $porPagina = $request->integer('por_pagina', 15);

        return $this->sucessoPaginado(
            $query->orderByDesc('data_emissao')->paginate($porPagina)
        );
    }

    public function exibir(int $id): JsonResponse
    {
        $recibo = Recibo::with(['protocolo:id,numero,solicitante_nome', 'usuario:id,nome'])->find($id);

        if (!$recibo) {
            return $this->naoEncontrado('Recibo não encontrado');
        }

        return $this->sucesso($recibo);
    }

    public function gerar(int $id): JsonResponse
    {
        $protocolo = Protocolo::find($id);

        if (!$protocolo) {
            return $this->naoEncontrado('Protocolo não encontrado');
        }

        $recibo = $this->reciboService->gerar($protocolo);

        return $this->criado(
            $recibo->load(['protocolo:id,numero', 'usuario:id,nome']),
            'Recibo gerado com sucesso'
        );
    }
}
