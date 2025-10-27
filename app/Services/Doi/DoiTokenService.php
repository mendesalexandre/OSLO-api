<?php

namespace App\Services\Doi;

use App\Models\Configuracao;

class DoiTokenService
{
    public function obterTokenValido(): string
    {
        $token = Configuracao::query()
            ->where('chave', '=', 'CONFIG_DOI_WEB_COOKIE')
            ->value('valor');

        if (!$token) {
            throw new \Exception('Token de autenticação não encontrado. Verifique a configuração do serviço.');
        }

        return $token;
    }
}
