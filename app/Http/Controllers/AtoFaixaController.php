<?php

namespace App\Http\Controllers;

use App\Models\Ato;
use App\Models\AtoFaixa;
use App\Traits\RespostaApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtoFaixaController extends Controller
{
    use RespostaApi;

    public function listar(int $atoId): JsonResponse
    {
        $ato = Ato::find($atoId);

        if (!$ato) {
            return $this->naoEncontrado('Ato não encontrado');
        }

        return $this->sucesso($ato->faixas);
    }

    public function criar(Request $request, int $atoId): JsonResponse
    {
        $ato = Ato::find($atoId);

        if (!$ato) {
            return $this->naoEncontrado('Ato não encontrado');
        }

        $dados = $request->validate([
            'valor_de' => 'required|numeric|min:0',
            'valor_ate' => 'nullable|numeric|min:0',
            'valor_fixo' => 'nullable|numeric|min:0',
            'percentual' => 'nullable|numeric|min:0',
        ]);

        $faixa = $ato->faixas()->create($dados);

        return $this->criado($faixa);
    }

    public function atualizar(Request $request, int $atoId, int $id): JsonResponse
    {
        $faixa = AtoFaixa::where('ato_id', $atoId)->find($id);

        if (!$faixa) {
            return $this->naoEncontrado('Faixa não encontrada');
        }

        $dados = $request->validate([
            'valor_de' => 'sometimes|numeric|min:0',
            'valor_ate' => 'nullable|numeric|min:0',
            'valor_fixo' => 'nullable|numeric|min:0',
            'percentual' => 'nullable|numeric|min:0',
        ]);

        $faixa->update($dados);

        return $this->sucesso($faixa->fresh(), 'Faixa atualizada com sucesso');
    }

    public function excluir(int $atoId, int $id): JsonResponse
    {
        $faixa = AtoFaixa::where('ato_id', $atoId)->find($id);

        if (!$faixa) {
            return $this->naoEncontrado('Faixa não encontrada');
        }

        $faixa->delete();

        return $this->sucesso(null, 'Faixa excluída com sucesso');
    }
}
