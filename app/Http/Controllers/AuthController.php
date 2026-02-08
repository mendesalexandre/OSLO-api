<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Handle user login.
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'password.required' => 'O campo password é obrigatório.',
        ]);

        // Buscar usuário (não excluído)
        $user = User::query()
            ->where('email', $request->email)
            ->whereNull('data_exclusao')
            ->first();

        if (!$user) {
            Log::warning('Tentativa de login - usuário não encontrado', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);

            return $this->errorResponse('Credenciais inválidas', [], 401);
        }

        if (!$user->is_ativo) {
            return $this->errorResponse('Usuário inativo', [], 403);
        }

        // Autenticação JWT via guard 'api'
        // 'password' é a chave que o guard usa para obter o valor plain-text,
        // getAuthPassword() no model retorna $this->senha (coluna do banco)
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!$token = auth('api')->attempt($credentials)) {
            Log::warning('Tentativa de login - credenciais inválidas', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);

            return $this->errorResponse('Credenciais inválidas', [], 401);
        }

        // Atualizar informações de último login
        $user->update([
            'ultimo_login_em' => now(),
            'ultimo_login_ip' => $request->ip(),
        ]);

        Log::info('Login realizado com sucesso', [
            'user_id' => $user->id,
            'ip' => $request->ip(),
        ]);

        return $this->respondWithToken($token, $user);
    }

    /**
     * Get the authenticated user with permissions and roles.
     */
    public function me(): JsonResponse
    {
        $user = auth('api')->user();

        return $this->successResponse([
            'user' => $this->formatUserResponse($user),
            'permissoes' => $user->obterPermissoes(),
            'modulos' => $user->obterPermissoesPorModulo(),
        ]);
    }

    /**
     * Log the user out (invalidate the token).
     */
    public function logout(): JsonResponse
    {
        try {
            $userId = auth('api')->id();
            auth('api')->logout();

            Log::info('Logout realizado', [
                'user_id' => $userId,
                'ip' => request()->ip(),
            ]);

            return $this->successResponse(null, [
                'message' => 'Logout realizado com sucesso.',
            ]);
        } catch (JWTException $e) {
            Log::error('Erro no logout', [
                'error' => $e->getMessage(),
            ]);

            return $this->errorResponse('Erro ao fazer logout.', [], 500);
        }
    }

    /**
     * Refresh the JWT token.
     */
    public function refresh(): JsonResponse
    {
        try {
            $token = auth('api')->refresh();
            $user = auth('api')->setToken($token)->user();

            Log::info('Token renovado', [
                'user_id' => $user?->id,
                'ip' => request()->ip(),
            ]);

            return $this->respondWithToken($token, $user);
        } catch (JWTException $e) {
            Log::error('Erro ao renovar token', [
                'error' => $e->getMessage(),
            ]);

            return $this->errorResponse('Erro ao renovar token.', [], 401);
        }
    }

    /**
     * Invalidate the current token.
     * JWT is stateless — token is added to the blacklist.
     */
    public function revokeAllTokens(): JsonResponse
    {
        try {
            $userId = auth('api')->id();
            auth('api')->logout();

            Log::info('Revogação de tokens solicitada', [
                'user_id' => $userId,
                'ip' => request()->ip(),
            ]);

            return $this->successResponse(null, [
                'message' => 'Token revogado com sucesso. Faça login novamente em todos os dispositivos.',
            ]);
        } catch (JWTException $e) {
            Log::error('Erro ao revogar tokens', [
                'error' => $e->getMessage(),
            ]);

            return $this->errorResponse('Erro ao revogar tokens.', [], 500);
        }
    }

    /**
     * Change the authenticated user's password.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'senha_atual' => 'required|string',
            'nova_senha' => 'required|string|min:6|confirmed',
        ], [
            'senha_atual.required' => 'A senha atual é obrigatória.',
            'nova_senha.required' => 'A nova senha é obrigatória.',
            'nova_senha.min' => 'A nova senha deve ter pelo menos 6 caracteres.',
            'nova_senha.confirmed' => 'A confirmação da nova senha não corresponde.',
        ]);

        $user = auth('api')->user();

        if (!Hash::check($request->senha_atual, $user->senha)) {
            return $this->errorResponse('Senha atual incorreta.', [], 422);
        }

        $user->update([
            'senha' => $request->nova_senha, // 'hashed' cast handles hashing
        ]);

        // Invalidar token para forçar re-login com nova senha
        auth('api')->logout();

        Log::info('Senha alterada com sucesso', [
            'user_id' => $user->id,
            'ip' => $request->ip(),
        ]);

        return $this->successResponse(null, [
            'message' => 'Senha alterada com sucesso. Faça login novamente.',
        ]);
    }

    /**
     * Check if the current token is valid.
     */
    public function checkToken(): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return $this->successResponse([
                'valid' => true,
                'user' => $this->formatUserResponse($user),
                'expires_in' => JWTAuth::getPayload()->get('exp') - time(),
            ]);
        } catch (JWTException $e) {
            return $this->errorResponse('Token inválido.', [
                'valid' => false,
            ], 401);
        }
    }

    /**
     * Format user data for response.
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
            'is_ativo' => $user->is_ativo,
            'grupos' => $user->grupos()->ativos()->pluck('nome')->toArray(),
        ];
    }

    /**
     * Build the token response structure.
     */
    private function respondWithToken(string $token, ?User $user = null): JsonResponse
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ];

        if ($user) {
            $data['user'] = [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
                'grupos' => $user->grupos()->ativos()->pluck('nome')->toArray(),
            ];
            $data['permissoes'] = $user->obterPermissoes();
            $data['modulos'] = $user->obterPermissoesPorModulo();
        }

        return $this->successResponse($data, [
            'message' => 'Autenticação realizada com sucesso.',
        ]);
    }
}
