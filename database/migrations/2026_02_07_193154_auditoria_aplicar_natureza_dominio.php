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
            DB::statement(
                "SELECT auditoria.fn_aplicar_auditoria(?, ?);",
                [$item['schema'], $item['tabela']]
            );
        }
    }

    public function down(): void
    {
        foreach ($this->tabelas as $item) {
            DB::statement(
                "SELECT auditoria.fn_remover_auditoria(?, ?);",
                [$item['schema'], $item['tabela']]
            );
        }
    }
};
