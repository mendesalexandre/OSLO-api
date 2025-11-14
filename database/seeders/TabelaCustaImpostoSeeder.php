<?php

namespace Database\Seeders;

use App\Models\TabelaCusta;
use App\Models\TabelaCustaImposto;
use Illuminate\Database\Seeder;

class TabelaCustaImpostoSeeder extends Seeder
{
    public function run(): void
    {
        $tabelaCusta = TabelaCusta::where('ano', 2025)
            ->where('estado_id', 11) // MT
            ->first();

        if (!$tabelaCusta) {
            $this->command->warn('Tabela de Custas MT 2025 não encontrada');
            return;
        }

        $impostos = [
            [
                'codigo' => 'registro_civil',
                'nome' => 'Registro Civil',
                'descricao' => 'Repasse para manutenção de gratuidade de certidões',
                'tipo_valor' => 'fixo',
                'valor_fixo' => 8.20,
                'percentual' => null,
                'base_calculo' => null,
                'ordem_aplicacao' => 1,
                'deduzir_da_base' => true,
            ],
            [
                'codigo' => 'funajuris',
                'nome' => 'FUNAJURIS',
                'descricao' => 'Fundo Judiciário',
                'tipo_valor' => 'percentual',
                'valor_fixo' => null,
                'percentual' => 20.00,
                'base_calculo' => 'emolumento_liquido', // Após deduzir Registro Civil
                'ordem_aplicacao' => 2,
                'deduzir_da_base' => true,
            ],
            [
                'codigo' => 'issqn',
                'nome' => 'ISSQN',
                'descricao' => 'Imposto sobre Serviços',
                'tipo_valor' => 'percentual',
                'valor_fixo' => null,
                'percentual' => 5.00,
                'base_calculo' => 'emolumento_liquido', // Após deduzir RC + FUNAJURIS
                'ordem_aplicacao' => 3,
                'deduzir_da_base' => false,
            ],
        ];

        foreach ($impostos as $impostoData) {
            TabelaCustaImposto::create([
                'tabela_custa_id' => $tabelaCusta->id,
                ...$impostoData
            ]);
        }

        $this->command->info('✅ Impostos cadastrados com sucesso!');
    }
}
