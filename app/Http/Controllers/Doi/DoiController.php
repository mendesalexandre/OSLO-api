<?php

namespace App\Http\Controllers\Doi;

use App\Models\Doi;
use App\Exports\DoiExport;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\Doi\DoiResource;
use App\Services\Doi\DoiImportacaoService;

class DoiController extends Controller
{
    public function index(Request $request)
    {
        $query = Doi::with(['alienantes', 'adquirentes', 'transmitentes']);

        // Filtro por status
        if ($request->has('status_processamento')) {
            $query->where('status_processamento', $request->status_processamento);
        }

        // Filtro por período
        if ($request->has('data_inicio') && $request->has('data_fim')) {
            $query->whereBetween('data_ato', [$request->data_inicio, $request->data_fim]);
        }

        // Filtro por matrícula
        if ($request->has('matricula')) {
            $query->where('matricula', 'like', '%' . $request->matricula . '%');
        }

        // Filtro por número de controle
        if ($request->has('numero_controle')) {
            $query->where('numero_controle', 'like', '%' . $request->numero_controle . '%');
        }

        // Apenas DOIs do usuário (se não for admin)
        // if (!Auth::user()->can('visualizar_todas_dois')) {
        //     $query->where('usuario_id', Auth::id());
        // }

        $dois = $query->orderBy('data_ato', 'desc')
            ->paginate($request->get('per_page', 1500));

        // return DoiResource::collection($dois);
        return response()->json($dois);
    }

    /**
     * Criar nova DOI
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_controle' => 'required|string|unique:dois',
            'matricula' => 'required|string',
            'data_ato' => 'required|date',
            'tipo_ato' => 'required|string',
            'valor_transacao' => 'required|numeric|min:0',
            // Adicione outras validações conforme necessário
        ]);

        DB::beginTransaction();

        try {
            $doi = Doi::create([
                'usuario_id' => Auth::id(),
                'numero_controle' => $request->numero_controle,
                'matricula' => $request->matricula,
                'data_ato' => $request->data_ato,
                'tipo_ato' => $request->tipo_ato,
                'valor_transacao' => $request->valor_transacao,
                'status_processamento' => 'pendente',
                // Adicione outros campos conforme necessário
            ]);

            // Salvar alienantes, adquirentes, transmitentes se fornecidos
            if ($request->has('alienantes')) {
                $this->salvarPessoas($doi, 'alienantes', $request->alienantes);
            }

            if ($request->has('adquirentes')) {
                $this->salvarPessoas($doi, 'adquirentes', $request->adquirentes);
            }

            if ($request->has('transmitentes')) {
                $this->salvarPessoas($doi, 'transmitentes', $request->transmitentes);
            }

            DB::commit();

            return new DoiResource($doi->load(['alienantes', 'adquirentes', 'transmitentes']));
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Erro ao criar DOI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibir DOI específica
     */
    public function show($id)
    {
        $doi = Doi::with(['alienantes', 'adquirentes', 'transmitentes'])
            ->findOrFail($id);

        // Verificar permissão
        // if ($doi->usuario_id !== Auth::id() && !Auth::user()->can('visualizar_todas_dois')) {
        //     abort(403, 'Não autorizado a visualizar esta DOI');
        // }

        return new DoiResource($doi);
    }

    /**
     * Atualizar DOI
     */
    public function update(Request $request, $id)
    {
        $doi = Doi::findOrFail($id);

        // Verificar permissão
        // if ($doi->usuario_id !== Auth::id() && !Auth::user()->can('editar_todas_dois')) {
        //     abort(403, 'Não autorizado a editar esta DOI');
        // }

        // Não permitir edição se já está em lote
        if ($doi->lote_doi_id) {
            return response()->json([
                'error' => 'Não é possível editar DOI que já está em lote'
            ], 422);
        }

        $request->validate([
            'numero_controle' => 'sometimes|string|unique:dois,numero_controle,' . $id,
            'matricula' => 'sometimes|string',
            'data_ato' => 'sometimes|date',
            'tipo_ato' => 'sometimes|string',
            'valor_transacao' => 'sometimes|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $doi->update($request->only([
                'numero_controle',
                'matricula',
                'data_ato',
                'tipo_ato',
                'valor_transacao'
            ]));

            // Atualizar pessoas se fornecidas
            if ($request->has('alienantes')) {
                $doi->alienantes()->delete();
                $this->salvarPessoas($doi, 'alienantes', $request->alienantes);
            }

