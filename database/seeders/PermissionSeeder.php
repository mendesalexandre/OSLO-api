<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar permissões do módulo NATUREZA
        $this->createNaturezaPermissions();

        // Criar permissões do módulo DOMINIO
        $this->createDominioPermissions();

        // Criar permissões do módulo USUARIO
        $this->createUsuarioPermissions();

        // Criar permissões do módulo SISTEMA
        $this->createSistemaPermissions();

        // Criar roles padrão
        $this->createDefaultRoles();
    }

    private function createNaturezaPermissions(): void
    {
        $permissions = [
            [
                'name' => 'PERMITIR_NATUREZA_CRIAR',
                'description' => 'Permitir criar novas naturezas',
                'module_name' => 'NATUREZA',
                'guard_name' => 'api' // ← Importante
            ],
            [
                'name' => 'PERMITIR_NATUREZA_VISUALIZAR',
                'description' => 'Permitir visualizar naturezas',
                'module_name' => 'NATUREZA',
                'guard_name' => 'api' // ← Importante
            ],
            [
                'name' => 'PERMITIR_NATUREZA_EDITAR',
                'description' => 'Permitir editar naturezas',
                'module_name' => 'NATUREZA',
                'guard_name' => 'api' // ← Importante
            ],
            [
                'name' => 'PERMITIR_NATUREZA_EXCLUIR',
                'description' => 'Permitir excluir naturezas',
                'module_name' => 'NATUREZA',
                'guard_name' => 'api' // ← Importante
            ],
            [
                'name' => 'PERMITIR_NATUREZA_RESTAURAR',
                'description' => 'Permitir restaurar naturezas excluídas',
                'module_name' => 'NATUREZA',
                'guard_name' => 'api' // ← Importante
            ],
            [
                'name' => 'PERMITIR_NATUREZA_ALTERAR_STATUS',
                'description' => 'Permitir ativar/desativar naturezas',
                'module_name' => 'NATUREZA',
                'guard_name' => 'api' // ← Importante
            ],
            [
                'name' => 'PERMITIR_NATUREZA_DUPLICAR',
                'description' => 'Permitir duplicar naturezas',
                'module_name' => 'NATUREZA',
                'guard_name' => 'api' // ← Importante
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    /**
     * Criar permissões do módulo Domínio
     */
    private function createDominioPermissions(): void
    {
        $permissions = [
            [
                'name' => 'PERMITIR_DOMINIO_CRIAR',
                'description' => 'Permitir criar novos domínios',
                'module_name' => 'DOMINIO'
            ],
            [
                'name' => 'PERMITIR_DOMINIO_VISUALIZAR',
                'description' => 'Permitir visualizar domínios',
                'module_name' => 'DOMINIO'
            ],
            [
                'name' => 'PERMITIR_DOMINIO_EDITAR',
                'description' => 'Permitir editar domínios',
                'module_name' => 'DOMINIO'
            ],
            [
                'name' => 'PERMITIR_DOMINIO_EXCLUIR',
                'description' => 'Permitir excluir domínios',
                'module_name' => 'DOMINIO'
            ],
            [
                'name' => 'PERMITIR_DOMINIO_RESTAURAR',
                'description' => 'Permitir restaurar domínios excluídos',
                'module_name' => 'DOMINIO'
            ],
            [
                'name' => 'PERMITIR_DOMINIO_ALTERAR_STATUS',
                'description' => 'Permitir ativar/desativar domínios',
                'module_name' => 'DOMINIO'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    /**
     * Criar permissões do módulo Usuário
     */
    private function createUsuarioPermissions(): void
    {
        $permissions = [
            [
                'name' => 'PERMITIR_USUARIO_CRIAR',
                'description' => 'Permitir criar novos usuários',
                'module_name' => 'USUARIO'
            ],
            [
                'name' => 'PERMITIR_USUARIO_VISUALIZAR',
                'description' => 'Permitir visualizar usuários',
                'module_name' => 'USUARIO'
            ],
            [
                'name' => 'PERMITIR_USUARIO_EDITAR',
                'description' => 'Permitir editar usuários',
                'module_name' => 'USUARIO'
            ],
            [
                'name' => 'PERMITIR_USUARIO_EXCLUIR',
                'description' => 'Permitir excluir usuários',
                'module_name' => 'USUARIO'
            ],
            [
                'name' => 'PERMITIR_USUARIO_ALTERAR_PERMISSOES',
                'description' => 'Permitir alterar permissões de usuários',
                'module_name' => 'USUARIO'
            ],
            [
                'name' => 'PERMITIR_USUARIO_ALTERAR_STATUS',
                'description' => 'Permitir ativar/desativar usuários',
                'module_name' => 'USUARIO'
            ],
            [
                'name' => 'PERMITIR_USUARIO_RESTAURAR',
                'description' => 'Permitir restaurar usuários excluídos',
                'module_name' => 'USUARIO'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    /**
     * Criar permissões do módulo Sistema
     */
    private function createSistemaPermissions(): void
    {
        $permissions = [
            [
                'name' => 'PERMITIR_SISTEMA_CONFIGURACOES',
                'description' => 'Permitir acessar configurações do sistema',
                'module_name' => 'SISTEMA'
            ],
            [
                'name' => 'PERMITIR_SISTEMA_LOGS',
                'description' => 'Permitir visualizar logs do sistema',
                'module_name' => 'SISTEMA'
            ],
            [
                'name' => 'PERMITIR_SISTEMA_BACKUP',
                'description' => 'Permitir realizar backup do sistema',
                'module_name' => 'SISTEMA'
            ],
            [
                'name' => 'PERMITIR_SISTEMA_DASHBOARD',
                'description' => 'Permitir acessar dashboard administrativo',
                'module_name' => 'SISTEMA'
            ],
            [
                'name' => 'PERMITIR_SISTEMA_RELATORIOS',
                'description' => 'Permitir gerar relatórios do sistema',
                'module_name' => 'SISTEMA'
            ],
            [
                'name' => 'PERMITIR_SISTEMA_AUDITORIA',
                'description' => 'Permitir visualizar logs de auditoria',
                'module_name' => 'SISTEMA'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    /**
     * Criar roles padrão
     */
    private function createDefaultRoles(): void
    {
        // Role Super Admin
        $superAdmin = Role::create([
            'name' => 'super-admin',
            'description' => 'Super Administrador com acesso total',
            'module_name' => 'SISTEMA',
            'guard_name' => 'web'
        ]);

        // Dar todas as permissões para super-admin
        $superAdmin->givePermissionTo(Permission::all());

        // Role Admin
        $admin = Role::create([
            'name' => 'admin',
            'description' => 'Administrador do sistema',
            'module_name' => 'SISTEMA',
            'guard_name' => 'web'
        ]);

        // Permissões para admin (exceto algumas críticas)
        $adminPermissions = Permission::whereNotIn('name', [
            'PERMITIR_SISTEMA_BACKUP',
            'PERMITIR_USUARIO_EXCLUIR',
            'PERMITIR_DOMINIO_EXCLUIR'
        ])->get();

        $admin->givePermissionTo($adminPermissions);

        // Role Gestor
        $gestor = Role::create([
            'name' => 'gestor',
            'description' => 'Gestor com permissões de gerenciamento',
            'module_name' => 'USUARIO',
            'guard_name' => 'web'
        ]);

        // Permissões para gestor
        $gestorPermissions = [
            // Natureza - Todas exceto excluir
            'PERMITIR_NATUREZA_VISUALIZAR',
            'PERMITIR_NATUREZA_CRIAR',
            'PERMITIR_NATUREZA_EDITAR',
            'PERMITIR_NATUREZA_DUPLICAR',
            'PERMITIR_NATUREZA_ALTERAR_STATUS',
            'PERMITIR_NATUREZA_RESTAURAR',

            // Domínio - Visualizar e editar
            'PERMITIR_DOMINIO_VISUALIZAR',
            'PERMITIR_DOMINIO_EDITAR',
            'PERMITIR_DOMINIO_ALTERAR_STATUS',

            // Usuário - Gerenciar usuários operacionais
            'PERMITIR_USUARIO_VISUALIZAR',
            'PERMITIR_USUARIO_CRIAR',
            'PERMITIR_USUARIO_EDITAR',
            'PERMITIR_USUARIO_ALTERAR_STATUS',

            // Sistema - Relatórios e dashboard
            'PERMITIR_SISTEMA_DASHBOARD',
            'PERMITIR_SISTEMA_RELATORIOS',
            'PERMITIR_SISTEMA_AUDITORIA',
        ];

        $gestor->givePermissionTo($gestorPermissions);

        // Role Operador
        $operador = Role::create([
            'name' => 'operador',
            'description' => 'Operador do sistema',
            'module_name' => 'USUARIO',
            'guard_name' => 'web'
        ]);

        // Permissões básicas para operador
        $operadorPermissions = [
            'PERMITIR_NATUREZA_VISUALIZAR',
            'PERMITIR_NATUREZA_CRIAR',
            'PERMITIR_NATUREZA_EDITAR',
            'PERMITIR_NATUREZA_DUPLICAR',
            'PERMITIR_DOMINIO_VISUALIZAR',
            'PERMITIR_USUARIO_VISUALIZAR',
            'PERMITIR_SISTEMA_DASHBOARD',
        ];

        $operador->givePermissionTo($operadorPermissions);

        // Role Consulta
        $consulta = Role::create([
            'name' => 'consulta',
            'description' => 'Apenas visualização',
            'module_name' => 'USUARIO',
            'guard_name' => 'web'
        ]);

        // Apenas permissões de visualização
        $consultaPermissions = [
            'PERMITIR_NATUREZA_VISUALIZAR',
            'PERMITIR_DOMINIO_VISUALIZAR',
            'PERMITIR_USUARIO_VISUALIZAR',
            'PERMITIR_SISTEMA_DASHBOARD',
        ];

        $consulta->givePermissionTo($consultaPermissions);

        // Role Suporte Técnico
        $suporte = Role::create([
            'name' => 'suporte',
            'description' => 'Suporte técnico com acesso a logs e configurações',
            'module_name' => 'SISTEMA',
            'guard_name' => 'web'
        ]);

        $suportePermissions = [
            'PERMITIR_NATUREZA_VISUALIZAR',
            'PERMITIR_DOMINIO_VISUALIZAR',
            'PERMITIR_USUARIO_VISUALIZAR',
            'PERMITIR_SISTEMA_CONFIGURACOES',
            'PERMITIR_SISTEMA_LOGS',
            'PERMITIR_SISTEMA_DASHBOARD',
            'PERMITIR_SISTEMA_AUDITORIA',
        ];

        $suporte->givePermissionTo($suportePermissions);
    }
}
