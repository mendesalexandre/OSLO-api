<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ONR\CertificadoDigital;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DominioController;
use App\Http\Controllers\FeriadoController;
use App\Services\ONR\Certidao\CertidaoService;
use App\Services\ONR\Autenticacao\Autenticacao;
use App\Http\Controllers\ONR\CertificadoDigitalController;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();


    // Dominios

})->middleware(['auth:api']);

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::group(['prefix' => 'feriados'], function () {
    Route::get('/', [FeriadoController::class, 'index']);
    Route::post('/criar', [FeriadoController::class, 'create']);
    Route::get('/{id}', [FeriadoController::class, 'show']);
    Route::put('/{id}', [FeriadoController::class, 'update']);
    Route::delete('/{id}', [FeriadoController::class, 'destroy']);
});

Route::group(['prefix' => 'onr'], function () {
    // Route::get('/configuracao', [OnrConfiguracaoController::class, 'index']);
    // Route::post('/configuracao', [OnrConfiguracaoController::class, 'store']);
    // Route::get('/certidao', [OnrCertidaoController::class, 'index']);
    // Route::post('/certidao', [OnrCertidaoController::class, 'store']);
    // Route::get('/certidao/{id}', [OnrCertidaoController::class, 'show']);

    Route::get('/autenticacao/token', function () {
        $autenticacao = app(Autenticacao::class);
        return response()->json($autenticacao->getToken());
    });

    Route::get('/certidao', function () {
        $certidao = new CertidaoService();
        return response()->json($certidao->listarPedidos());
    });


    Route::middleware(['auth:api'])->prefix('certificado-digital')->group(function () {

        // Upload de certificado
        Route::post('/upload', [CertificadoDigitalController::class, 'upload'])
            ->name('certificado.upload');

        // Informações do certificado atual
        Route::get('/info', [CertificadoDigitalController::class, 'info'])
            ->name('certificado.info');

        // Listar todos os certificados
        Route::get('/listar', [CertificadoDigitalController::class, 'listar'])
            ->name('certificado.listar');

        // Testar certificado atual
        Route::post('/testar', [CertificadoDigitalController::class, 'testar'])
            ->name('certificado.testar');

        // Ativar certificado específico
        Route::patch('/{id}/ativar', [CertificadoDigitalController::class, 'ativar'])
            ->name('certificado.ativar');

        // Remover certificado específico
        Route::delete('/{id}', [CertificadoDigitalController::class, 'remover'])
            ->name('certificado.remover');
    });

    // Rotas públicas (se necessário)
    Route::prefix('certificado-digital')->group(function () {

        // Status público (sem dados sensíveis)
        Route::get('/status', function () {
            $certificadoAtivo = CertificadoDigital::ativo();

            return response()->json([
                'certificado_configurado' => $certificadoAtivo !== null,
                'certificado_valido' => $certificadoAtivo?->isValido() ?? false,
                'status' => $certificadoAtivo?->getStatus() ?? 'nenhum',
                'verificado_em' => now()
            ]);
        })->name('certificado.status');
    })->group(function () {
        Route::delete('/{id}', [CertificadoDigitalController::class, 'remover'])
            ->name('certificado.remover');

        // Histórico de certificados
        Route::get('/historico', [CertificadoDigitalController::class, 'historico'])
            ->name('certificado.historico');
    });

    // Rotas públicas (se necessário)
    Route::prefix('certificado-digital')->group(function () {

        // Status público (sem dados sensíveis)
        Route::get('/status', function () {
            $existe = Storage::disk('local')->exists('certificados/certificado_atual.pfx');

            return response()->json([
                'certificado_configurado' => $existe,
                'verificado_em' => now()
            ]);
        })->name('certificado.status');
    });
});

// Login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');



// Rotas protegidas (requerem autenticação)
Route::middleware(['auth:api'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');

    // Dados do usuário autenticado
    Route::get('/me', [AuthController::class, 'me'])
        ->name('auth.me');

    // Renovar token
    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->name('auth.refresh');

    // Revogar todos os tokens
    Route::post('/revoke-all', [AuthController::class, 'revokeAllTokens'])
        ->name('auth.revokeAll');

    // Alterar senha
    Route::post('/change-password', [AuthController::class, 'changePassword'])
        ->name('auth.changePassword');


    Route::group(['prefix' => 'dominios'], function () {
        Route::get('/', [DominioController::class, 'index']);
        Route::post('/criar', [DominioController::class, 'create']);
        Route::get('/{id}', [DominioController::class, 'show']);
        Route::put('/{id}', [DominioController::class, 'update']);
        Route::delete('/{id}', [DominioController::class, 'destroy']);
    });
});
