<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', Categoria::class);

        $categorias = Categoria::all();

        return response()->json($categorias);
    }

    public function store(CategoriaRequest $request): JsonResponse
    {
        // $this->authorize('create', Categoria::class);

        $categoria = Categoria::create($request->validated());

        return response()->json($categoria, 201);
    }

    public function show($id): JsonResponse
    {
        $categoria = Categoria::with('transacoes')->findOrFail($id);

        return response()->json($categoria);
    }

    public function update(CategoriaRequest $request, $id): JsonResponse
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->update($request->validated());

        return response()->json($categoria);
    }

    public function destroy($id): JsonResponse
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->delete();

        return response()->json(['message' => 'Categoria excluída com sucesso']);
    }
}
