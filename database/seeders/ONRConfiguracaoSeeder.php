<?php

namespace Database\Seeders;

use App\Models\ONRConfiguracao;
use Illuminate\Database\Seeder;

class ONRConfiguracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ONRConfiguracao::query()->create([
            'url' => 'https://wsoficio.onr.org.br',
            'nome' => 'Configuração da ONR',
            'ambiente' => 0,
            'chave' => 'BB46F6F0-CF42-4346-A01E-99C6A33E962F',
            'certificado_subject' => 'RODRIGO ROBALINHO ESTEVAM:71256792187',
            'certificado_issuer' => 'ICP-Brasil',
            'certificado_public_key' => 'MIIHcTCCBVmgAwIBAgIUCraQbq0TQMZiHhf9STgma7L+wEcwDQYJKoZIhvcNAQEL',
            'certificado_serial_number' => '6FD0EAE20693AC47CFD510C9C8C95110C59779F4',
            'certificado_valid_until' => '2050-02-10',
            'cpf' => '71256792187',
            'email' => 'registrodeimoveis1@hotmail.com',
            'id_parceiro_ws' => 682
        ]);
    }
}
