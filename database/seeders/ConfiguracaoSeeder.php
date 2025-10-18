<?php

namespace Database\Seeders;

use App\Models\Configuracao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracaoSeeder extends Seeder
{
    public function run(): void
    {
        $configuracoes = [
            [
                'chave' => 'CAIXA_REQUER_ABERTURA',
                'valor' => 'false',
                'tipo' => 'boolean',
                'descricao' => 'Define se é obrigatório abrir o caixa antes de lançar transações',
                'grupo' => 'caixa',
                'data_cadastro' => now(),
            ],
            [
                'chave' => 'CAIXA_PERMITIR_LANCAMENTO_RETROATIVO',
                'valor' => 'true',
                'tipo' => 'boolean',
                'descricao' => 'Permite lançar transações com data passada',
                'grupo' => 'caixa',
                'data_cadastro' => now(),
            ],
            [
                'chave' => 'CAIXA_DIAS_RETROATIVO_MAXIMO',
                'valor' => '30',
                'tipo' => 'integer',
                'descricao' => 'Número máximo de dias retroativos permitidos',
                'grupo' => 'caixa',
                'data_cadastro' => now(),
            ],
            [
                'chave' => 'CAIXA_ALERTA_DIFERENCA_MINIMA',
                'valor' => '1.00',
                'tipo' => 'string',
                'descricao' => 'Valor mínimo de diferença para gerar alerta no fechamento',
                'grupo' => 'caixa',
                'data_cadastro' => now(),
            ],
        ];

        foreach ($configuracoes as $config) {
            Configuracao::query()->updateOrInsert(
                ['chave' => $config['chave']],
                $config
            );
        }
    }
}
