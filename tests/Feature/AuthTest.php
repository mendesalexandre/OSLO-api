<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Testes de Autenticação JWT
|--------------------------------------------------------------------------
|
| Valida o fluxo completo de autenticação: login, me, refresh, logout,
| alteração de senha e proteção de rotas.
|
*/

beforeEach(function () {
    $this->testPassword = 'SenhaSegura123!';

    $this->user = User::factory()->create([
        'nome' => 'Usuário Teste',
        'email' => 'teste@oslo.test',
        'senha' => Hash::make($this->testPassword),
        'is_ativo' => true,
        'data_exclusao' => null,
    ]);
});

// ========================================
// LOGIN
// ========================================

test('login com credenciais válidas retorna JWT', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => $this->user->email,
        'password' => $this->testPassword,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
                'user' => ['id', 'nome', 'email'],
            ],
            'message',
        ])
        ->assertJson([
            'success' => true,
            'data' => [
                'token_type' => 'Bearer',
            ],
        ]);
});

test('login com senha errada retorna 401', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => $this->user->email,
        'password' => 'senha-errada',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'Credenciais inválidas',
        ]);
});

test('login com email inexistente retorna 401', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'naoexiste@oslo.test',
        'password' => $this->testPassword,
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'Credenciais inválidas',
        ]);
});

test('login com usuário inativo retorna 403', function () {
    $this->user->update(['is_ativo' => false]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $this->user->email,
        'password' => $this->testPassword,
    ]);

    $response->assertStatus(403)
        ->assertJson([
            'success' => false,
            'message' => 'Usuário inativo',
        ]);
});

test('login com usuário excluído retorna 401', function () {
    $this->user->forceFill(['data_exclusao' => now()])->save();

    $response = $this->postJson('/api/auth/login', [
        'email' => $this->user->email,
        'password' => $this->testPassword,
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'Credenciais inválidas',
        ]);
});

test('login sem campos obrigatórios retorna 422', function () {
    $response = $this->postJson('/api/auth/login', []);

    $response->assertStatus(422);
});

test('login atualiza ultimo_login_em e ultimo_login_ip', function () {
    $this->postJson('/api/auth/login', [
        'email' => $this->user->email,
        'password' => $this->testPassword,
    ]);

    $this->user->refresh();
    expect($this->user->ultimo_login_em)->not->toBeNull();
    expect($this->user->ultimo_login_ip)->not->toBeNull();
});

// ========================================
// ME (usuário autenticado)
// ========================================

test('me retorna usuário autenticado com permissões', function () {
    $token = auth('api')->login($this->user);

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/auth/me');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'user' => ['id', 'uuid', 'nome', 'email', 'grupos'],
                'permissoes',
                'modulos',
            ],
        ])
        ->assertJson([
            'success' => true,
        ]);
});

test('me sem token retorna 401', function () {
    $response = $this->getJson('/api/auth/me');

    $response->assertStatus(401);
});

// ========================================
// REFRESH
// ========================================

test('refresh retorna novo token', function () {
    $token = auth('api')->login($this->user);

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->postJson('/api/refresh');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
            ],
        ]);

    // Novo token deve ser diferente do original
    $newToken = $response->json('data.access_token');
    expect($newToken)->not->toBe($token);
});

// ========================================
// LOGOUT
// ========================================

test('logout invalida o token', function () {
    $token = auth('api')->login($this->user);

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    // Token deve estar na blacklist
    $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/auth/me')
        ->assertStatus(401);
});

// ========================================
// CHECK TOKEN
// ========================================

test('check-token com token válido retorna valid true', function () {
    $token = auth('api')->login($this->user);

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/auth/check-token');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'valid' => true,
            ],
        ])
        ->assertJsonStructure([
            'data' => ['valid', 'user', 'expires_in'],
        ]);
});

// ========================================
// CHANGE PASSWORD
// ========================================

test('change-password altera senha e invalida token', function () {
    $token = auth('api')->login($this->user);
    $novaSenha = 'NovaSenha456!';

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->postJson('/api/change-password', [
            'senha_atual' => $this->testPassword,
            'nova_senha' => $novaSenha,
            'nova_senha_confirmation' => $novaSenha,
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    // Token antigo deve estar inválido
    $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/auth/me')
        ->assertStatus(401);

    // Login com nova senha deve funcionar
    $this->postJson('/api/auth/login', [
        'email' => $this->user->email,
        'password' => $novaSenha,
    ])->assertStatus(200);
});

test('change-password com senha atual incorreta retorna 422', function () {
    $token = auth('api')->login($this->user);

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->postJson('/api/change-password', [
            'senha_atual' => 'senha-errada',
            'nova_senha' => 'NovaSenha456!',
            'nova_senha_confirmation' => 'NovaSenha456!',
        ]);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'Senha atual incorreta.',
        ]);
});

// ========================================
// PROTEÇÃO DE ROTAS
// ========================================

test('rotas de negócio sem token retornam 401', function () {
    $rotasProtegidas = [
        ['GET', '/api/feriados'],
        ['GET', '/api/dominios'],
        ['GET', '/api/natureza'],
        ['GET', '/api/estados'],
        ['GET', '/api/cidade'],
        ['GET', '/api/caixa'],
        ['GET', '/api/configuracao'],
        ['GET', '/api/transacao'],
    ];

    foreach ($rotasProtegidas as [$method, $uri]) {
        $response = $this->json($method, $uri);
        expect($response->status())->toBe(401, "Rota $method $uri deveria retornar 401 sem token");
    }
});

test('rotas públicas funcionam sem token', function () {
    $this->getJson('/api/ping')
        ->assertStatus(200)
        ->assertJson(['message' => 'pong']);
});
