<?php

namespace App\Services\Doi;

class AdquirenteService
{
    public static function gerar($adquirente)
    {
        $json = [];

        $json['nome'] = $adquirente['nome'];
        $json['cpfCnpj'] = $adquirente['cpfCnpj'];
        $json['tipoPessoa'] = $adquirente['tipoPessoa'];
        $json['nacionalidade'] = $adquirente['nacionalidade'];
        $json['estadoCivil'] = $adquirente['estadoCivil'];
        $json['profissao'] = $adquirente['profissao'];
        $json['dataNascimento'] = $adquirente['dataNascimento'];
        $json['endereco'] = [
            'logradouro' => $adquirente['logradouro'],
            'numero' => $adquirente['numero'],
            'complemento' => $adquirente['complemento'],
            'bairro' => $adquirente['bairro'],
            'cep' => $adquirente['cep'],
            'cidade' => $adquirente['cidade'],
            'uf' => $adquirente['uf']
        ];

        return $json;
    }
}
