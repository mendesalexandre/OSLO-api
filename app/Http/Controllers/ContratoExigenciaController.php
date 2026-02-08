<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\ContratoExigencia;
use App\Services\ContratoService;
use App\Traits\RespostaApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContratoExigenciaController extends Controller
{
    use RespostaApi;

    public function __construct(
        private ContratoService $contratoService
    ) {}

    public function listar(int $id): JsonResponse
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return $this->naoEncontrado('Contrato não encontrado');
        }

        $exigencias = $contrato->exigencias()
            ->with('usuario:id,nome')
            ->orderByDesc('data_cadastro')
            ->get();

        return $this->sucesso($exigencias);
    }

    public function criar(Request $request, int $id): JsonResponse
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return $this->naoEncontrado('Contrato não encontrado');
        }

        $dados = $request->validate([
            'descricao' => 'required|string',
            'prazo_dias' => 'nullable|integer|min:1',
            'observacao' => 'nullable|string',
        ]);

        $exigencia = $this->contratoService->adicionarExigencia($contrato, $dados);

        return $this->criado($exigencia, 'Exigência criada com sucesso');
    }

    public function cumprir(int $id, int $exId): JsonResponse
    {
        $exigencia = ContratoExigencia::where('contrato_id', $id)->find($exId);

        if (!$exigencia) {
            return $this->naoEncontrado('Exigência não encontrada');
        }

        if ($exigencia->cumprida) {
            return $this->erro('Exigência já foi cumprida');
        }

        $this->contratoService->cumprirExigencia($exigencia);

        return $this->sucesso($exigencia->fresh(), 'Exigência cumprida com sucesso');
    }
}
