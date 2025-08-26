<?php

namespace App\Jobs\ONR\Certidao;

use App\Enums\ONRStatusEnum;
use Illuminate\Bus\Queueable;
use App\Services\Api\Online\Online;
use App\Services\Integrado\Integrado;
use App\Services\ONR\Certidao\CertidaoService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;

class ProcessarPedidoONRJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // No GerarCertidaoPdfJob, alterar:
    public $timeout = 600; // 10 minutos em vez de 2
    public $tries = 2; // Reduzir tentativas para não sobrecarregar

    public $backoff = [60, 180, 300]; // Delay entre tentativas: 1min, 3min, 5min

    public function __construct(public $pedido) {}

    public function handle(): void
    {
        try {
            $protocolo = $this->pedido->protocolo_solicitacao;
            $matricula = $this->pedido->certidao_matricula_numero;

            // VERIFICA SE A MATRÍCULA EXISTE NO SISTEMA, CASO CONTRÁRIO DEVOLVE O PEDIDO.
            $matriculaExiste = Online::request()->get('/api/matricula/' . $matricula . '/existe');

            if ($matriculaExiste->json('existe') !== true) {
                \Log::error('Matrícula não encontrada no sistema B', [
                    'protocolo' => $protocolo,
                    'matricula' => $matricula,
                    'response' => $matriculaExiste->json()
                ]);
                (new CertidaoService)->devolverCertidao([
                    'Protocolo' => $this->pedido->protocolo_solicitacao,
                    'Motivo' => 'Prezado cliente, a matrícula informada . ' . $this->pedido->certidao_matricula_numero . ' não foi encontrado. Por favor, verifique a matrícula e tente novamente.',
                ]);

                $this->pedido->update([
                    'status_envio' => 'ERRO_MATRICULA_NAO_ENCONTRADA',
                    'mensagem_erro_envio' => 'Matrícula não encontrada no sistema B: ' . $matricula,
                    'ultima_tentativa_envio' => now(),
                ]);

                return;
            }

            $descricao = "Pedido de certidão ONR - #{$protocolo} - Matrícula: {$matricula}";

            $dados = [
                'id_ecertidao_onr' => $protocolo,
                'apresentante'     => $this->pedido->solicitante_nome,
                'descricao'        => $descricao,
                'matricula'        => $matricula,

                // 🔽 Dados do cliente
                'cliente' => [
                    'cpf_cnpj' => $this->pedido->solicitante_cpf_cnpj,
                    'nome'     => $this->pedido->solicitante_nome,
                    'email'    => $this->pedido->solicitante_email,
                    'telefone' => $this->pedido->solicitante_telefone,
                    'endereco' => $this->pedido->solicitante_tipo_logradouro . ' ' .
                        $this->pedido->solicitante_logradouro,
                    'bairro'   => $this->pedido->solicitante_bairro,
                ]
            ];

            // 🔍 Verifica se já existe no sistema B
            $check = Integrado::request()->get('/api/ordem-servico/certidao-onr/' . $protocolo);
            Log::info('Verificando se certidão já existe no sistema B.', [
                'protocolo' => $protocolo,
                'check_response' => $check->json()
            ]);

            if ($check->successful() && $check->json('success') === true) {
                Log::info('Certidão já existe no sistema B. Nenhuma ação tomada.', [
                    'protocolo' => $protocolo,
                ]);
                return;
            }

            // CHECA SE TEM ALGUM ERRO 500
            if ($check->failed() && $check->status() === 500) {
                Log::error('Erro ao verificar certidão no sistema B', [
                    'status' => $check->status(),
                    'body'   => $check->body(),
                    'protocolo' => $protocolo
                ]);
                return;
            }

            // 🔥 Envia a ordem de serviço pro sistema B
            $response = Integrado::request()->post('/api/ordem-servico/criar/completa', $dados);

            if ($response->successful()) {
                Log::info('OS criada com sucesso no sistema B.', [
                    'protocolo' => $protocolo,
                    'dados_enviados' => $dados,
                    'response' => $response->json()
                ]);

                // Atualiza a certidão com os dados do integrador
                Log::info('RESPONSE JSON:', ['response' => $response->json()]);
                $retorno = $response->json();
                Log::info('Retorno da criação de OS:', ['retorno' => $retorno]);

                $selo = data_get($retorno, 'data.selo');
                $contraditorio = data_get($retorno, 'data.contraditorio');
                $ordemServico = data_get($retorno, 'data.ordem_servico');

                Log::warning('Selo Digital utilizado:', ['selo' => $selo]);
                Log::warning('Contraditório:', ['contraditorio' => $contraditorio]);


                if (!isset($ordemServico['idos'])) {
                    Log::warning('OS criada mas retorno não contém IDOS esperado', $retorno);
                    return;
                }

                $this->pedido->update([
                    'integrado_ordem_servico_id'       => $ordemServico['idos'],
                    'integrado_selo_prefixo'           => $selo['prefixo'],
                    'integrado_selo_numero'            => $selo['numeracao'],
                    'integrado_selo_codigo_atos'       => $selo['codigoatos'],
                    'integrado_selo_valor'             => $selo['valorselo'],
                    'status_envio'                     => ONRStatusEnum::PENDENTE->value,
                    'integrado_selo_data'              => $selo['dataselagem'],
                    'integrado_selo_hora'              => $selo['hora_selagem'],

                    // CONTRADITÓRIO
                    'possui_contraditorio'              => (is_array($contraditorio) && count($contraditorio) > 0) ? true : false,
                    'contraditorio_debug'               => (is_array($contraditorio) && count($contraditorio) > 0) ? $contraditorio : null,
                ]);

                // GerarCertidaoPdfJob::dispatch($this->pedido)->onQueue('onr_certidao');
            } else {
                \Log::error('Erro ao criar OS no sistema B', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                    'dados'  => $dados
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Falha ao processar integração com sistema B', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
