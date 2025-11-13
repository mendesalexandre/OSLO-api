<?php

namespace Database\Seeders;

use App\Models\TabelaCustaAto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabelaCustaAtoSeeder extends Seeder
{
    public function run(): void
    {
        TabelaCustaAto::query()->create();
    }
}
