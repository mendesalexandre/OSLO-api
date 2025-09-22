<?php

namespace Database\Seeders;

use App\Models\Feriado;
use Illuminate\Database\Seeder;

class FeriadoSeeder extends Seeder
{

    public function run(): void
    {
        Feriado::query()->create([
            'nome' => 'Ano Novo',
            'data' => '2025-01-01',
            'descricao' => 'Celebração do Ano Novo',
            'is_recorrente' => true,
        ]);
    }
}
