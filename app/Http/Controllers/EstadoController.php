<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class EstadoController extends Controller
{
    /**
     * Listar todos os estados
     */
    public function index(Request $request): JsonResponse
    {
        $query = Estado::query();

        // Filtro por status ativo
        if ($request->has('ativo')) {
            $ativo = filter_var($request->ativo, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_ativo', $ativo);
        }

        // Busca por nome
        if ($request->has('nome') && $request->nome) {
            $query->buscarPorNome($request->nome);
        }

        // Busca por sigla
        if ($request->has('sigla') && $request->sigla) {
            $query->buscarPorSigla($request->sigla);
        }

        // Incluir cidades se solicitado
        if ($request->has('com_cidades') && $request->com_cidades) {
            $query->with(['cidades' => function ($q) {
                $q->where('is_ativo', true)->orderBy('nome');
            }]);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'nome');
        $orderDirection = $request->get('order_direction', 'asc');
        $query->orderBy($orderBy, $orderDirection);

        // Paginação ou todos os registros
        if ($request->has('per_page')) {
            $estados = $query->paginate($request->per_page);
        } else {
            $estados = $query->get();
        }

        return response()->json([
            'success' => true,
            'data' => $estados
        ]);
    }

    /**
     * Criar novo estado
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:estado,nome',
            'sigla' => 'required|string|size:2|unique:estado,sigla',
            'ibge_codigo' => 'required|integer|unique:estado,ibge_codigo',
            'is_ativo' => 'boolean'
        ], [
            'nome.required' => 'O nome do estado é obrigatório',
            'nome.unique' => 'Já existe um estado com este nome',
            'sigla.required' => 'A sigla do estado é obrigatória',
            'sigla.size' => 'A sigla deve ter exatamente 2 caracteres',
            'sigla.unique' => 'Já existe um estado com esta sigla',
            'ibge_codigo.required' => 'O código IBGE é obrigatório',
            'ibge_codigo.unique' => 'Já existe um estado com este código IBGE'
        ]);

        try {
            $estado = Estado::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Estado criado com sucesso',
                'data' => $estado
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibir estado específico
     */
    public function show(Estado $estado): JsonResponse
    {
        // Carregar cidades ativas do estado
        $estado->load(['cidadesAtivas' => function ($query) {
            $query->orderBy('nome');
        }]);

        return response()->json([
            'success' => true,
            'data' => $estado
        ]);
    }

    /**
     * Atualizar estado
     */
    public function update(Request $request, Estado $estado): JsonResponse
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('estado', 'nome')->ignore($estado->id)
            ],
            'sigla' => [
                'required',
                'string',
                'size:2',
                Rule::unique('estado', 'sigla')->ignore($estado->id)
            ],
            'ibge_codigo' => [
                'required',
                'integer',
                Rule::unique('estado', 'ibge_codigo')->ignore($estado->id)
            ],
            'is_ativo' => 'boolean'
        ], [
            'nome.required' => 'O nome do estado é obrigatório',
            'nome.unique' => 'Já existe um estado com este nome',
            'sigla.required' => 'A sigla do estado é obrigatória',
            'sigla.size' => 'A sigla deve ter exatamente 2 caracteres',
            'sigla.unique' => 'Já existe um estado com esta sigla',
            'ibge_codigo.required' => 'O código IBGE é obrigatório',
            'ibge_codigo.unique' => 'Já existe um estado com este código IBGE'
        ]);

        try {
            $estado->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Estado atualizado com sucesso',
                'data' => $estado->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Excluir estado (soft delete)
     */
    public function destroy(Estado $estado): JsonResponse
    {
        try {
            // Verificar se há cidades ativas vinculadas
            $cidadesAtivas = $estado->cidadesAtivas()->count();

            if ($cidadesAtivas > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Não é possível excluir o estado pois há {$cidadesAtivas} cidade(s) ativa(s) vinculada(s)"
                ], 422);
            }

            $estado->delete();

            return response()->json([
                'success' => true,
                'message' => 'Estado excluído com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restaurar estado excluído
     */
    public function restore($id): JsonResponse
    {
        try {
            $estado = Estado::withTrashed()->findOrFail($id);
            $estado->restore();

            return response()->json([
                'success' => true,
                'message' => 'Estado restaurado com sucesso',
                'data' => $estado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao restaurar estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ativar/Desativar estado
     */
    public function toggleStatus(Estado $estado): JsonResponse
    {
        try {
            $estado->update(['is_ativo' => !$estado->is_ativo]);

            $status = $estado->is_ativo ? 'ativado' : 'desativado';

            return response()->json([
                'success' => true,
                'message' => "Estado {$status} com sucesso",
                'data' => $estado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao alterar status do estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar apenas estados ativos (para selects/dropdowns)
     */
    public function ativos(): JsonResponse
    {
        $estados = Estado::ativo()
            ->orderBy('nome')
            ->get(['id', 'nome', 'sigla']);

        return response()->json([
            'success' => true,
            'data' => $estados
        ]);
    }
}
