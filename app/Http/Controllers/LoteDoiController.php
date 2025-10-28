<?php

namespace App\Http\Controllers;

use App\Http\Resources\Doi\DoiResource;
use App\Models\Doi;
use App\Models\LoteDoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoteDoiController extends Controller
{
    public function criar(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        DB::beginTransaction();

        try {
            // Buscar DOIs do período que estão completas e não foram enviadas
            $dois = Doi::with(['alienantes', 'adquirentes', 'transmitentes'])
                ->whereBetween('data_ato', [$request->data_inicio, $request->data_fim])
                ->where('status_processamento', 'concluido') // Apenas completas
                ->whereNull('lote_doi_id') // Não enviadas ainda
                ->where('enviado', '=', false) // Não enviadas
                ->orderBy('numero_controle')
                ->get();

            if ($dois->isEmpty()) {
                return response()->json([
                    'error' => 'Nenhuma DOI encontrada para o período informado'
                ], 404);
            }

            // Criar o lote
            $lote = LoteDoi::create([
                'usuario_id' => 1,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'total_doi' => $dois->count(),
                'status' => 'criado',
                'observacao' => "Lote gerado para período de {$request->data_inicio} até {$request->data_fim}"
            ]);

            // Associar DOIs ao lote
            $dois->each(function ($doi) use ($lote) {
                $doi->update([
                    'lote_doi_id' => $lote->id,
                    'data_geracao' => now(),
                ]);
            });

            // Atualizar status do lote
            $lote->update(['status' => 'gerado']);

            DB::commit();

            return response()->json([
                'lote' => $lote,
                'total_dois' => $dois->count(),
                'periodo' => "{$request->data_inicio} até {$request->data_fim}",
                'download_url' => route('lote-doi.download', $lote->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Erro ao criar lote: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download do JSON do lote
     */
    public function download($loteId)
    {
        $lote = LoteDoi::with(['declaracoes.transmitentes', 'declaracoes.adquirentes'])
            ->findOrFail($loteId);

        // Gerar JSON usando o DoiResource
        $declaracoes = DoiResource::collection($lote->declaracoes);

        $jsonData = [
            'declaracoes' => $declaracoes
        ];

        $nomeArquivo = "declaracao_doi_lote_{$lote->id}_" . date('Y-m-d_H-i-s') . ".json";

        return response()->streamDownload(function () use ($jsonData) {
            echo json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $nomeArquivo, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $nomeArquivo . '"'
        ]);
    }


    /**
     * Preview do lote (para mostrar quais DOIs serão incluídas)
     */
    public function preview(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $dois = Doi::whereBetween('data_ato', [$request->data_inicio, $request->data_fim])
            ->where('status_processamento', 'concluido')
            ->whereNull('lote_doi_id')
            ->orderBy('numero_controle')
            ->get(['id', 'numero_controle', 'data_ato', 'matricula', 'status_processamento']);

        $comProblemas = Doi::whereBetween('data_ato', [$request->data_inicio, $request->data_fim])
            ->where(function ($query) {
                $query->where('status_processamento', '!=', 'concluido')
                    ->orWhereNotNull('lote_doi_id');
            })
            ->get(['id', 'numero_controle', 'status_processamento', 'lote_doi_id']);

        $periodo = date('d/m/Y', strtotime($request->data_inicio)) . ' até ' . date('d/m/Y', strtotime($request->data_fim));

        return response()->json([
            'validas' => $dois,
            'total_validas' => $dois->count(),
            'com_problemas' => $comProblemas,
            'total_problemas' => $comProblemas->count(),
            'periodo' => $periodo
        ]);
    }


    /**
     * Marcar lote como enviado
     */
    public function marcarEnviado($loteId)
    {
        $lote = LoteDoi::findOrFail($loteId);

        // Verificar permissão
        // if ($lote->usuario_id !== Auth::id() && !Auth::user()->can('marcarLoteEnviado')) {
        //     abort(403, 'Não autorizado a marcar este lote como enviado');
        // }

        $lote->update([
            'status' => 'enviado',
            'data_envio' => now()
        ]);

        // Atualizar DOIs do lote
        $lote->declaracoes()->update([
            'data_envio' => now(),
            'status_envio_individual' => 'enviado'
        ]);

        return response()->json([
            'message' => 'Lote marcado como enviado com sucesso',
            'lote' => $lote
        ]);
    }

    /**
     * Listar lotes do usuário
     */
    public function listar()
    {
        $lotes = LoteDoi::where('usuario_id', Auth::id())
            ->orderBy('data_cadastro', 'desc')
            ->paginate(20);

        return response()->json($lotes);
    }

    /**
     * Pesquisar lotes com filtros
     */
    public function pesquisar(Request $request)
    {
        $query = LoteDoi::with(['declaracoes:id,lote_doi_id'])
            ->select([
                'id',
                // 'numero',
                'data_envio_iniciado',
                'data_envio_concluido',
                'data_criacao',
                // 'total_doi',
                'status',
                'data_cadastro',
                // 'data_envio',
                'usuario_id'
            ]);

        // Filtro por período
        if ($request->filled('data_inicio')) {
            $query->where('data_inicio', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('data_fim', '<=', $request->data_fim);
        }

        // Filtro por número do lote
        if ($request->filled('numero')) {
            $query->where('numero', 'like', '%' . $request->numero . '%');
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrar apenas lotes do usuário logado (opcional)
        // $query->where('usuario_id', Auth::id());

        $lotes = $query->orderBy('data_cadastro', 'desc')->get();

        // Adicionar campo calculado para total_dois
        $lotes->transform(function ($lote) {
            $lote->total_dois = $lote->total_doi; // Usar o campo existente
            return $lote;
        });

        return response()->json([
            'data' => $lotes,
            'total' => $lotes->count()
        ]);
    }

    /**
     * Obter detalhes completos do lote
     */
    public function detalhes($loteId)
    {
        $lote = LoteDoi::with([
            'declaracoes' => function ($query) {
                $query->select([
                    'id',
                    'lote_doi_id',
                    'numero_controle as numero',
                    'tipo_ato as tipo',
                    'valor_operacao as valor',
                    'data_vencimento',
                    'data_ato',
                    'matricula',
                    'status_processamento'
                ]);
            }
        ])->findOrFail($loteId);

        // Verificar permissão (opcional)
        // if ($lote->usuario_id !== Auth::id() && !Auth::user()->can('visualizar_todos_lotes')) {
        //     abort(403, 'Não autorizado a visualizar este lote');
        // }

        return response()->json([
            'data' => [
                'id' => $lote->id,
                'numero' => $lote->numero ?? "LOTE-{$lote->id}",
                'data_criacao' => $lote->data_cadastro,
                'data_inicio' => $lote->data_inicio,
                'data_fim' => $lote->data_fim,
                'status' => $lote->status,
                'data_envio' => $lote->data_envio,
                'total_dois' => $lote->total_doi,
                'observacao' => $lote->observacao,
                'dois' => $lote->declaracoes->map(function ($doi) {
                    return [
                        'id' => $doi->id,
                        'numero' => $doi->numero,
                        'tipo' => $doi->tipo,
                        'valor' => $doi->valor,
                        'data_vencimento' => $doi->data_vencimento,
                        'data_ato' => $doi->data_ato,
                        'matricula' => $doi->matricula,
                        'status' => $doi->status_processamento
                    ];
                })
            ]
        ]);
    }

    /**
     * Gerar relatório PDF de um lote específico
     */
    public function relatorioPdf($loteId)
    {
        $lote = LoteDoi::with([
            'declaracoes' => function ($query) {
                // Ordenar as declarações pela data do ato (mais antigas primeiro)
                $query->orderBy('data_ato', 'asc')
                    ->orderBy('numero_controle', 'asc'); // Ordenação secundária por número de controle
            },
            'declaracoes.alienantes',
            'declaracoes.adquirentes',
            'declaracoes.transmitentes'
        ])
            ->findOrFail($loteId);

        // Verificar se o lote foi enviado
        if ($lote->status !== 'enviado') {
            return response()->json([
                'error' => 'Relatório disponível apenas para lotes enviados'
            ], 400);
        }

        // DEBUG: Verificar se as declarações estão sendo carregadas
        \Log::info("Gerando relatório para lote {$loteId}:", [
            'total_doi_campo' => $lote->total_doi,
            'declaracoes_carregadas' => $lote->declaracoes->count(),
            'primeira_declaracao_data' => $lote->declaracoes->first() ? $lote->declaracoes->first()->data_ato : null,
            'ultima_declaracao_data' => $lote->declaracoes->last() ? $lote->declaracoes->last()->data_ato : null
        ]);

        // Dados para o relatório
        $dadosRelatorio = [
            'lote' => [
                'id' => $lote->id,
                'numero' => $lote->numero ?? "LOTE-{$lote->id}",
                'periodo' => "{$lote->data_inicio} até {$lote->data_fim}",
                'data_criacao' => $lote->data_cadastro->format('d/m/Y H:i:s'),
                'data_envio' => $lote->data_envio ? $lote->data_envio->format('d/m/Y H:i:s') : null,
                'total_declaracoes' => $lote->total_doi,
                'status' => $lote->status
            ],
            'declaracoes' => $lote->declaracoes->map(function ($doi) {
                return [
                    'numero_controle' => $doi->numero_controle,
                    'tipo_ato' => $doi->tipo_ato,
                    'valor_operacao' => $doi->valor_operacao ?? 0,
                    'data_ato' => $doi->data_ato,
                    'data_ato_formatada' => date('d/m/Y', strtotime($doi->data_ato)), // Data formatada para exibição
                    'matricula' => $doi->matricula,
                    'alienantes' => $doi->alienantes->pluck('nome')->join(', '),
                    'adquirentes' => $doi->adquirentes->pluck('nome')->join(', '),
                ];
            }),
            'estatisticas' => [
                'total_declaracoes' => $lote->declaracoes->count(),
                'valor_total' => $lote->declaracoes->sum('valor_operacao') ?? 0,
                'tipos_ato' => $lote->declaracoes->groupBy('tipo_ato')->map->count(),
                // Adicionar estatística por período
                'por_mes' => $lote->declaracoes->groupBy(function ($doi) {
                    return date('m/Y', strtotime($doi->data_ato));
                })->map->count()->sortKeys(),
            ]
        ];

        // DEBUG: Log dos dados preparados
        \Log::info('Dados preparados para o relatório:', [
            'lote' => $dadosRelatorio['lote'],
            'total_declaracoes_dados' => $dadosRelatorio['declaracoes']->count(),
            'estatisticas' => $dadosRelatorio['estatisticas'],
            'primeira_data_ato' => $dadosRelatorio['declaracoes']->first()['data_ato'] ?? null,
            'ultima_data_ato' => $dadosRelatorio['declaracoes']->last()['data_ato'] ?? null
        ]);

        try {
            // Gerar PDF usando Snappy
            $pdf = \PDF::loadView('relatorios.doi.02_lote-doi', $dadosRelatorio);

            // Configurações do Snappy para melhor qualidade
            $pdf->setOptions([
                'page-size' => 'A4',
                'orientation' => 'Portrait',
                'margin-top' => 10,
                'margin-right' => 10,
                'margin-bottom' => 10,
                'margin-left' => 10,
                'encoding' => 'UTF-8',
                'enable-local-file-access' => true,
                'javascript-delay' => 1000,
                'no-stop-slow-scripts' => true,
                'lowquality' => false,
                'print-media-type' => true
            ]);

            $nomeArquivo = "relatorio_lote_{$lote->id}_" . date('Y-m-d_H-i-s') . ".pdf";

            return $pdf->download($nomeArquivo);
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar PDF do lote:', [
                'lote_id' => $loteId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Erro ao gerar relatório PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método adicional para debug - retorna dados em JSON
    public function debugRelatorioPdf($loteId)
    {
        $lote = LoteDoi::with([
            'declaracoes.alienantes',
            'declaracoes.adquirentes',
            'declaracoes.transmitentes'
        ])->findOrFail($loteId);

        return response()->json([
            'lote_info' => [
                'id' => $lote->id,
                'numero' => $lote->numero,
                'status' => $lote->status,
                'total_doi' => $lote->total_doi,
                'data_inicio' => $lote->data_inicio,
                'data_fim' => $lote->data_fim
            ],
            'declaracoes_info' => [
                'count' => $lote->declaracoes->count(),
                'first_5' => $lote->declaracoes->take(5)->map(function ($doi) {
                    return [
                        'id' => $doi->id,
                        'numero_controle' => $doi->numero_controle,
                        'tipo_ato' => $doi->tipo_ato,
                        'valor_operacao' => $doi->valor_operacao,
                        'lote_doi_id' => $doi->lote_doi_id,
                        'alienantes_count' => $doi->alienantes->count(),
                        'adquirentes_count' => $doi->adquirentes->count()
                    ];
                })
            ],
            'relacionamentos' => [
                'alienantes_loaded' => $lote->declaracoes->first() ? $lote->declaracoes->first()->relationLoaded('alienantes') : false,
                'adquirentes_loaded' => $lote->declaracoes->first() ? $lote->declaracoes->first()->relationLoaded('adquirentes') : false,
                'transmitentes_loaded' => $lote->declaracoes->first() ? $lote->declaracoes->first()->relationLoaded('transmitentes') : false
            ]
        ]);
    }

    /**
     * Gerar relatório PDF geral (múltiplos lotes)
     */
    public function relatorioGeralPdf(Request $request)
    {
        $request->validate([
            'lotes_ids' => 'required|array|min:1',
            'lotes_ids.*' => 'integer|exists:lote_dois,id'
        ]);

        $lotes = LoteDoi::with([
            'declaracoes.alienantes',
            'declaracoes.adquirentes'
        ])
            ->whereIn('id', $request->lotes_ids)
            ->where('status', 'enviado') // Apenas lotes enviados
            ->orderBy('data_cadastro', 'desc')
            ->get();

        if ($lotes->isEmpty()) {
            return response()->json([
                'error' => 'Nenhum lote enviado encontrado para gerar o relatório'
            ], 404);
        }

        // Calcular estatísticas gerais
        $totalDeclaracoes = $lotes->sum('total_doi');
        $valorTotal = $lotes->flatMap->declaracoes->sum('valor_operacao');
        $periodoInicio = $lotes->min('data_inicio');
        $periodoFim = $lotes->max('data_fim');

        $dadosRelatorio = [
            'resumo' => [
                'total_lotes' => $lotes->count(),
                'total_declaracoes' => $totalDeclaracoes,
                'valor_total' => $valorTotal,
                'periodo' => "{$periodoInicio} até {$periodoFim}",
                'data_geracao' => now()->format('d/m/Y H:i:s')
            ],
            'lotes' => $lotes->map(function ($lote) {
                return [
                    'id' => $lote->id,
                    'numero' => $lote->numero ?? "LOTE-{$lote->id}",
                    'periodo' => "{$lote->data_inicio} até {$lote->data_fim}",
                    'total_declaracoes' => $lote->total_doi,
                    'valor_total' => $lote->declaracoes->sum('valor_operacao'),
                    'data_envio' => $lote->data_envio->format('d/m/Y H:i:s'),
                    'declaracoes' => $lote->declaracoes->map(function ($doi) {
                        return [
                            'numero_controle' => $doi->numero_controle,
                            'tipo_ato' => $doi->tipo_ato,
                            'valor_operacao' => $doi->valor_operacao,
                            'data_ato' => $doi->data_ato,
                            'matricula' => $doi->matricula
                        ];
                    })
                ];
            }),
            'estatisticas' => [
                'por_tipo_ato' => $lotes->flatMap->declaracoes->groupBy('tipo_ato')->map->count(),
                'por_mes' => $lotes->flatMap->declaracoes->groupBy(function ($doi) {
                    return date('Y-m', strtotime($doi->data_ato));
                })->map->count(),
                'valores_por_lote' => $lotes->mapWithKeys(function ($lote) {
                    return ["LOTE-{$lote->id}" => $lote->declaracoes->sum('valor_operacao')];
                })
            ]
        ];

        // Gerar PDF
        $pdf = app('dompdf.wrapper')->loadView('relatorios.lote-doi-geral', $dadosRelatorio);

        $dataAtual = date('Y-m-d_H-i-s');
        $nomeArquivo = "relatorio_geral_lotes_{$dataAtual}.pdf";

        return $pdf->download($nomeArquivo);
    }

    /**
     * Obter estatísticas dos lotes
     */
    public function estatisticas()
    {
        // Estatísticas por status
        $estatisticasPorStatus = LoteDoi::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Estatísticas gerais
        $totalLotes = LoteDoi::count();
        $totalDeclaracoes = LoteDoi::sum('total_doi');
        $lotesEnviados = LoteDoi::where('status', 'enviado')->count();
        $lotesPendentes = LoteDoi::where('status', 'criado')->count();

        // Estatísticas dos últimos 30 dias
        $ultimosTrintaDias = LoteDoi::where('data_cadastro', '>=', now()->subDays(30))
            ->selectRaw('DATE(data_cadastro) as data, count(*) as total')
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        // Top 5 usuários que mais criaram lotes
        $topUsuarios = LoteDoi::select('usuario_id', DB::raw('count(*) as total_lotes'))
            ->with('usuario:id,name')
            ->groupBy('usuario_id')
            ->orderByDesc('total_lotes')
            ->limit(5)
            ->get();

        return response()->json([
            'por_status' => [
                'pendente' => $estatisticasPorStatus['criado'] ?? 0,
                'processando' => $estatisticasPorStatus['processando'] ?? 0,
                'enviado' => $estatisticasPorStatus['enviado'] ?? 0,
                'erro' => $estatisticasPorStatus['erro'] ?? 0,
            ],
            'gerais' => [
                'total_lotes' => $totalLotes,
                'total_declaracoes' => $totalDeclaracoes,
                'lotes_enviados' => $lotesEnviados,
                'lotes_pendentes' => $lotesPendentes,
                'percentual_enviados' => $totalLotes > 0 ? round(($lotesEnviados / $totalLotes) * 100, 2) : 0
            ],
            'ultimos_30_dias' => $ultimosTrintaDias,
            'top_usuarios' => $topUsuarios->map(function ($item) {
                return [
                    'usuario' => $item->usuario->name ?? 'Usuário Desconhecido',
                    'total_lotes' => $item->total_lotes
                ];
            })
        ]);
    }

    /**
     * Excluir lote e liberar declarações para nova geração
     */
    public function excluirLote($loteId)
    {
        DB::beginTransaction();

        try {
            $lote = LoteDoi::with('declaracoes')->findOrFail($loteId);

            // Verificar se o lote pode ser excluído (não pode estar enviado)
            if ($lote->status === 'enviado') {
                return response()->json([
                    'error' => 'Não é possível excluir um lote que já foi enviado'
                ], 400);
            }

            // DEBUG: Log da exclusão
            \Log::info("Excluindo lote {$loteId}:", [
                'status_atual' => $lote->status,
                'total_declaracoes' => $lote->declaracoes->count(),
                'total_doi_campo' => $lote->total_doi
            ]);

            // Liberar todas as declarações do lote (remover associação)
            $lote->declaracoes()->update([
                'lote_doi_id' => null,
                'data_geracao' => null,
                'data_envio' => null,
                'status_envio_individual' => null
            ]);

            $totalDeclaracoesLiberadas = $lote->declaracoes->count();

            // Excluir o lote
            $lote->delete();

            DB::commit();

            return response()->json([
                'message' => 'Lote excluído com sucesso',
                'declaracoes_liberadas' => $totalDeclaracoesLiberadas,
                'details' => "O lote foi excluído e {$totalDeclaracoesLiberadas} declarações foram liberadas para nova geração de lote."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erro ao excluir lote:', [
                'lote_id' => $loteId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Erro ao excluir lote: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verificar se um lote pode ser excluído
     */
    public function verificarExclusao($loteId)
    {
        $lote = LoteDoi::findOrFail($loteId);

        $podeExcluir = $lote->status !== 'enviado';

        return response()->json([
            'pode_excluir' => $podeExcluir,
            'motivo' => $podeExcluir ? 'Lote pode ser excluído' : 'Lotes enviados não podem ser excluídos',
            'status' => $lote->status,
            'total_declaracoes' => $lote->total_doi
        ]);
    }
}
