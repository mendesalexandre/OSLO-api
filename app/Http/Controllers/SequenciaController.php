<?php

namespace App\Http\Controllers;

use App\Models\Sequencia;
use App\Services\SequenciaService;
use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SequenciaController extends Controller
{
    use ApiResponseTrait, AuthorizesRequests;

    protected SequenciaService $sequenciaService;

    public function __construct(SequenciaService $sequenciaService)
    {
        $this->sequenciaService = $sequenciaService;
    }

    /**
     * Listar todas as sequências
     */
    public function index(): JsonResponse
    {
        $this->authorize('PERMITIR_SEQUENCIA_VISUALIZAR');

        $sequencias = $this->sequenciaService->listarSequencias();

        return $this->successResponse($sequencias, [
            'user_permissions' => $this->getUserModulePermissions()
        ]);
    }

    /**
     * Buscar configuração de uma sequência específica
     */
    public function show(string $dominoCodigo, int|null $ano = null): JsonResponse
    {
        $this->authorize('PERMITIR_SEQUENCIA_VISUALIZAR');

        $situacao = $this->sequenciaService->situacaoSequencia($dominoCodigo, $ano);

        return $this->successResponse($situacao);
    }

    /**
     * Configurar ou atualizar sequência
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('PERMITIR_SEQUENCIA_CRIAR');

        $validated = $this->validateSequencia($request);

        $sequencia = $this->sequenciaService->configurarSequencia(
            $validated['dominio_codigo'],
            $validated
        );

        Log::info('Sequência configurada', [
            'dominio_codigo' => $validated['dominio_codigo'],
            'user_id' => auth()->id()
        ]);

        return $this->createdResponse($sequencia, 'Sequência configurada com sucesso.');
    }

    /**
     * Atualizar configuração existente
     */
    public function update(Request $request, string $dominoCodigo, int|null $ano = null): JsonResponse
    {
        $this->authorize('PERMITIR_SEQUENCIA_EDITAR');

        $ano = $ano ?? now()->year;
        $validated = $this->validateSequencia($request, true);

        // Buscar sequência existente
        $sequencia = Sequencia::where('dominio_codigo', $dominoCodigo)
            ->where('ano', $ano)
            ->firstOrFail();

        // Atualizar configurações
        $sequencia->update($validated);

        Log::info('Sequência atualizada', [
            'dominio_codigo' => $dominoCodigo,
            'ano' => $ano,
            'user_id' => auth()->id()
        ]);

        return $this->updatedResponse($sequencia->fresh());
    }

    /**
     * Gerar próximo número de uma sequência
     */
    public function proximoNumero(string $dominoCodigo, int|null $ano = null): JsonResponse
    {
        $this->authorize('PERMITIR_SEQUENCIA_GERAR');

        $numero = $this->sequenciaService->proximoNumero($dominoCodigo, $ano);

        return $this->successResponse([
            'dominio_codigo' => $dominoCodigo,
            'numero_gerado' => $numero,
            'ano' => $ano ?? now()->year
        ], [
            'message' => 'Número gerado com sucesso.'
        ]);
    }

    /**
     * Resetar sequência (cuidado!)
     */
    public function reset(Request $request, string $dominoCodigo, int|null $ano = null): JsonResponse
    {
        $this->authorize('PERMITIR_SEQUENCIA_RESETAR');

        $ano = $ano ?? now()->year;
        $novoNumero = $request->get('numero_atual', 0);

        $sucesso = $this->sequenciaService->resetarSequencia($dominoCodigo, $ano, $novoNumero);

        if (!$sucesso) {
            return $this->notFoundResponse('Sequência não encontrada.');
        }

        Log::warning('Sequência resetada', [
            'dominio_codigo' => $dominoCodigo,
            'ano' => $ano,
            'novo_numero' => $novoNumero,
            'user_id' => auth()->id()
        ]);

        return $this->successResponse(null, [
            'message' => 'Sequência resetada com sucesso.'
        ]);
    }

    /**
     * Obter configurações padrão disponíveis
     */
    public function configuracoesPadrao(): JsonResponse
    {
        $configuracoes = Sequencia::configuracoesPadrao();

        return $this->successResponse([
            'configuracoes_padrao' => $configuracoes,
            'opcoes_formato' => [
                'placeholders' => [
                    '{prefixo}' => 'Prefixo configurado',
                    '{numero}' => 'Número sequencial',
                    '{sufixo}' => 'Sufixo configurado',
                    '{ano}' => 'Ano atual'
                ],
                'exemplos' => [
                    '{prefixo}{numero}{sufixo}' => 'PROT-0001/2025',
                    '{numero}/{ano}' => '1/2025',
                    'DOC-{numero}' => 'DOC-1'
                ]
            ]
        ]);
    }

    /**
     * Verificar sequências que precisam renovação
     */
    public function verificarRenovacoes(): JsonResponse
    {
        $this->authorize('PERMITIR_SEQUENCIA_VISUALIZAR');

        $sequenciasParaRenovar = $this->sequenciaService->verificarSequenciasParaRenovar();

        return $this->successResponse($sequenciasParaRenovar, [
            'total_para_renovar' => count($sequenciasParaRenovar)
        ]);
    }

    /**
     * Aplicar configurações padrão para um domínio
     */
    public function aplicarPadrao(string $dominoCodigo, int|null $ano = null): JsonResponse
    {
        $this->authorize('PERMITIR_SEQUENCIA_CRIAR');

        $ano = $ano ?? now()->year;

        // Buscar ou criar sequência
        $sequencia = Sequencia::firstOrCreate([
            'dominio_codigo' => $dominoCodigo,
            'ano' => $ano
        ], [
            'numero_atual' => 0,
            'is_ativo' => true,
            'reinicia_ano' => true,
            'inicio_contagem' => 1,
        ]);

        // Aplicar configurações padrão
        $sequencia->aplicarConfiguracoesPadrao();

        Log::info('Configurações padrão aplicadas', [
            'dominio_codigo' => $dominoCodigo,
            'ano' => $ano,
            'user_id' => auth()->id()
        ]);

        return $this->successResponse($sequencia->fresh(), [
            'message' => 'Configurações padrão aplicadas com sucesso.'
        ]);
    }

    /**
     * Validar dados da sequência
     */
    private function validateSequencia(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'prefixo' => 'nullable|string|max:20',
            'sufixo' => 'nullable|string|max:20',
            'formato' => 'nullable|string|max:100',
            'tamanho_numero' => 'nullable|integer|min:0|max:10',
            'apenas_numero' => 'sometimes|boolean',
            'reinicia_ano' => 'sometimes|boolean',
            'inicio_contagem' => 'nullable|integer|min:1',
            'numero_atual' => 'nullable|integer|min:0',
            'is_ativo' => 'sometimes|boolean',
        ];

        if (!$isUpdate) {
            $rules['dominio_codigo'] = [
                'required',
                'string',
                'exists:dominio,codigo'
            ];
            $rules['ano'] = 'nullable|integer|min:2020|max:2099';
        }

        return $request->validate($rules, [
            'dominio_codigo.required' => 'O código do domínio é obrigatório.',
            'dominio_codigo.exists' => 'Domínio não encontrado.',
            'tamanho_numero.max' => 'Tamanho do número não pode ser maior que 10.',
            'inicio_contagem.min' => 'Início da contagem deve ser pelo menos 1.',
            'ano.min' => 'Ano deve ser pelo menos 2020.',
            'ano.max' => 'Ano não pode ser maior que 2099.',
        ]);
    }

    /**
     * Get user permissions for SEQUENCIA module.
     */
    private function getUserModulePermissions(): array
    {
        $user = auth()->user();

        return [
            'pode_visualizar' => $user->can('PERMITIR_SEQUENCIA_VISUALIZAR'),
            'pode_criar' => $user->can('PERMITIR_SEQUENCIA_CRIAR'),
            'pode_editar' => $user->can('PERMITIR_SEQUENCIA_EDITAR'),
            'pode_gerar' => $user->can('PERMITIR_SEQUENCIA_GERAR'),
            'pode_resetar' => $user->can('PERMITIR_SEQUENCIA_RESETAR'),
        ];
    }
}
