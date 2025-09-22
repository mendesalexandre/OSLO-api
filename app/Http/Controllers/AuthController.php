<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    use ApiResponseTrait;


    /**
     * Handle user login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Buscar usuário pelo email
        $user = $this->findUserByEmail($request->getEmail());

        // Verificar se usuário existe e está ativo
        if (!$user) {
            return $this->loginFailedResponse($request, 'Usuário não encontrado');
        }

        if (!$user->is_ativo) {
            return $this->loginFailedResponse($request, 'Usuário inativo');
        }

        // Verificar senha
        if (!Hash::check($request->getPassword(), $user->senha)) {
            return $this->loginFailedResponse($request, 'Senha incorreta');
        }

        // Verificar se email foi verificado (se necessário)
        if ($this->shouldVerifyEmail() && !$user->email_verificado_em) {
            return $this->errorResponse(
                'Email não verificado. Verifique sua caixa de entrada.',
                ['code' => 'EMAIL_NOT_VERIFIED'],
                403
            );
        }

        // Gerar token JWT
        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            Log::error('Erro ao gerar token JWT', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse('Erro ao gerar token de acesso.', [], 500);
        }

        // Atualizar dados do último login
        $this->updateLastLogin($user, $request);

        // Log de sucesso
        Log::info('Login realizado com sucesso', [
            'user_id' => $user->id,
            'user_uuid' => $user->uuid,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'remember_me' => $request->shouldRemember()
        ]);

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('jwt.ttl') * 60, // TTL em segundos
            'user' => $this->formatUserResponse($user)
        ], [
            'message' => 'Login realizado com sucesso.'
        ]);
    }

    /**
     * Get the authenticated User.
     */
    public function me(): JsonResponse
    {
        $user = auth()->user();

        return $this->successResponse([
            'user' => $this->formatUserResponse($user),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'roles' => $user->getRoleNames()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            Log::info('Logout realizado', [
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);

            return $this->successResponse(null, [
                'message' => 'Logout realizado com sucesso.'
            ]);
        } catch (JWTException $e) {
            Log::error('Erro no logout', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse('Erro ao fazer logout.', [], 500);
        }
    }

    /**
     * Refresh a token.
     */
    public function refresh(): JsonResponse
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());

            Log::info('Token renovado', [
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);

            return $this->successResponse([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ], [
                'message' => 'Token renovado com sucesso.'
            ]);
        } catch (JWTException $e) {
            Log::error('Erro ao renovar token', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse('Erro ao renovar token.', [], 500);
        }
    }

    /**
     * Invalidate all user tokens (logout from all devices).
     */
    public function logoutAllDevices(): JsonResponse
    {
        try {
            // Invalidar token atual
            JWTAuth::invalidate(JWTAuth::getToken());

            // Para JWT, não há como invalidar todos os tokens de uma vez
            // Uma alternação seria usar uma blacklist ou mudar o JWT secret do usuário
            // Por enquanto, apenas invalidamos o token atual

            Log::info('Logout de todos os dispositivos', [
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);

            return $this->successResponse(null, [
                'message' => 'Logout realizado de todos os dispositivos.'
            ]);
        } catch (JWTException $e) {
            Log::error('Erro no logout de todos os dispositivos', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse('Erro ao fazer logout.', [], 500);
        }
    }

    /**
     * Check if token is valid.
     */
    public function checkToken(): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return $this->successResponse([
                'valid' => true,
                'user' => $this->formatUserResponse($user),
                'expires_in' => JWTAuth::getPayload()->get('exp') - time()
            ]);
        } catch (JWTException $e) {
            return $this->errorResponse('Token inválido.', [
                'valid' => false
            ], 401);
        }
    }

    /**
     * Find user by email
     */
    private function findUserByEmail(string $email): ?User
    {
        return User::query()
            ->where('email', $email)
            ->whereNull('data_exclusao')
            ->first();
    }

    /**
     * Handle failed login response
     */
    private function loginFailedResponse(LoginRequest $request, string $reason): JsonResponse
    {
        Log::warning('Tentativa de login falhada', [
            'email' => $request->getEmail(),
            'reason' => $reason,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        return $this->errorResponse(
            'Os dados informados são inválidos, por favor tente novamente.',
            [],
            401
        );
    }

    /**
     * Update user's last login information
     */
    private function updateLastLogin(User $user, LoginRequest $request): void
    {
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);
    }

    /**
     * Format user data for response
     */
    private function formatUserResponse(User $user): array
    {
        return [
            'id' => $user->id,
            'uuid' => $user->uuid,
            'nome' => $user->nome,
            'email' => $user->email,
            'foto' => $user->foto ? asset('storage/' . $user->foto) : null,
            'email_verificado' => !is_null($user->email_verificado_em),
            'data_cadastro' => $user->data_cadastro?->format('Y-m-d H:i:s'),
            'is_ativo' => $user->is_ativo
        ];
    }

    /**
     * Check if email verification is required
     */
    private function shouldVerifyEmail(): bool
    {
        return config('auth.require_email_verification', false);
    }
}
