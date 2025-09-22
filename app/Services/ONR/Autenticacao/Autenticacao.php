<?php

namespace App\Services\ONR\Autenticacao;

use App\Models\ONR\Token;
use App\Models\ONRConfiguracao;
use App\Services\Soap\SoapBase;

class Autenticacao extends SoapBase
{
    protected string $encoding = 'UTF-8';
    protected int $timeout = 60;
    protected bool $debugmode = true;

    public function getToken(): mixed
    {
        try {
            $response = $this->call('LoginUsuarioCertificado', [
                'oRequest' =>  $this->producao()
            ]);

            logger()->debug('Resposta recebida', ['response' => $response]);

            // Verificação mais robusta da resposta
            if (!$response || (isset($response->RETORNO) && $response->RETORNO == false)) {
                logger()->error('Erro no login certificado', [
                    'erro' => $response->ERRODESCRICAO ?? 'Resposta vazia',
                    'codigo' => $response->CODIGOERRO ?? 'N/A'
                ]);

                return [
                    'erro' => true,
                    'mensagem' => $response->ERRODESCRICAO ?? 'Erro desconhecido na autenticação',
                    'codigo' => $response->CODIGOERRO ?? 0,
                ];
            }

            logger()->debug('Login bem-sucedido, persistindo...');
            return $this->persistirLogin($response);
        } catch (\SoapFault $e) {
            logger()->error('Erro SOAP', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'faultcode' => $e->faultcode ?? null,
                'faultstring' => $e->faultstring ?? null
            ]);

            return [
                'error' => true,
                'message' => 'Erro SOAP: ' . $e->getMessage(),
                'code' => $e->getCode(),
            ];
        } catch (\Exception $e) {
            logger()->error('Erro de comunicação', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'erro' => true,
                'mensagem' => 'Erro de comunicação: ' . $e->getMessage(),
                'code' => $e->getCode(),
                'linha' => $e->getLine()
            ];
        }
    }

    protected function getWsdlBase(): string
    {
        return 'https://wsoficio.onr.org.br';
    }

    protected function getWsdlEndpoint(): string
    {
        return '/login.asmx?WSDL';
    }

    public function persistirLogin($resultado)
    {
        if (!isset($resultado->Tokens->string) || !is_array($resultado->Tokens->string)) {
            throw new \RuntimeException('Nenhum token retornado no login.');
        }

        foreach ($resultado->Tokens->string as $token) {
            Token::query()
                ->create([
                    'codigo' => $token,
                    'data_criacao' => now(),
                    'data_validade' => now()->addHours(8),
                    'id_usuario' => $resultado->IDUsuario ?? null,
                    'id_instituicao' => $resultado->IDInstituicao ?? null,
                ]);
        }
    }

    public function producao()
    {
        $configuracao = ONRConfiguracao::query()
            ->first();

        if (!$configuracao) {
            throw new \RuntimeException('Configuração ONR não encontrada');
        }

        return [
            'SUBJECTCN' => $configuracao->certificado_subject,
            'ISSUERO' => $configuracao->certificado_issuer,
            'PUBLICKEY' => $configuracao->certificado_public_key,
            'SERIALNUMBER' => $configuracao->certificado_serial_number,
            'VALIDUNTIL' => $configuracao->certificado_valid_until,
            'CPF' =>  $configuracao->cpf,
            'EMAIL' => $configuracao->email,
            'IDParceiroWS' => $configuracao->id_parceiro_ws,
        ];
    }

    public function getAmbiente()
    {
        return ONRConfiguracao::query()
            ->value('ambiente');
    }
}
