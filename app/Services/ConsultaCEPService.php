<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConsultaCEPService
{
    private const VIACEP_URL = 'https://viacep.com.br/ws';
    private const TIMEOUT = 10; // segundos

    public function __construct() {}

    /**
     * Consulta o CEP e retorna os dados completos
     *
     * @param string $cep
     * @return array|null
     */
    public function consultar(string $cep): ?array
    {
        $cep = $this->limparCEP($cep);

        if (!$this->validarCEP($cep)) {
            Log::warning("CEP inválido: {$cep}");
            return null;
        }

        try {
            $response = Http::timeout(self::TIMEOUT)
                ->get(self::VIACEP_URL . "/{$cep}/json/");

            if (!$response->successful()) {
                Log::error("Erro na consulta do CEP {$cep}: Status {$response->status()}");
                return null;
            }

            $dados = $response->json();

            // ViaCEP retorna {"erro": true} quando não encontra
            if (isset($dados['erro']) && $dados['erro'] === true) {
                Log::info("CEP não encontrado: {$cep}");
                return null;
            }

            return $dados;
        } catch (\Exception $e) {
            Log::error("Exceção ao consultar CEP {$cep}: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Consulta apenas o código IBGE do CEP
     *
     * @param string $cep
     * @return string|null
     */
    public function obterCodigoIBGE(string $cep): ?string
    {
        $dados = $this->consultar($cep);

        return $dados['ibge'] ?? null;
    }

    /**
     * Consulta e retorna dados formatados
     *
     * @param string $cep
     * @return array|null
     */
    public function consultarFormatado(string $cep): ?array
    {
        $dados = $this->consultar($cep);

        if (!$dados) {
            return null;
        }

        return [
            'cep' => $dados['cep'] ?? null,
            'logradouro' => $dados['logradouro'] ?? null,
            'complemento' => $dados['complemento'] ?? null,
            'bairro' => $dados['bairro'] ?? null,
            'localidade' => $dados['localidade'] ?? null,
            'uf' => $dados['uf'] ?? null,
            'ibge' => $dados['ibge'] ?? null,
            'gia' => $dados['gia'] ?? null,
            'ddd' => $dados['ddd'] ?? null,
            'siafi' => $dados['siafi'] ?? null,
        ];
    }

    /**
     * Remove caracteres não numéricos do CEP
     *
     * @param string $cep
     * @return string
     */
    private function limparCEP(string $cep): string
    {
        return preg_replace('/[^0-9]/', '', $cep);
    }

    /**
     * Valida formato do CEP (deve ter 8 dígitos)
     *
     * @param string $cep
     * @return bool
     */
    private function validarCEP(string $cep): bool
    {
        return strlen($cep) === 8 && ctype_digit($cep);
    }

    /**
     * Formata CEP no padrão 00000-000
     *
     * @param string $cep
     * @return string|null
     */
    public function formatarCEP(string $cep): ?string
    {
        $cep = $this->limparCEP($cep);

        if (!$this->validarCEP($cep)) {
            return null;
        }

        return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    }
}
