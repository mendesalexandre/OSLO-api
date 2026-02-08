<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Remove tabelas não utilizadas:
 * - Spatie Permissions (5 tabelas)
 * - ONR (5 tabelas)
 * - Infraestrutura Laravel (4 tabelas)
 */
return new class extends Migration
{
    public function up(): void
    {
        // Usar CASCADE para resolver dependências FK no PostgreSQL
        $tabelas = [
            // Spatie Permissions — pivot tables primeiro
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'roles',
            'permissions',

            // ONR — configuracao antes de certificado_digital (FK)
            'onr_tabela_custa',
            'onr_configuracao',
            'onr_certificado_digital',
            'onr_token',
            'onr_certidao',

            // Infraestrutura Laravel não utilizada
            'password_reset_tokens',
            'cache',
            'cache_locks',
            'sessions',
        ];

        foreach ($tabelas as $tabela) {
            DB::statement("DROP TABLE IF EXISTS \"{$tabela}\" CASCADE");
        }
    }

    public function down(): void
    {
        // Não é necessário recriar — código removido
    }
};
