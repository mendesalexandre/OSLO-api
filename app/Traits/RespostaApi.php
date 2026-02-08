<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait RespostaApi
{
    protected function sucesso($dados = null, string $mensagem = 'Operação realizada com sucesso', int $codigo = 200): JsonResponse
    {
        return response()->json([
            'sucesso'  => true,
            'mensagem' => $mensagem,
            'dados'    => $dados,
        ], $codigo);
    }

    protected function sucessoPaginado(LengthAwarePaginator $paginador, string $mensagem = 'Consulta realizada com sucesso'): JsonResponse
    {
        return response()->json([
            'sucesso'  => true,
            'mensagem' => $mensagem,
            'dados'    => $paginador->items(),
            'paginacao' => [
                'pagina_atual'  => $paginador->currentPage(),
                'por_pagina'    => $paginador->perPage(),
                'total'         => $paginador->total(),
                'ultima_pagina' => $paginador->lastPage(),
            ],
        ]);
    }

    protected function erro(string $mensagem = 'Erro ao processar requisição', int $codigo = 400, $erros = null): JsonResponse
    {
        $resposta = [
            'sucesso'  => false,
            'mensagem' => $mensagem,
        ];

        if ($erros !== null) {
            $resposta['erros'] = $erros;
        }

        return response()->json($resposta, $codigo);
    }

    protected function naoEncontrado(string $mensagem = 'Registro não encontrado'): JsonResponse
    {
        return $this->erro($mensagem, 404);
    }

    protected function criado($dados = null, string $mensagem = 'Registro criado com sucesso'): JsonResponse
    {
        return $this->sucesso($dados, $mensagem, 201);
    }
}
