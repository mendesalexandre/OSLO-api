<?php

namespace Database\Seeders;

use App\Models\Natureza;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NaturezaSeeder extends Seeder
{
    public function run(): void
    {
        Natureza::query()->create([
            'nome' => 'Abertura de Matrícula',
            'descricao' => 'Abertura de Matrícula de Imóvel'
        ]);

        Natureza::query()->create([
            'nome' => 'Escritura Pública de Compra e Venda',
            'descricao' => 'Escritura Pública de Compra e Venda de Imóvel'
        ]);

        Natureza::query()->create([
            'nome' => 'Cédula de Crédito Bancário',
            'descricao' => 'Cédula de Crédito Bancário'
        ]);
    }
}
