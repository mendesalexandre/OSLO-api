<?php

namespace App\Services\Lacuna;

use App\Models\ONRConfiguracao;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Exception;
use Illuminate\Support\Facades\Http;

class Assinador
{
    private const TIMEOUT_ASSINATURA = 900; // 15 minutos
    private const TIMEOUT_COMPLETION = 1800; // 30 minutos
    private const TIMEOUT_CONEXAO = 180; // 3 minutos
    private const MAX_RETRIES = 3;
    private const RETRY_DELAY = 15000; // 15 segundos

    public function __construct(public Certificado $certificado)
    {
        // Validar se certificado está carregado
        if (!$this->certificado->getCertificado()) {
            throw new Exception('Certificado deve estar carregado antes de usar o Assinador');
        }
    }

    /**
     * Iniciar processo de assinatura
     */
    public function iniciarAssinatura(string $caminhoArquivo, string $nomeArquivo = 'documento.pdf'): array
    {
        $this->validarArquivo($caminhoArquivo);

        try {
            $chavePublica = $this->certificado->extrairCertificadoPublicoBase64();
            $conteudoArquivo = file_get_contents($caminhoArquivo);
            $tamanhoArquivo = filesize($caminhoArquivo);

            Log::info('Iniciando assinatura', [
                'arquivo' => $nomeArquivo,
                'tamanho' => $this->formatBytes($tamanhoArquivo),
                'certificado_id' => $this->certificado->getCertificado()->id
            ]);

            $response = $this->fazerRequisicaoInicial($conteudoArquivo, $nomeArquivo, $tamanhoArquivo, $chavePublica);

            return $this->processarRespostaInicial($response);
        } catch (Exception $e) {
            Log::error('Erro ao iniciar assinatura', [
                'arquivo' => $nomeArquivo,
                'erro' => $e->getMessage(),
                'certificado_id' => $this->certificado->getCertificado()->id
            ]);
            throw new Exception('Erro ao iniciar assinatura: ' . $e->getMessage());
        }
    }

    /**
     * Completar processo de assinatura
     */
    public function completarAssinatura(string $state, string $signature): array
    {
        try {
            Log::info('Completando assinatura', [
                'state' => substr($state, 0, 50) . '...', // Log parcial por segurança
                'certificado_id' => $this->certificado->getCertificado()->id
            ]);

            $response = $this->fazerRequisicaoCompletion($state, $signature);

            return $this->processarRespostaCompletion($response);
        } catch (Exception $e) {
            Log::error('Erro ao completar assinatura', [
                'state' => substr($state, 0, 50) . '...',
                'erro' => $e->getMessage(),
                'certificado_id' => $this->certificado->getCertificado()->id
            ]);
            throw new Exception('Erro ao completar assinatura: ' . $e->getMessage());
        }
    }

    /**
     * Assinar documento completo (processo full)
     */
    public function assinar(string $caminhoArquivo, string $nomeArquivo): array
    {
        $inicioProcesso = microtime(true);

        try {
            // 1. Iniciar assinatura
            $resultadoInicial = $this->iniciarAssinatura($caminhoArquivo, $nomeArquivo);

            if (!$resultadoInicial['success']) {
                throw new Exception($resultadoInicial['message'] ?? 'Erro desconhecido ao iniciar assinatura');
            }

            // 2. Assinar com certificado local
            $state = $resultadoInicial['state'];
            $dadosParaAssinar = $resultadoInicial['toSign']['data'];

            $assinaturaFinal = $this->certificado->assinarComCertificado($dadosParaAssinar);

            // 3. Completar assinatura
            $resultadoFinal = $this->completarAssinatura($state, $assinaturaFinal);

            $tempoTotal = round(microtime(true) - $inicioProcesso, 2);

            Log::info('Assinatura concluída com sucesso', [
                'arquivo' => $nomeArquivo,
                'tempo_total' => $tempoTotal . 's',
                'certificado_id' => $this->certificado->getCertificado()->id,
                'url_assinado' => $resultadoFinal['signedFile']['url'] ?? null,
                'dados_assinatura' => $resultadoFinal
            ]);

            return $resultadoFinal;
        } catch (Exception $e) {
            $tempoTotal = round(microtime(true) - $inicioProcesso, 2);

            Log::error('Falha na assinatura', [
                'arquivo' => $nomeArquivo,
                'tempo_ate_erro' => $tempoTotal . 's',
                'erro' => $e->getMessage(),
                'certificado_id' => $this->certificado->getCertificado()->id
            ]);

            throw $e;
        }
    }

