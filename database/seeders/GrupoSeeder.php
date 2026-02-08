<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Permissao;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador — tem todas as permissões (bypass via eAdmin())
        $admin = Grupo::firstOrCreate(
            ['nome' => 'Administrador'],
            ['descricao' => 'Acesso total ao sistema', 'ativo' => true]
        );

        // Registrador — protocolo, contrato, ato, recibo
        $registrador = Grupo::firstOrCreate(
            ['nome' => 'Registrador'],
            ['descricao' => 'Gestão de protocolos, contratos e atos', 'ativo' => true]
        );

        // Atendente — protocolo (criar/listar), consulta
        $atendente = Grupo::firstOrCreate(
            ['nome' => 'Atendente'],
            ['descricao' => 'Atendimento ao público e criação de protocolos', 'ativo' => true]
        );

        // Caixa — financeiro, caixa, pagamentos
        $caixa = Grupo::firstOrCreate(
            ['nome' => 'Caixa'],
            ['descricao' => 'Operações financeiras e de caixa', 'ativo' => true]
        );

        // Consulta — somente leitura
        $consulta = Grupo::firstOrCreate(
            ['nome' => 'Consulta'],
            ['descricao' => 'Acesso somente leitura ao sistema', 'ativo' => true]
        );

        // Sincronizar permissões dos grupos
        $this->sincronizarPermissoes($registrador, [
            'PROTOCOLO_*', 'CONTRATO_*', 'RECIBO_*', 'ATO_*',
        ]);

        $this->sincronizarPermissoes($atendente, [
            'PROTOCOLO_LISTAR', 'PROTOCOLO_CRIAR', 'PROTOCOLO_VISUALIZAR',
            'CONTRATO_LISTAR', 'CONTRATO_VISUALIZAR',
            'RECIBO_LISTAR', 'RECIBO_VISUALIZAR',
        ]);

        $this->sincronizarPermissoes($caixa, [
            'CAIXA_*', 'TRANSACAO_*',
            'FORMA_PAGAMENTO_LISTAR', 'FORMA_PAGAMENTO_VISUALIZAR',
            'MEIO_PAGAMENTO_LISTAR', 'MEIO_PAGAMENTO_VISUALIZAR',
            'PROTOCOLO_LISTAR', 'PROTOCOLO_VISUALIZAR', 'PROTOCOLO_PAGAR', 'PROTOCOLO_ESTORNAR',
            'RECIBO_LISTAR', 'RECIBO_VISUALIZAR', 'RECIBO_GERAR',
        ]);

        $this->sincronizarPermissoes($consulta, [
            'PROTOCOLO_LISTAR', 'PROTOCOLO_VISUALIZAR',
            'CONTRATO_LISTAR', 'CONTRATO_VISUALIZAR',
            'RECIBO_LISTAR', 'RECIBO_VISUALIZAR',
            'ATO_LISTAR', 'ATO_VISUALIZAR',
            'DOMINIO_LISTAR', 'DOMINIO_VISUALIZAR',
            'NATUREZA_LISTAR', 'NATUREZA_VISUALIZAR',
        ]);
    }

    private function sincronizarPermissoes(Grupo $grupo, array $padroes): void
    {
        $permissaoIds = collect();

        foreach ($padroes as $padrao) {
            if (str_contains($padrao, '*')) {
                $prefixo = str_replace('*', '', $padrao);
                $ids = Permissao::where('nome', 'like', $prefixo . '%')
                    ->where('ativo', true)
                    ->pluck('id');
                $permissaoIds = $permissaoIds->merge($ids);
            } else {
                $id = Permissao::where('nome', $padrao)
                    ->where('ativo', true)
                    ->value('id');
                if ($id) {
                    $permissaoIds->push($id);
                }
            }
        }

        $grupo->permissoes()->sync($permissaoIds->unique()->toArray());
    }
}
