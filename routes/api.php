<?php

use App\Http\Controllers\Api\EtapaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtoController;
use App\Http\Controllers\AtoFaixaController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\CaixaMovimentoController;
use App\Http\Controllers\CaixaOperacaoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ContratoExigenciaController;
use App\Http\Controllers\Doi\DoiController;
use App\Http\Controllers\DominioController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\FeriadoController;
use App\Http\Controllers\FormaPagamentoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\LoteDoiController;
use App\Http\Controllers\MeioPagamentoController;
use App\Http\Controllers\NaturezaController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\ProtocoloController;
use App\Http\Controllers\ProtocoloIsencaoController;
use App\Http\Controllers\ProtocoloPagamentoController;
use App\Http\Controllers\ReciboController;
use App\Http\Controllers\TabelaCustaController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\UsuarioPermissaoController;
use App\Http\Controllers\VersaoController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS (sem autenticação)
|--------------------------------------------------------------------------
*/

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::post('/auth/login', [AuthController::class, 'login'])
    ->name('login');

Route::get('/versao', [VersaoController::class, 'version']);
Route::get('/system/info', [VersaoController::class, 'info']);

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS (requerem autenticação JWT)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:api'])->group(function () {

    // ========================================
    // AUTENTICAÇÃO
    // ========================================

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');

    Route::get('/auth/me', [AuthController::class, 'me'])
        ->name('auth.me');

    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->name('auth.refresh');

    Route::post('/revoke-all', [AuthController::class, 'revokeAllTokens'])
        ->name('auth.revokeAll');

    Route::post('/change-password', [AuthController::class, 'changePassword'])
        ->name('auth.changePassword');

    Route::get('/auth/check-token', [AuthController::class, 'checkToken'])
        ->name('auth.checkToken');

    // Minhas permissões (sem middleware de permissão)
    Route::get('/usuario/minhas-permissoes', [UsuarioPermissaoController::class, 'minhasPermissoes']);

    // ========================================
    // GRUPOS
    // ========================================
    Route::prefix('grupo')->group(function () {
        Route::get('/', [GrupoController::class, 'listar'])->middleware('permissao:GRUPO_LISTAR');
        Route::post('/', [GrupoController::class, 'criar'])->middleware('permissao:GRUPO_CRIAR');
        Route::get('/{id}', [GrupoController::class, 'exibir'])->middleware('permissao:GRUPO_VISUALIZAR');
        Route::put('/{id}', [GrupoController::class, 'atualizar'])->middleware('permissao:GRUPO_EDITAR');
        Route::delete('/{id}', [GrupoController::class, 'excluir'])->middleware('permissao:GRUPO_EXCLUIR');
        Route::post('/{id}/restaurar', [GrupoController::class, 'restaurar'])->middleware('permissao:GRUPO_EDITAR');
        Route::put('/{id}/permissoes', [GrupoController::class, 'sincronizarPermissoes'])->middleware('permissao:GRUPO_EDITAR');
        Route::post('/{id}/permissao', [GrupoController::class, 'adicionarPermissao'])->middleware('permissao:GRUPO_EDITAR');
        Route::delete('/{id}/permissao/{permissaoId}', [GrupoController::class, 'removerPermissao'])->middleware('permissao:GRUPO_EDITAR');
    });

    // ========================================
    // PERMISSÕES
    // ========================================
    Route::prefix('permissao')->group(function () {
        Route::get('/', [PermissaoController::class, 'listar'])->middleware('permissao:PERMISSAO_LISTAR');
        Route::post('/', [PermissaoController::class, 'criar'])->middleware('permissao:PERMISSAO_CRIAR');
        Route::get('/modulos', [PermissaoController::class, 'listarModulos'])->middleware('permissao:PERMISSAO_LISTAR');
        Route::get('/modulo/{modulo}', [PermissaoController::class, 'listarPorModulo'])->middleware('permissao:PERMISSAO_LISTAR');
        Route::get('/{id}', [PermissaoController::class, 'exibir'])->middleware('permissao:PERMISSAO_VISUALIZAR');
        Route::put('/{id}', [PermissaoController::class, 'atualizar'])->middleware('permissao:PERMISSAO_EDITAR');
        Route::delete('/{id}', [PermissaoController::class, 'excluir'])->middleware('permissao:PERMISSAO_EXCLUIR');
        Route::post('/{id}/restaurar', [PermissaoController::class, 'restaurar'])->middleware('permissao:PERMISSAO_EDITAR');
    });

    // ========================================
    // USUÁRIOS (listagem para gerenciamento de permissões)
    // ========================================
    Route::get('/usuario', [UsuarioPermissaoController::class, 'listarUsuarios'])->middleware('permissao:USUARIO_PERMISSAO_LISTAR');

    // ========================================
    // PERMISSÕES DE USUÁRIO
    // ========================================
    Route::prefix('usuario/{usuarioId}/permissao')->group(function () {
        Route::get('/', [UsuarioPermissaoController::class, 'listar'])->middleware('permissao:USUARIO_PERMISSAO_LISTAR');
        Route::get('/efetivas', [UsuarioPermissaoController::class, 'permissoesEfetivas'])->middleware('permissao:USUARIO_PERMISSAO_LISTAR');
        Route::put('/grupos', [UsuarioPermissaoController::class, 'sincronizarGrupos'])->middleware('permissao:USUARIO_PERMISSAO_EDITAR');
        Route::post('/grupo', [UsuarioPermissaoController::class, 'adicionarGrupo'])->middleware('permissao:USUARIO_PERMISSAO_EDITAR');
        Route::delete('/grupo/{grupoId}', [UsuarioPermissaoController::class, 'removerGrupo'])->middleware('permissao:USUARIO_PERMISSAO_EDITAR');
        Route::post('/', [UsuarioPermissaoController::class, 'adicionarPermissao'])->middleware('permissao:USUARIO_PERMISSAO_EDITAR');
        Route::delete('/{permissaoId}', [UsuarioPermissaoController::class, 'removerPermissao'])->middleware('permissao:USUARIO_PERMISSAO_EDITAR');
    });

    // ========================================
    // FERIADOS
    // ========================================
    Route::group(['prefix' => 'feriados'], function () {
        Route::get('/', [FeriadoController::class, 'index'])->middleware('permissao:FERIADO_LISTAR');
        Route::post('/criar', [FeriadoController::class, 'create'])->middleware('permissao:FERIADO_CRIAR');
        Route::get('/{id}', [FeriadoController::class, 'show'])->middleware('permissao:FERIADO_VISUALIZAR');
        Route::put('/{id}', [FeriadoController::class, 'update'])->middleware('permissao:FERIADO_EDITAR');
        Route::delete('/{id}', [FeriadoController::class, 'destroy'])->middleware('permissao:FERIADO_EXCLUIR');
    });

    // ========================================
    // CONFIGURAÇÃO
    // ========================================
    Route::group(['prefix' => 'configuracao'], function () {
        Route::get('/', [ConfiguracaoController::class, 'index'])->name('configuracao.index')->middleware('permissao:CONFIGURACAO_LISTAR');
        Route::get('/filtro', [ConfiguracaoController::class, 'show'])->name('configuracao.show')->middleware('permissao:CONFIGURACAO_LISTAR');
        Route::put('/', [ConfiguracaoController::class, 'update'])->name('configuracao.update')->middleware('permissao:CONFIGURACAO_EDITAR');
    });

    // ========================================
    // DOI (Declaração de Operações Imobiliárias)
    // ========================================
    Route::prefix('declaracao-imobiliaria')->middleware('permissao:DOI_LISTAR,DOI_CRIAR,DOI_EDITAR')->group(function () {
        Route::get('/', [DoiController::class, 'index']);
        Route::post('/', [DoiController::class, 'store']);
        Route::get('/disponiveis', [DoiController::class, 'disponiveis']);
        Route::post('/validar', [DoiController::class, 'validar']);
        Route::get('/exportar-excel', [DoiController::class, 'exportarExcel']);

        // Importação
        Route::post('/importar/site-receita', [DoiController::class, 'importarSiteReceita']);
        Route::post('/importar/site-receita-async', [DoiController::class, 'importarSiteReceitaAsync']);

        // Controle e estatísticas
        Route::get('/importacao/estatisticas', [DoiController::class, 'estatisticasImportacao']);
        Route::get('/token/verificar', [DoiController::class, 'verificarToken']);

        Route::prefix('{id}')->group(function () {
            Route::get('/', [DoiController::class, 'show']);
            Route::put('/', [DoiController::class, 'update']);
            Route::delete('/', [DoiController::class, 'destroy']);
            Route::post('/reprocessar', [DoiController::class, 'reprocessar']);
            Route::get('/imprimir', [DoiController::class, 'imprimir']);
        });
    });

    // ========================================
    // LOTES DOI
    // ========================================
    Route::prefix('lote-doi')->middleware('permissao:DOI_LISTAR,DOI_CRIAR,DOI_EDITAR')->group(function () {
        Route::get('/listar', [LoteDoiController::class, 'listar']);
        Route::post('/preview', [LoteDoiController::class, 'preview']);
        Route::post('/criar', [LoteDoiController::class, 'criar']);
        Route::get('/pesquisar', [LoteDoiController::class, 'pesquisar']);
        Route::get('/{id}/detalhes', [LoteDoiController::class, 'detalhes']);
        Route::get('/{id}/relatorio-pdf', [LoteDoiController::class, 'relatorioPdf']);
        Route::post('/relatorio-geral-pdf', [LoteDoiController::class, 'relatorioGeralPdf']);
        Route::get('/estatisticas', [LoteDoiController::class, 'estatisticas']);

        // Exclusão
        Route::get('/{id}/verificar-exclusao', [LoteDoiController::class, 'verificarExclusao']);
        Route::delete('/{id}/excluir', [LoteDoiController::class, 'excluirLote']);

        Route::prefix('{loteId}')->group(function () {
            Route::get('/download', [LoteDoiController::class, 'download'])->name('lote-doi.download');
            Route::patch('/marcar-enviado', [LoteDoiController::class, 'marcarEnviado']);
        });
    });

    // ========================================
    // DOMÍNIOS
    // ========================================
    Route::group(['prefix' => 'dominios'], function () {
        Route::get('/', [DominioController::class, 'index'])->middleware('permissao:DOMINIO_LISTAR');
        Route::post('/criar', [DominioController::class, 'create'])->middleware('permissao:DOMINIO_CRIAR');
        Route::get('/{id}', [DominioController::class, 'show'])->middleware('permissao:DOMINIO_VISUALIZAR');
        Route::put('/{id}', [DominioController::class, 'update'])->middleware('permissao:DOMINIO_EDITAR');
        Route::delete('/{id}', [DominioController::class, 'destroy'])->middleware('permissao:DOMINIO_EXCLUIR');
    });

    // ========================================
    // NATUREZA
    // ========================================
    Route::group(['prefix' => 'natureza'], function () {
        Route::get('/', [NaturezaController::class, 'index'])->middleware('permissao:NATUREZA_LISTAR');
        Route::post('/criar', [NaturezaController::class, 'create'])->middleware('permissao:NATUREZA_CRIAR');
        Route::get('/{id}', [NaturezaController::class, 'show'])->middleware('permissao:NATUREZA_VISUALIZAR');
        Route::put('/{id}', [NaturezaController::class, 'update'])->middleware('permissao:NATUREZA_EDITAR');
        Route::delete('/{id}', [NaturezaController::class, 'destroy'])->middleware('permissao:NATUREZA_EXCLUIR');
    });

    // ========================================
    // ESTADOS
    // ========================================
    Route::prefix('estados')->group(function () {
        Route::get('/', [EstadoController::class, 'index'])->name('estados.index')->middleware('permissao:ESTADO_LISTAR');
        Route::post('/', [EstadoController::class, 'store'])->name('estados.store')->middleware('permissao:ESTADO_CRIAR');
        Route::get('/{estado}', [EstadoController::class, 'show'])->name('estados.show')->middleware('permissao:ESTADO_VISUALIZAR');
        Route::put('/{estado}', [EstadoController::class, 'update'])->name('estados.update')->middleware('permissao:ESTADO_EDITAR');
        Route::delete('/{estado}', [EstadoController::class, 'destroy'])->name('estados.destroy')->middleware('permissao:ESTADO_EXCLUIR');

        Route::get('/ativos/lista', [EstadoController::class, 'ativos'])->name('estados.ativos')->middleware('permissao:ESTADO_LISTAR');
        Route::patch('/{estado}/toggle-status', [EstadoController::class, 'toggleStatus'])->name('estados.toggle-status')->middleware('permissao:ESTADO_EDITAR');
        Route::patch('/{id}/restore', [EstadoController::class, 'restore'])->name('estados.restore')->middleware('permissao:ESTADO_EDITAR');
    });

    // ========================================
    // CIDADES
    // ========================================
    Route::prefix('cidade')->group(function () {
        Route::get('/', [CidadeController::class, 'index'])->name('cidades.index')->middleware('permissao:CIDADE_LISTAR');
        Route::post('/', [CidadeController::class, 'store'])->name('cidades.store')->middleware('permissao:CIDADE_CRIAR');
        Route::get('/{cidade}', [CidadeController::class, 'show'])->name('cidades.show')->middleware('permissao:CIDADE_VISUALIZAR');
        Route::put('/{cidade}', [CidadeController::class, 'update'])->name('cidades.update')->middleware('permissao:CIDADE_EDITAR');
        Route::delete('/{cidade}', [CidadeController::class, 'destroy'])->name('cidades.destroy')->middleware('permissao:CIDADE_EXCLUIR');
        Route::get('/codigo-ibge/{codigoIbge}', [CidadeController::class, 'porCodigoIbge'])->name('cidades.por-codigoIbge')->middleware('permissao:CIDADE_LISTAR');

        Route::get('/ativas/lista', [CidadeController::class, 'ativas'])->name('cidades.ativas')->middleware('permissao:CIDADE_LISTAR');
        Route::get('/estado/{estadoId}', [CidadeController::class, 'porEstado'])->name('cidades.por-estado')->middleware('permissao:CIDADE_LISTAR');
        Route::get('/buscar/termo', [CidadeController::class, 'buscar'])->name('cidades.buscar')->middleware('permissao:CIDADE_LISTAR');
        Route::patch('/{cidade}/toggle-status', [CidadeController::class, 'toggleStatus'])->name('cidades.toggle-status')->middleware('permissao:CIDADE_EDITAR');
        Route::patch('/{id}/restore', [CidadeController::class, 'restore'])->name('cidades.restore')->middleware('permissao:CIDADE_EDITAR');
    });

    // ========================================
    // ETAPA / CAIXA
    // ========================================
    Route::apiResource('etapa', EtapaController::class)->middleware('permissao:ETAPA_LISTAR,ETAPA_CRIAR,ETAPA_EDITAR,ETAPA_EXCLUIR');
    Route::apiResource('caixa', CaixaController::class)->middleware('permissao:CAIXA_LISTAR,CAIXA_CRIAR,CAIXA_EDITAR,CAIXA_EXCLUIR');

    // ========================================
    // CATEGORIA
    // ========================================
    Route::apiResource('categoria', CategoriaController::class)->middleware('permissao:CATEGORIA_LISTAR,CATEGORIA_CRIAR,CATEGORIA_EDITAR,CATEGORIA_EXCLUIR');

    // ========================================
    // TABELA DE CUSTAS
    // ========================================
    Route::prefix('tabela-custa')
        ->as('tabela-custa.')
        ->middleware('permissao:TABELA_CUSTA_LISTAR')
        ->group(function () {
            Route::get('/', [TabelaCustaController::class, 'index'])->name('index');
            Route::get('/{tabelaCusta}', [TabelaCustaController::class, 'show'])->name('show');
        });

    Route::prefix('tabela-custa-ato')
        ->as('tabela-custa-ato.')
        ->middleware('permissao:TABELA_CUSTA_LISTAR')
        ->group(function () {
            Route::get('/', [TabelaCustaController::class, 'index'])->name('index');
            Route::get('/{tabelaCusta}', [TabelaCustaController::class, 'show'])->name('show');
        });

    // ========================================
    // TRANSAÇÃO
    // ========================================
    Route::apiResource('transacao', TransacaoController::class)->middleware('permissao:TRANSACAO_LISTAR,TRANSACAO_CRIAR,TRANSACAO_EDITAR,TRANSACAO_EXCLUIR');

    Route::prefix('transacao')->middleware('permissao:TRANSACAO_EDITAR')->group(function () {
        Route::post('{id}/pagar', [TransacaoController::class, 'pagar']);
        Route::post('{id}/cancelar', [TransacaoController::class, 'cancelar']);
    });

    Route::prefix('transacao')->middleware('permissao:TRANSACAO_LISTAR')->group(function () {
        Route::get('pendentes', [TransacaoController::class, 'pendentes']);
        Route::get('vencidas', [TransacaoController::class, 'vencidas']);
        Route::get('contas-pagar', [TransacaoController::class, 'contasPagar']);
        Route::get('contas-receber', [TransacaoController::class, 'contasReceber']);
    });

    // ========================================
    // CAIXA MOVIMENTO (Abertura/Fechamento)
    // ========================================
    Route::prefix('caixa-movimento')->group(function () {
        Route::get('/', [CaixaMovimentoController::class, 'index'])->middleware('permissao:CAIXA_MOVIMENTO_LISTAR');
        Route::get('{id}', [CaixaMovimentoController::class, 'show'])->middleware('permissao:CAIXA_MOVIMENTO_LISTAR');

        Route::post('abrir', [CaixaMovimentoController::class, 'abrir'])->middleware('permissao:CAIXA_MOVIMENTO_ABRIR');
        Route::post('{id}/fechar', [CaixaMovimentoController::class, 'fechar'])->middleware('permissao:CAIXA_MOVIMENTO_FECHAR');
        Route::post('{id}/conferir', [CaixaMovimentoController::class, 'conferir'])->middleware('permissao:CAIXA_MOVIMENTO_CONFERIR');
        Route::post('{id}/reabrir', [CaixaMovimentoController::class, 'reabrir'])->middleware('permissao:CAIXA_MOVIMENTO_REABRIR');

        Route::get('status/abertos', [CaixaMovimentoController::class, 'abertos'])->middleware('permissao:CAIXA_MOVIMENTO_LISTAR');
        Route::get('status/fechados', [CaixaMovimentoController::class, 'fechados'])->middleware('permissao:CAIXA_MOVIMENTO_LISTAR');
        Route::get('status/com-diferenca', [CaixaMovimentoController::class, 'comDiferenca'])->middleware('permissao:CAIXA_MOVIMENTO_LISTAR');
    });

    Route::get('caixa/{id}/movimento-atual', [CaixaMovimentoController::class, 'movimentoAtual'])->middleware('permissao:CAIXA_MOVIMENTO_LISTAR');

    // ========================================
    // CAIXA OPERAÇÃO
    // ========================================
    Route::prefix('caixa-operacao')->group(function () {
        Route::get('/', [CaixaOperacaoController::class, 'index'])->middleware('permissao:CAIXA_OPERACAO_LISTAR');
        Route::get('{id}', [CaixaOperacaoController::class, 'show'])->middleware('permissao:CAIXA_OPERACAO_LISTAR');

        Route::post('sangria', [CaixaOperacaoController::class, 'sangria'])->middleware('permissao:CAIXA_OPERACAO_SANGRIA');
        Route::post('reforco', [CaixaOperacaoController::class, 'reforco'])->middleware('permissao:CAIXA_OPERACAO_REFORCO');
        Route::post('transferir', [CaixaOperacaoController::class, 'transferir'])->middleware('permissao:CAIXA_OPERACAO_TRANSFERIR');
        Route::post('{id}/estornar', [CaixaOperacaoController::class, 'estornar'])->middleware('permissao:CAIXA_OPERACAO_ESTORNAR');

        Route::get('tipo/sangrias', [CaixaOperacaoController::class, 'sangrias'])->middleware('permissao:CAIXA_OPERACAO_LISTAR');
        Route::get('tipo/reforcos', [CaixaOperacaoController::class, 'reforcos'])->middleware('permissao:CAIXA_OPERACAO_LISTAR');
        Route::get('tipo/transferencias', [CaixaOperacaoController::class, 'transferencias'])->middleware('permissao:CAIXA_OPERACAO_LISTAR');
        Route::get('caixa/{id}', [CaixaOperacaoController::class, 'porCaixa'])->middleware('permissao:CAIXA_OPERACAO_LISTAR');
    });

    // ========================================
    // AUDITORIA
    // ========================================
    Route::prefix('auditoria')->middleware('permissao:AUDITORIA_LISTAR')->group(function () {
        Route::get('/', [AuditoriaController::class, 'listar']);
        Route::get('/tabelas', [AuditoriaController::class, 'tabelasAuditadas']);
        Route::get('/estatisticas', [AuditoriaController::class, 'estatisticas']);
        Route::get('/tabela/{tabela}', [AuditoriaController::class, 'porTabela']);
        Route::get('/tabela/{tabela}/registro/{registroId}', [AuditoriaController::class, 'porRegistro']);
        Route::get('/usuario/{usuarioId}', [AuditoriaController::class, 'porUsuario']);
    });

    // ========================================
    // ATO
    // ========================================
    Route::prefix('ato')->group(function () {
        Route::get('/', [AtoController::class, 'listar'])->middleware('permissao:ATO_LISTAR');
        Route::post('/', [AtoController::class, 'criar'])->middleware('permissao:ATO_CRIAR');
        Route::get('/{id}', [AtoController::class, 'exibir'])->middleware('permissao:ATO_VISUALIZAR');
        Route::put('/{id}', [AtoController::class, 'atualizar'])->middleware('permissao:ATO_EDITAR');
        Route::delete('/{id}', [AtoController::class, 'excluir'])->middleware('permissao:ATO_EXCLUIR');
        Route::post('/{id}/restaurar', [AtoController::class, 'restaurar'])->middleware('permissao:ATO_EDITAR');
        Route::post('/{id}/calcular', [AtoController::class, 'calcularValor'])->middleware('permissao:ATO_LISTAR');

        // Faixas
        Route::prefix('/{atoId}/faixa')->group(function () {
            Route::get('/', [AtoFaixaController::class, 'listar'])->middleware('permissao:ATO_LISTAR');
            Route::post('/', [AtoFaixaController::class, 'criar'])->middleware('permissao:ATO_CRIAR');
            Route::put('/{id}', [AtoFaixaController::class, 'atualizar'])->middleware('permissao:ATO_EDITAR');
            Route::delete('/{id}', [AtoFaixaController::class, 'excluir'])->middleware('permissao:ATO_EXCLUIR');
        });
    });

    // ========================================
    // FORMA DE PAGAMENTO
    // ========================================
    Route::prefix('forma-pagamento')->group(function () {
        Route::get('/', [FormaPagamentoController::class, 'listar'])->middleware('permissao:FORMA_PAGAMENTO_LISTAR');
        Route::post('/', [FormaPagamentoController::class, 'criar'])->middleware('permissao:FORMA_PAGAMENTO_CRIAR');
        Route::get('/{id}', [FormaPagamentoController::class, 'exibir'])->middleware('permissao:FORMA_PAGAMENTO_VISUALIZAR');
        Route::put('/{id}', [FormaPagamentoController::class, 'atualizar'])->middleware('permissao:FORMA_PAGAMENTO_EDITAR');
        Route::delete('/{id}', [FormaPagamentoController::class, 'excluir'])->middleware('permissao:FORMA_PAGAMENTO_EXCLUIR');
        Route::post('/{id}/restaurar', [FormaPagamentoController::class, 'restaurar'])->middleware('permissao:FORMA_PAGAMENTO_EDITAR');
    });

    // ========================================
    // MEIO DE PAGAMENTO
    // ========================================
    Route::prefix('meio-pagamento')->group(function () {
        Route::get('/', [MeioPagamentoController::class, 'listar'])->middleware('permissao:MEIO_PAGAMENTO_LISTAR');
        Route::post('/', [MeioPagamentoController::class, 'criar'])->middleware('permissao:MEIO_PAGAMENTO_CRIAR');
        Route::get('/{id}', [MeioPagamentoController::class, 'exibir'])->middleware('permissao:MEIO_PAGAMENTO_VISUALIZAR');
        Route::put('/{id}', [MeioPagamentoController::class, 'atualizar'])->middleware('permissao:MEIO_PAGAMENTO_EDITAR');
        Route::delete('/{id}', [MeioPagamentoController::class, 'excluir'])->middleware('permissao:MEIO_PAGAMENTO_EXCLUIR');
        Route::post('/{id}/restaurar', [MeioPagamentoController::class, 'restaurar'])->middleware('permissao:MEIO_PAGAMENTO_EDITAR');
    });

    // ========================================
    // PROTOCOLO
    // ========================================
    Route::prefix('protocolo')->group(function () {
        Route::get('/', [ProtocoloController::class, 'listar'])->middleware('permissao:PROTOCOLO_LISTAR');
        Route::post('/', [ProtocoloController::class, 'criar'])->middleware('permissao:PROTOCOLO_CRIAR');
        Route::get('/{id}', [ProtocoloController::class, 'exibir'])->middleware('permissao:PROTOCOLO_VISUALIZAR');
        Route::put('/{id}', [ProtocoloController::class, 'atualizar'])->middleware('permissao:PROTOCOLO_EDITAR');
        Route::post('/{id}/cancelar', [ProtocoloController::class, 'cancelar'])->middleware('permissao:PROTOCOLO_CANCELAR');
        Route::post('/{id}/recalcular', [ProtocoloController::class, 'recalcular'])->middleware('permissao:PROTOCOLO_EDITAR');

        // Itens
        Route::post('/{id}/item', [ProtocoloController::class, 'adicionarItem'])->middleware('permissao:PROTOCOLO_EDITAR');
        Route::delete('/{id}/item/{itemId}', [ProtocoloController::class, 'removerItem'])->middleware('permissao:PROTOCOLO_EDITAR');

        // Pagamentos
        Route::get('/{id}/pagamento', [ProtocoloPagamentoController::class, 'listar'])->middleware('permissao:PROTOCOLO_LISTAR');
        Route::post('/{id}/pagamento', [ProtocoloPagamentoController::class, 'registrar'])->middleware('permissao:PROTOCOLO_PAGAR');
        Route::post('/{id}/pagamento/{pagId}/estornar', [ProtocoloPagamentoController::class, 'estornar'])->middleware('permissao:PROTOCOLO_ESTORNAR');

        // Isenções
        Route::get('/{id}/isencao', [ProtocoloIsencaoController::class, 'listar'])->middleware('permissao:PROTOCOLO_LISTAR');
        Route::post('/{id}/isencao', [ProtocoloIsencaoController::class, 'registrar'])->middleware('permissao:PROTOCOLO_ISENTAR');

        // Contrato (criar a partir do protocolo)
        Route::post('/{id}/contrato', [ContratoController::class, 'criar'])->middleware('permissao:CONTRATO_CRIAR');

        // Recibo
        Route::post('/{id}/recibo', [ReciboController::class, 'gerar'])->middleware('permissao:RECIBO_GERAR');
    });

    // ========================================
    // CONTRATO
    // ========================================
    Route::prefix('contrato')->group(function () {
        Route::get('/', [ContratoController::class, 'listar'])->middleware('permissao:CONTRATO_LISTAR');
        Route::get('/{id}', [ContratoController::class, 'exibir'])->middleware('permissao:CONTRATO_VISUALIZAR');
        Route::put('/{id}', [ContratoController::class, 'atualizar'])->middleware('permissao:CONTRATO_EDITAR');
        Route::post('/{id}/status', [ContratoController::class, 'alterarStatus'])->middleware('permissao:CONTRATO_EDITAR');
        Route::post('/{id}/concluir', [ContratoController::class, 'concluir'])->middleware('permissao:CONTRATO_CONCLUIR');
        Route::post('/{id}/cancelar', [ContratoController::class, 'cancelar'])->middleware('permissao:CONTRATO_CANCELAR');

        // Exigências
        Route::get('/{id}/exigencia', [ContratoExigenciaController::class, 'listar'])->middleware('permissao:CONTRATO_LISTAR');
        Route::post('/{id}/exigencia', [ContratoExigenciaController::class, 'criar'])->middleware('permissao:CONTRATO_EDITAR');
        Route::post('/{id}/exigencia/{exId}/cumprir', [ContratoExigenciaController::class, 'cumprir'])->middleware('permissao:CONTRATO_EDITAR');

        // Andamentos (somente leitura)
        Route::get('/{id}/andamento', [ContratoController::class, 'andamentos'])->middleware('permissao:CONTRATO_LISTAR');
    });

    // ========================================
    // RECIBO
    // ========================================
    Route::prefix('recibo')->group(function () {
        Route::get('/', [ReciboController::class, 'listar'])->middleware('permissao:RECIBO_LISTAR');
        Route::get('/{id}', [ReciboController::class, 'exibir'])->middleware('permissao:RECIBO_VISUALIZAR');
    });
});
