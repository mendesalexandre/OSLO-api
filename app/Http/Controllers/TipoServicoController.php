<?php

namespace App\Http\Controllers;

use App\Models\TipoServico;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TipoServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // Usando Policy - Laravel resolve automaticamente
        $this->authorize('viewAny', TipoServico::class);

        $query = TipoServico::disponivel();
        $this->applyFilters($query, $request);

        $tiposServico = $query->orderBy('nome')->paginate(
            $request->get('per_page', 15)
        );

        return $this->successResponse($tiposServico->items(), [
            'pagination' => $this->formatPagination($tiposServico),
            'user_permissions' => $this->getUserModulePermissions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', TipoServico::class);

        $validated = $this->validateTipoServico($request);
        $tipoServico = TipoServico::create($validated);

        Log::info('Tipo de serviço criado', array_merge(
            $this->getLogData($tipoServico),
            ['user_id' => auth()->id()]
        ));

        return $this->successResponse($tipoServico, [
            'message' => 'Tipo de serviço criado com sucesso.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $tipoServico = $this->findTipoServico($id);

        // Policy com instância do model
        $this->authorize('view', $tipoServico);

        return $this->successResponse($tipoServico, [
            'user_permissions' => $this->getUserModulePermissions($tipoServico)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $tipoServico = $this->findTipoServico($id);

        $this->authorize('update', $tipoServico);

        $validated = $this->validateTipoServico($request, $tipoServico->id);
        $tipoServico->update($validated);

        Log::info('Tipo de serviço atualizado', array_merge(
            $this->getLogData($tipoServico),
            ['user_id' => auth()->id()]
        ));

        return $this->successResponse($tipoServico->fresh(), [
            'message' => 'Tipo de serviço atualizado com sucesso.'
        ]);
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(string $id): JsonResponse
    {
        $tipoServico = $this->findTipoServico($id);

        $this->authorize('delete', $tipoServico);

        $tipoServico->delete();

        Log::info('Tipo de serviço excluído', array_merge(
            $this->getLogData($tipoServico),
            ['user_id' => auth()->id()]
        ));

        return $this->successResponse(null, [
            'message' => 'Tipo de serviço excluído com sucesso.'
        ]);
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore(string $id): JsonResponse
    {
        $tipoServico = TipoServico::where('id', $id)
            ->whereNotNull('data_exclusao')
            ->firstOrFail();

        $this->authorize('restore', $tipoServico);

        $tipoServico->restore();

        Log::info('Tipo de serviço restaurado', array_merge(
            $this->getLogData($tipoServico),
            ['user_id' => auth()->id()]
        ));

        return $this->successResponse($tipoServico->fresh(), [
            'message' => 'Tipo de serviço restaurado com sucesso.'
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(string $id): JsonResponse
    {
        $tipoServico = $this->findTipoServico($id);

        $this->authorize('toggleStatus', $tipoServico);

        $tipoServico->update(['is_ativo' => !$tipoServico->is_ativo]);

        $status = $tipoServico->is_ativo ? 'ativado' : 'desativado';

        Log::info("Tipo de serviço {$status}", array_merge(
            $this->getLogData($tipoServico),
            ['is_ativo' => $tipoServico->is_ativo, 'user_id' => auth()->id()]
        ));

        return $this->successResponse($tipoServico->fresh(), [
            'message' => "Tipo de serviço {$status} com sucesso."
        ]);
    }

    // ... resto dos métodos iguais ...

    /**
     * Get user permissions for specific TipoServico instance.
     */
    private function getUserModulePermissions(?TipoServico $tipoServico = null): array
    {
        $user = auth()->user();

        if ($tipoServico) {
            return [
                'pode_visualizar' => $user->can('view', $tipoServico),
                'pode_editar' => $user->can('update', $tipoServico),
                'pode_excluir' => $user->can('delete', $tipoServico),
                'pode_restaurar' => $user->can('restore', $tipoServico),
                'pode_alterar_status' => $user->can('toggleStatus', $tipoServico),
            ];
        }

        return [
            'pode_criar' => $user->can('create', TipoServico::class),
            'pode_visualizar' => $user->can('viewAny', TipoServico::class),
        ];
    }

    // ... resto dos métodos privados iguais ...
}
