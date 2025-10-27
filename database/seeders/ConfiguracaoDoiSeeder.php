<?php

namespace Database\Seeders;

use App\Models\Configuracao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracaoDoiSeeder extends Seeder
{
    public function run(): void
    {
        Configuracao::query()->updateOrCreate(
            ['chave' => 'CONFI_DOI_WEB_COOKIE'],
            [
                'chave' => 'CONFI_DOI_WEB_COOKIE',
                'valor' => '',
                'descricao' => 'Cookie utilizado para acessar o site da Receita Federal',
            ]
        );
    }
}
