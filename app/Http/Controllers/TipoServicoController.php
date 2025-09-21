<?php

namespace App\Http\Controllers;

use App\Models\TipoServico;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TipoServicoController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('PERMITIR_TIPO_SERVICO_VISUALIZAR');

        $query = TipoServico::disponivel()->comAuditoria();

        $this->applyFilters($query, $request);

        $tiposServico = $query->orderBy('nome')->paginate(
            $request->get('per_page', 15)
        );

        return $this->paginatedResponse($tiposServico, [
            'user_permissions' => $this->getUserModulePermissions()
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $this->authorize('PERMITIR_TIPO_SERVICO_CRIAR');

        $validated = $this->validateTipoServico($request);

        $tipoServico = TipoServico::create($validated);

        Log::info('Tipo de serviço criado', $this->getLogData($tipoServico));

        return $this->createdResponse($tipoServico->load([
            'usuarioCriacao:id,nome,email'
        ]));
    }


    public function show(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_TIPO_SERVICO_VISUALIZAR');

        $tipoServico = $this->findTipoServico($id, true); // Com auditoria

        return $this->successResponse($tipoServico, [
            'user_permissions' => $this->getUserModulePermissions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $this->authorize('PERMITIR_TIPO_SERVICO_EDITAR');

        $tipoServico = $this->findTipoServico($id);

        $validated = $this->validateTipoServico($request, $tipoServico->id);

        $tipoServico->update($validated);

        Log::info('Tipo de serviço atualizado', $this->getLogData($tipoServico));

        return $this->updatedResponse($tipoServico->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]));
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_TIPO_SERVICO_EXCLUIR');

        $tipoServico = $this->findTipoServico($id);

        $tipoServico->delete(); // Usa o delete customizado com auditoria

        Log::info('Tipo de serviço excluído', $this->getLogData($tipoServico));

        return $this->deletedResponse();
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_TIPO_SERVICO_RESTAURAR');

        $tipoServico = TipoServico::where('id', $id)
            ->whereNotNull('data_exclusao')
            ->firstOrFail();

        $tipoServico->restore(); // Usa o restore customizado com auditoria

        Log::info('Tipo de serviço restaurado', $this->getLogData($tipoServico));

        return $this->successResponse($tipoServico->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]), [
            'message' => 'Tipo de serviço restaurado com sucesso.'
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_TIPO_SERVICO_ALTERAR_STATUS');

        $tipoServico = $this->findTipoServico($id);

        $tipoServico->update(['is_ativo' => !$tipoServico->is_ativo]);

        $status = $tipoServico->is_ativo ? 'ativado' : 'desativado';

        Log::info("Tipo de serviço {$status}", array_merge(
            $this->getLogData($tipoServico),
            ['is_ativo' => $tipoServico->is_ativo]
        ));

        return $this->successResponse($tipoServico->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]), [
            'message' => "Tipo de serviço {$status} com sucesso."
        ]);
    }

    /**
     * Find TipoServico by ID or fail.
     */
    private function findTipoServico(string $id, bool $withAudit = false): TipoServico
    {
        $query = TipoServico::disponivel();

        if ($withAudit) {
            $query->comAuditoria();
        }

        return $query->findOrFail($id);
    }

    /**
     * Validate TipoServico data.
     */
    private function validateTipoServico(Request $request, ?int $excludeId = null): array
    {
        return $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tipo_servico', 'nome')->ignore($excludeId)
            ],
            'descricao' => 'nullable|string',
            'valor' => 'nullable|numeric|min:0|max:999999.99',
            'opcoes' => 'nullable|array',
            'is_ativo' => 'sometimes|boolean'
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.unique' => 'Já existe um tipo de serviço com este nome.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
            'valor.numeric' => 'O valor deve ser um número.',
            'valor.min' => 'O valor deve ser maior ou igual a zero.',
            'valor.max' => 'O valor não pode ser maior que 999.999,99.',
            'opcoes.array' => 'As opções devem ser um array válido.'
        ]);
    }

    /**
     * Apply filters to query.
     */
    private function applyFilters($query, Request $request): void
    {
        $query->when($request->filled('nome'), function ($q) use ($request) {
            $q->where('nome', 'like', '%' . $request->nome . '%');
        });

        $query->when($request->has('is_ativo'), function ($q) use ($request) {
            $q->where('is_ativo', $request->boolean('is_ativo'));
        });

        // Filtros de auditoria
        $query->when($request->filled('usuario_criacao_id'), function ($q) use ($request) {
            $q->where('usuario_criacao_id', $request->usuario_criacao_id);
        });

        $query->when($request->filled('data_criacao_inicio'), function ($q) use ($request) {
            $q->where('data_cadastro', '>=', $request->data_criacao_inicio);
        });

        $query->when($request->filled('data_criacao_fim'), function ($q) use ($request) {
            $q->where('data_cadastro', '<=', $request->data_criacao_fim);
        });
    }

    /**
     * Get log data for TipoServico.
     */
    private function getLogData(TipoServico $tipoServico): array
    {
        return [
            'id' => $tipoServico->id,
            'uuid' => $tipoServico->uuid,
            'nome' => $tipoServico->nome,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email
        ];
    }

    /**
     * Get user permissions for TIPO_SERVICO module.
     */
    private function getUserModulePermissions(): array
    {
        $user = auth()->user();

        return [
            'pode_criar' => $user->can('PERMITIR_TIPO_SERVICO_CRIAR'),
            'pode_editar' => $user->can('PERMITIR_TIPO_SERVICO_EDITAR'),
            'pode_excluir' => $user->can('PERMITIR_TIPO_SERVICO_EXCLUIR'),
            'pode_restaurar' => $user->can('PERMITIR_TIPO_SERVICO_RESTAURAR'),
            'pode_alterar_status' => $user->can('PERMITIR_TIPO_SERVICO_ALTERAR_STATUS'),
        ];
    }
}
