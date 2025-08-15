<?php

namespace App\Services\Soap;

use App\Services\Telegram\TelegramNotifier;
use SoapClient;
use SoapFault;
use SoapHeader;
use Illuminate\Support\Facades\Log;

abstract class SoapBase
{
    protected SoapClient $client;

    protected bool $debugmode = false;
    protected string $debugdir = 'storage/logs/soap';
    protected int $soaptimeout = 300;
    protected int $timeout = 300;
    protected string $encoding = 'UTF-8';
    protected bool $verifypeer = false;
    protected bool $verifyhost = false;
    protected int $soapVersao = SOAP_1_1;
    protected int $cache_wsdl = WSDL_CACHE_NONE;
    protected bool $trace = true;
    protected bool $exceptions = true;
    protected array $options = [];
    protected array $soapHeaders = [];

    // Certificados
    protected ?string $certFile = null;
    protected ?string $certPassphrase = null;
    protected ?string $certPrivateKey = null;

    // URL base do WSDL que cada classe filha deve implementar
    abstract protected function getWsdlBase(): string;

    // Endpoint específico que cada classe filha deve implementar
    abstract protected function getWsdlEndpoint(): string;

    // Método que monta a URL completa
    protected function getWsdl(): string
    {
        return $this->getWsdlBase() . $this->getWsdlEndpoint();
    }

    public function __construct()
    {
        $this->buildClient();
    }

    protected function buildClient(): void
    {
        $sslContext = [
            'verify_peer' => $this->verifypeer,
            'verify_peer_name' => $this->verifyhost,
            'allow_self_signed' => true,
        ];

        if ($this->certFile) {
            $sslContext['local_cert'] = base_path($this->certFile);

            if (!file_exists($sslContext['local_cert'])) {
                throw new \Exception("Certificado não encontrado: {$sslContext['local_cert']}");
            }

            if ($this->certPassphrase) {
                $sslContext['passphrase'] = $this->certPassphrase;
            }

            if ($this->certPrivateKey) {
                $sslContext['local_pk'] = base_path($this->certPrivateKey);
                if (!file_exists($sslContext['local_pk'])) {
                    throw new \Exception("Chave privada não encontrada: {$sslContext['local_pk']}");
                }
            }
        }

        $defaultOptions = [
            'soap_version' => $this->soapVersao,
            'cache_wsdl' => $this->cache_wsdl,
            'trace' => $this->trace,
            'exceptions' => $this->exceptions,
            'encoding' => $this->encoding,
            'connection_timeout' => $this->timeout,
            'stream_context' => stream_context_create(['ssl' => $sslContext]),
        ];

        $options = array_merge($defaultOptions, $this->options);

        try {
            // Agora usa a função getWsdl() ao invés da propriedade
            $this->client = new SoapClient($this->getWsdl(), $options);

            if (!empty($this->soapHeaders)) {
                $this->client->__setSoapHeaders($this->soapHeaders);
            }

            if ($this->debugmode) {
                $this->logDebug("SOAP client iniciado com sucesso para: " . $this->getWsdl());
            }
        } catch (SoapFault $e) {
            $this->logDebug("Erro ao iniciar SOAP: " . $e->getMessage());
            throw $e;
        }
    }

    protected function call(string $method, array $params = []): mixed
    {
        try {
            $this->logDebug("Chamando método: {$method} com parâmetros: " . json_encode($params));

            $response = $this->client->__soapCall($method, [$params]);

            $this->logDebug("Resposta bruta: " . json_encode($response));

            if (!is_object($response)) {
                $this->logDebug("Resposta inesperada de {$method}: " . json_encode($response));
                $this->dispararAlerta("Resposta do método {$method} não é objeto", $params);

                // Retorna um objeto padrão de erro em vez de null
                return (object)[
                    'RETORNO' => false,
                    'ERRODESCRICAO' => 'Resposta inválida do servidor',
                    'CODIGOERRO' => -1
                ];
            }

            // Extrai automaticamente "{$method}Result" se existir
            $resultProperty = $method . 'Result';
            if (property_exists($response, $resultProperty)) {
                $this->logDebug("Extraindo propriedade: {$resultProperty}");
                return $response->$resultProperty;
            }

            return $response;
        } catch (\Throwable $e) {
            $this->logDebug("Erro no método {$method}: {$e->getMessage()}");
            $this->logDebug("Último Request: " . $this->getLastRequest());
            $this->logDebug("Última Response: " . $this->getLastResponse());

            $this->dispararAlerta("Erro ao executar método {$method}", [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Retorna objeto de erro em vez de null
            return (object)[
                'RETORNO' => false,
                'ERRODESCRICAO' => $e->getMessage(),
                'CODIGOERRO' => $e->getCode() ?: -2
            ];
        }
    }

    protected function dispararAlerta(string $mensagem, mixed $dados = []): void
    {
        Log::warning('[SOAP ALERTA] ' . $mensagem, ['dados' => $dados]);

        $mensagem = "SOAP ALERTA: {$mensagem}";
        if (!empty($dados)) {
            $mensagem .= "\nDados: " . json_encode($dados);
        }
        $telegram = new TelegramNotifier();
        $telegram->send($mensagem);
    }

    // ========================
    // ✅ SETTERS DINÂMICOS
    // ========================

    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        return $this->rebuild();
    }

    public function setHeaders(array $headers): self
    {
        $this->soapHeaders = $headers;
        return $this->rebuild();
    }

    public function addHeader(string $namespace, string $name, mixed $data, bool $mustUnderstand = false): self
    {
        $this->soapHeaders[] = new SoapHeader($namespace, $name, $data, $mustUnderstand);
        return $this->rebuild();
    }

    public function setCert(string $certPath, ?string $passphrase = null, ?string $privateKeyPath = null): self
    {
        $this->certFile = $certPath;
        $this->certPassphrase = $passphrase;
        $this->certPrivateKey = $privateKeyPath;
        return $this->rebuild();
    }

    public function setDebug(bool $enabled, string $dir = 'storage/logs/soap'): self
    {
        $this->debugmode = $enabled;
        $this->debugdir = $dir;
        return $this;
    }

    protected function rebuild(): self
    {
        $this->buildClient();
        return $this;
    }

    // ========================
    // ✅ UTILITÁRIOS
    // ========================
    protected function logDebug(string $message): void
    {
        if (!is_dir(base_path($this->debugdir))) {
            mkdir(base_path($this->debugdir), 0777, true);
        }

        $file = base_path("{$this->debugdir}/soap.log");
        file_put_contents($file, $message . PHP_EOL, FILE_APPEND);
        Log::debug("[SOAP DEBUG] " . $message);
    }

    public function getLastRequest(): string
    {
        return $this->client->__getLastRequest();
    }

    public function getLastResponse(): string
    {
        return $this->client->__getLastResponse();
    }

    public function getAvailableFunctions(): array
    {
        return $this->client->__getFunctions();
    }

    public function getAvailableTypes(): array
    {
        return $this->client->__getTypes();
    }
}
