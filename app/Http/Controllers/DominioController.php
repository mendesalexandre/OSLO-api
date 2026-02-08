<?php

namespace App\Http\Controllers;

use App\Models\Dominio;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DominioController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = Dominio::disponivel()->comAuditoria();

        $this->applyFilters($query, $request);

        $dominios = $query->ordenadoPorExibicao()->paginate(
            $request->get('per_page', 15)
        );

        return $this->paginatedResponse($dominios, [
            // 'user_permissions' => $this->getUserModulePermissions(),
            'opcoes_sistema' => $this->getOpcoesSistema()
        ]);
    }

    public function create(Request $request): JsonResponse
    {

        $validated = $this->validateDominio($request);

        $dominio = Dominio::create($validated);

        Log::info('Domínio criado', $this->getLogData($dominio));

        return $this->createdResponse($dominio->load([
            'usuarioCriacao:id,nome,email'
        ]));
    }

    public function show(string $id): JsonResponse
    {

        $dominio = $this->findDominio($id, true);

        return $this->successResponse($dominio, [
            'opcoes_sistema' => $this->getOpcoesSistema()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {

        $dominio = $this->findDominio($id);

        $validated = $this->validateDominio($request, $dominio->id);

        $dominio->update($validated);

        Log::info('Domínio atualizado', $this->getLogData($dominio));

        return $this->updatedResponse($dominio->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]));
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(string $id): JsonResponse
    {

        $dominio = $this->findDominio($id);

        $dominio->delete();

        Log::info('Domínio excluído', $this->getLogData($dominio));

        return $this->deletedResponse();
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore(string $id): JsonResponse
    {

        $dominio = Dominio::where('id', $id)
            ->whereNotNull('data_exclusao')
            ->firstOrFail();

        $dominio->restore();

        Log::info('Domínio restaurado', $this->getLogData($dominio));

        return $this->successResponse($dominio->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]), [
            'message' => 'Domínio restaurado com sucesso.'
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(string $id): JsonResponse
    {

        $dominio = $this->findDominio($id);

        $dominio->update(['is_ativo' => !$dominio->is_ativo]);

        $status = $dominio->is_ativo ? 'ativado' : 'desativado';

        Log::info("Domínio {$status}", array_merge(
            $this->getLogData($dominio),
            ['is_ativo' => $dominio->is_ativo]
        ));

        return $this->successResponse($dominio->fresh()->load([
            'usuarioCriacao:id,nome,email',
            'usuarioAlteracao:id,nome,email'
        ]), [
            'message' => "Domínio {$status} com sucesso."
        ]);
    }

    /**
     * Get domínios by atribuição.
     */
    public function porAtribuicao(string $atribuicao): JsonResponse
    {

        $dominios = Dominio::getPorAtribuicao($atribuicao);

        return $this->collectionResponse($dominios);
    }

    /**
     * Get domínios agrupados por atribuição.
     */
    public function agrupadoPorAtribuicao(): JsonResponse
    {

        $dominios = Dominio::getAgrupadoPorAtribuicao();

        return $this->successResponse($dominios->toArray());
    }

    /**
     * Get domínios by tipo.
     */
    public function porTipo(string $tipo): JsonResponse
    {

        $dominios = Dominio::disponivel()
            ->porTipo($tipo)
            ->ordenadoPorExibicao()
            ->get();

        return $this->collectionResponse($dominios);
    }

    /**
     * Validate if código exists.
     */
    public function validarCodigo(Request $request): JsonResponse
    {
        $codigo = $request->get('codigo');
        $excludeId = $request->get('exclude_id');

        $existe = Dominio::codigoExiste($codigo, $excludeId);

        return $this->successResponse([
            'codigo' => $codigo,
            'existe' => $existe,
            'disponivel' => !$existe
        ]);
    }

    /**
     * Find Dominio by ID or fail.
     */
    private function findDominio(string $id, bool $comAuditoria = false): Dominio
    {
        /**
         * @var Dominio $query
         */
        $query = Dominio::disponivel();

        if ($comAuditoria) {
            $query->comAuditoria();
        }

        return $query->findOrFail($id);
    }

    /**
     * Validate Dominio data.
     */
    private function validateDominio(Request $request, ?int $excludeId = null): array
    {
        return $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('dominio', 'codigo')->ignore($excludeId)
            ],
            'nome' => 'required|string|max:100',
            'nome_completo' => 'required|string|max:255',
            'tipo' => [
                'required',
                'string',
                Rule::in(['PROTOCOLO', 'PEDIDO_CERTIDAO', 'AUXILIAR'])
            ],
            'atribuicao' => [
                'required',
                'string',
                Rule::in(['RI', 'RTD', 'RCPJ', 'NOTAS', 'GERAL'])
            ],
            'genero' => [
                'required',
                'string',
                Rule::in(['o', 'a'])
            ],
            'descricao' => 'nullable|string',
            'configuracoes' => 'nullable|array',
            'ordem_exibicao' => 'sometimes|integer|min:0',
            'is_ativo' => 'sometimes|boolean',
        ], [
            'codigo.required' => 'O código é obrigatório.',
            'codigo.unique' => 'Já existe um domínio com este código.',
            'codigo.max' => 'O código não pode ter mais de 50 caracteres.',
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 100 caracteres.',
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'nome_completo.max' => 'O nome completo não pode ter mais de 255 caracteres.',
            'tipo.required' => 'O tipo é obrigatório.',
            'tipo.in' => 'O tipo deve ser PROTOCOLO, PEDIDO_CERTIDAO ou AUXILIAR.',
            'atribuicao.required' => 'A atribuição é obrigatória.',
            'atribuicao.in' => 'A atribuição deve ser RI, RTD, RCPJ, NOTAS ou GERAL.',
            'genero.required' => 'O gênero é obrigatório.',
            'genero.in' => 'O gênero deve ser "o" ou "a".',
            'configuracoes.array' => 'As configurações devem ser um array.',
            'ordem_exibicao.integer' => 'A ordem de exibição deve ser um número.',
            'ordem_exibicao.min' => 'A ordem de exibição deve ser maior ou igual a zero.',
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

        $query->when($request->filled('codigo'), function ($q) use ($request) {
            $q->where('codigo', 'like', '%' . $request->codigo . '%');
        });

        $query->when($request->has('is_ativo'), function ($q) use ($request) {
            $q->where('is_ativo', $request->boolean('is_ativo'));
        });

        $query->when($request->filled('tipo'), function ($q) use ($request) {
            $q->where('tipo', $request->tipo);
        });

        $query->when($request->filled('atribuicao'), function ($q) use ($request) {
            $q->where('atribuicao', $request->atribuicao);
        });

        $query->when($request->filled('genero'), function ($q) use ($request) {
            $q->where('genero', $request->genero);
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
     * Get log data for Dominio.
     */
    private function getLogData(Dominio $dominio): array
    {
        return [
            'id' => $dominio->id,
            'codigo' => $dominio->codigo,
            'nome' => $dominio->nome,
            'tipo' => $dominio->tipo,
            'atribuicao' => $dominio->atribuicao,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email
        ];
    }

    /**
     * Get system options for frontend.
     */
    private function getOpcoesSistema(): array
    {
        return [
            'tipos' => Dominio::getTipos(),
            'atribuicoes' => Dominio::getAtribuicoes(),
            'generos' => Dominio::getGeneros(),
        ];
    }
}
