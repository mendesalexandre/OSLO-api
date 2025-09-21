<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class CertidaoService
{
    private string $path = 'api/protocolo';

    /**
     * Trata os dados de um ato, fazendo parse dos campos JSON
     */
    private function tratarAto(array $ato): array
    {
        $ato['tipoServico'] = json_decode($ato['tipoServico'] ?? '{}', true);

        if (!empty($ato['tipoServico']['opcoes']) && is_string($ato['tipoServico']['opcoes'])) {
            $ato['tipoServico']['opcoes'] = json_decode($ato['tipoServico']['opcoes'] ?: '[]', true);
        }

        $ato['indicadorPessoalVersao'] = !empty($ato['indicadorPessoalVersao'])
            ? json_decode($ato['indicadorPessoalVersao'], true)
            : [];

        $ato['custas'] = json_decode($ato['custas'] ?? '{}', true);
        $ato['checklist'] = json_decode($ato['checklist'] ?? '{}', true);
        $ato['indices'] = json_decode($ato['indices'] ?? '{}', true);
        $ato['exigencias'] = json_decode($ato['exigencias'] ?? '[]', true);
        $ato['dto'] = json_decode($ato['dto'] ?? '{}', true);

        $ato['indicador'] = json_decode($ato['indicador'] ?? 'null', true);
        if (empty($ato['indicador']['id'])) {
            $ato['indicador'] = null;
        }

        $ato['registroAuxiliar'] = json_decode($ato['registroAuxiliar'] ?? 'null', true);
        if (empty($ato['registroAuxiliar']['id'])) {
            $ato['registroAuxiliar'] = null;
        }

        $ato['indicadorReal'] = json_decode($ato['indicadorReal'] ?? 'null', true);
        if (empty($ato['indicadorReal']['id'])) {
            $ato['indicadorReal'] = null;
        }

        $ato['ficha'] = $ato['indicadorReal'] ?? $ato['registroAuxiliar'] ?? $ato['indicador'];

        return $ato;
    }

    /**
     * Retorna URL para baixar certidão específica
     */
    public function baixarCertidao(string $protocolo, string $certidao, bool $pdfa = false): string
    {
        $suffix = $pdfa ? 'pdfa' : 'pdf';
        return "{$this->path}/{$protocolo}/certidao/{$certidao}/{$suffix}";
    }

    /**
     * Retorna URL para baixar todas as certidões do protocolo
     */
    public function baixarCertidoesProtocolo(string $protocolo): string
    {
        return "{$this->path}/{$protocolo}/certidao/pdf";
    }

    /**
     * Edita a data de selagem
     */
    public function editarDataSelagem(array $dto, string $protocolo)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/atualizar-data-selagem", $dto);
    }

    /**
     * Retorna os tipos de certidão disponíveis
     */
    public function tiposCertidao(?string $dominio = null): array
    {
        $retorno = [
            ['id' => 'INTEIRO_TEOR', 'nome' => 'Inteiro Teor'],
            ['id' => 'INTEIRO_TEOR_SEM_BUSCA', 'nome' => 'Inteiro Teor - Sem Busca (4hrs)'],
        ];

        if ($dominio === 'CERTIDAO_RCPJ') {
            $retorno[] = [
                'id' => 'INTEIRO_TEOR_PESSOA_JURIDICA',
                'nome' => 'Inteiro Teor de Pessoa Jurídica'
            ];
        }

        $retorno = array_merge($retorno, [
            ['id' => 'RESUMIDA', 'nome' => 'Resumida'],
            ['id' => 'POR_QUESITO', 'nome' => 'Por Quesito'],
            ['id' => 'NEGATIVA', 'nome' => 'Negativa'],
            ['id' => 'ONUS_ACOES', 'nome' => 'Ônus & Ações'],
            ['id' => 'INFORMACAO_VERBAL', 'nome' => 'Informação Verbal'],
            ['id' => 'COPIA_POR_PAGINA', 'nome' => 'Cópia Reprográfica por Página'],
            ['id' => 'RELATORIO', 'nome' => 'Certidão em Relatório'],
            ['id' => 'QUESITOS', 'nome' => 'Certidão em Relatório com Quesitos'],
            ['id' => 'UNIDADES_VIRTUAIS', 'nome' => 'Certidão de Atos Virtuais'],
            ['id' => 'SITUACAO_JURIDICA', 'nome' => 'Certidão de Situação Jurídica'],
            ['id' => 'DOCUMENTO_ARQUIVADO', 'nome' => 'Documento Arquivado na Serventia'],
        ]);

        // Assumindo que você tenha uma forma de verificar se é estado BA
        // Você pode implementar isso como um config ou método auxiliar
        if ($this->isEstadoBA()) {
            $retorno[] = ['id' => 'POSITIVA', 'nome' => 'Certidão Positiva'];
        }

        return $retorno;
    }

    /**
     * Nomeia a entidade (simplificado)
     */
    public function nomearEntidade(?array $certidao = null, bool $code = true): string
    {
        return 'Certidão';
    }

    /**
     * Lista todas as certidões de um protocolo
     */
    public function listar(string $protocolo): array
    {
        $response = Http::get("{$this->path}/{$protocolo}/certidao");
        $certidoes = $response->json();

        return array_map([$this, 'tratarAto'], $certidoes);
    }

    /**
     * Busca certidão por ID
     */
    public function getById(string $protocolo, string $id): ?array
    {
        if (!$this->isValidUUID($id)) {
            throw new \InvalidArgumentException('ID deve ser um UUID válido');
        }

        $response = Http::get("{$this->path}/{$protocolo}/certidao/{$id}");
        $ato = $response->json();

        if (empty($ato['registroAuxiliar']['id'])) {
            $ato['registroAuxiliar'] = null;
        }
        if (empty($ato['indicadorReal']['id'])) {
            $ato['indicadorReal'] = null;
        }
        if (empty($ato['indicador']['id'])) {
            $ato['indicador'] = null;
        }

        $ato['ficha'] = $ato['indicadorReal'] ?? $ato['registroAuxiliar'] ?? $ato['indicador'];

        return $ato;
    }

    /**
     * Gera minuta de uma certidão
     */
    public function gerarMinuta(string $protocolo, string $id, ?string $modelo = null)
    {
        $url = $modelo
            ? "{$this->path}/{$protocolo}/certidao/{$id}/{$modelo}/minuta"
            : "{$this->path}/{$protocolo}/certidao/{$id}/minuta";

        return Http::get($url);
    }

    /**
     * Obtém custo de certidão
     */
    public function getCusto(string $protocolo)
    {
        return Http::get("{$this->path}/{$protocolo}/certidao/custo");
    }

    /**
     * Calcula custo do protocolo
     */
    public function calcularCustoProtocolo(string $protocolo)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/calcular-custo-protocolo");
    }

    /**
     * Verifica certidões seladas
     */
    public function verificarCertidoesSeladas(string $protocolo, array $dto)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/verificar-certidoes-seladas", $dto);
    }

    /**
     * Verifica certidões assinadas
     */
    public function verificarCertidoesAssinadas(string $protocolo, array $dto)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/verificar-certidoes-assinadas", $dto);
    }

    /**
     * Deleta uma certidão
     */
    public function delete(string $protocolo, string $id)
    {
        return Http::delete("{$this->path}/{$protocolo}/certidao/{$id}");
    }

    /**
     * Salva uma certidão
     */
    public function save(array $dto, string $protocolo, string $id = '')
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/{$id}", $dto);
    }

    /**
     * Insere certidão de vínculo
     */
    public function inserirCertidaoVinculo(array $dtoEnvolvidos, string $protocolo)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/inserir-certidao-vinculo", $dtoEnvolvidos);
    }

    /**
     * Obtém certidão de vínculo
     */
    public function getCertidaoVinculo(string $idCertidao, string $protocolo)
    {
        return Http::get("{$this->path}/{$protocolo}/certidao/get-certidao-vinculo", [
            'idCertidao' => $idCertidao
        ]);
    }

    /**
     * Insere anexo em certidão
     */
    public function inserirAnexoCertidao(string $idProtocolo, string $idCertidao, array $dto)
    {
        return Http::post("{$this->path}/{$idProtocolo}/certidao/inserir-anexo-certidao/{$idCertidao}", $dto);
    }

    /**
     * Obtém anexo de certidão
     */
    public function getAnexoCertidao(string $idProtocolo, string $idCertidao)
    {
        return Http::get("{$this->path}/{$idProtocolo}/certidao/get-anexo-certidao", [
            'idCertidao' => $idCertidao
        ]);
    }

    /**
     * Insere lote de certidões
     */
    public function inserirLote(string $protocolo, array $dto)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/lote", $dto);
    }

    /**
     * Insere quantidade específica
     */
    public function inserirQuantidade(string $protocolo, array $dto, int $quantidade)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/lote/{$quantidade}", $dto);
    }

    /**
     * Regenera checklist
     */
    public function regerarChecklist(string $protocolo)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/checklist");
    }

    /**
     * Ordena certidões
     */
    public function ordenarCertidoes(string $protocolo, array $certidoes)
    {
        return Http::post("{$this->path}/{$protocolo}/certidao/ordenar", $certidoes);
    }

    /**
     * Importa visualizações via arquivo
     */
    public function importarVisualizacoes(string $protocolo, string $tipo, UploadedFile $file)
    {
        return Http::timeout(0)->attach('file', $file->get(), $file->getClientOriginalName())
            ->post("{$this->path}/{$protocolo}/certidao/importar-visualizacoes/{$tipo}");
    }

    /**
     * Importa pesquisa qualificada ONR
     */
    public function importarPesquisaQualificadaOnr(string $protocolo, UploadedFile $file, string $idTipoCertidao)
    {
        return Http::timeout(0)
            ->attach('file', $file->get(), $file->getClientOriginalName())
            ->withData(['idTipoCertidao' => $idTipoCertidao])
            ->post("{$this->path}/{$protocolo}/certidao/importar-pesquisa-qualificada-onr");
    }

    /**
     * Verifica se é certidão ficha
     */
    public function isCertidaoFicha($livro): bool
    {
        if (empty($livro)) {
            return false;
        }

        if (is_string($livro)) {
            return $livro !== 'NAO_VINCULAR';
        }

        if (is_array($livro)) {
            return count($livro) > 0 && !in_array('NAO_VINCULAR', $livro);
        }

        return false;
    }

    /**
     * Valida se é um UUID válido
     */
    private function isValidUUID(string $uuid): bool
    {
        return Str::isUuid($uuid);
    }

    /**
     * Verifica se é estado da Bahia
     * Implementar conforme sua lógica de negócio
     */
    private function isEstadoBA(): bool
    {
        // Implementar conforme sua aplicação
        // Pode ser um config, sessão, ou consulta ao banco
        return config('app.estado') === 'BA';
    }
}
