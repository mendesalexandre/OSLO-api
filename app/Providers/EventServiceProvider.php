<?php

namespace App\Providers;

use App\Models\CaixaOperacao;
use App\Models\Transacao;
use App\Models\TransacaoPagamento;
use App\Observers\CaixaOperacaoObserver;
use App\Observers\TransacaoObserver;
use App\Observers\TransacaoPagamentoObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registrar Observers
        Transacao::observe(TransacaoObserver::class);
        TransacaoPagamento::observe(TransacaoPagamentoObserver::class);
        CaixaOperacao::observe(CaixaOperacaoObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