    /**
     * Salvar documento assinado e dados de auditoria
     */
    public function salvarDocumentoAssinado(array $dadosAssinatura, string $prefixoPath = ''): string
    {
        if (!isset($dadosAssinatura['signedFile']['url'])) {
            throw new Exception('URL do arquivo assinado não encontrada na resposta');
        }

        $urlAssinado = $dadosAssinatura['signedFile']['url'];
        $nomeArquivo = $dadosAssinatura['signedFile']['name'] ?? 'documento_assinado.pdf';

        // Adicionar timestamp se solicitado
        if ($prefixoPath) {
            $timestamp = now()->format('Y-m-d_H-i-s');
            $nomeArquivo = "{$prefixoPath}_{$timestamp}_{$nomeArquivo}";
        }

        $caminhoPdf = "documentos/assinados/{$nomeArquivo}";
        $caminhoJson = "documentos/auditoria/assinaturas/" . pathinfo($nomeArquivo, PATHINFO_FILENAME) . ".json";

        try {
            // Baixar arquivo assinado
            $response = Http::timeout(300)
                ->withOptions(['verify' => true])
                ->retry(3, 5000)
                ->get($urlAssinado);

            if (!$response->successful()) {
                throw new Exception("Erro ao baixar PDF assinado. Status: {$response->status()}");
            }

            // Salvar PDF
            Storage::disk('local')->put($caminhoPdf, $response->body());

            // Preparar dados de auditoria
            $dadosAuditoria = [
                'assinatura_realizada_em' => now()->toISOString(),
                'certificado_usado' => [
                    'id' => $this->certificado->getCertificado()->id,
                    'titular' => $this->certificado->getCertificado()->titular,
                    'serial' => $this->certificado->getCertificado()->serial,
                ],
                'arquivo_original' => pathinfo($nomeArquivo, PATHINFO_FILENAME),
                'tamanho_assinado' => strlen($response->body()),
                'dados_lacuna' => $dadosAssinatura
            ];

            // Salvar JSON de auditoria
            Storage::disk('local')->put(
                $caminhoJson,
                json_encode($dadosAuditoria, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            Log::info('Documento assinado salvo', [
                'caminho_pdf' => $caminhoPdf,
                'caminho_auditoria' => $caminhoJson,
                'tamanho' => $this->formatBytes(strlen($response->body()))
            ]);

            return $caminhoPdf;
        } catch (Exception $e) {
            Log::error('Erro ao salvar documento assinado', [
                'url' => $urlAssinado,
                'arquivo' => $nomeArquivo,
                'erro' => $e->getMessage()
            ]);
            throw new Exception('Erro ao salvar documento assinado: ' . $e->getMessage());
        }
    }

    /**
     * Verificar se arquivo é válido para assinatura
     */
    private function validarArquivo(string $caminhoArquivo): void
    {
        if (!file_exists($caminhoArquivo)) {
            throw new Exception("Arquivo não encontrado: {$caminhoArquivo}");
        }

        if (!is_readable($caminhoArquivo)) {
            throw new Exception("Arquivo não pode ser lido: {$caminhoArquivo}");
        }

        $tamanho = filesize($caminhoArquivo);
        if ($tamanho === 0) {
            throw new Exception("Arquivo está vazio: {$caminhoArquivo}");
        }

        // Verificar limite de tamanho (50MB)
        if ($tamanho > 50 * 1024 * 1024) {
            throw new Exception("Arquivo muito grande (máximo 50MB): " . $this->formatBytes($tamanho));
        }
    }

    /**
     * Fazer requisição inicial para a Lacuna
     */
    private function fazerRequisicaoInicial(string $conteudo, string $nome, int $tamanho, string $chavePublica): Response
    {
        return Http::withHeaders([
            'X-Api-Key' => ONRConfiguracao::query()->value('chave_assinador_onr_web'),
            'Content-Type' => 'application/json',
        ])
            ->timeout(self::TIMEOUT_ASSINATURA)
            ->connectTimeout(self::TIMEOUT_CONEXAO)
            ->withOptions([
                'verify' => true,
                'stream' => true,
                'curl' => [
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 3,
                    CURLOPT_TCP_KEEPALIVE => 1,
                ]
            ])
            ->retry(self::MAX_RETRIES, self::RETRY_DELAY)
            ->post(config('services.restpki.endpoint') . '/signature', [
                'file' => [
                    'mimeType' => 'application/pdf',
                    'content' => base64_encode($conteudo),
                    'name' => $nome,
                    'length' => $tamanho,
                ],
                'certificate' => [
                    'content' => $chavePublica,
                ],
            ]);
    }

    /**
     * Fazer requisição de completion para a Lacuna
     */
    private function fazerRequisicaoCompletion(string $state, string $signature): Response
    {
        return Http::withHeaders([
            'X-Api-Key' => ONRConfiguracao::query()->value('chave_assinador_onr_web'),
            'Content-Type' => 'application/json',
        ])
            ->timeout(self::TIMEOUT_COMPLETION)
            ->connectTimeout(self::TIMEOUT_CONEXAO)
            ->withOptions([
                'verify' => true,
                'stream' => true,
                'curl' => [
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 3,
                    CURLOPT_TCP_KEEPALIVE => 1,
                ]
            ])
            ->retry(self::MAX_RETRIES, self::RETRY_DELAY)
            ->post(config('services.restpki.endpoint') . '/signature/completion', [
                'state' => $state,
                'signature' => $signature
            ]);
    }

    /**
     * Processar resposta da requisição inicial
     */
    private function processarRespostaInicial(Response $response): array
    {
        if (!$response->successful()) {
            $erro = $response->json()['message'] ?? "Status HTTP: {$response->status()}";
            throw new Exception("Falha na requisição inicial: {$erro}");
        }

        $dados = $response->json();

        if (!isset($dados['success']) || !$dados['success']) {
            $erro = $dados['message'] ?? 'Erro desconhecido';
            throw new Exception("API retornou erro: {$erro}");
        }

        if (!isset($dados['state']) || !isset($dados['toSign']['data'])) {
            throw new Exception('Resposta da API incompleta - faltam state ou toSign.data');
        }

        return $dados;
    }

    /**
     * Processar resposta da requisição de completion
     */
    private function processarRespostaCompletion(Response $response): array
    {
        if (!$response->successful()) {
            $erro = $response->json()['message'] ?? "Status HTTP: {$response->status()}";
            throw new Exception("Falha na requisição de completion: {$erro}");
        }

        $dados = $response->json();

        if (!isset($dados['signedFile']['url'])) {
            throw new Exception('Resposta da completion incompleta - falta signedFile.url');
        }

        return $dados;
    }

    /**
     * Formatar bytes em formato legível
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
