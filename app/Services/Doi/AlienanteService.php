<?php

namespace App\Services\Doi;

class AlienanteService
{
    public static function gerar($alienante)
    {
        $json = [];

        $json['nome'] = $alienante['nome'];
        $json['cpfCnpj'] = $alienante['cpfCnpj'];
        $json['tipoPessoa'] = $alienante['tipoPessoa'];
        $json['nacionalidade'] = $alienante['nacionalidade'];
        $json['estadoCivil'] = $alienante['estadoCivil'];
        $json['profissao'] = $alienante['profissao'];
        $json['dataNascimento'] = $alienante['dataNascimento'];
        $json['endereco'] = [
            'logradouro' => $alienante['logradouro'],
            'numero' => $alienante['numero'],
            'complemento' => $alienante['complemento'],
            'bairro' => $alienante['bairro'],
            'cep' => $alienante['cep'],
            'cidade' => $alienante['cidade'],
            'uf' => $alienante['uf']
        ];

        return $json;
    }
}
