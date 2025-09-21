<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class WhitelistIpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $this->getClientIpAddress($request);
        $allowedIps = $this->getAllowedIps();

        // Log da tentativa de acesso
        Log::info('Tentativa de acesso', [
            'ip' => $clientIp,
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);

        // Verifica se o IP está na whitelist
        if (!$this->isIpAllowed($clientIp, $allowedIps)) {
            Log::warning('Acesso negado - IP não autorizado', [
                'ip' => $clientIp,
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent()
            ]);

            // Retorna erro 403 - Forbidden
            return response()->json([
                'message' => 'Acesso negado. IP não autorizado.',
                'ip' => $clientIp
            ], 403);
        }

        Log::info('Acesso autorizado', ['ip' => $clientIp]);

        return $next($request);
    }

    /**
     * Obtém o IP real do cliente considerando proxies e load balancers
     */
    private function getClientIpAddress(Request $request): string
    {
        // Headers a verificar em ordem de prioridade
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_X_REAL_IP',            // Nginx proxy
            'HTTP_X_FORWARDED_FOR',      // Load balancers/proxies
            'HTTP_X_FORWARDED',          // Proxies
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Outros proxies
            'HTTP_FORWARDED',            // RFC 7239
            'REMOTE_ADDR'                // IP direto (padrão)
        ];

        foreach ($headers as $header) {
            $ip = $request->server($header);

            if (!empty($ip)) {
                // Se contém múltiplos IPs separados por vírgula, pega o primeiro
                if (str_contains($ip, ',')) {
                    $ip = trim(explode(',', $ip)[0]);
                }

                // Valida se é um IP válido
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        // Fallback para o IP padrão do request
        return $request->ip();
    }

    /**
     * Obtém a lista de IPs permitidos
     */
    private function getAllowedIps(): array
    {
        $ips = config('security.whitelist_ips', []);

        // Se não há IPs configurados, permite apenas localhost
        if (empty($ips)) {
            return [
                '127.0.0.1',
                '::1',
                'localhost'
            ];
        }

        return $ips;
    }

    /**
     * Verifica se o IP está permitido
     */
    private function isIpAllowed(string $clientIp, array $allowedIps): bool
    {
        foreach ($allowedIps as $allowedIp) {
            if ($this->matchIp($clientIp, $allowedIp)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica se o IP do cliente corresponde ao padrão permitido
     * Suporta:
     * - IPs exatos: 192.168.1.100
     * - Ranges CIDR: 192.168.1.0/24
     * - Wildcards: 192.168.1.*
     */
    private function matchIp(string $clientIp, string $allowedPattern): bool
    {
        // IP exato
        if ($clientIp === $allowedPattern) {
            return true;
        }

        // Localhost variants
        if (
            in_array($allowedPattern, ['localhost', '127.0.0.1', '::1']) &&
            in_array($clientIp, ['127.0.0.1', '::1'])
        ) {
            return true;
        }

        // CIDR notation (ex: 192.168.1.0/24)
        if (str_contains($allowedPattern, '/')) {
            return $this->ipInCidr($clientIp, $allowedPattern);
        }

        // Wildcard pattern (ex: 192.168.1.*)
        if (str_contains($allowedPattern, '*')) {
            return $this->ipMatchesWildcard($clientIp, $allowedPattern);
        }

        return false;
    }

    /**
     * Verifica se IP está dentro do range CIDR
     */
    private function ipInCidr(string $ip, string $cidr): bool
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        [$subnet, $bits] = explode('/', $cidr);

        if (!filter_var($subnet, FILTER_VALIDATE_IP)) {
            return false;
        }

        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;

        return ($ip & $mask) === $subnet;
    }

    /**
     * Verifica se IP corresponde ao padrão com wildcard
     */
    private function ipMatchesWildcard(string $ip, string $pattern): bool
    {
        // Converte o padrão com * para regex
        $regex = str_replace(['.', '*'], ['\.', '\d+'], $pattern);
        $regex = "/^{$regex}$/";

        return preg_match($regex, $ip);
    }
}
