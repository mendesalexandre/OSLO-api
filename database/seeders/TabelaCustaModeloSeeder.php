<?php

namespace Database\Seeders;

use App\Models\TabelaCusta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabelaCustaModeloSeeder extends Seeder
{
    public function run(): void
    {
        TabelaCusta::query()->create([
            'nome' => 'Tabela de Custa do Estado de Mato Grosso',
            'vigencia_inicio' => now()->subYear(),
            'vigencia_fim' => now()->endOfYear(),
            'ano' => now()->year,
            'observacao' => 'Tabela padrão de custa para o estado de Mato Grosso.',
        ]);
    }
}
