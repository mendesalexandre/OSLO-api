<?php

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

trait VerificaPermissao
{
    protected function verificarPermissao(string $permissao): void
    {
        $usuario = auth('api')->user();

        if (!$usuario || !$usuario->temPermissao($permissao)) {
            throw new AccessDeniedHttpException(
                "Você não possui a permissão necessária: {$permissao}"
            );
        }
    }

    protected function verificarAlgumaPermissao(array $permissoes): void
    {
        $usuario = auth('api')->user();

        if (!$usuario || !$usuario->temAlgumaPermissao($permissoes)) {
            throw new AccessDeniedHttpException(
                'Você não possui nenhuma das permissões necessárias: ' . implode(', ', $permissoes)
            );
        }
    }
}
