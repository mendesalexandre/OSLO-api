<?php

namespace App\Services\Doi;

class DoiService
{
    public static function gerar($data)
    {
        $json = [];

        if ($data['data']['tipoDeclaracao'] !== null) {
            $json['tipoDeclaracao'] = $data['data']['tipoDeclaracao'] !== '0' ? '0' : $data['data']['tipoDeclaracao'];
        }

        $json['tipoServico'] = (string) $data['data']['tipoServico'];
        $json['dataLavraturaRegistroAverbacao'] = $data['data']['dataLavraturaRegistroAverbacao'];
        $json['tipoAto'] = (string) !empty($data['data']['tipoAto']) ? $data['data']['tipoAto'] : '4';
        $json['tipoLivro'] = (string) !empty($data['data']['tipoLivro']) ? $data['data']['tipoLivro'] : '1';
        $json['numeroLivro'] = (string) $data['data']['numeroLivro'];
        $json['numeroLivro'] = '0000002';
        $json['folha'] = (string) $data['data']['folha'];
        $json['matricula'] = (string) preg_replace('/[^0-9]/', '', $data['data']['matricula']);
        // $json['codigoNacionalMatricula'] = preg_replace('/[^0-9]/', '', $data['data']['codigoNacionalMatricula']);
        // $json['transcricao'] = (string) $data['transcricao'];

        // if ($data['data']['codigoNacionalMatricula'] !== null) {
        //     $json['codigoNacionalMatricula']  = $data['data']['codigoNacionalMatricula'];
        // }

        $json['numeroRegistroAverbacao'] = $data['data']['numeroRegistroAverbacao'];
        $json['naturezaTitulo'] = (string) $data['data']['naturezaTitulo'];
        // $json['numeroRegistro'] = $data['numeroRegistro'];

        if ($data['data']['existeDoiAnterior'] === null) {
            $json['existeDoiAnterior'] = false;
        }

        if ($data['data']['descricaoOutrasOperacoesImobiliarias'] !== null) {
            $json['descricaoOutrasOperacoesImobiliarias'] = 'Não informado';
        }

        $json['dataNegocioJuridico'] = $data['data']['dataNegocioJuridico'];

        $json['tipoOperacaoImobiliaria'] = (string) $data['data']['tipoOperacaoImobiliaria'];

        $json['valorOperacaoImobiliaria'] = $data['data']['valorOperacaoImobiliaria'];

        $json['indicadorNaoConstaValorOperacaoImobiliaria'] = $data['data']['indicadorNaoConstaValorOperacaoImobiliaria'];

        if ($data['data']['valorBaseCalculoItbiItcmd'] !== null) {
            $json['valorBaseCalculoItbiItcmd'] = $data['data']['valorBaseCalculoItbiItcmd'];
        }

        $json['indicadorNaoConstaValorBaseCalculoItbiItcmd'] = $data['data']['indicadorNaoConstaValorBaseCalculoItbiItcmd'];

        $json['formaPagamento'] = $data['data']['formaPagamento'] ? (string) $data['data']['formaPagamento'] : '11';

        if ($data['data']['indicadorAlienacaoFiduciaria'] !== null) {
            $json['indicadorAlienacaoFiduciaria'] = $data['data']['indicadorAlienacaoFiduciaria'];
        }

        if ($data['data']['mesAnoUltimaParcela'] !== null) {
            $json['mesAnoUltimaParcela'] = $data['mesAnoUltimaParcela'];
        }

        if ($data['data']['valorPagoAteDataAto'] !== null) {
            $json['valorPagoAteDataAto'] = $data['data']['valorPagoAteDataAto'];
        }

        if ($data['data']['indicadorPermutaBens'] !== null) {
            $json['indicadorPermutaBens'] = $data['data']['indicadorPermutaBens'];
        }

        if ($data['data']['indicadorPagamentoDinheiro'] !== null) {
            $json['indicadorPagamentoDinheiro'] = $data['data']['indicadorPagamentoDinheiro'];
        }

        if ($data['data']['valorPagoMoedaCorrenteDataAto'] !== null) {
            $json['valorPagoMoedaCorrenteDataAto'] = $data['data']['valorPagoMoedaCorrenteDataAto'];
        }

        if (
            empty($data['data']['valorParteTransacionada']) || is_null($data['data']['valorParteTransacionada'])
            || $data['data']['valorParteTransacionada'] === 0
        ) {
            $json['valorParteTransacionada'] = 100;
        }


        if (empty($data['data']['tipoParteTransacionada'])) {
            $json['tipoParteTransacionada'] = "1";
        }

        //   ;

        if ($data['data']['cib'] !== null) {
            $json['cib'] = $data['data']['cib'];
        }

        $json['destinacao'] = (string) $data['data']['destinacao'];

        if ($data['data']['indicadorImovelPublicoUniao'] !== null) {
            $json['indicadorImovelPublicoUniao'] = $data['data']['indicadorImovelPublicoUniao'];
        }

        if ($data['data']['registroImobiliarioPatrimonial'] !== null) {
            $json['registroImobiliarioPatrimonial'] = $data['data']['registroImobiliarioPatrimonial'];
        }

        if ($data['data']['certidaoAutorizacaoTransferencia'] !== null) {
            $json['certidaoAutorizacaoTransferencia'] = $data['data']['certidaoAutorizacaoTransferencia'];
        }

        if ($data['data']['inscricaoMunicipal'] !== null && $data['data']['inscricaoMunicipal'] != '0') {
            $json['inscricaoMunicipal'] = $data['data']['inscricaoMunicipal'];
        }


        // $json['codigoIbge'] = $data['codigoIbge'];

        // if (is_null($data['codigoIbge']) && $data['municipio'] === 'SINOP') {
        //     $json['codigoIbge'] = '5107909';
        //     // if ($data['codigoIbge'] !== null) {
        //     //     $json['codigoIbge'] = $data['codigoIbge'];
        //     // }
        // }

        if (is_null($data['data']['codigoIbge'])) {
            $json['codigoIbge'] = '5107909';
        }

        if ($data['data']['areaImovel'] !== null) {
            $json['areaImovel'] = $data['data']['areaImovel'];
        }

        if ($data['data']['indicadorAreaLoteNaoConsta'] !== null) {
            $json['indicadorAreaLoteNaoConsta'] = $data['data']['indicadorAreaLoteNaoConsta'];
        }

        if ($data['data']['areaConstruida'] !== null) {
            $json['areaConstruida'] = $data['data']['areaConstruida'];
        }

        if ($data['data']['indicadorAreaConstruidaNaoConsta'] !== null) {
            $json['indicadorAreaConstruidaNaoConsta'] = $data['data']['indicadorAreaConstruidaNaoConsta'];
        }

        if ($data['data']['tipoImovel'] !== null) {
            $json['tipoImovel'] = (string) $data['data']['tipoImovel'];
        }

        if ($data['data']['tipoLogradouro'] !== null) {
            $json['tipoLogradouro'] = $data['data']['tipoLogradouro'];
        }

        if ($data['data']['nomeLogradouro'] !== null) {
            $json['nomeLogradouro'] = $data['data']['nomeLogradouro'];
        }

        if ($data['data']['numeroImovel'] !== null) {
            $json['numeroImovel'] = $data['data']['numeroImovel'];
        }

        if ($data['data']['complementoNumeroImovel'] !== null) {
            $json['complementoNumeroImovel'] = $data['data']['complementoNumeroImovel'];
        }

        if ($data['data']['complementoEndereco'] !== null) {
            $json['complementoEndereco'] = $data['data']['complementoEndereco'];
        }

        if ($data['data']['bairro'] !== null) {
            $json['bairro'] = $data['data']['bairro'];
        }

        if ($data['data']['cep'] !== null) {
            $json['cep'] = $data['data']['cep'];
        }

        if ($data['data']['codigoIncra'] !== null) {
            $json['codigoIncra'] = $data['data']['codigoIncra'];
        }

        if ($data['data']['denominacao'] !== null) {
            $json['denominacao'] = $data['data']['denominacao'];
        }

        if ($data['data']['localizacao'] !== null) {
            $json['localizacao'] = $data['data']['localizacao'];
        }

        // $json['municipiosUF'] = $data['municipiosUF'];
        // $json['municipio'] = $data['municipio'];
        // $json['uf'] = $data['uf'];


        // if (isset($alienante)) {
        //     $json['alienantes'] = DoiAlienanteJsonResource::collection($alienante->data);
        // } else {
        //     throw new \Exception('É obrigatório informar ao menos um vendedor/transmitente');
        // }

        // if (isset($adquirente)) {
        //     $json['adquirentes'] = DoiAlienanteJsonResource::collection($adquirente->data);
        // } else {
        //     throw new \Exception('É obrigatório informar ao menos um comprador/adquirente');
        // }

        return $json;
    }
}
