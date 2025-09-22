<?php

namespace Database\Seeders;

use App\Models\Dominio;
use Illuminate\Database\Seeder;

class DominioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dominios = [
            // REGISTRO DE IMÓVEIS
            [
                'is_ativo' => true,
                'codigo' => 'PROTOCOLO_RI',
                'nome' => 'Protocolo RI',
                'nome_completo' => 'Protocolo RI',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'RI',
                'genero' => 'o',
                'ordem_exibicao' => 1,
                'descricao' => 'Protocolo para Registro de Imóveis'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'CERTIDAO_RI',
                'nome' => 'Certidão RI',
                'nome_completo' => 'Pedido de Certidão RI',
                'tipo' => 'PEDIDO_CERTIDAO',
                'atribuicao' => 'RI',
                'genero' => 'o',
                'ordem_exibicao' => 2,
                'descricao' => 'Pedido de Certidão do Registro de Imóveis'
            ],

            // REGISTRO DE TÍTULOS E DOCUMENTOS
            [
                'is_ativo' => true,
                'codigo' => 'PROTOCOLO_RTD',
                'nome' => 'Protocolo RTD',
                'nome_completo' => 'Protocolo RTD',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'RTD',
                'genero' => 'o',
                'ordem_exibicao' => 3,
                'descricao' => 'Protocolo para Registro de Títulos e Documentos'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'CERTIDAO_RTD',
                'nome' => 'Certidão RTD',
                'nome_completo' => 'Pedido de Certidão RTD',
                'tipo' => 'PEDIDO_CERTIDAO',
                'atribuicao' => 'RTD',
                'genero' => 'o',
                'ordem_exibicao' => 4,
                'descricao' => 'Pedido de Certidão do Registro de Títulos e Documentos'
            ],

            // REGISTRO CIVIL DE PESSOAS JURÍDICAS
            [
                'is_ativo' => true,
                'codigo' => 'PROTOCOLO_RCPJ',
                'nome' => 'Protocolo RCPJ',
                'nome_completo' => 'Protocolo RCPJ',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'RCPJ',
                'genero' => 'o',
                'ordem_exibicao' => 5,
                'descricao' => 'Protocolo para Registro Civil de Pessoas Jurídicas'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'CERTIDAO_RCPJ',
                'nome' => 'Certidão RCPJ',
                'nome_completo' => 'Pedido de Certidão RCPJ',
                'tipo' => 'PEDIDO_CERTIDAO',
                'atribuicao' => 'RCPJ',
                'genero' => 'o',
                'ordem_exibicao' => 6,
                'descricao' => 'Pedido de Certidão do Registro Civil de Pessoas Jurídicas'
            ],

            // TABELIONATO DE NOTAS
            [
                'is_ativo' => true,
                'codigo' => 'PROTOCOLO_NOTAS',
                'nome' => 'Protocolo TN',
                'nome_completo' => 'Protocolo TN',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'NOTAS',
                'genero' => 'o',
                'ordem_exibicao' => 7,
                'descricao' => 'Protocolo para Tabelionato de Notas'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'SERVICO_TN',
                'nome' => 'Serviço TN',
                'nome_completo' => 'Serviço TN',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'NOTAS',
                'genero' => 'o',
                'ordem_exibicao' => 8,
                'descricao' => 'Serviço do Tabelionato de Notas'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'CERTIDAO_TN',
                'nome' => 'Certidão TN',
                'nome_completo' => 'Pedido de Certidão TN',
                'tipo' => 'PEDIDO_CERTIDAO',
                'atribuicao' => 'NOTAS',
                'genero' => 'o',
                'ordem_exibicao' => 9,
                'descricao' => 'Pedido de Certidão do Tabelionato de Notas'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'ESCRITURA',
                'nome' => 'Escritura',
                'nome_completo' => 'Escritura',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'NOTAS',
                'genero' => 'a',
                'ordem_exibicao' => 10,
                'descricao' => 'Escritura Pública'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'PROCURACAO',
                'nome' => 'Procuração',
                'nome_completo' => 'Procuração',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'NOTAS',
                'genero' => 'a',
                'ordem_exibicao' => 11,
                'descricao' => 'Procuração Pública'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'SUBSTABELECIMENTO',
                'nome' => 'Substabelecimento',
                'nome_completo' => 'Substabelecimento',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'NOTAS',
                'genero' => 'o',
                'ordem_exibicao' => 12,
                'descricao' => 'Substabelecimento de Procuração'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'TESTAMENTO',
                'nome' => 'Testamento',
                'nome_completo' => 'Testamento',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'NOTAS',
                'genero' => 'o',
                'ordem_exibicao' => 13,
                'descricao' => 'Testamento Público'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'ATA_NOTARIAL',
                'nome' => 'Ata Notarial',
                'nome_completo' => 'Ata Notarial',
                'tipo' => 'PROTOCOLO',
                'atribuicao' => 'NOTAS',
                'genero' => 'a',
                'ordem_exibicao' => 14,
                'descricao' => 'Ata Notarial'
            ],

            // SERVIÇOS GERAIS/AUXILIARES
            [
                'is_ativo' => true,
                'codigo' => 'NOTIFICACAO',
                'nome' => 'Notificação',
                'nome_completo' => 'Notificação',
                'tipo' => 'AUXILIAR',
                'atribuicao' => 'GERAL',
                'genero' => 'a',
                'ordem_exibicao' => 15,
                'descricao' => 'Serviço de Notificação'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'OCORRENCIA',
                'nome' => 'Ocorrência',
                'nome_completo' => 'Ocorrência',
                'tipo' => 'AUXILIAR',
                'atribuicao' => 'GERAL',
                'genero' => 'a',
                'ordem_exibicao' => 16,
                'descricao' => 'Registro de Ocorrência'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'OFICIO',
                'nome' => 'Ofício',
                'nome_completo' => 'Ofício',
                'tipo' => 'AUXILIAR',
                'atribuicao' => 'GERAL',
                'genero' => 'o',
                'ordem_exibicao' => 17,
                'descricao' => 'Ofício'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'PERSONALIZADO',
                'nome' => 'Processos Personalizados',
                'nome_completo' => 'Processos Personalizados',
                'tipo' => 'AUXILIAR',
                'atribuicao' => 'GERAL',
                'genero' => 'o',
                'ordem_exibicao' => 18,
                'descricao' => 'Processos Personalizados'
            ],
            [
                'is_ativo' => true,
                'codigo' => 'DOCUMENTACAO',
                'nome' => 'Documentação',
                'nome_completo' => 'Documentação',
                'tipo' => 'AUXILIAR',
                'atribuicao' => 'GERAL',
                'genero' => 'a',
                'ordem_exibicao' => 19,
                'descricao' => 'Serviços de Documentação'
            ],
        ];

        foreach ($dominios as $dominio) {
            Dominio::create($dominio);
        }
    }
}
