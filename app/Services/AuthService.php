<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Generate access token for user
     */
    public function generateAccessToken(User $user, int $expirationHours = 24): array
    {
        try {
            // Revogar tokens anteriores se necessário
            if (config('auth.revoke_other_tokens_on_login', false)) {
                $this->revokeUserTokens($user);
            }

            // Criar novo token com Passport
            $tokenResult = $user->createToken('API Token');
            $token = $tokenResult->token;

            // Definir expiração do token
            $expiresAt = Carbon::now()->addHours($expirationHours);
            $token->expires_at = $expiresAt;
            $token->save();

            Log::info('Token de acesso gerado', [
                'user_id' => $user->id,
                'user_uuid' => $user->uuid,
                'expires_at' => $expiresAt->toDateTimeString(),
                'expiration_hours' => $expirationHours
            ]);

            return [
                'access_token' => $tokenResult->accessToken,
                'expires_at' => $expiresAt->toDateTimeString(),
                'expires_in' => $expiresAt->diffInSeconds(now()),
                'token_type' => 'Bearer'
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao gerar token de acesso', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new \Exception('Erro ao gerar token de acesso');
        }
    }

    /**
     * Revoke all user tokens
     */
    public function revokeUserTokens(User $user): bool
    {
        try {
            $tokens = $user->tokens;

            foreach ($tokens as $token) {
                $token->revoke();
            }

            Log::info('Tokens do usuário revogados', [
                'user_id' => $user->id,
                'tokens_count' => $tokens->count()
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao revogar tokens do usuário', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Logout user (revoke current token)
     */
    public function logout(User $user): bool
    {
        try {
            // Revogar token atual
            $user->token()->revoke();

            Log::info('Logout realizado', [
                'user_id' => $user->id,
                'user_uuid' => $user->uuid
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erro no logout', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Refresh user token
     */
    public function refreshToken(User $user, int $expirationHours = 24): array
    {
        try {
            // Revogar token atual
            $user->token()->revoke();

            // Gerar novo token
            return $this->generateAccessToken($user, $expirationHours);
        } catch (\Exception $e) {
            Log::error('Erro ao renovar token', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            throw new \Exception('Erro ao renovar token');
        }
    }

    /**
     * Validate user for authentication
     */
    public function validateUser(User $user): array
    {
        $errors = [];

        // Verificar se usuário está ativo
        if (!$user->is_ativo) {
            $errors[] = 'Usuário inativo';
        }

        // Verificar se usuário não foi excluído
        if (!is_null($user->data_exclusao)) {
            $errors[] = 'Usuário excluído';
        }

        // Verificar verificação de email se obrigatória
        if (config('auth.require_email_verification', false) && !$user->email_verificado_em) {
            $errors[] = 'Email não verificado';
        }

        return $errors;
    }

    /**
     * Get user's active tokens count
     */
    public function getUserActiveTokensCount(User $user): int
    {
        return $user->tokens()
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->count();
    }

    /**
     * Clean expired tokens (can be called in a scheduled job)
     */
    public function cleanExpiredTokens(): int
    {
        try {
            $expiredTokens = Token::where('expires_at', '<', now())
                ->where('revoked', false)
                ->get();

            $count = $expiredTokens->count();

            foreach ($expiredTokens as $token) {
                $token->revoke();
            }

            Log::info('Tokens expirados limpos', ['count' => $count]);

            return $count;
        } catch (\Exception $e) {
            Log::error('Erro ao limpar tokens expirados', [
                'error' => $e->getMessage()
            ]);

            return 0;
        }
    }

    /**
     * Check if user has too many active sessions
     */
    public function hasExceededMaxSessions(User $user): bool
    {
        $maxSessions = config('auth.max_concurrent_sessions', 5);
        $activeSessions = $this->getUserActiveTokensCount($user);

        return $activeSessions >= $maxSessions;
    }

    /**
     * Force logout from all devices
     */
    public function logoutFromAllDevices(User $user): bool
    {
        try {
            $tokensCount = $this->getUserActiveTokensCount($user);
            $this->revokeUserTokens($user);

            Log::info('Logout forçado de todos os dispositivos', [
                'user_id' => $user->id,
                'tokens_revoked' => $tokensCount
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao fazer logout de todos os dispositivos', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
