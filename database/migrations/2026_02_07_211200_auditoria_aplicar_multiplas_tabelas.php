<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Aplica auditoria nas tabelas: ato, ato_faixa, forma_pagamento, protocolo_item, protocolo_pagamento, protocolo_isencao, contrato, contrato_exigencia, contrato_andamento, recibo
 *
 * Gerado automaticamente por: php artisan auditoria:migration
 * Data: 2026-02-07 19:58:36
 */
return new class extends Migration
{
    private array $tabelas = [
        ['schema' => 'public', 'tabela' => 'ato'],
        ['schema' => 'public', 'tabela' => 'ato_faixa'],
        ['schema' => 'public', 'tabela' => 'forma_pagamento'],
        ['schema' => 'public', 'tabela' => 'protocolo_item'],
        ['schema' => 'public', 'tabela' => 'protocolo_pagamento'],
        ['schema' => 'public', 'tabela' => 'protocolo_isencao'],
        ['schema' => 'public', 'tabela' => 'contrato'],
        ['schema' => 'public', 'tabela' => 'contrato_exigencia'],
        ['schema' => 'public', 'tabela' => 'contrato_andamento'],
        ['schema' => 'public', 'tabela' => 'recibo'],
    ];

    public function up(): void
    {
        foreach ($this->tabelas as $item) {
            DB::unprepared("
                DO \$\$
                BEGIN
                    IF EXISTS (SELECT 1 FROM pg_proc WHERE proname = 'fn_aplicar_auditoria') THEN
                        PERFORM auditoria.fn_aplicar_auditoria('{$item['schema']}', '{$item['tabela']}');
                    END IF;
                END \$\$;
            ");
        }
    }

    public function down(): void
    {
        foreach ($this->tabelas as $item) {
            DB::unprepared("
                DO \$\$
                BEGIN
                    IF EXISTS (SELECT 1 FROM pg_proc WHERE proname = 'fn_remover_auditoria') THEN
                        PERFORM auditoria.fn_remover_auditoria('{$item['schema']}', '{$item['tabela']}');
                    END IF;
                END \$\$;
            ");
        }
    }
};
