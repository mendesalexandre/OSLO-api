<?php

namespace App\Services;

use App\Models\Dominio;

class DominioService
{
    public function __construct(public Dominio $dominio) {}

    public function nomearEntidade(string $nome): Dominio
    {
        $nome = trim($nome);

        if (empty($nome)) {
            throw new \InvalidArgumentException("O nome do domínio não pode ser vazio.");
        }

        if ($this->dominio->nome === $nome) {
            return $this->dominio;
        }
    }
}
