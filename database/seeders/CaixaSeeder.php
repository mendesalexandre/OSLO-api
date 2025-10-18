<?php

namespace Database\Seeders;

use App\Models\Caixa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaixaSeeder extends Seeder
{

    public function run(): void
    {
        Caixa::query()->create([
            'is_ativo' => true,
            'nome' => 'Caixa Padrão',
            'descricao' => 'Caixa padrão da empresa',
            'saldo_inicial' => 0,
            'data_saldo_inicial' => now(),
            'saldo_atual' => 0,
        ]);
    }
}
