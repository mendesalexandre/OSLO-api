<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Http\Requests\CaixaRequest;
use Illuminate\Http\JsonResponse;

class CaixaController extends Controller
{
    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', Caixa::class);

        $caixas = Caixa::all();

        return response()->json($caixas);
    }

    public function store(CaixaRequest $request): JsonResponse
    {
        // $this->authorize('create', Caixa::class);

        $caixa = Caixa::create($request->validated());

        return response()->json($caixa, 201);
    }

    public function update(CaixaRequest $request, $id): JsonResponse
    {
        $caixa = Caixa::findOrFail($id);

        $caixa->update($request->validated());

        return response()->json($caixa);
    }

    public function destroy($id): JsonResponse
    {
        $caixa = Caixa::findOrFail($id);

        $caixa->delete();

        return response()->json(['message' => 'Caixa excluído com sucesso']);
    }
}
