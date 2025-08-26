<?php

namespace Database\Seeders;

use App\Models\ONR\TabelaCusta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabelaCustaONR2025Seeder extends Seeder
{
    public function run(): void
    {
        TabelaCusta::query()->create([
            'nome' => ''
        ]);
    }
}
