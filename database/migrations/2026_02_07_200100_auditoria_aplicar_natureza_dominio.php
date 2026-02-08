<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Aplica auditoria nas tabelas: natureza, dominio
 *
 * Gerado automaticamente por: php artisan auditoria:migration
 * Data: 2026-02-07 19:31:54
 */
return new class extends Migration
{
    private array $tabelas = [
        ['schema' => 'public', 'tabela' => 'natureza'],
        ['schema' => 'public', 'tabela' => 'dominio'],
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
