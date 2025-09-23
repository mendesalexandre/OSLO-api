<?php

namespace App\Http\Controllers;

use App\Models\Natureza;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class NaturezaController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // $this->authorize('PERMITIR_NATUREZA_VISUALIZAR');

        $query = Natureza::disponivel()->comAuditoria();

        $this->applyFilters($query, $request);

        $naturezas = $query->ordenadoPorExibicao()->paginate(
            $request->get('per_page', 15)
        );

        return $this->paginatedResponse($naturezas, [
            'user_permissions' => $this->getUserModulePermissions(),
            'opcoes_sistema' => $this->getOpcoesSistema()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_CRIAR');

        $validated = $this->validateNatureza($request);

        $natureza = Natureza::create($validated);

        Log::info('Natureza criada', $this->getLogData($natureza));

        return $this->createdResponse($natureza->load([
            'usuarioCriacao:id,nome,email'
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_VISUALIZAR');

        $natureza = $this->findNatureza($id, true);

        return $this->successResponse($natureza, [
            'user_permissions' => $this->getUserModulePermissions(),
            'opcoes_sistema' => $this->getOpcoesSistema()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_EDITAR');

        $natureza = $this->findNatureza($id);

        $validated = $this->validateNatureza($request, $natureza->id);

        $natureza->update($validated);

        Log::info('Natureza atualizada', $this->getLogData($natureza));

        return $this->updatedResponse($natureza->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]));
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_EXCLUIR');

        $natureza = $this->findNatureza($id);

        $natureza->delete();

        Log::info('Natureza excluída', $this->getLogData($natureza));

        return $this->deletedResponse();
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_RESTAURAR');

        $natureza = Natureza::where('id', $id)
            ->whereNotNull('data_exclusao')
            ->firstOrFail();

        $natureza->restore();

        Log::info('Natureza restaurada', $this->getLogData($natureza));

        return $this->successResponse($natureza->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]), [
            'message' => 'Natureza restaurada com sucesso.'
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_ALTERAR_STATUS');

        $natureza = $this->findNatureza($id);

        $natureza->update(['is_ativo' => !$natureza->is_ativo]);

        $status = $natureza->is_ativo ? 'ativada' : 'desativada';

        Log::info("Natureza {$status}", array_merge(
            $this->getLogData($natureza),
            ['is_ativo' => $natureza->is_ativo]
        ));

        return $this->successResponse($natureza->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]), [
            'message' => "Natureza {$status} com sucesso."
        ]);
    }

    /**
     * Toggle registro ativo status.
     */
    public function toggleRegistroAtivo(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_ALTERAR_STATUS');

        $natureza = $this->findNatureza($id);

        $natureza->update(['registro_ativo' => !$natureza->registro_ativo]);

        $status = $natureza->registro_ativo ? 'ativado' : 'desativado';

        Log::info("Registro de natureza {$status}", array_merge(
            $this->getLogData($natureza),
            ['registro_ativo' => $natureza->registro_ativo]
        ));

        return $this->successResponse($natureza->fresh(), [
            'message' => "Registro {$status} com sucesso."
        ]);
    }

    /**
     * Get naturezas by categoria.
     */
    public function porCategoria(string $categoria): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_VISUALIZAR');

        $naturezas = Natureza::disponivel()
            ->porCategoria($categoria)
            ->ordenadoPorExibicao()
            ->get();

        return $this->collectionResponse($naturezas);
    }

    /**
     * Duplicate natureza.
     */
    public function duplicate(string $id): JsonResponse
    {
        $this->authorize('PERMITIR_NATUREZA_CRIAR');

        $naturezaOriginal = $this->findNatureza($id);

        $dadosNova = $naturezaOriginal->toArray();

        // Limpar campos que não devem ser duplicados
        unset(
            $dadosNova['id'],
            $dadosNova['uuid'],
            $dadosNova['data_cadastro'],
            $dadosNova['data_alteracao'],
            $dadosNova['usuario_criacao_id'],
            $dadosNova['usuario_alteracao_id'],
            $dadosNova['auditoria']
        );

        // Adicionar sufixo no nome
        $dadosNova['nome'] = $dadosNova['nome'] . ' (Cópia)';
        $dadosNova['is_ativo'] = false; // Criar inativa por padrão

        $novaNatureza = Natureza::create($dadosNova);

        Log::info('Natureza duplicada', array_merge(
            $this->getLogData($novaNatureza),
            ['natureza_original_id' => $naturezaOriginal->id]
        ));

        return $this->createdResponse($novaNatureza->load([
            'usuarioCriacao:id,nome,email'
        ]), 'Natureza duplicada com sucesso.');
    }

    /**
     * Find Natureza by ID or fail.
     */
    private function findNatureza(string $id, bool $withAudit = false): Natureza
    {
        $query = Natureza::disponivel();

        if ($withAudit) {
            $query->comAuditoria();
        }

        return $query->findOrFail($id);
    }

    /**
     * Validate Natureza data.
     */
    private function validateNatureza(Request $request, ?int $excludeId = null): array
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
            'is_ativo' => 'sometimes|boolean',
            'registro_ativo' => 'sometimes|boolean',
            'permitir_edicao_minuta' => 'sometimes|boolean',
            'permitir_isencao' => 'sometimes|boolean',
            'permitir_gerar_selo' => 'sometimes|boolean',
            'informar_valores_base_calculo' => 'sometimes|boolean',
            'nivel_dificuldade' => 'required|integer|min:1|max:4',
            'regra_custas' => 'nullable|string|max:255',
            'base_calculo' => 'nullable|string|max:255',
            'limite_base_calculo' => 'nullable|string|max:255',
            'tipo_registro_averbacao' => 'nullable|string|max:255',
            'tipo_ato_tribunal_cobranca' => 'nullable|string|max:255',
            'titulo_ato_minuta' => 'nullable|string|max:255',
            'base_calculo_opcoes' => 'nullable|array',
            'livros' => 'nullable|array',
            'tipos_documento' => 'nullable|array',
            'categoria' => 'nullable|string|max:100',
            'ordem_exibicao' => 'sometimes|integer|min:0',
            'opcoes' => 'nullable|array',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.unique' => 'Já existe uma natureza com este nome.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
            'nivel_dificuldade.required' => 'O nível de dificuldade é obrigatório.',
            'nivel_dificuldade.integer' => 'O nível de dificuldade deve ser um número.',
            'nivel_dificuldade.min' => 'O nível de dificuldade deve ser no mínimo 1.',
            'nivel_dificuldade.max' => 'O nível de dificuldade deve ser no máximo 4.',
            'valor.numeric' => 'O valor deve ser um número.',
            'valor.min' => 'O valor deve ser maior ou igual a zero.',
            'valor.max' => 'O valor não pode ser maior que 999.999,99.',
            'base_calculo_opcoes.array' => 'As opções de base de cálculo devem ser um array.',
            'livros.array' => 'Os livros devem ser um array.',
            'tipos_documento.array' => 'Os tipos de documento devem ser um array.',
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

        $query->when($request->has('registro_ativo'), function ($q) use ($request) {
            $q->where('registro_ativo', $request->boolean('registro_ativo'));
        });

        $query->when($request->filled('categoria'), function ($q) use ($request) {
            $q->where('categoria', $request->categoria);
        });

        $query->when($request->filled('nivel_dificuldade'), function ($q) use ($request) {
            $q->where('nivel_dificuldade', $request->nivel_dificuldade);
        });

        $query->when($request->has('permitir_gerar_selo'), function ($q) use ($request) {
            $q->where('permitir_gerar_selo', $request->boolean('permitir_gerar_selo'));
        });

        $query->when($request->has('permitir_isencao'), function ($q) use ($request) {
            $q->where('permitir_isencao', $request->boolean('permitir_isencao'));
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
     * Get log data for Natureza.
     */
    private function getLogData(Natureza $natureza): array
    {
        return [
            'id' => $natureza->id,
            'uuid' => $natureza->uuid,
            'nome' => $natureza->nome,
            'categoria' => $natureza->categoria,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email
        ];
    }

    /**
     * Get user permissions for NATUREZA module.
     */
    private function getUserModulePermissions(): array
    {
        $user = auth()->user();

        return [
            'pode_criar' => $user->can('PERMITIR_NATUREZA_CRIAR'),
            'pode_editar' => $user->can('PERMITIR_NATUREZA_EDITAR'),
            'pode_excluir' => $user->can('PERMITIR_NATUREZA_EXCLUIR'),
            'pode_restaurar' => $user->can('PERMITIR_NATUREZA_RESTAURAR'),
            'pode_alterar_status' => $user->can('PERMITIR_NATUREZA_ALTERAR_STATUS'),
        ];
    }

    /**
     * Get system options for frontend.
     */
    private function getOpcoesSistema(): array
    {
        return [
            'niveis_dificuldade' => Natureza::getNiveiseDificuldade(),
            'opcoes_livros' => Natureza::getOpcoesLivros(),
            'tipos_documento' => Natureza::getOpcoesTiposDocumento(),
            'opcoes_base_calculo' => Natureza::getOpcoesBaseCalculo(),
        ];
    }
}
