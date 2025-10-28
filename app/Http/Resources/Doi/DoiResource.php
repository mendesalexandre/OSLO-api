<?php

namespace App\Http\Resources\Doi;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $json = [];

        if ($this->debug['tipoDeclaracao'] !== null) {
            $json['tipoDeclaracao'] = $this->debug['tipoDeclaracao'] !== '0' ? '0' : $this->debug['tipoDeclaracao'];
        }

        $json['tipoServico'] = (string) $this->debug['tipoServico'];
        $json['dataLavraturaRegistroAverbacao'] = $this->debug['dataLavraturaRegistroAverbacao'];
        $json['tipoAto'] =  !empty($this->debug['tipoAto']) ? (string) $this->debug['tipoAto'] : (string) '4';
        $json['tipoLivro'] = !empty($this->debug['tipoLivro']) ?  (string) $this->debug['tipoLivro'] :  (string) '1';
        $json['numeroLivro'] = (string) $this->debug['numeroLivro'];
        $json['folha'] = (string) $this->debug['folha'];
        $json['matricula'] = (string) preg_replace('/[^0-9]/', '', $this->debug['matricula']);

        $json['codigoIbge'] = (string) $this->debug['codigoIbge'];


        if ($this->debug['numeroRegistroAverbacao'] !== null) {
            $json['numeroRegistroAverbacao'] = (string) $this->debug['numeroRegistroAverbacao'];
        }

        $json['naturezaTitulo'] = (string) $this->debug['naturezaTitulo'];

        if ($this->debug['existeDoiAnterior'] === null) {
            $json['existeDoiAnterior'] = false;
        } else {
            $json['existeDoiAnterior'] = $this->debug['existeDoiAnterior'];
        }

        if ($this->debug['dataNegocioJuridico'] !== null) {
            $json['dataNegocioJuridico'] = $this->debug['dataNegocioJuridico'];
        }

        // SE TIPO OPERACAO FOR IGUAL A 39, TEM QUE INFORMAR A DESCRIÇÃO
        if ($this->debug['tipoOperacaoImobiliaria'] == 39) {
            $json['tipoOperacaoImobiliaria'] = (string) $this->debug['tipoOperacaoImobiliaria'];
            $json['descricaoOutrasOperacoesImobiliarias'] = (string) $this->debug['descricaoOutrasOperacoesImobiliarias'] ?? '';
        } else {
            $json['tipoOperacaoImobiliaria'] = (string) $this->debug['tipoOperacaoImobiliaria'];
        }

        $json['tipoOperacaoImobiliaria'] = (string) $this->debug['tipoOperacaoImobiliaria'];

        if ($this->debug['valorOperacaoImobiliaria'] !== null) {
            $json['valorOperacaoImobiliaria'] = $this->debug['valorOperacaoImobiliaria'];
        }

        if ($this->debug['indicadorNaoConstaValorOperacaoImobiliaria'] !== null) {
            $json['indicadorNaoConstaValorOperacaoImobiliaria'] = $this->debug['indicadorNaoConstaValorOperacaoImobiliaria'];
        }

        if ($this->debug['valorBaseCalculoItbiItcmd'] !== null) {
            $json['valorBaseCalculoItbiItcmd'] = $this->debug['valorBaseCalculoItbiItcmd'];
        }

        if ($this->debug['indicadorNaoConstaValorBaseCalculoItbiItcmd'] !== null) {
            $json['indicadorNaoConstaValorBaseCalculoItbiItcmd'] = $this->debug['indicadorNaoConstaValorBaseCalculoItbiItcmd'];
        }

        $json['formaPagamento'] = $this->debug['formaPagamento'] ? (string) $this->debug['formaPagamento'] : '11';

        if ($this->debug['indicadorPermutaBens'] !== null) {
            $json['indicadorPermutaBens'] = $this->debug['indicadorPermutaBens'];
        }

        if ($this->debug['indicadorPagamentoDinheiro'] !== null) {
            $json['indicadorPagamentoDinheiro'] = $this->debug['indicadorPagamentoDinheiro'];
        }

        if (
            empty($this->debug['valorParteTransacionada']) || is_null($this->debug['valorParteTransacionada'])
            || $this->debug['valorParteTransacionada'] === 0
        ) {
            $json['valorParteTransacionada'] = 100;
        } else {
            $json['valorParteTransacionada'] = $this->debug['valorParteTransacionada'];
        }

        if (empty($this->debug['tipoParteTransacionada'])) {
            $json['tipoParteTransacionada'] = "1";
        } else {
            $json['tipoParteTransacionada'] = (string) $this->debug['tipoParteTransacionada'];
        }

        if ($this->debug['cib'] !== null) {
            $json['cib'] = $this->debug['cib'];
        }

        $json['destinacao'] = (string) $this->debug['destinacao'];

        if ($this->debug['indicadorImovelPublicoUniao'] !== null) {
            $json['indicadorImovelPublicoUniao'] = $this->debug['indicadorImovelPublicoUniao'];
        }

        if ($this->debug['areaImovel'] !== null) {
            $json['areaImovel'] = $this->debug['areaImovel'];
        }

        if ($this->debug['indicadorAreaLoteNaoConsta'] !== null) {
            $json['indicadorAreaLoteNaoConsta'] = $this->debug['indicadorAreaLoteNaoConsta'];
        }

        if ($this->debug['tipoImovel'] !== null) {
            $json['tipoImovel'] = (string) $this->debug['tipoImovel'];
        }

        if ($this->debug['nomeLogradouro'] !== null) {
            $json['nomeLogradouro'] = $this->debug['nomeLogradouro'];
        }

        if ($this->debug['numeroImovel'] !== null) {
            $json['numeroImovel'] = (string) $this->debug['numeroImovel'];
        }

        if ($this->debug['complementoEndereco'] !== null) {
            $json['complementoEndereco'] = $this->debug['complementoEndereco'];
        }

        if ($this->debug['bairro'] !== null) {
            $json['bairro'] = $this->debug['bairro'];
        }

        if ($this->debug['cep'] !== null) {
            $json['cep'] = $this->debug['cep'];
        }

        if ($this->debug['localizacao'] !== null) {
            $json['localizacao'] = $this->debug['localizacao'];
        }

        // Transmitentes (renomeados como alienantes para seguir o padrão da versão funcional)
        // if ($this->relationLoaded('transmitentes') && $this->transmitentes->count() > 0) {
        if ($this->relationLoaded('transmitentes') && $this->transmitentes->count() > 0) {
            $alienantes = [];

            foreach ($this->transmitentes as $transmitente) {
                // Agora $transmitente->data é um ARRAY de alienantes
                $arrayAlienantes = $transmitente->data;

                // Verifica se é array e não está vazio
                if (is_array($arrayAlienantes)) {
                    foreach ($arrayAlienantes as $dadosTransmitente) {
                        $transmitenteData = [];

                        if (isset($dadosTransmitente['indicadorRepresentante'])) {
                            $transmitenteData['indicadorRepresentante'] = (bool) $dadosTransmitente['indicadorRepresentante'];
                        }

                        if (isset($dadosTransmitente['indicadorEspolio'])) {
                            $transmitenteData['indicadorEspolio'] = (bool) $dadosTransmitente['indicadorEspolio'];
                        }

                        if (isset($dadosTransmitente['indicadorEstrangeiro'])) {
                            $transmitenteData['indicadorEstrangeiro'] = (bool) $dadosTransmitente['indicadorEstrangeiro'];
                        }

                        if (isset($dadosTransmitente['indicadorNaoConstaParticipacaoOperacao'])) {
                            $transmitenteData['indicadorNaoConstaParticipacaoOperacao'] = (bool) $dadosTransmitente['indicadorNaoConstaParticipacaoOperacao'];
                        }

                        if (isset($dadosTransmitente['indicadorNiIdentificado']) && $dadosTransmitente['indicadorNiIdentificado'] === false) {
                            $transmitenteData['indicadorNiIdentificado'] = (bool) $dadosTransmitente['indicadorNiIdentificado'];
                            $transmitenteData['motivoNaoIdentificacaoNi'] = (string) $dadosTransmitente['motivoNaoIdentificacaoNi'];
                        } else {
                            $transmitenteData['indicadorNiIdentificado'] = (bool) $dadosTransmitente['indicadorNiIdentificado'];
                        }

                        if (isset($dadosTransmitente['ni']) && $dadosTransmitente['ni'] !== null) {
                            $transmitenteData['ni'] = $dadosTransmitente['ni'];
                        }

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

        // Adquirentes
        if ($this->relationLoaded('adquirentes') && $this->adquirentes->count() > 0) {
            $adquirentes = [];

            foreach ($this->adquirentes as $adquirente) {
                // Agora $adquirente->data é um ARRAY de adquirentes
                $arrayAdquirentes = $adquirente->data;

                // Verifica se é array e não está vazio
                if (is_array($arrayAdquirentes)) {
                    foreach ($arrayAdquirentes as $dadosAdquirente) {
                        $adquirenteData = [];

                        if (isset($dadosAdquirente['indicadorRepresentante'])) {
                            $adquirenteData['indicadorRepresentante'] = (bool) $dadosAdquirente['indicadorRepresentante'];
                        }

                        if (isset($dadosAdquirente['indicadorNiIdentificado']) && $dadosAdquirente['indicadorNiIdentificado'] === false) {
                            $adquirenteData['indicadorNiIdentificado'] = (bool) $dadosAdquirente['indicadorNiIdentificado'];
                            $adquirenteData['motivoNaoIdentificacaoNi'] = (string) $dadosAdquirente['motivoNaoIdentificacaoNi'];
                        } else {
                            $adquirenteData['indicadorNiIdentificado'] = (bool) $dadosAdquirente['indicadorNiIdentificado'];
                        }

                        if (isset($dadosAdquirente['indicadorEspolio'])) {
                            $adquirenteData['indicadorEspolio'] = (bool) $dadosAdquirente['indicadorEspolio'];
                        }

                        if (isset($dadosAdquirente['indicadorEstrangeiro'])) {
                            $adquirenteData['indicadorEstrangeiro'] = (bool) $dadosAdquirente['indicadorEstrangeiro'];
                        }

                        if (isset($dadosAdquirente['indicadorNaoConstaParticipacaoOperacao'])) {
                            $adquirenteData['indicadorNaoConstaParticipacaoOperacao'] = (bool) $dadosAdquirente['indicadorNaoConstaParticipacaoOperacao'];
                        }

                        // if (isset($dadosAdquirente['indicadorNiIdentificado'])) {
                        //     $adquirenteData['indicadorNiIdentificado'] = (bool) $dadosAdquirente['indicadorNiIdentificado'];
                        // }

                        if (isset($dadosAdquirente['ni']) && $dadosAdquirente['ni'] !== null) {
                            $adquirenteData['ni'] = $dadosAdquirente['ni'];
                        }

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
