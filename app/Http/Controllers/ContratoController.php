<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Protocolo;
use App\Services\ContratoService;
use App\Traits\RespostaApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    use RespostaApi;

    public function __construct(
        private ContratoService $contratoService
    ) {}

    public function listar(Request $request): JsonResponse
    {
        $query = Contrato::with(['protocolo:id,numero', 'responsavel:id,nome']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('protocolo_id')) {
            $query->where('protocolo_id', $request->protocolo_id);
        }

        if ($request->filled('responsavel')) {
            $query->where('usuario_id', $request->responsavel);
        }

        if ($request->filled('data_entrada_inicio')) {
            $query->where('data_entrada', '>=', $request->data_entrada_inicio);
        }

        if ($request->filled('data_entrada_fim')) {
            $query->where('data_entrada', '<=', $request->data_entrada_fim);
        }

        if ($request->filled('numero')) {
            $query->where('numero', 'ilike', "%{$request->numero}%");
        }

        $porPagina = $request->integer('por_pagina', 15);

        return $this->sucessoPaginado(
            $query->orderByDesc('data_cadastro')->paginate($porPagina)
        );
    }

    public function criar(Request $request, int $id): JsonResponse
    {
        $protocolo = Protocolo::find($id);

        if (!$protocolo) {
            return $this->naoEncontrado('Protocolo não encontrado');
        }

        $dados = $request->validate([
            'tipo' => 'required|in:REGISTRO,AVERBACAO,CERTIDAO,RETIFICACAO,OUTRO',
            'descricao' => 'nullable|string',
            'matricula' => 'nullable|string|max:50',
            'parte_nome' => 'nullable|string|max:200',
            'parte_cpf_cnpj' => 'nullable|string|max:18',
            'parte_qualificacao' => 'nullable|string',
            'data_entrada' => 'nullable|date',
            'data_previsao' => 'nullable|date',
            'prazo_dias' => 'nullable|integer|min:1',
            'observacao' => 'nullable|string',
            'observacao_interna' => 'nullable|string',
        ]);

        $contrato = $this->contratoService->criar($protocolo, $dados);

        return $this->criado($contrato, 'Contrato criado com sucesso');
    }

    public function exibir(int $id): JsonResponse
    {
        $contrato = Contrato::with([
            'protocolo:id,numero,solicitante_nome,valor_total,valor_pago,status',
            'responsavel:id,nome',
            'exigencias.usuario:id,nome',
            'andamentos.usuario:id,nome',
        ])->find($id);

        if (!$contrato) {
            return $this->naoEncontrado('Contrato não encontrado');
        }

        return $this->sucesso($contrato);
    }

    public function atualizar(Request $request, int $id): JsonResponse
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return $this->naoEncontrado('Contrato não encontrado');
        }

        $dados = $request->validate([
            'tipo' => 'sometimes|in:REGISTRO,AVERBACAO,CERTIDAO,RETIFICACAO,OUTRO',
            'descricao' => 'nullable|string',
            'matricula' => 'nullable|string|max:50',
            'parte_nome' => 'nullable|string|max:200',
            'parte_cpf_cnpj' => 'nullable|string|max:18',
            'parte_qualificacao' => 'nullable|string',
            'data_previsao' => 'nullable|date',
            'prazo_dias' => 'nullable|integer|min:1',
            'observacao' => 'nullable|string',
            'observacao_interna' => 'nullable|string',
        ]);

        $contrato->update($dados);

        return $this->sucesso($contrato->fresh()->load(['protocolo:id,numero', 'responsavel:id,nome']), 'Contrato atualizado com sucesso');
    }

    public function alterarStatus(Request $request, int $id): JsonResponse
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return $this->naoEncontrado('Contrato não encontrado');
        }

        $dados = $request->validate([
            'status' => 'required|in:pendente,em_analise,exigencia,em_andamento,concluido,cancelado,devolvido',
            'descricao' => 'required|string',
        ]);

        $this->contratoService->atualizarStatus(
            $contrato,
            $dados['status'],
            $dados['descricao'],
            auth('api')->id()
        );

        return $this->sucesso($contrato->fresh(), 'Status do contrato alterado com sucesso');
    }

    public function concluir(int $id): JsonResponse
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return $this->naoEncontrado('Contrato não encontrado');
        }

        $this->contratoService->concluir($contrato, auth('api')->id());

        return $this->sucesso($contrato->fresh(), 'Contrato concluído com sucesso');
    }

    public function cancelar(Request $request, int $id): JsonResponse
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return $this->naoEncontrado('Contrato não encontrado');
        }

        $dados = $request->validate([
            'descricao' => 'required|string',
        ]);

        $this->contratoService->atualizarStatus(
            $contrato,
            'cancelado',
            $dados['descricao'],
            auth('api')->id()
        );

        return $this->sucesso(null, 'Contrato cancelado com sucesso');
    }

    public function andamentos(int $id): JsonResponse
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return $this->naoEncontrado('Contrato não encontrado');
        }

        return $this->sucesso(
            $contrato->andamentos()->with('usuario:id,nome')->get()
        );
    }
}