            if ($request->has('adquirentes')) {
                $doi->adquirentes()->delete();
                $this->salvarPessoas($doi, 'adquirentes', $request->adquirentes);
            }

            if ($request->has('transmitentes')) {
                $doi->transmitentes()->delete();
                $this->salvarPessoas($doi, 'transmitentes', $request->transmitentes);
            }

            DB::commit();

            return new DoiResource($doi->load(['alienantes', 'adquirentes', 'transmitentes']));
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Erro ao atualizar DOI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Excluir DOI
     */
    public function destroy($id)
    {
        $doi = Doi::findOrFail($id);

        // // Verificar permissão
        // if ($doi->usuario_id !== Auth::id() && !Auth::user()->can('excluir_todas_dois')) {
        //     abort(403, 'Não autorizado a excluir esta DOI');
        // }

        // Não permitir exclusão se já está em lote
        if ($doi->lote_doi_id) {
            return response()->json([
                'error' => 'Não é possível excluir DOI que já está em lote'
            ], 422);
        }

        try {
            $doi->delete();

            return response()->json([
                'message' => 'DOI excluída com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao excluir DOI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * DOIs disponíveis para lote
     */
    public function disponiveis()
    {
        $dois = Doi::where('status_processamento', 'concluido')
            ->whereNull('lote_doi_id')
            ->orderBy('numero_controle')
            ->get(['id', 'numero_controle', 'matricula', 'data_ato']);

        return response()->json($dois);
    }

    /**
     * Validar DOI
     */
    public function validar(Request $request)
    {
        $request->validate([
            'numero_controle' => 'required|string',
            'matricula' => 'required|string',
            'data_ato' => 'required|date',
            'valor_transacao' => 'required|numeric|min:0',
        ]);

        $erros = [];

        // Verificar se número de controle já existe
        if (Doi::where('numero_controle', $request->numero_controle)->exists()) {
            $erros[] = 'Número de controle já existe';
        }

        // Validações específicas do seu negócio
        if ($request->valor_transacao <= 0) {
            $erros[] = 'Valor da transação deve ser maior que zero';
        }

        if (strtotime($request->data_ato) > time()) {
            $erros[] = 'Data do ato não pode ser futura';
        }

        return response()->json([
            'valida' => empty($erros),
            'erros' => $erros
        ]);
    }

    /**
     * Reprocessar DOI com erro
     */
    public function reprocessar($id)
    {
        $doi = Doi::findOrFail($id);

        // Verificar se pode reprocessar
        if ($doi->status_processamento !== 'erro') {
            return response()->json([
                'error' => 'Apenas DOIs com erro podem ser reprocessadas'
            ], 422);
        }

        try {
            $doi->update([
                'status_processamento' => 'em_processamento',
                'data_reprocessamento' => now()
            ]);

            // Aqui você colocaria a lógica de reprocessamento
            // Por exemplo, disparar um job para processar novamente

            return response()->json([
                'message' => 'DOI enviada para reprocessamento',
                'doi' => new DoiResource($doi)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao reprocessar DOI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Imprimir DOI individual
     */
    public function imprimir($id)
    {
        $doi = Doi::with(['alienantes', 'adquirentes', 'transmitentes'])
            ->findOrFail($id);

        // Verificar permissão
        if ($doi->usuario_id !== Auth::id() && !Auth::user()->can('imprimir_dois')) {
            abort(403, 'Não autorizado a imprimir esta DOI');
        }

        try {
            $pdf = Pdf::loadView('dois.individual', compact('doi'));

            return $pdf->download("doi_{$doi->numero_controle}.pdf");
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao gerar PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar DOIs para Excel
     */
    public function exportarExcel(Request $request)
    {
        try {
            $filtros = $request->only([
                'status_processamento',
                'data_inicio',
                'data_fim',
                'matricula',
                'numero_controle'
            ]);

            return Excel::download(
                new DoiExport($filtros),
                'dois_' . date('Y-m-d_H-i-s') . '.xlsx'
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao exportar Excel: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método auxiliar para salvar pessoas relacionadas
     */
    private function salvarPessoas($doi, $tipo, $pessoas)
    {
        foreach ($pessoas as $pessoa) {
            $doi->{$tipo}()->create([
                'nome' => $pessoa['nome'],
                'cpf_cnpj' => $pessoa['cpf_cnpj'] ?? null,
                'tipo_pessoa' => $pessoa['tipo_pessoa'] ?? 'fisica',
                // Adicione outros campos conforme necessário
            ]);
        }
    }
    /**
     * Importar DOIs do site da Receita Federal
     */
    public function importarSiteReceita(Request $request)
    {
        $request->validate([
            'page_size' => 'integer|min:1|max:5000',
            'anos' => 'integer|min:1|max:10',
            'batch_size' => 'integer|min:100|max:5000',
            'por_mes' => 'boolean',
            'dry_run' => 'boolean'
        ]);

        try {
            $importacaoService = app(DoiImportacaoService::class);

            // Configurar callback para logs em tempo real (opcional)
            $logs = [];
            $importacaoService->setLogCallback(function ($tipo, $mensagem) use (&$logs) {
                $logs[] = [
                    'tipo' => $tipo,
                    'mensagem' => $mensagem,
                    'timestamp' => now()->format('H:i:s')
                ];
            });

            // Configurar callback para progresso (pode ser usado com websockets)
            $progressos = [];
            $importacaoService->setProgressCallback(function ($dados) use (&$progressos) {
                $progressos[] = $dados;
            });

            $resultado = $importacaoService->importarSiteReceita([
                'page_size' => $request->get('page_size', 1000),
                'anos' => $request->get('anos', 5),
                'batch_size' => $request->get('batch_size', 1000),
                'por_mes' => $request->get('por_mes', true),
                'dry_run' => $request->get('dry_run', false)
            ]);

            if ($resultado['sucesso']) {
                return response()->json([
                    'success' => true,
                    'message' => $resultado['mensagem'],
                    'data' => [
                        'total_importados' => $resultado['total_importados'],
                        'tempo_processamento_minutos' => $resultado['tempo_processamento_minutos'],
                        'inicio' => $resultado['inicio'],
                        'fim' => $resultado['fim'],
                        'opcoes_utilizadas' => $resultado['opcoes_utilizadas'],
                        'logs' => $logs,
                        'progressos' => $progressos
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $resultado['erro'],
                'data' => [
                    'opcoes_utilizadas' => $resultado['opcoes_utilizadas'],
                    'logs' => $logs
                ]
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno ao processar importação: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Importar DOIs de forma assíncrona (com Job)
     */
    public function importarSiteReceitaAsync(Request $request)
    {
        $request->validate([
            'page_size' => 'integer|min:1|max:5000',
            'anos' => 'integer|min:1|max:10',
            'batch_size' => 'integer|min:100|max:5000',
            'por_mes' => 'boolean',
            'dry_run' => 'boolean'
        ]);

        try {
            // Dispatch job para processamento em background
            \App\Jobs\ImportarDoiJob::dispatch(
                $request->only(['page_size', 'anos', 'batch_size', 'por_mes', 'dry_run']),
                Auth::id()
            );

            return response()->json([
                'success' => true,
                'message' => 'Importação iniciada em background. Você receberá uma notificação quando concluída.',
                'data' => [
                    'opcoes_enviadas' => $request->only(['page_size', 'anos', 'batch_size', 'por_mes', 'dry_run']),
                    'usuario_id' => Auth::id(),
                    'iniciado_em' => now()->format('d/m/Y H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao iniciar importação em background: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obter estatísticas da importação
     */
    public function estatisticasImportacao()
    {
        try {
            $importacaoService = app(DoiImportacaoService::class);
            $estatisticas = $importacaoService->obterEstatisticasImportacao();

            return response()->json([
                'success' => true,
                'data' => $estatisticas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter estatísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verificar se o token DOI está válido
     */
    public function verificarToken()
    {
        $url = 'https://doi.rfb.gov.br/api/auth/me';
        try {
            $cookie = Configuracao::query()
                ->where('chave', '=', 'CONFIG_DOI_WEB_COOKIE')
                ->value('valor');

            if (!$cookie) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token DOI não configurado',
                    'token_valido' => false
                ]);
            }

            $response = Http::withHeaders([
                'cookie' => $cookie,
                'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36'
            ])
                ->timeout(10)
                ->get($url);

            $valido = $response->successful();

            return response()->json([
                'success' => true,
                'token_valido' => $valido,
                'message' => $valido ? 'Token válido' : 'Token inválido ou expirado',
                'status_code' => $response->status(),
                'dados' => $response->json()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'token_valido' => false,
                'message' => 'Erro ao verificar token: ' . $e->getMessage()
            ]);
        }
    }

    // Mantenha o método sincronizar() que já existia, mas agora implementado
    public function sincronizar()
    {
        // Aqui você pode implementar uma sincronização mais simples
        // ou redirecionar para o método de importação
        return $this->importarSiteReceita(request());
    }
}
