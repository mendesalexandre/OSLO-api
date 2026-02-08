<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChecarPermissao
{
    public function handle(Request $request, Closure $next, string ...$permissoes): Response
    {
        $usuario = auth('api')->user();

        if (!$usuario) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Não autenticado',
            ], 401);
        }

        // Admin bypassa todas as permissões
        if ($usuario->isAdmin()) {
            return $next($request);
        }

        // Verifica se tem ao menos uma das permissões (OR)
        if (!$usuario->temAlgumaPermissao($permissoes)) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Você não possui permissão para acessar este recurso.',
                'dados' => [
                    'permissoes_necessarias' => $permissoes,
                ],
            ], 403);
        }

        return $next($request);
    }
}
