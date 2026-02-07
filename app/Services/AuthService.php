<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    /**
     * Generate JWT access token for a user.
     */
    public function generateAccessToken(User $user): array
    {
        try {
            $token = JWTAuth::fromUser($user);
            $ttl = config('jwt.ttl', 60);

            Log::info('Token de acesso gerado', [
                'user_id' => $user->id,
                'user_uuid' => $user->uuid,
                'ttl_minutes' => $ttl,
            ]);

            return [
                'access_token' => $token,
                'expires_in' => $ttl * 60,
                'token_type' => 'Bearer',
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao gerar token de acesso', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Erro ao gerar token de acesso');
        }
    }

    /**
     * Invalidate the current JWT token via blacklist.
     */
    public function revokeCurrentToken(): bool
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return true;
        } catch (JWTException $e) {
            Log::error('Erro ao revogar token', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Validate user for authentication.
     */
    public function validateUser(User $user): array
    {
        $errors = [];

        if (!$user->is_ativo) {
            $errors[] = 'Usuário inativo';
        }

        if (!is_null($user->data_exclusao)) {
            $errors[] = 'Usuário excluído';
        }

        if (config('auth.require_email_verification', false) && !$user->email_verificado_em) {
            $errors[] = 'Email não verificado';
        }

        return $errors;
    }

    /**
     * Refresh the current JWT token.
     */
    public function refreshToken(): ?string
    {
        try {
            return JWTAuth::refresh(JWTAuth::getToken());
        } catch (JWTException $e) {
            Log::error('Erro ao renovar token', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
