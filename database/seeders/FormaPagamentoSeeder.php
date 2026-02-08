<?php

namespace Database\Seeders;

use App\Models\FormaPagamento;
use Illuminate\Database\Seeder;

class FormaPagamentoSeeder extends Seeder
{
    public function run(): void
    {
        $formas = [
            ['nome' => 'Dinheiro', 'descricao' => 'Pagamento em espécie'],
            ['nome' => 'PIX', 'descricao' => 'Pagamento via PIX'],
            ['nome' => 'Cartão de Débito', 'descricao' => 'Pagamento com cartão de débito'],
            ['nome' => 'Cartão de Crédito', 'descricao' => 'Pagamento com cartão de crédito'],
            ['nome' => 'Boleto Bancário', 'descricao' => 'Pagamento via boleto bancário'],
            ['nome' => 'Transferência Bancária', 'descricao' => 'Pagamento via transferência bancária'],
        ];

        foreach ($formas as $forma) {
            FormaPagamento::firstOrCreate(
                ['nome' => $forma['nome']],
                $forma
            );
        }
    }
}
