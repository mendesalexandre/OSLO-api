<?php

namespace Database\Seeders;

use App\Enums\TipoCalculoAto;
use App\Models\TabelaCustaAto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TabelaCustaAtoSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('seeders/json/tabelacusta2025.json'));
        $atos = json_decode($json, true);

        foreach ($atos as $atoData) {
            TabelaCustaAto::create($atoData);
        }

        $this->command->info('✅ ' . count($atos) . ' atos cadastrados!');
    }
}
