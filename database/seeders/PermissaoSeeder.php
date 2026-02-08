<?php

namespace Database\Seeders;

use App\Models\Permissao;
use Illuminate\Database\Seeder;

class PermissaoSeeder extends Seeder
{
    public function run(): void
    {
        $permissoes = [
            // PROTOCOLO
            ['nome' => 'PROTOCOLO_LISTAR', 'descricao' => 'Listar protocolos', 'modulo' => 'Protocolo'],
            ['nome' => 'PROTOCOLO_CRIAR', 'descricao' => 'Criar protocolo', 'modulo' => 'Protocolo'],
            ['nome' => 'PROTOCOLO_VISUALIZAR', 'descricao' => 'Visualizar protocolo', 'modulo' => 'Protocolo'],
            ['nome' => 'PROTOCOLO_EDITAR', 'descricao' => 'Editar protocolo', 'modulo' => 'Protocolo'],
            ['nome' => 'PROTOCOLO_CANCELAR', 'descricao' => 'Cancelar protocolo', 'modulo' => 'Protocolo'],
            ['nome' => 'PROTOCOLO_PAGAR', 'descricao' => 'Registrar pagamento de protocolo', 'modulo' => 'Protocolo'],
            ['nome' => 'PROTOCOLO_ESTORNAR', 'descricao' => 'Estornar pagamento de protocolo', 'modulo' => 'Protocolo'],
            ['nome' => 'PROTOCOLO_ISENTAR', 'descricao' => 'Registrar isenção de protocolo', 'modulo' => 'Protocolo'],

            // CONTRATO
            ['nome' => 'CONTRATO_LISTAR', 'descricao' => 'Listar contratos', 'modulo' => 'Contrato'],
            ['nome' => 'CONTRATO_CRIAR', 'descricao' => 'Criar contrato', 'modulo' => 'Contrato'],
            ['nome' => 'CONTRATO_VISUALIZAR', 'descricao' => 'Visualizar contrato', 'modulo' => 'Contrato'],
            ['nome' => 'CONTRATO_EDITAR', 'descricao' => 'Editar contrato', 'modulo' => 'Contrato'],
            ['nome' => 'CONTRATO_CONCLUIR', 'descricao' => 'Concluir contrato', 'modulo' => 'Contrato'],
            ['nome' => 'CONTRATO_CANCELAR', 'descricao' => 'Cancelar contrato', 'modulo' => 'Contrato'],

            // RECIBO
            ['nome' => 'RECIBO_LISTAR', 'descricao' => 'Listar recibos', 'modulo' => 'Recibo'],
            ['nome' => 'RECIBO_VISUALIZAR', 'descricao' => 'Visualizar recibo', 'modulo' => 'Recibo'],
            ['nome' => 'RECIBO_GERAR', 'descricao' => 'Gerar recibo', 'modulo' => 'Recibo'],

            // ATO
            ['nome' => 'ATO_LISTAR', 'descricao' => 'Listar atos', 'modulo' => 'Ato'],
            ['nome' => 'ATO_CRIAR', 'descricao' => 'Criar ato', 'modulo' => 'Ato'],
            ['nome' => 'ATO_VISUALIZAR', 'descricao' => 'Visualizar ato', 'modulo' => 'Ato'],
            ['nome' => 'ATO_EDITAR', 'descricao' => 'Editar ato', 'modulo' => 'Ato'],
            ['nome' => 'ATO_EXCLUIR', 'descricao' => 'Excluir ato', 'modulo' => 'Ato'],

            // FINANCEIRO
            ['nome' => 'FORMA_PAGAMENTO_LISTAR', 'descricao' => 'Listar formas de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'FORMA_PAGAMENTO_CRIAR', 'descricao' => 'Criar forma de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'FORMA_PAGAMENTO_VISUALIZAR', 'descricao' => 'Visualizar forma de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'FORMA_PAGAMENTO_EDITAR', 'descricao' => 'Editar forma de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'FORMA_PAGAMENTO_EXCLUIR', 'descricao' => 'Excluir forma de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'MEIO_PAGAMENTO_LISTAR', 'descricao' => 'Listar meios de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'MEIO_PAGAMENTO_CRIAR', 'descricao' => 'Criar meio de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'MEIO_PAGAMENTO_VISUALIZAR', 'descricao' => 'Visualizar meio de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'MEIO_PAGAMENTO_EDITAR', 'descricao' => 'Editar meio de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'MEIO_PAGAMENTO_EXCLUIR', 'descricao' => 'Excluir meio de pagamento', 'modulo' => 'Financeiro'],
            ['nome' => 'TRANSACAO_LISTAR', 'descricao' => 'Listar transações', 'modulo' => 'Financeiro'],
            ['nome' => 'TRANSACAO_CRIAR', 'descricao' => 'Criar transação', 'modulo' => 'Financeiro'],
            ['nome' => 'TRANSACAO_EDITAR', 'descricao' => 'Editar transação', 'modulo' => 'Financeiro'],
            ['nome' => 'TRANSACAO_EXCLUIR', 'descricao' => 'Excluir transação', 'modulo' => 'Financeiro'],

            // CAIXA
            ['nome' => 'CAIXA_LISTAR', 'descricao' => 'Listar caixas', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_CRIAR', 'descricao' => 'Criar caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_EDITAR', 'descricao' => 'Editar caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_EXCLUIR', 'descricao' => 'Excluir caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_MOVIMENTO_LISTAR', 'descricao' => 'Listar movimentos de caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_MOVIMENTO_ABRIR', 'descricao' => 'Abrir movimento de caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_MOVIMENTO_FECHAR', 'descricao' => 'Fechar movimento de caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_MOVIMENTO_CONFERIR', 'descricao' => 'Conferir movimento de caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_MOVIMENTO_REABRIR', 'descricao' => 'Reabrir movimento de caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_OPERACAO_LISTAR', 'descricao' => 'Listar operações de caixa', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_OPERACAO_SANGRIA', 'descricao' => 'Realizar sangria', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_OPERACAO_REFORCO', 'descricao' => 'Realizar reforço', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_OPERACAO_TRANSFERIR', 'descricao' => 'Transferir entre caixas', 'modulo' => 'Caixa'],
            ['nome' => 'CAIXA_OPERACAO_ESTORNAR', 'descricao' => 'Estornar operação de caixa', 'modulo' => 'Caixa'],

            // ADMINISTRAÇÃO
            ['nome' => 'DOMINIO_LISTAR', 'descricao' => 'Listar domínios', 'modulo' => 'Administração'],
            ['nome' => 'DOMINIO_CRIAR', 'descricao' => 'Criar domínio', 'modulo' => 'Administração'],
            ['nome' => 'DOMINIO_VISUALIZAR', 'descricao' => 'Visualizar domínio', 'modulo' => 'Administração'],
            ['nome' => 'DOMINIO_EDITAR', 'descricao' => 'Editar domínio', 'modulo' => 'Administração'],
            ['nome' => 'DOMINIO_EXCLUIR', 'descricao' => 'Excluir domínio', 'modulo' => 'Administração'],
            ['nome' => 'NATUREZA_LISTAR', 'descricao' => 'Listar naturezas', 'modulo' => 'Administração'],
            ['nome' => 'NATUREZA_CRIAR', 'descricao' => 'Criar natureza', 'modulo' => 'Administração'],
            ['nome' => 'NATUREZA_VISUALIZAR', 'descricao' => 'Visualizar natureza', 'modulo' => 'Administração'],
            ['nome' => 'NATUREZA_EDITAR', 'descricao' => 'Editar natureza', 'modulo' => 'Administração'],
            ['nome' => 'NATUREZA_EXCLUIR', 'descricao' => 'Excluir natureza', 'modulo' => 'Administração'],
            ['nome' => 'ESTADO_LISTAR', 'descricao' => 'Listar estados', 'modulo' => 'Administração'],
            ['nome' => 'ESTADO_CRIAR', 'descricao' => 'Criar estado', 'modulo' => 'Administração'],
            ['nome' => 'ESTADO_VISUALIZAR', 'descricao' => 'Visualizar estado', 'modulo' => 'Administração'],
            ['nome' => 'ESTADO_EDITAR', 'descricao' => 'Editar estado', 'modulo' => 'Administração'],
            ['nome' => 'ESTADO_EXCLUIR', 'descricao' => 'Excluir estado', 'modulo' => 'Administração'],
            ['nome' => 'CIDADE_LISTAR', 'descricao' => 'Listar cidades', 'modulo' => 'Administração'],
            ['nome' => 'CIDADE_CRIAR', 'descricao' => 'Criar cidade', 'modulo' => 'Administração'],
            ['nome' => 'CIDADE_VISUALIZAR', 'descricao' => 'Visualizar cidade', 'modulo' => 'Administração'],
            ['nome' => 'CIDADE_EDITAR', 'descricao' => 'Editar cidade', 'modulo' => 'Administração'],
            ['nome' => 'CIDADE_EXCLUIR', 'descricao' => 'Excluir cidade', 'modulo' => 'Administração'],
            ['nome' => 'FERIADO_LISTAR', 'descricao' => 'Listar feriados', 'modulo' => 'Administração'],
            ['nome' => 'FERIADO_CRIAR', 'descricao' => 'Criar feriado', 'modulo' => 'Administração'],
            ['nome' => 'FERIADO_VISUALIZAR', 'descricao' => 'Visualizar feriado', 'modulo' => 'Administração'],
            ['nome' => 'FERIADO_EDITAR', 'descricao' => 'Editar feriado', 'modulo' => 'Administração'],
            ['nome' => 'FERIADO_EXCLUIR', 'descricao' => 'Excluir feriado', 'modulo' => 'Administração'],
            ['nome' => 'CONFIGURACAO_LISTAR', 'descricao' => 'Visualizar configurações', 'modulo' => 'Administração'],
            ['nome' => 'CONFIGURACAO_EDITAR', 'descricao' => 'Editar configurações', 'modulo' => 'Administração'],
            ['nome' => 'TABELA_CUSTA_LISTAR', 'descricao' => 'Listar tabelas de custas', 'modulo' => 'Administração'],
            ['nome' => 'ETAPA_LISTAR', 'descricao' => 'Listar etapas', 'modulo' => 'Administração'],
            ['nome' => 'ETAPA_CRIAR', 'descricao' => 'Criar etapa', 'modulo' => 'Administração'],
            ['nome' => 'ETAPA_EDITAR', 'descricao' => 'Editar etapa', 'modulo' => 'Administração'],
            ['nome' => 'ETAPA_EXCLUIR', 'descricao' => 'Excluir etapa', 'modulo' => 'Administração'],
            ['nome' => 'CATEGORIA_LISTAR', 'descricao' => 'Listar categorias', 'modulo' => 'Administração'],
            ['nome' => 'CATEGORIA_CRIAR', 'descricao' => 'Criar categoria', 'modulo' => 'Administração'],
            ['nome' => 'CATEGORIA_EDITAR', 'descricao' => 'Editar categoria', 'modulo' => 'Administração'],
            ['nome' => 'CATEGORIA_EXCLUIR', 'descricao' => 'Excluir categoria', 'modulo' => 'Administração'],
            ['nome' => 'AUDITORIA_LISTAR', 'descricao' => 'Consultar registros de auditoria', 'modulo' => 'Administração'],

            // DOI
            ['nome' => 'DOI_LISTAR', 'descricao' => 'Listar declarações DOI', 'modulo' => 'DOI'],
            ['nome' => 'DOI_CRIAR', 'descricao' => 'Criar declaração DOI', 'modulo' => 'DOI'],
            ['nome' => 'DOI_EDITAR', 'descricao' => 'Editar declaração DOI', 'modulo' => 'DOI'],

            // PERMISSÕES (gestão)
            ['nome' => 'GRUPO_LISTAR', 'descricao' => 'Listar grupos', 'modulo' => 'Permissões'],
            ['nome' => 'GRUPO_CRIAR', 'descricao' => 'Criar grupo', 'modulo' => 'Permissões'],
            ['nome' => 'GRUPO_VISUALIZAR', 'descricao' => 'Visualizar grupo', 'modulo' => 'Permissões'],
            ['nome' => 'GRUPO_EDITAR', 'descricao' => 'Editar grupo', 'modulo' => 'Permissões'],
            ['nome' => 'GRUPO_EXCLUIR', 'descricao' => 'Excluir grupo', 'modulo' => 'Permissões'],
            ['nome' => 'PERMISSAO_LISTAR', 'descricao' => 'Listar permissões', 'modulo' => 'Permissões'],
            ['nome' => 'PERMISSAO_CRIAR', 'descricao' => 'Criar permissão', 'modulo' => 'Permissões'],
            ['nome' => 'PERMISSAO_VISUALIZAR', 'descricao' => 'Visualizar permissão', 'modulo' => 'Permissões'],
            ['nome' => 'PERMISSAO_EDITAR', 'descricao' => 'Editar permissão', 'modulo' => 'Permissões'],
            ['nome' => 'PERMISSAO_EXCLUIR', 'descricao' => 'Excluir permissão', 'modulo' => 'Permissões'],
            ['nome' => 'USUARIO_PERMISSAO_LISTAR', 'descricao' => 'Listar permissões de usuário', 'modulo' => 'Permissões'],
            ['nome' => 'USUARIO_PERMISSAO_EDITAR', 'descricao' => 'Editar permissões de usuário', 'modulo' => 'Permissões'],
        ];

        foreach ($permissoes as $permissao) {
            Permissao::firstOrCreate(
                ['nome' => $permissao['nome']],
                $permissao
            );
        }
    }
}
