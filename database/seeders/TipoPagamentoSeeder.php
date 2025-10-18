<?php

namespace Database\Seeders;

use App\Models\TipoPagamento;
use Illuminate\Database\Seeder;

class TipoPagamentoSeeder extends Seeder
{
    public function run()
    {
        $tipoPagamento = [
            ['nome' => 'Dinheiro', 'descricao' => 'Pagamento em dinheiro'],
            ['nome' => 'Cartão de Crédito', 'descricao' => 'Pagamento em cartão de crédito'],
            ['nome' => 'Cartão de Débito', 'descricao' => 'Pagamento em cartão de débito'],
            ['nome' => 'Boleto Bancário', 'descricao' => 'Pagamento em boleto'],
            ['nome' => 'Transferência Bancária', 'descricao' => 'Pagamento em transferência bancária'],
            ['nome' => 'PIX Cobrança', 'descricao' => 'Pix Cobrança'],
            ['nome' => 'PIX - Pagamento Instantâneo', 'descricao' => 'PIX - Pagamento Instantâneo'],
            ['nome' => 'PIX - Parcelado', 'descricao' => 'PIX - Parcelado'],
            ['nome' => 'Drex', 'descricao' => 'Real Digital'],
            ['nome' => 'Crediário', 'descricao' => 'Pagamento em Crediário'],
            ['nome' => 'Cheque à Vista', 'descricao' => 'Pagamento em Cheque à Vista'],
            ['nome' => 'Cheque Pré Datado', 'descricao' => 'Pagamento em Pré Datadao'],
            ['nome' => 'Cashback', 'descricao' => 'Pagamento por meio de Cashback'],
            ['nome' => 'Sem Pagamento', 'descricao' => 'Sem pagamento'],
            ['nome' => 'Gratuito', 'descricao' => 'Gratuito'],
            ['nome' => 'Crédito na Loja', 'descricao' => 'Crédito na Loja'],
            ['nome' => 'Programa de Fidelidade', 'descricao' => 'Programa de Fidelidade'],
            ['nome' => 'Vale Alimentação', 'descricao' => 'Vale Alimentação'],
            ['nome' => 'Vale Combustível', 'descricao' => 'Vale Combustível'],
            ['nome' => 'Vale Refeição', 'descricao' => 'Vale Refeição'],
            ['nome' => 'Vale Presente', 'descricao' => 'Vale Presente'],
            ['nome' => 'Transferência de Saldo', 'descricao' => 'Transferência de Saldo'],
        ];
        foreach ($tipoPagamento as $pagamento) {
            TipoPagamento::query()->create($pagamento);
        }
    }
}
