<?php

namespace Database\Seeders;

use App\Models\Etapa;
use Illuminate\Database\Seeder;

class EtapaSeeder extends Seeder
{

    public function run(): void
    {
        Etapa::query()->create([
            'nome' => 'Cadastro no sistema',
            'descricao' => 'Etapa de cadastro no sistema',
        ]);

        Etapa::query()->create([
            'nome' => 'Documento em Analise',
            'descricao' => 'Etapa de análise de documentos',
        ]);
    }
}
