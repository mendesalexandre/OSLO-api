<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de Pedidos de E-Certidão</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Protocolo</th>
                <th>Data Pedido</th>
                <th>Status</th>
                <th>Forma Pgto.</th>
                <th>Valor (R$)</th>
                <th>Solicitante</th>
                <th>CPF/CNPJ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($certidoes as $certidao)
                <tr>
                    <td>{{ $certidao['PROTOCOLO_SOLICITACAO'] }}</td>
                    <td>{{ $certidao['DATA_PEDIDO'] }}</td>
                    <td>{{ $certidao['STATUS_SOLICITACAO'] }}</td>
                    <td>{{ $certidao['TIPO_COBRANCA'] }}</td>
                    <td>{{ $certidao['VALOR'] }}</td>
                    <td>{{ $certidao['SOLICITANTE']['NOME'] }}</td>
                    <td>{{ formatarCnpjCpf($certidao['SOLICITANTE']['CPFCNPJ']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $certidao['SOLICITANTE']['EMAIL'] }}
        {{ $certidao['VALOR'] }} --}}

    {{-- "NOME" => "TOLEDO PIZA ADVOGADOS ASSOCIADOS"
      "TELEFONE" => "11 35269650"
      "EMAIL" => "ci.ativas@toledopizaadvogados.com.br"
      "CPFCNPJ" => "02735428000108"
      "INSCRICAO_MUNICIPAL" => []
      "ISENTO_CCM" => "1"
      "NUMERO_CCM" => []
      "ENDERECO" => array:8 [▶]
    ]
    "CERTIDAO" => array:12 [▼
      "TIPO" => "3"
      "PEDIDO_POR" => "4"
      "MATRICULA" => array:5 [▶]
      "ENDERECO" => []
      "TRANSCRICAO" => []
      "PESSOA" => []
      "PROTOCOLO" => []
      "PACTO_ANTENUPCIAL" => []
      "CONVENCAO" => []
      "LIVRO3" => []
      "OBSERVACAO" => []
      "TIPOFINALIDADE" => "Não desejo declarar a finalidade, estando ciente de que esta poderá ser exigida pelo Cartório, nas situações legalmente previstas." --}}

</body>

</html>
