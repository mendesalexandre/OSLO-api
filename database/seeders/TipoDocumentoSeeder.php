<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        TipoDocumento::query()->create(['nome' => 'Registro de Imóveis']);
        TipoDocumento::query()->create(['nome' => 'Registro de Títulos e Documentos']);
        TipoDocumento::query()->create(['nome' => 'Certidão']);
        TipoDocumento::query()->create(['nome' => 'Documento Personalizado']);
    }
}
