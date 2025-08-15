<?php

namespace App\Services\ONR;

use App\Models\Configuracao;
use App\Models\ONR\Token;
use App\Models\ONRConfiguracao;
use App\Services\ONR\Autenticacao\Autenticacao;
use App\Services\Soap\SoapBase;
use Illuminate\Support\Facades\DB;
use Log;


class ONRBase extends SoapBase
{
    protected array $soapErrorMessages = [
        0 => 'Erro de sistema.',
        10 => 'Request inválido.',
        11 => 'O Hash de validação não foi informado.',
        18 => 'Status Inválido.',
        19 => 'Data inválida em "DataPedidoDe".',
        20 => 'Data inválida em "DataPedidoAte".',
        21 => 'Data inválida em "DataConferenciaDe".',
        22 => 'Data inválida em "DataConferenciaAte".',
        23 => 'Campo "TipoCertidao" deve estar em branco ou entre 1 e 10.',
        24 => 'Campo "PesquisaPor" deve estar em branco ou entre 4 e 12.',
        26 => 'Campo "TipoResposta" inválido. Valores permitidos: "", "D" ou "C". Os valores "D" e "C" somente são permitidos se o campo "Sttatus" estiver preenchido com "3" (Respondido).',
        45 => 'Hash inválido.',
        46 => 'Hash inválido: Hash já utilizado.',
        47 => 'Hash inválido: Hash expirado.',
        200 => 'Não foram localizados registros para exportação.',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    protected function getWsdlBase(): string
    {
        return 'https://wsoficio.onr.org.br';
    }

    protected function getWsdlEndpoint(): string
    {
        return '/eprotocolo.asmx?WSDL';
    }

    protected function call(string $method, array $params = []): mixed
    {
        $token = $this->obterTokenValido();
        // Adiciona o token ao array de parâmetros
        $hash = $token->codigo;
        $chave = $this->obterChaveONR();
        $hash = sha1($chave . $hash);
        \Log::debug("HASH gerado para o método {$method}: {$hash}");
        \Log::debug("HASH gerado para chave: {$chave}");
        $params['oRequest']['Hash'] = $hash;

        try {
            $response = $this->client->__soapCall($method, [$params]);

            // Extrai automaticamente "{$method}Result" se existir
            $resultProperty = $method . 'Result';
            if (is_object($response) && property_exists($response, $resultProperty)) {
                return $response->$resultProperty;
            }

            // Verifica se o retorno foi positivo
            if (isset($result->RETORNO) && $result->RETORNO !== true) {
                $codigo = $result->CODIGOERRO ?? 0;
                $descricao = $result->ERRODESCRICAO
                    ?? ($this->soapErrorMessages[$codigo] ?? 'Erro desconhecido.');

                throw new \RuntimeException("SOAP falhou [{$codigo}]: {$descricao}");
            }

            return $response;
        } catch (\SoapFault $e) {
            if ($this->debugmode) {
                $this->logDebug("Erro no método {$method}: {$e->getMessage()}");
                $this->logDebug("Último Request: " . $this->getLastRequest());
                $this->logDebug("Última Response: " . $this->getLastResponse());
            }

            throw $e;
        }
    }
    public function obterTokenValido()
    {
        return DB::transaction(function () {
            $token = $this->buscarTokenValido();

            if (!$token) {
                $resultado = (new Autenticacao())->getToken();
                \Log::debug('Resultado da geração de token', ['resultado' => $resultado]);

                // Verifica se houve erro na geração do token
                if (is_array($resultado) && isset($resultado['erro'])) {
                    throw new \Exception($resultado['mensagem']);
                }

                $token = $this->buscarTokenValido();
            }

            if (!$token) {
                throw new \Exception('Não foi possível obter um token válido após gerar um novo');
            }

            $token->update([
                'is_utilizado' => true,
                'data_utilizacao' => now('America/Cuiaba')
            ]);

            return $token;
        });
    }

    private function buscarTokenValido()
    {
        return Token::query()
            ->where('is_ativo', '=', true)
            ->where('is_utilizado', '=', false)
            ->where('data_validade', '>=', now('America/Cuiaba'))
            ->lockForUpdate()
            ->first();
    }
    /**
     * Garante que o retorno seja sempre um array, mesmo que tenha apenas 1 item.
     */
    protected function normalizarArray(mixed $data): array
    {
        if (is_array($data)) {
            return $data;
        }

        if (is_object($data)) {
            return [$data];
        }

        return [];
    }

    public function obterChaveONR()
    {
        $chave = ONRConfiguracao::query()
            ->value('chave');

        \Log::debug('Chave ONR obtida', ['chave' => $chave]);

        return $chave;
    }


    /**
     * Procura o primeiro array dentro de um objeto ou array aninhado.
     *
     * @param object|array $data
     * @return array
     */
    protected function getFirstArrayInside(mixed $data): array
    {
        if (is_object($data)) {
            foreach (get_object_vars($data) as $value) {
                if (is_array($value)) {
                    return $value;
                }
            }
        }

        if (is_array($data)) {
            foreach ($data as $value) {
                if (is_array($value)) {
                    return $value;
                }
            }
        }

        return [];
    }

    /**
     * Converte uma string XML (ou objeto SimpleXMLElement) em array PHP associativo.
     */
    protected function xmlToArray(mixed $xml): array
    {
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        }

        if ($xml instanceof \SimpleXMLElement) {
            $json = json_encode($xml);
            return json_decode($json, true);
        }

        return [];
    }
}
