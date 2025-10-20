<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etapa;
use App\Http\Requests\EtapaRequest;
use Illuminate\Http\JsonResponse;

class EtapaController extends Controller
{
    public function index(): JsonResponse
    {
        $etapas = Etapa::query()->get();

        return response()->json($etapas);
    }

    public function store(EtapaRequest $request): JsonResponse
    {
        $etapa = Etapa::create($request->validated());

        return response()->json($etapa, 201);
    }

    public function update(EtapaRequest $request, $id): JsonResponse
    {
        $etapa = Etapa::whereNull('data_exclusao')->findOrFail($id);

        $etapa->update($request->validated());

        return response()->json($etapa);
    }

    public function destroy($id): JsonResponse
    {
        $etapa = Etapa::whereNull('data_exclusao')->findOrFail($id);

        return response()->json(['message' => 'Etapa excluída com sucesso']);
    }
}
