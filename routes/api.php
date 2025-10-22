<?php

use App\Http\Controllers\Api\EtapaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ONR\CertificadoDigital;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\CaixaMovimentoController;
use App\Http\Controllers\CaixaOperacaoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\DominioController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\FeriadoController;
use App\Http\Controllers\NaturezaController;
use App\Services\ONR\Certidao\CertidaoService;
use App\Services\ONR\Autenticacao\Autenticacao;
use App\Http\Controllers\ONR\CertificadoDigitalController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\VersaoController;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();
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
// Route::middleware(['auth:api'])->group(function () {
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

Route::group(['prefix' => 'natureza'], function () {
    Route::get('/', [NaturezaController::class, 'index']);
    Route::post('/criar', [NaturezaController::class, 'create']);
    Route::get('/{id}', [NaturezaController::class, 'show']);
    Route::put('/{id}', [NaturezaController::class, 'update']);
    Route::delete('/{id}', [NaturezaController::class, 'destroy']);
});


/*
|--------------------------------------------------------------------------
| ROTAS DE ESTADOS
|--------------------------------------------------------------------------
*/
Route::prefix('estados')->group(function () {
    // CRUD básico
    Route::get('/', [EstadoController::class, 'index'])->name('estados.index');
    Route::post('/', [EstadoController::class, 'store'])->name('estados.store');
    Route::get('/{estado}', [EstadoController::class, 'show'])->name('estados.show');
    Route::put('/{estado}', [EstadoController::class, 'update'])->name('estados.update');
    Route::delete('/{estado}', [EstadoController::class, 'destroy'])->name('estados.destroy');

    // Rotas especiais
    Route::get('/ativos/lista', [EstadoController::class, 'ativos'])->name('estados.ativos');
    Route::patch('/{estado}/toggle-status', [EstadoController::class, 'toggleStatus'])->name('estados.toggle-status');
    Route::patch('/{id}/restore', [EstadoController::class, 'restore'])->name('estados.restore');
});

/*
|--------------------------------------------------------------------------
| ROTAS DE CIDADES
|--------------------------------------------------------------------------
*/
Route::prefix('cidade')->group(function () {
    // CRUD básico
    Route::get('/', [CidadeController::class, 'index'])->name('cidades.index');
    Route::post('/', [CidadeController::class, 'store'])->name('cidades.store');
    Route::get('/{cidade}', [CidadeController::class, 'show'])->name('cidades.show');
    Route::put('/{cidade}', [CidadeController::class, 'update'])->name('cidades.update');
    Route::delete('/{cidade}', [CidadeController::class, 'destroy'])->name('cidades.destroy');
    Route::get('/codigo-ibge/{codigoIbge}', [CidadeController::class, 'porCodigoIbge'])->name('cidades.por-codigoIbge');

    // Rotas especiais
    Route::get('/ativas/lista', [CidadeController::class, 'ativas'])->name('cidades.ativas');
    Route::get('/estado/{estadoId}', [CidadeController::class, 'porEstado'])->name('cidades.por-estado');
    Route::get('/buscar/termo', [CidadeController::class, 'buscar'])->name('cidades.buscar');
    Route::patch('/{cidade}/toggle-status', [CidadeController::class, 'toggleStatus'])->name('cidades.toggle-status');
    Route::patch('/{id}/restore', [CidadeController::class, 'restore'])->name('cidades.restore');
});


Route::apiResource('etapa', EtapaController::class);
Route::apiResource('caixa', CaixaController::class);
// ========================================
// CATEGORIA
// ========================================
Route::apiResource('categoria', CategoriaController::class);

// ========================================
// TRANSAÇÃO
// ========================================
Route::apiResource('transacao', TransacaoController::class);
// Rotas extras de Transação
Route::prefix('transacao')->group(function () {
    Route::post('{id}/pagar', [TransacaoController::class, 'pagar']);
    Route::post('{id}/cancelar', [TransacaoController::class, 'cancelar']);
});

// Consultas de Transação
Route::prefix('transacao')->group(function () {
    Route::get('pendentes', [TransacaoController::class, 'pendentes']);
    Route::get('vencidas', [TransacaoController::class, 'vencidas']);
    Route::get('contas-pagar', [TransacaoController::class, 'contasPagar']);
    Route::get('contas-receber', [TransacaoController::class, 'contasReceber']);
});

// ========================================
// CAIXA MOVIMENTO (Abertura/Fechamento)
// ========================================
Route::prefix('caixa-movimento')->group(function () {
    // CRUD
    Route::get('/', [CaixaMovimentoController::class, 'index']);
    Route::get('{id}', [CaixaMovimentoController::class, 'show']);

    // Ações
    Route::post('abrir', [CaixaMovimentoController::class, 'abrir']);
    Route::post('{id}/fechar', [CaixaMovimentoController::class, 'fechar']);
    Route::post('{id}/conferir', [CaixaMovimentoController::class, 'conferir']);
    Route::post('{id}/reabrir', [CaixaMovimentoController::class, 'reabrir']);

    // Consultas
    Route::get('status/abertos', [CaixaMovimentoController::class, 'abertos']);
    Route::get('status/fechados', [CaixaMovimentoController::class, 'fechados']);
    Route::get('status/com-diferenca', [CaixaMovimentoController::class, 'comDiferenca']);
});

// Movimento atual de um caixa específico
Route::get('caixa/{id}/movimento-atual', [CaixaMovimentoController::class, 'movimentoAtual']);


Route::prefix('caixa-operacao')->group(function () {
    // Listar
    Route::get('/', [CaixaOperacaoController::class, 'index']);
    Route::get('{id}', [CaixaOperacaoController::class, 'show']);

    // Operações
    Route::post('sangria', [CaixaOperacaoController::class, 'sangria']);
    Route::post('reforco', [CaixaOperacaoController::class, 'reforco']);
    Route::post('transferir', [CaixaOperacaoController::class, 'transferir']);
    Route::post('{id}/estornar', [CaixaOperacaoController::class, 'estornar']);

    // Consultas
    Route::get('tipo/sangrias', [CaixaOperacaoController::class, 'sangrias']);
    Route::get('tipo/reforcos', [CaixaOperacaoController::class, 'reforcos']);
    Route::get('tipo/transferencias', [CaixaOperacaoController::class, 'transferencias']);
    Route::get('caixa/{id}', [CaixaOperacaoController::class, 'porCaixa']);
});

// }); FINAL ROTAS PROTEGIDAS

Route::get('/versao', [VersaoController::class, 'version']);
Route::get('/system/info', [VersaoController::class, 'info']);
