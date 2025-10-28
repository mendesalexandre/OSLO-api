<?php

namespace App\Http\Resources\Doi;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $json = [];

        // Tipo Declaração - sempre 0 se não informado
        $json['tipoDeclaracao'] = $this->debug['tipoDeclaracao'] ?? '0';

        // Tipo Serviço
        $json['tipoServico'] = (string) $this->debug['tipoServico'];

        // Data Lavratura
        $json['dataLavraturaRegistroAverbacao'] = $this->debug['dataLavraturaRegistroAverbacao'];

        // Tipo Ato - ATENÇÃO: valor 4 não é permitido, usando 1 como padrão
        $json['tipoAto'] = !empty($this->debug['tipoAto']) ? (string) $this->debug['tipoAto'] : '1';

        // Tipo Livro - padrão 1
        $json['tipoLivro'] = !empty($this->debug['tipoLivro']) ? (string) $this->debug['tipoLivro'] : '1';

        // Número Livro
        $json['numeroLivro'] = (string) $this->debug['numeroLivro'];

        // Folha
        $json['folha'] = (string) $this->debug['folha'];

        // Matrícula - remove caracteres não numéricos
        $json['matricula'] = (string) preg_replace('/[^0-9]/', '', $this->debug['matricula']);

        // Código IBGE - deve ter 7 dígitos numéricos
        if (!empty($this->debug['codigoIbge'])) {
            $codigoIbge = preg_replace('/[^0-9]/', '', $this->debug['codigoIbge']);
            $json['codigoIbge'] = str_pad($codigoIbge, 7, '0', STR_PAD_LEFT);
        }

        // Número Registro Averbação
        if ($this->debug['numeroRegistroAverbacao'] !== null) {
            $json['numeroRegistroAverbacao'] = (string) $this->debug['numeroRegistroAverbacao'];
        }

        // Natureza Título
        $json['naturezaTitulo'] = (string) $this->debug['naturezaTitulo'];

        // Existe DOI Anterior
        $json['existeDoiAnterior'] = $this->debug['existeDoiAnterior'] ?? false;

        // Data Negócio Jurídico
        if ($this->debug['dataNegocioJuridico'] !== null) {
            $json['dataNegocioJuridico'] = $this->debug['dataNegocioJuridico'];
        }

        // Tipo Operação Imobiliária
        $json['tipoOperacaoImobiliaria'] = (string) $this->debug['tipoOperacaoImobiliaria'];

        // Se tipo 39, informar descrição
        if ($this->debug['tipoOperacaoImobiliaria'] == 39) {
            $json['descricaoOutrasOperacoesImobiliarias'] = (string) ($this->debug['descricaoOutrasOperacoesImobiliarias'] ?? '');
        }

        // Valor Operação Imobiliária
        if ($this->debug['valorOperacaoImobiliaria'] !== null) {
            $json['valorOperacaoImobiliaria'] = $this->debug['valorOperacaoImobiliaria'];
        }

        // Indicador Não Consta Valor Operação
        $json['indicadorNaoConstaValorOperacaoImobiliaria'] = $this->debug['indicadorNaoConstaValorOperacaoImobiliaria'] ?? false;

        // Valor Base Cálculo ITBI/ITCMD
        if ($this->debug['valorBaseCalculoItbiItcmd'] !== null) {
            $json['valorBaseCalculoItbiItcmd'] = $this->debug['valorBaseCalculoItbiItcmd'];
        }

        // Indicador Não Consta Valor Base Cálculo
        $json['indicadorNaoConstaValorBaseCalculoItbiItcmd'] = $this->debug['indicadorNaoConstaValorBaseCalculoItbiItcmd'] ?? false;

        // Forma Pagamento
        $json['formaPagamento'] = $this->debug['formaPagamento'] ? (string) $this->debug['formaPagamento'] : '11';

        // ⚠️ CAMPOS OBRIGATÓRIOS - sempre enviar com false como padrão
        $json['indicadorPermutaBens'] = $this->debug['indicadorPermutaBens'] ?? false;
        $json['indicadorPagamentoDinheiro'] = $this->debug['indicadorPagamentoDinheiro'] ?? false;

        // Valor Parte Transacionada
        if (empty($this->debug['valorParteTransacionada']) || is_null($this->debug['valorParteTransacionada']) || $this->debug['valorParteTransacionada'] === 0) {
            $json['valorParteTransacionada'] = 100;
        } else {
            $json['valorParteTransacionada'] = $this->debug['valorParteTransacionada'];
        }

        // Tipo Parte Transacionada
        $json['tipoParteTransacionada'] = empty($this->debug['tipoParteTransacionada']) ? "1" : (string) $this->debug['tipoParteTransacionada'];

        // CIB
        if ($this->debug['cib'] !== null) {
            $json['cib'] = $this->debug['cib'];
        }

        // Destinação
        $json['destinacao'] = (string) $this->debug['destinacao'];

        // ⚠️ CAMPO OBRIGATÓRIO - sempre enviar com false como padrão
        $json['indicadorImovelPublicoUniao'] = $this->debug['indicadorImovelPublicoUniao'] ?? false;

        // Área Imóvel
        if ($this->debug['areaImovel'] !== null) {
            $json['areaImovel'] = $this->debug['areaImovel'];
        }

        // Indicador Área Lote Não Consta
        $json['indicadorAreaLoteNaoConsta'] = $this->debug['indicadorAreaLoteNaoConsta'] ?? false;

        // Tipo Imóvel
        if ($this->debug['tipoImovel'] !== null) {
            $json['tipoImovel'] = (string) $this->debug['tipoImovel'];
        }

        // Nome Logradouro
        if ($this->debug['nomeLogradouro'] !== null) {
            $json['nomeLogradouro'] = $this->debug['nomeLogradouro'];
        }

        // Número Imóvel
        if ($this->debug['numeroImovel'] !== null) {
            $json['numeroImovel'] = (string) $this->debug['numeroImovel'];
        }

        // Complemento Endereço
        if ($this->debug['complementoEndereco'] !== null) {
            $json['complementoEndereco'] = $this->debug['complementoEndereco'];
        }

        // Bairro
        if ($this->debug['bairro'] !== null) {
            $json['bairro'] = $this->debug['bairro'];
        }

        // CEP
        if ($this->debug['cep'] !== null) {
            $json['cep'] = $this->debug['cep'];
        }

        // Localização
        if ($this->debug['localizacao'] !== null) {
            $json['localizacao'] = $this->debug['localizacao'];
        }

        // ============================================
        // ALIENANTES (Transmitentes)
        // ============================================
        if ($this->relationLoaded('transmitentes') && $this->transmitentes->count() > 0) {
            $alienantes = [];

            foreach ($this->transmitentes as $transmitente) {
                $arrayAlienantes = $transmitente->data;

                if (is_array($arrayAlienantes)) {
                    foreach ($arrayAlienantes as $dadosTransmitente) {
                        $transmitenteData = [];

                        // ⚠️ CAMPOS OBRIGATÓRIOS - sempre enviar com false como padrão
                        $transmitenteData['indicadorRepresentante'] = (bool) ($dadosTransmitente['indicadorRepresentante'] ?? false);
                        $transmitenteData['indicadorEspolio'] = (bool) ($dadosTransmitente['indicadorEspolio'] ?? false);
                        $transmitenteData['indicadorEstrangeiro'] = (bool) ($dadosTransmitente['indicadorEstrangeiro'] ?? false);
                        $transmitenteData['indicadorNaoConstaParticipacaoOperacao'] = (bool) ($dadosTransmitente['indicadorNaoConstaParticipacaoOperacao'] ?? false);

                        // Indicador NI Identificado
                        if (isset($dadosTransmitente['indicadorNiIdentificado']) && $dadosTransmitente['indicadorNiIdentificado'] === false) {
                            $transmitenteData['indicadorNiIdentificado'] = false;
                            $transmitenteData['motivoNaoIdentificacaoNi'] = (string) ($dadosTransmitente['motivoNaoIdentificacaoNi'] ?? '');
                        } else {
                            $transmitenteData['indicadorNiIdentificado'] = true;
                        }

                        // NI
                        if (isset($dadosTransmitente['ni']) && $dadosTransmitente['ni'] !== null) {
                            $transmitenteData['ni'] = $dadosTransmitente['ni'];
                        }

                        // Participação
                        if (isset($dadosTransmitente['participacao']) && $dadosTransmitente['participacao'] !== null) {
                            $transmitenteData['participacao'] = $dadosTransmitente['participacao'];
                        }

                        // Representantes
                        if (isset($dadosTransmitente['representantes']) && is_array($dadosTransmitente['representantes']) && !empty($dadosTransmitente['representantes'])) {
                            $transmitenteData['representantes'] = [];
                            foreach ($dadosTransmitente['representantes'] as $representante) {
                                if (isset($representante['ni']) && $representante['ni'] !== null) {
                                    $transmitenteData['representantes'][] = ['ni' => $representante['ni']];
                                }
                            }
                        }

                        $alienantes[] = $transmitenteData;
                    }
                }
            }

            if (empty($alienantes)) {
                throw new \Exception('É obrigatório informar ao menos um vendedor/transmitente');
            }
            $json['alienantes'] = $alienantes;
        } else {
            throw new \Exception('É obrigatório informar ao menos um vendedor/transmitente');
        }

        // ============================================
        // ADQUIRENTES
        // ============================================
        if ($this->relationLoaded('adquirentes') && $this->adquirentes->count() > 0) {
            $adquirentes = [];

            foreach ($this->adquirentes as $adquirente) {
                $arrayAdquirentes = $adquirente->data;

                if (is_array($arrayAdquirentes)) {
                    foreach ($arrayAdquirentes as $dadosAdquirente) {
                        $adquirenteData = [];

                        // ⚠️ CAMPOS OBRIGATÓRIOS - sempre enviar com false como padrão
                        $adquirenteData['indicadorRepresentante'] = (bool) ($dadosAdquirente['indicadorRepresentante'] ?? false);
                        $adquirenteData['indicadorEspolio'] = (bool) ($dadosAdquirente['indicadorEspolio'] ?? false);
                        $adquirenteData['indicadorEstrangeiro'] = (bool) ($dadosAdquirente['indicadorEstrangeiro'] ?? false);
                        $adquirenteData['indicadorNaoConstaParticipacaoOperacao'] = (bool) ($dadosAdquirente['indicadorNaoConstaParticipacaoOperacao'] ?? false);

                        // Indicador NI Identificado
                        if (isset($dadosAdquirente['indicadorNiIdentificado']) && $dadosAdquirente['indicadorNiIdentificado'] === false) {
                            $adquirenteData['indicadorNiIdentificado'] = false;
                            $adquirenteData['motivoNaoIdentificacaoNi'] = (string) ($dadosAdquirente['motivoNaoIdentificacaoNi'] ?? '');
                        } else {
                            $adquirenteData['indicadorNiIdentificado'] = true;
                        }

                        // NI
                        if (isset($dadosAdquirente['ni']) && $dadosAdquirente['ni'] !== null) {
                            $adquirenteData['ni'] = $dadosAdquirente['ni'];
                        }

                        // Participação
                        if (isset($dadosAdquirente['participacao']) && $dadosAdquirente['participacao'] !== null) {
                            $adquirenteData['participacao'] = $dadosAdquirente['participacao'];
                        }

                        // Representantes
                        if (isset($dadosAdquirente['representantes']) && is_array($dadosAdquirente['representantes']) && !empty($dadosAdquirente['representantes'])) {
                            $adquirenteData['representantes'] = [];
                            foreach ($dadosAdquirente['representantes'] as $representante) {
                                if (isset($representante['ni']) && $representante['ni'] !== null) {
                                    $adquirenteData['representantes'][] = ['ni' => $representante['ni']];
                                }
                            }
                        }

                        $adquirentes[] = $adquirenteData;
                    }
                }
            }

            if (empty($adquirentes)) {
                throw new \Exception('É obrigatório informar ao menos um comprador/adquirente');
            }
            $json['adquirentes'] = $adquirentes;
        } else {
            throw new \Exception('É obrigatório informar ao menos um comprador/adquirente');
        }

        return $json;
    }
}
