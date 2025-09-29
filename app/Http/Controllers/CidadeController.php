<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CidadeController extends Controller
{
    /**
     * Listar todas as cidades
     */
    public function index(Request $request): JsonResponse
    {
        $query = Cidade::query();

        // Sempre incluir informações do estado
        $query->comEstado();

        // Filtro por status ativo
        if ($request->has('ativo')) {
            $ativo = filter_var($request->ativo, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_ativo', $ativo);
        }

        // Busca por nome
        if ($request->has('nome') && $request->nome) {
            $query->buscarPorNome($request->nome);
        }

        // Filtro por estado
        if ($request->has('estado_id') && $request->estado_id) {
            $query->porEstado($request->estado_id);
        }

        // Filtro por sigla do estado
        if ($request->has('estado_sigla') && $request->estado_sigla) {
            $query->whereHas('estado', function ($q) use ($request) {
                $q->where('sigla', strtoupper($request->estado_sigla));
            });
        }

        // Filtro por código IBGE
        if ($request->has('ibge_codigo') && $request->ibge_codigo) {
            $query->where('ibge_codigo', $request->ibge_codigo);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'nome');
        $orderDirection = $request->get('order_direction', 'asc');

        if ($orderBy === 'estado') {
            $query->join('estado', 'cidade.estado_id', '=', 'estado.id')
                ->orderBy('estado.nome', $orderDirection)
                ->orderBy('cidade.nome', 'asc')
                ->select('cidade.*');
        } else {
            $query->orderBy($orderBy, $orderDirection);
        }

        // Paginação ou todos os registros
        if ($request->has('per_page')) {
            $cidades = $query->paginate($request->per_page);
        } else {
            $cidades = $query->get();
        }

        return response()->json([
            'success' => true,
            'data' => $cidades
        ]);
    }

    /**
     * Criar nova cidade
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:150',
                // Validação única composta: mesmo nome só pode existir uma vez por estado
                Rule::unique('cidade')->where(function ($query) use ($request) {
                    return $query->where('estado_id', $request->estado_id);
                })
            ],
            'estado_id' => 'required|exists:estado,id',
            'ibge_codigo' => 'required|integer|unique:cidade,ibge_codigo',
            'ibge_estado_id' => 'required|integer',
            'is_ativo' => 'boolean'
        ], [
            'nome.required' => 'O nome da cidade é obrigatório',
            'nome.unique' => 'Já existe uma cidade com este nome neste estado',
            'estado_id.required' => 'O estado é obrigatório',
            'estado_id.exists' => 'Estado não encontrado',
            'ibge_codigo.required' => 'O código IBGE é obrigatório',
            'ibge_codigo.unique' => 'Já existe uma cidade com este código IBGE',
            'ibge_estado_id.required' => 'O código IBGE do estado é obrigatório'
        ]);

        try {
            // Verificar se o estado está ativo
            $estado = Estado::find($validated['estado_id']);
            if (!$estado->is_ativo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível criar cidade em um estado inativo'
                ], 422);
            }

            $cidade = Cidade::create($validated);
            $cidade->load('estado');

            return response()->json([
                'success' => true,
                'message' => 'Cidade criada com sucesso',
                'data' => $cidade
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar cidade',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibir cidade específica
     */
    public function show(Cidade $cidade): JsonResponse
    {
        $cidade->load('estado');

        return response()->json([
            'success' => true,
            'data' => $cidade
        ]);
    }

    /**
     * Atualizar cidade
     */
    public function update(Request $request, Cidade $cidade): JsonResponse
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:150',
                Rule::unique('cidade')->where(function ($query) use ($request) {
                    return $query->where('estado_id', $request->estado_id);
                })->ignore($cidade->id)
            ],
            'estado_id' => 'required|exists:estado,id',
            'ibge_codigo' => [
                'required',
                'integer',
                Rule::unique('cidade', 'ibge_codigo')->ignore($cidade->id)
            ],
            'ibge_estado_id' => 'required|integer',
            'is_ativo' => 'boolean'
        ], [
            'nome.required' => 'O nome da cidade é obrigatório',
            'nome.unique' => 'Já existe uma cidade com este nome neste estado',
            'estado_id.required' => 'O estado é obrigatório',
            'estado_id.exists' => 'Estado não encontrado',
            'ibge_codigo.required' => 'O código IBGE é obrigatório',
            'ibge_codigo.unique' => 'Já existe uma cidade com este código IBGE',
            'ibge_estado_id.required' => 'O código IBGE do estado é obrigatório'
        ]);

        try {
            // Verificar se o novo estado está ativo (se mudou)
            if ($validated['estado_id'] != $cidade->estado_id) {
                $estado = Estado::find($validated['estado_id']);
                if (!$estado->is_ativo) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Não é possível mover cidade para um estado inativo'
                    ], 422);
                }
            }

            $cidade->update($validated);
            $cidade->load('estado');

            return response()->json([
                'success' => true,
                'message' => 'Cidade atualizada com sucesso',
                'data' => $cidade
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar cidade',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Excluir cidade (soft delete)
     */
    public function destroy(Cidade $cidade): JsonResponse
    {
        try {
            $cidade->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cidade excluída com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir cidade',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restaurar cidade excluída
     */
    public function restore($id): JsonResponse
    {
        try {
            $cidade = Cidade::withTrashed()->findOrFail($id);
            $cidade->restore();
            $cidade->load('estado');

            return response()->json([
                'success' => true,
                'message' => 'Cidade restaurada com sucesso',
                'data' => $cidade
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao restaurar cidade',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ativar/Desativar cidade
     */
    public function toggleStatus(Cidade $cidade): JsonResponse
    {
        try {
            $cidade->update(['is_ativo' => !$cidade->is_ativo]);

            $status = $cidade->is_ativo ? 'ativada' : 'desativada';

            return response()->json([
                'success' => true,
                'message' => "Cidade {$status} com sucesso",
                'data' => $cidade
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao alterar status da cidade',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar cidades por estado (para selects/dropdowns)
     */
    public function porEstado($estadoId): JsonResponse
    {
        $cidades = Cidade::ativa()
            ->porEstado($estadoId)
            ->orderBy('nome')
            ->get(['id', 'nome', 'estado_id']);

        return response()->json([
            'success' => true,
            'data' => $cidades
        ]);
    }

    /**
     * Listar apenas cidades ativas (para selects/dropdowns)
     */
    public function ativas(Request $request): JsonResponse
    {
        $query = Cidade::ativa()->with('estado:id,nome,sigla');

        // Filtro opcional por estado
        if ($request->has('estado_id') && $request->estado_id) {
            $query->porEstado($request->estado_id);
        }

        $cidades = $query->orderBy('nome')
            ->get(['id', 'nome', 'estado_id']);

        return response()->json([
            'success' => true,
            'data' => $cidades
        ]);
    }

    /**
     * Buscar cidades por termo (para autocomplete)
     */
    public function buscar(Request $request): JsonResponse
    {
        $termo = $request->get('termo', '');

        if (strlen($termo) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Digite pelo menos 2 caracteres para buscar'
            ], 422);
        }

        $cidades = Cidade::ativa()
            ->comEstado()
            ->buscarPorNome($termo)
            ->limit(20)
            ->orderBy('nome')
            ->get(['id', 'nome', 'estado_id']);

        return response()->json([
            'success' => true,
            'data' => $cidades
        ]);
    }
}
