<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Aplica auditoria nas tabelas: grupo, permissao, grupo_permissao, usuario_grupo, usuario_permissao
 */
return new class extends Migration
{
    private array $tabelas = [
        ['schema' => 'public', 'tabela' => 'grupo'],
        ['schema' => 'public', 'tabela' => 'permissao'],
        ['schema' => 'public', 'tabela' => 'grupo_permissao'],
        ['schema' => 'public', 'tabela' => 'usuario_grupo'],
        ['schema' => 'public', 'tabela' => 'usuario_permissao'],
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
