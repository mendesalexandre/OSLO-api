<?php

namespace Database\Seeders;

use App\Models\MeioPagamento;
use Illuminate\Database\Seeder;

class MeioPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meiosPagamento = [
            [
                'nome' => 'Dinheiro',
                'descricao' => 'Pagamento direto em espécie',
                'taxa_percentual' => 0,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 0,
            ],
            [
                'nome' => 'Mercado Pago',
                'descricao' => 'Gateway de pagamento Mercado Pago',
                'taxa_percentual' => 3.99,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 1,
            ],
            [
                'nome' => 'PagSeguro',
                'descricao' => 'Gateway de pagamento PagSeguro',
                'taxa_percentual' => 4.99,
                'taxa_fixa' => 0.40,
                'prazo_compensacao' => 14,
            ],
            [
                'nome' => 'Stone',
                'descricao' => 'Maquininha Stone',
                'taxa_percentual' => 2.75,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 1,
            ],
            [
                'nome' => 'Cielo',
                'descricao' => 'Maquininha Cielo',
                'taxa_percentual' => 3.25,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 2,
            ],
            [
                'nome' => 'Rede',
                'descricao' => 'Maquininha Rede',
                'taxa_percentual' => 3.15,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 2,
            ],
            [
                'nome' => 'Banco - Transferência Direta',
                'descricao' => 'Transferência bancária direta',
                'taxa_percentual' => 0,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 0,
            ],
            [
                'nome' => 'Banco - DOC/TED',
                'descricao' => 'Transferência via DOC ou TED',
                'taxa_percentual' => 0,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 1,
            ],
            [
                'nome' => 'PicPay',
                'descricao' => 'Carteira digital PicPay',
                'taxa_percentual' => 0,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 0,
            ],
            [
                'nome' => 'PayPal',
                'descricao' => 'Gateway de pagamento PayPal',
                'taxa_percentual' => 4.99,
                'taxa_fixa' => 0.60,
                'prazo_compensacao' => 1,
            ],
            [
                'nome' => 'Stripe',
                'descricao' => 'Gateway de pagamento Stripe',
                'taxa_percentual' => 3.99,
                'taxa_fixa' => 0.39,
                'prazo_compensacao' => 7,
            ],
            [
                'nome' => 'GetNet',
                'descricao' => 'Maquininha GetNet',
                'taxa_percentual' => 2.99,
                'taxa_fixa' => 0,
                'prazo_compensacao' => 1,
            ],
        ];

        foreach ($meiosPagamento as $meio) {
            MeioPagamento::create($meio);
        }
    }
}
