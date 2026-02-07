<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Define variáveis de sessão do PostgreSQL para o sistema de auditoria.
 *
 * O trigger auditoria.fn_registrar_auditoria() lê essas variáveis
 * para identificar o usuário, IP e user-agent da operação.
 */
class AuditoriaContexto
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $usuarioId = auth('api')->id() ?? 0;
            $ipAddress = $request->ip() ?? '0.0.0.0';
            $userAgent = mb_substr($request->userAgent() ?? '', 0, 512);

            // Escapar aspas simples para prevenir SQL injection
            $userAgent = str_replace("'", "''", $userAgent);

            DB::statement("SET LOCAL app.usuario_id = '{$usuarioId}'");
            DB::statement("SET LOCAL app.ip_address = '{$ipAddress}'");
            DB::statement("SET LOCAL app.user_agent = '{$userAgent}'");
        } catch (\Throwable $e) {
            // Não bloquear o request em caso de falha
            Log::warning('Falha ao definir contexto de auditoria', [
                'erro' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}
