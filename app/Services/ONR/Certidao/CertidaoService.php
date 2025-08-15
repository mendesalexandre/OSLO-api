<?php

namespace App\Services\ONR\Certidao;

use App\Services\ONR\ONRBase;
use Log;

class CertidaoService extends ONRBase
{
    protected string $wsdl = 'https://wsoficio.onr.org.br/Certidoes.asmx?wsdl';

    protected $camposObrigatorios = [
        'Protocolo',
        'Solicitante',
        'TipoCertidao',
        'PesquisarPor',
        'Status',
        'TipoResposta',
        'DataPedidoDe',
        'DataPedidoAte',
        'DataConferenciaDe',
        'DataConferenciaAte'
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
        return '/Certidoes.asmx?wsdl';
    }

    /**
     * Obtém o XML de solicitações de certidão.
     * @param array $parametros
     * ObterXMLSolicitacoes_v4
     * @return array
     * @throws \Exception
     */
    public function listarPedidos(array $parametros = [])
    {
        try {
            $parametros = [
                'oRequest' => [
                    'Protocolo' => '',
                    'Solicitante' => '',
                    'TipoCertidao' => '',
                    'PesquisaPor' => '',
                    'Status' => '',
                    'TipoResposta' => '',
                    'DataPedidoDe' => now()->subDays(7)->format('Y-m-d'),
                    'DataPedidoAte' => now()->format('Y-m-d'),
                    'DataConferenciaDe' => '',
                    'DataConferenciaAte' => '',
                ]
            ];

            $response = $this->call('ObterXMLSolicitacoes_v4', $parametros);
            \Log::info('Listando pedidos de certidão', [
                'response' => $response
            ]);


            if ($response->RETORNO == false && $response->CODIGOERRO != 0) {
                throw new \Exception('Erro ao listar pedidos de certidão: ' . $response->ERRODESCRICAO);
            }

            $xml = $response->XML ?? null;

            if ($xml) {
                $array = $this->xmlToArray($xml);

                return $array;
            }

            return $response;
        } catch (\SoapFault $e) {
            \Log::error('Erro ao listar pedidos de certidão: ' . $e->getMessage());
            throw new \Exception('Erro ao listar pedidos de certidão: ' . $e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            \Log::error('Erro inesperado ao listar pedidos de certidão: ' . $e->getMessage() . ' (Código: ' . $e->getCode() . ')');
            throw new \Exception('Erro inesperado ao listar pedidos de certidão: ' . $e->getMessage(), $e->getCode());
        }
    }

    public function devolverCertidao($parametros = [])
    {
        if ($parametros === []) {
            throw new \Exception('Parâmetros obrigatórios não informados.');
        }
        $camposObrigatorios = [
            'Protocolo',
            'Motivo',
        ];

        if (!in_array('Protocolo', $camposObrigatorios)) {
            throw new \Exception('Campo obrigatório "Protocolo" não informado.');
        }

        if (!in_array('Motivo', $camposObrigatorios)) {
            throw new \Exception('Campo obrigatório "Motivo" não informado.');
        }

        return $this->call('DevolverCertidao', $parametros);
    }

    public function enviarAnexoCertidaoDocID($parametros = [])
    {
        // ✅ Debug primeiro para ver o que está chegando
        // \Log::info('enviarAnexoCertidao Parâmetros recebidos:', $parametros);

        // ✅ Validação dos parâmetros obrigatórios
        if (empty($parametros['Protocolo'])) {
            throw new \InvalidArgumentException('Protocolo é obrigatório');
        }

        if (empty($parametros['DocumentID'])) {
            throw new \InvalidArgumentException('DocumentID é obrigatório');
        }

        // ✅ Montar request corretamente
        $request = [
            'oRequest' => [
                'Protocolo' => (string) $parametros['Protocolo'],
                'DocumentID' => (string) $parametros['DocumentID'] // ID DO ARQUIVO NO ASSINADOR DA ONR
            ]
        ];

        // ✅ Debug do request que será enviado
        // \Log::info('Request SOAP:', $request);

        try {
            // $resposta = $this->call('EnviarAnexoCertidao_DocID', $request);
            $resposta = $this->call('EnviarAnexoCertidao_DocID', $request);

            // ✅ Debug da resposta
            \Log::info('Resposta SOAP:', (array) $resposta);

            if ($resposta->RETORNO == false && $resposta->CODIGOERRO != 0) {
                throw new \Exception('Erro ao enviar anexo: ' . $resposta->ERRODESCRICAO);
            }

            return $resposta;
        } catch (\SoapFault $e) {
            // ✅ Log detalhado do erro SOAP
            \Log::error('SOAP Fault:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            throw new \Exception('Erro SOAP: ' . $e->getMessage());
        }
    }

    public function enviarAnexoCertidao($parametros = [])
    {
        // ✅ Debug primeiro para ver o que está chegando
        // \Log::info('enviarAnexoCertidao Parâmetros recebidos:', $parametros);

        // ✅ Validação dos parâmetros obrigatórios
        if (empty($parametros['Protocolo'])) {
            throw new \InvalidArgumentException('Protocolo é obrigatório');
        }

        if (empty($parametros['NomeArquivo'])) {
            throw new \InvalidArgumentException('NomeArquivo é obrigatório');
        }

        // ARQUIVO BASE64
        if (empty($parametros['ArquivoBase64'])) {
            throw new \InvalidArgumentException('ArquivoBase64 é obrigatório');
        }

        // ✅ Montar request corretamente
        $request = [
            'oRequest' => [
                'Protocolo' => (string) $parametros['Protocolo'],
                'NomeArquivo' => (string) $parametros['NomeArquivo'],
                'ArquivoBase64' => (string) $parametros['ArquivoBase64'] // Certifique-se de que este campo é uma string base64 válida
            ]
        ];

        // ✅ Debug do request que será enviado
        // \Log::info('Request SOAP:', $request);

        try {
            // $resposta = $this->call('EnviarAnexoCertidao_DocID', $request);
            $resposta = $this->call('EnviarAnexoCertidao', $request);

            // ✅ Debug da resposta
            \Log::info('Resposta SOAP:', (array) $resposta);

            if ($resposta->RETORNO == false && $resposta->CODIGOERRO != 0) {
                throw new \Exception('Erro ao enviar anexo: ' . $resposta->ERRODESCRICAO);
            }

            return $resposta;
        } catch (\SoapFault $e) {
            // ✅ Log detalhado do erro SOAP
            \Log::error('SOAP Fault:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            throw new \Exception('Erro SOAP: ' . $e->getMessage());
        }
    }

    public function finalizarRespostaCertidao($parametros = [], $ignorarErro55 = false)
    {
        \Log::info('=== FINALIZAR CERTIDÃO (VERSÃO CORRIGIDA) ===');
        \Log::info('Parâmetros recebidos:', [
            'parametros' => $parametros,
            'ignorarErro55' => $ignorarErro55
        ]);


        // Validações
        if (empty($parametros['Protocolo'])) {
            throw new \InvalidArgumentException('Protocolo é obrigatório');
        }

        if (!array_key_exists('InteresseSocial', $parametros)) {
            throw new \InvalidArgumentException('Interesse Social é obrigatório');
        }

        // ✅ SOLUÇÃO: Sempre incluir Matriculas, mesmo que vazio
        $request = [
            'oRequest' => [
                'Protocolo' => (string) $parametros['Protocolo'],
                'Matriculas' => !empty($parametros['Matriculas']) ? (string) $parametros['Matriculas'] : '', // SEMPRE incluir
                'InteresseSocial' => (bool) $parametros['InteresseSocial'],
            ]
        ];

        \Log::info('Request corrigido (com Matriculas sempre presente):', $request);

        try {
            \Log::info('Iniciando chamada SOAP...');

            $resposta = $this->call('FinalizarRespostaCertidao', $request);

            \Log::info('✅ Resposta recebida:', [
                'resposta_completa' => $resposta,
                'resposta_array' => (array) $resposta,
            ]);

            // Verificar resposta
            if (is_object($resposta) && property_exists($resposta, 'RETORNO')) {
                if ($resposta->RETORNO === false) {
                    $codigoErro = $resposta->CODIGOERRO ?? 'N/A';
                    $descricaoErro = $resposta->ERRODESCRICAO ?? 'N/A';

                    // Se for erro 55 (já finalizada) e estivermos ignorando este erro
                    if ($codigoErro == 55 && $ignorarErro55) {
                        \Log::info('✅ Erro 55 ignorado - Certidão já estava finalizada:', [
                            'CODIGOERRO' => $codigoErro,
                            'ERRODESCRICAO' => $descricaoErro
                        ]);
                        return $resposta; // Retorna sem lançar exceção
                    }

                    \Log::error('❌ Erro na finalização:', [
                        'CODIGOERRO' => $codigoErro,
                        'ERRODESCRICAO' => $descricaoErro
                    ]);

                    throw new \Exception("Erro ao finalizar certidão: {$descricaoErro} (Código: {$codigoErro})");
                }

                \Log::info('✅ 🎉 SUCESSO! Finalização realizada com sucesso!');
                return $resposta;
            }

            return $resposta;
        } catch (\SoapFault $e) {
            \Log::error('❌ SOAP Fault:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            throw new \Exception('Erro SOAP: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('❌ Exceção:', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
}
