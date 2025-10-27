<?php

namespace App\Services\Doi;

use App\Models\Configuracao;
use App\Models\Doi;
use App\Services\Doi\DoiTokenService;
use App\Services\Doi\DoiBatchService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DoiImportacaoService
{
    private $callback;
    private $logCallback;

    public function __construct(
        private DoiTokenService $tokenService,
        private DoiBatchService $batchService
    ) {}

    /**
     * Define callback para receber logs em tempo real (útil para progress no frontend)
     */
    public function setLogCallback(callable $callback): self
    {
        $this->logCallback = $callback;
        return $this;
    }

    /**
     * Define callback para progresso (útil para websockets, etc)
     */
    public function setProgressCallback(callable $callback): self
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * Método principal para importar DOIs do site da Receita
     */
    public function importarSiteReceita(array $opcoes = []): array
    {
        $pageSize = $opcoes['page_size'] ?? 1000;
        $anos = $opcoes['anos'] ?? 5;
        $batchSize = $opcoes['batch_size'] ?? 1000;
        $porMes = $opcoes['por_mes'] ?? true;
        $dryRun = $opcoes['dry_run'] ?? false;

        $this->log('info', '🔍 Iniciando a importação de DOIs do site da Receita Federal...');

        if ($dryRun) {
            $this->log('warning', '🧪 MODO DRY-RUN ATIVADO - Nenhum job será disparado');
        }

        // Verificar token
        if (!$this->verificarToken()) {
            throw new \Exception('Token DOI inválido! Atualize o token DOI antes de continuar.');
        }

        try {
            $inicioProcessamento = now();

            if ($porMes) {
                $totalImportados = $this->importarPorMes($pageSize, $anos, $batchSize, $dryRun);
            } else {
                $totalImportados = $this->importarTodosPeriodo($pageSize, $anos, $batchSize, $dryRun);
            }

            $tempoProcessamento = $inicioProcessamento->diffInMinutes(now());

            $this->log('success', "✅ Importação concluída! Total de DOIs processados: {$totalImportados}");

            return [
                'sucesso' => true,
                'total_importados' => $totalImportados,
                'tempo_processamento_minutos' => $tempoProcessamento,
                'inicio' => $inicioProcessamento->format('d/m/Y H:i:s'),
                'fim' => now()->format('d/m/Y H:i:s'),
                'opcoes_utilizadas' => $opcoes,
                'mensagem' => "Importação concluída com sucesso! {$totalImportados} DOIs processados em {$tempoProcessamento} minutos."
            ];
        } catch (\Exception $e) {
            $this->log('error', '❌ Erro ao executar importação: ' . $e->getMessage());

            Log::error('Erro na importação DOI via service', [
                'erro' => $e->getMessage(),
                'opcoes' => $opcoes,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'sucesso' => false,
                'erro' => $e->getMessage(),
                'total_importados' => 0,
                'opcoes_utilizadas' => $opcoes
            ];
        }
    }

    /**
     * Importa DOIs mês a mês
     */
    private function importarPorMes(int $pageSize, int $anos, int $batchSize, bool $dryRun): int
    {
        $totalGeral = 0;
        $meses = $this->gerarListaMeses($anos);

        $this->log('info', "📅 Processando " . count($meses) . " meses dos últimos {$anos} anos...");

        foreach ($meses as $indice => $periodo) {
            try {
                $this->log('info', "📆 Processando: {$periodo['nome']} ({$periodo['inicio']} até {$periodo['fim']})");

                // Callback de progresso
                $this->notificarProgresso([
                    'tipo' => 'mes_iniciado',
                    'periodo' => $periodo['nome'],
                    'progresso' => round(($indice / count($meses)) * 100, 2),
                    'mes_atual' => $indice + 1,
                    'total_meses' => count($meses)
                ]);

                $totalMes = $this->importarDOIWebReceita(
                    pageSize: $pageSize,
                    dataCriacaoInicio: $periodo['inicio'],
                    dataCriacaoFim: $periodo['fim'],
                    batchSize: $batchSize,
                    dryRun: $dryRun,
                    nomePeriodo: $periodo['nome']
                );

                $totalGeral += $totalMes;
                $this->log('success', "✅ {$periodo['nome']}: {$totalMes} DOIs processados");

                // Callback de progresso
                $this->notificarProgresso([
                    'tipo' => 'mes_concluido',
                    'periodo' => $periodo['nome'],
                    'dois_processados' => $totalMes,
                    'total_geral' => $totalGeral
                ]);

                // Pequena pausa entre meses para não sobrecarregar
                if (!$dryRun && $totalMes > 0) {
                    sleep(2);
                }
            } catch (\Exception $e) {
                $this->log('error', "❌ Erro no período {$periodo['nome']}: " . $e->getMessage());

                // Se erro de token, parar tudo
                if (str_contains($e->getMessage(), '401') || str_contains($e->getMessage(), 'Token')) {
                    $this->log('error', '🔐 Erro de token - Parando importação');
                    throw $e;
                }

                // Para outros erros, continuar com próximo mês
                $this->log('warning', "⚠️ Continuando com próximo período...");
            }
        }

        return $totalGeral;
    }

    /**
     * Importa todo o período de uma vez
     */
    private function importarTodosPeriodo(int $pageSize, int $anos, int $batchSize, bool $dryRun): int
    {
        return $this->importarDOIWebReceita(
            pageSize: $pageSize,
            dataCriacaoInicio: date('Y-m-d', strtotime("-{$anos} years")),
            dataCriacaoFim: date('Y-m-d'),
            batchSize: $batchSize,
            dryRun: $dryRun,
            nomePeriodo: "Últimos {$anos} anos"
        );
    }

    /**
     * Lógica principal de importação da API
     */
    private function importarDOIWebReceita(
        int $pageSize = 100,
        string $dataCriacaoInicio = '',
        string $dataCriacaoFim = '',
        int $batchSize = 1000,
        bool $dryRun = false,
        string $nomePeriodo = ''
    ): int {
        $totalProcessados = 0;
        $currentPage = 0;
        $batchBuffer = [];
        $batchNumber = 1;
        $totalElementosAPI = null;
        $inicioImportacao = now();

        do {
            try {
                $url = $this->construirUrl($currentPage, $pageSize, $dataCriacaoInicio, $dataCriacaoFim);

                $this->log('info', "📄 Buscando página {$currentPage} (tamanho: {$pageSize})...");

                $resposta = $this->fazerRequisicao($url);

                if (!isset($resposta['content']) || !is_array($resposta['content'])) {
                    $this->log('warning', '⚠️ Resposta sem conteúdo válido na página ' . $currentPage);
                    break;
                }

                $totalPaginas = $resposta['totalPages'] ?? 0;
                $paginaAtual = $resposta['number'] ?? $currentPage;
                $totalElementosAPI = $resposta['totalElements'] ?? null;
                $elementosNaPagina = count($resposta['content']);
                $conteudo = $resposta['content'];

                $this->log('info', "📊 Página {$paginaAtual}/{$totalPaginas} - {$elementosNaPagina} elementos nesta página" .
                    ($totalElementosAPI ? " (Total API: {$totalElementosAPI})" : ""));

                // Notificar progresso da página
                $this->notificarProgresso([
                    'tipo' => 'pagina_processada',
                    'pagina_atual' => $paginaAtual,
                    'total_paginas' => $totalPaginas,
                    'elementos_pagina' => $elementosNaPagina,
                    'total_processados' => $totalProcessados
                ]);

                if (empty($conteudo)) {
                    $this->log('info', '📭 Nenhum DOI encontrado nesta página');
                    break;
                }

                // Adicionar DOIs ao buffer
                foreach ($conteudo as $doi) {
                    $batchBuffer[] = $doi;
                    $totalProcessados++;

                    // Quando buffer atingir o tamanho do batch, processar
                    if (count($batchBuffer) >= $batchSize) {
                        $this->processarBatch($batchBuffer, $batchNumber, $dryRun, $nomePeriodo);
                        $batchBuffer = [];
                        $batchNumber++;
                    }
                }

                // Verificar se há mais páginas
                if ($paginaAtual >= $totalPaginas - 1) {
                    $this->log('info', '📄 Última página processada');
                    break;
                }

                $currentPage++;

                // Delay entre requisições
                if ($currentPage % 10 === 0) {
                    $this->log('info', '⏳ Aguardando 2 segundos...');
                    sleep(2);
                }
            } catch (\Exception $e) {
                $this->log('error', "❌ Erro na página {$currentPage}: " . $e->getMessage());

                // Se erro for de autenticação, parar tudo
                if (str_contains($e->getMessage(), '401') || str_contains($e->getMessage(), 'Unauthorized')) {
                    $this->log('error', '🔐 Erro de autenticação - Token expirado!');
                    throw $e;
                }

                // Para outros erros, tentar próxima página após delay
                $this->log('info', '⏳ Aguardando 5 segundos antes de continuar...');
                sleep(5);
                $currentPage++;
            }
        } while (true);

        // Processar DOIs restantes no buffer
        if (!empty($batchBuffer)) {
            $this->processarBatch($batchBuffer, $batchNumber, $dryRun, $nomePeriodo);
        }

        // Deduplicação global
        if (!$dryRun && $totalProcessados > 0) {
            $this->log('info', "🧹 Verificando duplicações por sobreposição de páginas...");

            $doisUnicos = Doi::where('data_importacao', '>=', $inicioImportacao)
                ->distinct('numero_controle')
                ->count();

            $this->log('info', "📊 DOIs únicos no banco: {$doisUnicos} | Processados: {$totalProcessados}");

            if ($doisUnicos < $totalProcessados) {
                $diferenca = $totalProcessados - $doisUnicos;
                $this->log('warning', "⚠️ {$diferenca} DOIs duplicados detectados (problema de paginação da API)");
            }
        }

        // Log final com comparação
        $this->log('info', "🔢 Contagem final: {$totalProcessados} DOIs processados");

        if ($totalElementosAPI !== null) {
            $this->log('info', "📊 Total informado pela API: {$totalElementosAPI}");

            $diferenca = $totalProcessados - $totalElementosAPI;
            if ($diferenca != 0) {
                $emoji = $diferenca > 0 ? '⬆️' : '⬇️';
                $this->log('warning', "{$emoji} Diferença: {$diferenca} DOIs");
            } else {
                $this->log('success', "✅ Contagens coincidem!");
            }
        }

        return $totalProcessados;
    }

    private function processarBatch(array $dois, int $batchNumber, bool $dryRun, string $nomePeriodo = ''): void
    {
        $prefixo = $nomePeriodo ? "{$nomePeriodo} - " : "";
        $nomeBatch = "{$prefixo}Batch #{$batchNumber} - " . now()->format('d/m H:i');

        if ($dryRun) {
            $this->log('info', "🧪 [DRY-RUN] {$nomeBatch} com " . count($dois) . " DOIs");
            return;
        }

        try {
            $batch = $this->batchService->importarLote($dois, $nomeBatch);

            $this->log('success', "🚀 {$nomeBatch} criado com " . count($dois) . " DOIs (ID: " . substr($batch->id, 0, 8) . "...)");

            // Notificar progresso do batch
            $this->notificarProgresso([
                'tipo' => 'batch_criado',
                'batch_number' => $batchNumber,
                'batch_id' => $batch->id,
                'dois_count' => count($dois),
                'nome_batch' => $nomeBatch
            ]);
        } catch (\Exception $e) {
            $this->log('error', "❌ Erro ao criar {$nomeBatch}: " . $e->getMessage());

            Log::error('Erro ao criar batch DOI via service', [
                'batch_number' => $batchNumber,
                'periodo' => $nomePeriodo,
                'dois_count' => count($dois),
                'erro' => $e->getMessage()
            ]);
        }
    }

    private function gerarListaMeses(int $anos): array
    {
        $meses = [];
        $dataAtual = now();

        for ($i = 0; $i < ($anos * 12); $i++) {
            $mesReferencia = $dataAtual->copy()->subMonths($i);

            $inicioMes = $mesReferencia->startOfMonth()->format('Y-m-d');
            $fimMes = $mesReferencia->endOfMonth()->format('Y-m-d');

            // Se o mês atual, usar até hoje
            if ($i === 0) {
                $fimMes = $dataAtual->format('Y-m-d');
            }

            $meses[] = [
                'inicio' => $inicioMes,
                'fim' => $fimMes,
                'nome' => $mesReferencia->locale('pt_BR')->isoFormat('MMMM/YYYY'),
                'mes_ano' => $mesReferencia->format('Y-m')
            ];
        }

        return array_reverse($meses);
    }

    private function fazerRequisicao(string $url): array
    {
        $cookie = Configuracao::query()
            ->where('chave', '=', 'CONFIG_DOI_WEB_COOKIE')
            ->value('valor');


        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'accept' => 'application/json',
            'cookie' => $cookie,
            'priority' => 'u=1, i',
            'referer' => 'https://doi.rfb.gov.br/',
            'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36'
        ])
            ->timeout(30)
            ->retry(2, 1000)
            ->get($url);

        if ($response->status() === 401) {
            throw new \Exception('Token DOI inválido ou expirado - Status: 401');
        }

        return $response->throw()->json();
    }

    private function construirUrl(int $currentPage, int $pageSize, string $dataCriacaoInicio, string $dataCriacaoFim): string
    {
        $parametros = [
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
            'dataCriacaoInicio' => $dataCriacaoInicio,
            'dataCriacaoFim' => $dataCriacaoFim,
            'situacaoEntregue' => 'true'
        ];

        return 'https://doi.rfb.gov.br/api/declaracoes?' . http_build_query($parametros);
    }

    private function verificarToken(): bool
    {
        $url = 'https://doi.rfb.gov.br/api/auth/me';
        try {
            $cookie = Configuracao::query()
                ->where('chave', '=', 'CONFIG_DOI_WEB_COOKIE')
                ->value('valor');

            $response = Http::withHeaders([
                'cookie' => $cookie,
                'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36'
            ])
                ->timeout(10)
                ->get('https://doi.rfb.gov.br/api/declaracoes?pageSize=1&currentPage=0');

            $valido = $response->successful();

            if ($valido) {
                $this->log('success', '✅ Token válido!');
            } else {
                $this->log('error', '❌ Token inválido (Status: ' . $response->status() . ')');
            }

            return $valido;
        } catch (\Exception $e) {
            $this->log('error', '❌ Erro ao verificar token: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Sistema de log interno
     */
    private function log(string $tipo, string $mensagem): void
    {
        if ($this->logCallback) {
            call_user_func($this->logCallback, $tipo, $mensagem);
        }

        // Log padrão do Laravel também
        match ($tipo) {
            'error' => Log::error($mensagem),
            'warning' => Log::warning($mensagem),
            'success', 'info' => Log::info($mensagem),
            default => Log::debug($mensagem)
        };
    }

    /**
     * Notificar progresso
     */
    private function notificarProgresso(array $dados): void
    {
        if ($this->callback) {
            call_user_func($this->callback, $dados);
        }
    }

    /**
     * Obter estatísticas da última importação
     */
    public function obterEstatisticasImportacao(): array
    {
        $ultimaImportacao = Doi::query()->latest('data_importacao')->first();

        if (!$ultimaImportacao) {
            return [
                'ultima_importacao' => null,
                'total_dois' => 0,
                'dois_hoje' => 0,
                'dois_semana' => 0,
                'status_mais_comum' => null
            ];
        }

        return [
            'ultima_importacao' => $ultimaImportacao->data_importacao,
            'total_dois' => Doi::count(),
            'dois_hoje' => Doi::whereDate('data_importacao', today())->count(),
            'dois_semana' => Doi::where('data_importacao', '>=', now()->subWeek())->count(),
            'status_mais_comum' => Doi::select('status_processamento')
                ->groupBy('status_processamento')
                ->orderByRaw('COUNT(*) DESC')
                ->value('status_processamento')
        ];
    }
}
