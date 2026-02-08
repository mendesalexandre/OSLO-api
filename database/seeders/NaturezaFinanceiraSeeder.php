<?php

namespace Database\Seeders;

use App\Models\Natureza;
use Illuminate\Database\Seeder;

class NaturezaFinanceiraSeeder extends Seeder
{
    public function run(): void
    {
        $naturezas = [
            ['nome' => 'Emolumento', 'descricao' => 'Emolumentos cartorários', 'codigo' => 'EMOL'],
            ['nome' => 'Taxa de Fiscalização Judiciária', 'descricao' => 'TFJ - Taxa de Fiscalização Judiciária', 'codigo' => 'TFJ'],
            ['nome' => 'FUNDESP', 'descricao' => 'Fundo Especial de Reaparelhamento - MT', 'codigo' => 'FUNDESP'],
            ['nome' => 'ISS', 'descricao' => 'Imposto Sobre Serviços / ISSQN', 'codigo' => 'ISS'],
        ];

        foreach ($naturezas as $natureza) {
            Natureza::firstOrCreate(
                ['codigo' => $natureza['codigo']],
                array_merge($natureza, ['is_ativo' => true])
            );
        }
    }
}
