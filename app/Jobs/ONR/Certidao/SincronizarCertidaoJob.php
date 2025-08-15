<?php

namespace App\Jobs\ONR\Certidao;

use App\DTOs\ONR\Certidao\CertidaoSolicitacaoDTO;
use App\DTOs\ONR\Certidao\TiposCertidao\CertidaoImovelDTO;
use App\DTOs\ONR\Certidao\TiposCertidao\CertidaoPessoaDTO;
use App\Models\ONR\Certidao;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SincronizarCertidaoJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries = 3;

    public function __construct(
        public readonly array $certidaoData
    ) {}

    public function handle(): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $solicitacaoDTO = CertidaoSolicitacaoDTO::fromArray($this->certidaoData);
        Log::info("🔄 [STEP 1/3] Sincronizando certidão: {$solicitacaoDTO->protocoloSolicitacao}");

        try {
            DB::beginTransaction();

            $this->atualizarStatusBatch('SINCRONIZANDO', 'Sincronizando dados da certidão', $solicitacaoDTO->protocoloSolicitacao);

            $certidaoExistente = Certidao::where('protocolo_solicitacao', $solicitacaoDTO->protocoloSolicitacao)->first();

            if ($certidaoExistente) {
                $this->atualizarCertidao($certidaoExistente, $solicitacaoDTO);
                Log::info("🔄 Certidão atualizada: {$solicitacaoDTO->protocoloSolicitacao}");
            } else {
                $this->criarNovaCertidao($solicitacaoDTO);
                Log::info("✨ Nova certidão criada: {$solicitacaoDTO->protocoloSolicitacao}");
            }

            DB::commit();
            $this->atualizarStatusBatch('SINCRONIZADA', 'Dados sincronizados com sucesso', $solicitacaoDTO->protocoloSolicitacao);
            Log::info("✅ [STEP 1/3] Sincronização concluída: {$solicitacaoDTO->protocoloSolicitacao}");
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->atualizarStatusBatch('ERRO_SINCRONIZACAO', "Erro: {$e->getMessage()}", $solicitacaoDTO->protocoloSolicitacao);
            Log::error("❌ [STEP 1/3] Erro: {$solicitacaoDTO->protocoloSolicitacao} - {$e->getMessage()}");
            throw $e;
        }
    }

    private function atualizarStatusBatch(string $status, string $mensagem, string $protocolo): void
    {
        Certidao::where('protocolo_solicitacao', $protocolo)
            ->update([
                'status_batch' => $status,
                'mensagem_batch' => $mensagem,
                'batch_id' => $this->batch()?->id,
                'data_alteracao' => now(),
            ]);
    }

    private function atualizarCertidao(Certidao $certidao, CertidaoSolicitacaoDTO $solicitacaoDTO): void
    {
        Log::info("Atualizando certidão existente: {$solicitacaoDTO->protocoloSolicitacao}");

        $dadosBase = $this->extrairDadosBase($solicitacaoDTO);
        $dadosEspecificos = $this->extrairDadosEspecificosCertidao($solicitacaoDTO->certidao);

        $certidao->update(array_merge($dadosBase, $dadosEspecificos, [
            'data_alteracao' => now(),
        ]));
    }

    private function criarNovaCertidao(CertidaoSolicitacaoDTO $solicitacaoDTO): void
    {
        Log::info("Criando nova certidão: {$solicitacaoDTO->protocoloSolicitacao}");

        $dadosBase = $this->extrairDadosBase($solicitacaoDTO);
        $dadosEspecificos = $this->extrairDadosEspecificosCertidao($solicitacaoDTO->certidao);

        Certidao::query()->create(array_merge($dadosBase, $dadosEspecificos, [
            'status_batch' => 'SINCRONIZADA',
            'batch_id' => $this->batch()?->id,
            'data_cadastro' => now(),
            'data_alteracao' => now(),
        ]));
    }

    private function extrairDadosBase(CertidaoSolicitacaoDTO $solicitacaoDTO): array
    {
        return [
            'protocolo_solicitacao' => $solicitacaoDTO->protocoloSolicitacao,
            'status_solicitacao' => $solicitacaoDTO->statusSolicitacao,
            'data_pedido' => $solicitacaoDTO->dataPedido,
            'tipo_cobranca' => $solicitacaoDTO->tipoCobranca,
            'valor' => $solicitacaoDTO->valor,

            // Dados do solicitante
            'solicitante_nome' => $solicitacaoDTO->solicitante->nome,
            'solicitante_cpf_cnpj' => $solicitacaoDTO->solicitante->cpfCnpj,
            'solicitante_email' => $solicitacaoDTO->solicitante->email,
            'solicitante_telefone' => $solicitacaoDTO->solicitante->telefone,
            'solicitante_cep' => $solicitacaoDTO->solicitante->endereco->cep,
            'solicitante_tipo_logradouro' => $solicitacaoDTO->solicitante->endereco->tipoLogradouro,
            'solicitante_logradouro' => $solicitacaoDTO->solicitante->endereco->logradouro,
            'solicitante_numero' => $solicitacaoDTO->solicitante->endereco->numero,
            'solicitante_complemento' => $solicitacaoDTO->solicitante->endereco->complemento,
            'solicitante_bairro' => $solicitacaoDTO->solicitante->endereco->bairro,
            'solicitante_cidade' => $solicitacaoDTO->solicitante->endereco->cidade,
            'solicitante_uf' => $solicitacaoDTO->solicitante->endereco->uf,
            'solicitante_isento_ccm' => $solicitacaoDTO->solicitante->isentoCcm,
            'solicitante_numero_ccm' => $solicitacaoDTO->solicitante->numeroCcm,

            // Dados básicos da certidão
            'certidao_tipo' => $solicitacaoDTO->certidao->tipo,
            'certidao_pedido_por' => $solicitacaoDTO->certidao->pedidoPor,
            'observacao' => $solicitacaoDTO->certidao->observacao ?? null,
            'tipo_finalidade' => $solicitacaoDTO->certidao->tipoFinalidade,
        ];
    }

    private function extrairDadosEspecificosCertidao($certidao): ?array
    {
        $dados = [];

        if ($certidao instanceof CertidaoImovelDTO) {
            // Dados específicos de imóvel
            $dados['certidao_matricula_numero'] = $certidao->matricula->getNumeroMatricula();
            $dados['certidao_endereco_cep'] = $certidao->endereco?->cep;
            $dados['certidao_endereco_logradouro'] = $certidao->endereco?->getEnderecoCompleto();

            // Limpar dados de pessoa (já que é imóvel)
            $dados['pessoa_nome'] = null;
            $dados['pessoa_cpf_cnpj'] = null;
            $dados['pessoa_rg_ie'] = null;
        } elseif ($certidao instanceof CertidaoPessoaDTO) {
            // Dados específicos de pessoa
            $dados['pessoa_nome'] = $certidao->pessoa?->nome;
            $dados['pessoa_cpf_cnpj'] = $certidao->pessoa?->cpfCnpj;
            $dados['pessoa_rg_ie'] = $certidao->pessoa?->rgIe;

            // Limpar dados de imóvel (já que é pessoa)
            $dados['certidao_matricula_numero'] = null;
            $dados['certidao_endereco_cep'] = null;
            $dados['certidao_endereco_logradouro'] = null;
        }

        return $dados;
    }

    public function failed(\Throwable $exception): void
    {
        $solicitacaoDTO = CertidaoSolicitacaoDTO::fromArray($this->certidaoData);
        $this->atualizarStatusBatch('FALHA_SINCRONIZACAO', "Falha definitiva: {$exception->getMessage()}", $solicitacaoDTO->protocoloSolicitacao);
        Log::error("💥 [STEP 1/3] Falha definitiva na sincronização: {$solicitacaoDTO->protocoloSolicitacao}");
    }
}
