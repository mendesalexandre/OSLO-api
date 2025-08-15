<?php

namespace App\Services\Lacuna;

use Lacuna\RestPki\RestPkiCoreClient;
use Lacuna\RestPki\RestPkiOptions;
use Lacuna\RestPki\RestPkiService;
use App\Models\ONR\CertificadoDigital;
use Illuminate\Support\Facades\Storage;
use Exception;

class Certificado
{
    protected RestPkiService $service;
    protected ?CertificadoDigital $certificado = null;
    protected ?string $certificadoConteudo = null;
    protected ?string $senhaCertificado = null;

    public function __construct(?int $certificadoId = null)
    {
        $options = new RestPkiOptions(
            config('services.restpki.endpoint'),
            config('services.restpki.api_key'),
            'pt-BR'
        );

        $client = new RestPkiCoreClient($options);
        $this->service = new RestPkiService($client);

        // Carregar certificado apenas se ID foi fornecido
        if ($certificadoId) {
            $this->carregarCertificado($certificadoId);
        }
        // Se não forneceu ID, precisa carregar manualmente
    }

    /**
     * Carregar certificado específico por ID
     */
    public function carregarCertificado(int $certificadoId): self
    {
        $this->certificado = CertificadoDigital::where('id', $certificadoId)
            ->where('ativo', true)
            ->whereNull('data_exclusao')
            ->first();

        if (!$this->certificado) {
            throw new Exception("Certificado ID {$certificadoId} não encontrado ou inativo");
        }

        $this->carregarConteudoCertificado();
        return $this;
    }

    /**
     * Carregar certificado ativo padrão (mais recente)
     */
    public function carregarCertificadoPadrao(): self
    {
        $this->certificado = CertificadoDigital::where('ativo', true)
            ->whereNull('data_exclusao')
            ->orderBy('data_cadastro', 'desc')
            ->first();

        if (!$this->certificado) {
            throw new Exception('Nenhum certificado ativo encontrado');
        }

        $this->carregarConteudoCertificado();
        return $this;
    }

    /**
     * Definir certificado por objeto
     */
    public function definirCertificado(CertificadoDigital $certificado): self
    {
        $this->certificado = $certificado;
        $this->carregarConteudoCertificado();
        return $this;
    }

    /**
     * Carregar conteúdo do certificado (arquivo físico ou base64)
     */
    private function carregarConteudoCertificado(): void
    {
        if (!$this->certificado) {
            throw new Exception('Nenhum certificado definido');
        }

        // Tentar carregar do arquivo físico primeiro
        if ($this->certificado->caminho_arquivo && Storage::disk('local')->exists($this->certificado->caminho_arquivo)) {
            $this->certificadoConteudo = Storage::disk('local')->get($this->certificado->caminho_arquivo);
        }
        // Se arquivo físico não existe, usar backup em base64
        elseif ($this->certificado->certificado_base64) {
            $this->certificadoConteudo = base64_decode($this->certificado->certificado_base64);
        } else {
            throw new Exception('Conteúdo do certificado não encontrado (arquivo físico e base64 ausentes)');
        }

        // Descriptografar senha
        try {
            $this->senhaCertificado = decrypt($this->certificado->senha_criptografada);
        } catch (Exception $e) {
            throw new Exception('Erro ao descriptografar senha do certificado: ' . $e->getMessage());
        }
    }

    /**
     * Assinar dados com o certificado carregado
     */
    public function assinarComCertificado(string $base64ToSign): string
    {
        $this->validarCertificadoCarregado();

        if (!openssl_pkcs12_read($this->certificadoConteudo, $certs, $this->senhaCertificado)) {
            throw new Exception('Erro ao ler o certificado - senha incorreta ou arquivo corrompido');
        }

        $dadosParaAssinar = base64_decode($base64ToSign);
        if (!openssl_sign($dadosParaAssinar, $assinaturaBinaria, $certs['pkey'], OPENSSL_ALGO_SHA256)) {
            throw new Exception('Erro ao assinar os dados com a chave privada');
        }

        return base64_encode($assinaturaBinaria);
    }

    /**
     * Extrair certificado público em base64
     */
    public function extrairCertificadoPublicoBase64(): string
    {
        $this->validarCertificadoCarregado();

        if (!openssl_pkcs12_read($this->certificadoConteudo, $certs, $this->senhaCertificado)) {
            throw new Exception('Erro ao ler o arquivo PFX, verifique a senha');
        }

        if (!isset($certs['cert'])) {
            throw new Exception('Certificado público não encontrado no PFX');
        }

        return base64_encode($certs['cert']);
    }

    /**
     * Obter informações do certificado carregado
     */
    public function obterInformacoesCertificado(): array
    {
        $this->validarCertificadoCarregado();

        if (!openssl_pkcs12_read($this->certificadoConteudo, $certs, $this->senhaCertificado)) {
            throw new Exception('Erro ao ler o certificado');
        }

        $certInfo = openssl_x509_parse($certs['cert']);

        return [
            'id' => $this->certificado->id,
            'nome' => $this->certificado->nome,
            'titular' => $certInfo['subject']['CN'] ?? 'N/A',
            'emissor' => $certInfo['issuer']['CN'] ?? 'N/A',
            'serial' => $certInfo['serialNumber'] ?? 'N/A',
            'valido_de' => date('d/m/Y H:i:s', $certInfo['validFrom_time_t']),
            'valido_ate' => date('d/m/Y H:i:s', $certInfo['validTo_time_t']),
            'algoritmo' => $certInfo['signatureTypeLN'] ?? 'N/A',
            'tamanho' => $this->certificado->tamanho_formatado,
        ];
    }

    /**
     * Verificar se certificado está válido (não expirado)
     */
    public function verificarValidadeCertificado(): bool
    {
        $this->validarCertificadoCarregado();

        if (!openssl_pkcs12_read($this->certificadoConteudo, $certs, $this->senhaCertificado)) {
            return false;
        }

        $certInfo = openssl_x509_parse($certs['cert']);
        $validoAte = $certInfo['validTo_time_t'];

        return time() < $validoAte;
    }

    /**
     * Listar todos os certificados ativos
     */
    public static function listarCertificadosAtivos(): array
    {
        return CertificadoDigital::where('ativo', true)
            ->whereNull('data_exclusao')
            ->orderBy('data_cadastro', 'desc')
            ->get()
            ->map(function ($cert) {
                return [
                    'id' => $cert->id,
                    'nome' => $cert->nome,
                    'titular' => $cert->titular,
                    'valido_ate' => $cert->valido_ate?->format('d/m/Y'),
                    'tamanho' => $cert->tamanho_formatado,
                ];
            })
            ->toArray();
    }

    /**
     * Obter certificado atual carregado
     */
    public function getCertificado(): ?CertificadoDigital
    {
        return $this->certificado;
    }

    /**
     * Validar se certificado está carregado
     */
    private function validarCertificadoCarregado(): void
    {
        if (!$this->certificado) {
            throw new Exception('Nenhum certificado carregado. Use carregarCertificado() primeiro.');
        }

        if (!$this->certificadoConteudo) {
            throw new Exception('Conteúdo do certificado não disponível');
        }

        if (!$this->senhaCertificado) {
            throw new Exception('Senha do certificado não disponível');
        }
    }
}
