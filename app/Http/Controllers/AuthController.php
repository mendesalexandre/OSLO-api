<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Login do usuário
     */
    public function login(Request $request): JsonResponse
    {
        try {
            // Validação dos dados
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ], [
                'email.required' => 'O email é obrigatório.',
                'email.email' => 'Email deve ter um formato válido.',
                'password.required' => 'A senha é obrigatória.',
                'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Buscar usuário pelo email
            $user = User::query()
                ->where('email', strtolower($request->email))
                ->first();

            // Verificar se usuário existe e senha está correta
            if (!$user || !Hash::check($request->password, $user->senha)) {
                Log::warning('Tentativa de login falhada', [
                    'email' => $request->email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Os dados informados são inválidos, por favor tente novamente.'
                ], 400);
            }

            // Criar token com Passport
            $tokenResult = $user->createToken('API Token');
            $token = $tokenResult->token;

            // Definir expiração do token (24 horas por padrão)
            $token->expires_at = Carbon::now()->addHours(24);
            $token->save();

            // Atualizar último login
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            Log::info('Login realizado com sucesso', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso.',
                'data' => [
                    'access_token' => $tokenResult->accessToken,
                    // 'refresh_token' => $tokenResult->refreshToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
                    'user' => [
                        'id' => $user->id,
                        'nome' => $user->nome,
                        'email' => $user->email,
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Erro no login', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor.'
            ], 500);
        }
    }

    /**
     * Logout do usuário
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Revogar o token atual
            $request->user()->token()->revoke();

            Log::info('Logout realizado', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Logout realizado com sucesso.'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro no logout', [
                'erro' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer logout.'
            ], 500);
        }
    }

    /**
     * Obter dados do usuário autenticado
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at->format('d/m/Y H:i:s'),
                    'updated_at' => $user->updated_at->format('d/m/Y H:i:s'),
                    // Adicione outros campos conforme necessário
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter dados do usuário.'
            ], 500);
        }
    }

    /**
     * Refresh token (opcional)
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Revogar token atual
            $request->user()->token()->revoke();

            // Criar novo token
            $tokenResult = $user->createToken('API Token Refreshed');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addHours(24);
            $token->save();

            Log::info('Token renovado', [
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Token renovado com sucesso.',
                'data' => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao renovar token.'
            ], 500);
        }
    }

    /**
     * Revogar todos os tokens do usuário
     */
    public function revokeAllTokens(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Revogar todos os tokens
            $user->tokens->each(function ($token) {
                $token->revoke();
            });

            Log::info('Todos os tokens revogados', [
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Todos os tokens foram revogados.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao revogar tokens.'
            ], 500);
        }
    }

    /**
     * Alterar senha
     */
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|string|min:6|confirmed',
            ], [
                'current_password.required' => 'A senha atual é obrigatória.',
                'new_password.required' => 'A nova senha é obrigatória.',
                'new_password.min' => 'A nova senha deve ter pelo menos 6 caracteres.',
                'new_password.confirmed' => 'A confirmação da nova senha não confere.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $request->user();

            // Verificar senha atual
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Senha atual incorreta.'
                ], 400);
            }

            // Atualizar senha
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            Log::info('Senha alterada', [
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Senha alterada com sucesso.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao alterar senha.'
            ], 500);
        }
    }
}
