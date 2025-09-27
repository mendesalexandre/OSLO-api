<?php

namespace App\Services;

use App\Models\Sequencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SequenciaService
{
    /**
     * Obter próximo número da sequência para um domínio
     */
    public function proximoNumero(string $dominoCodigo, int|null $ano = null): string
    {
        $ano = $ano ?? now()->year;

        return DB::transaction(function () use ($dominoCodigo, $ano) {
            // Buscar ou criar sequência com lock para evitar concorrência
            $sequencia = Sequencia::lockForUpdate()
                ->where('dominio_codigo', $dominoCodigo)
                ->where('ano', $ano)
                ->first();

            if (!$sequencia) {
                // Criar nova sequência
                $sequencia = $this->criarNovaSequencia($dominoCodigo, $ano);
            } else {
                // Verificar se precisa renovar para novo ano
                if ($sequencia->precisaRenovarAno()) {
                    $sequencia = $this->renovarSequenciaParaNovoAno($sequencia, $ano);
                }
            }

            // Incrementar e retornar número formatado
            return $sequencia->proximoNumero();
        });
    }

    /**
     * Criar nova sequência com configurações padrão
     */
    private function criarNovaSequencia(string $dominoCodigo, int $ano): Sequencia
    {
        Log::info("Criando nova sequência", [
            'dominio_codigo' => $dominoCodigo,
            'ano' => $ano
        ]);

        $sequencia = Sequencia::create([
            'dominio_codigo' => $dominoCodigo,
            'ano' => $ano,
            'numero_atual' => 0,
            'is_ativo' => true,
            'reinicia_ano' => true,
            'inicio_contagem' => 1,
        ]);

        // Aplicar configurações padrão baseadas no tipo de domínio
        $sequencia->aplicarConfiguracoesPadrao();

        return $sequencia;
    }

    /**
     * Renovar sequência para novo ano
     */
    private function renovarSequenciaParaNovoAno(Sequencia $sequenciaAntiga, int $novoAno): Sequencia
    {
        Log::info("Renovando sequência para novo ano", [
            'dominio_codigo' => $sequenciaAntiga->dominio_codigo,
            'ano_antigo' => $sequenciaAntiga->ano,
            'ano_novo' => $novoAno
        ]);

        // Criar nova sequência para o novo ano baseada na anterior
        return Sequencia::create([
            'dominio_codigo' => $sequenciaAntiga->dominio_codigo,
            'ano' => $novoAno,
            'numero_atual' => $sequenciaAntiga->inicio_contagem - 1,
            'prefixo' => $sequenciaAntiga->prefixo,
            'sufixo' => $sequenciaAntiga->sufixo,
            'formato' => $sequenciaAntiga->formato,
            'tamanho_numero' => $sequenciaAntiga->tamanho_numero,
            'apenas_numero' => $sequenciaAntiga->apenas_numero,
            'reinicia_ano' => $sequenciaAntiga->reinicia_ano,
            'inicio_contagem' => $sequenciaAntiga->inicio_contagem,
            'is_ativo' => true,
        ]);
    }

    /**
     * Obter situação atual de uma sequência
     */
    public function situacaoSequencia(string $dominoCodigo, int $ano = null): array
    {
        $ano = $ano ?? now()->year;

        $sequencia = Sequencia::where('dominio_codigo', $dominoCodigo)
            ->where('ano', $ano)
            ->first();

        if (!$sequencia) {
            return [
                'existe' => false,
                'numero_atual' => 0,
                'proximo_numero' => 'Não configurado',
                'ano' => $ano,
            ];
        }

        return [
            'existe' => true,
            'numero_atual' => $sequencia->numero_atual,
            'proximo_numero' => $sequencia->proximo_numero_formatado,
            'ano' => $sequencia->ano,
            'formato' => $sequencia->apenas_numero ? 'Apenas número' : 'Formatado',
            'configuracao' => [
                'prefixo' => $sequencia->prefixo,
                'sufixo' => $sequencia->sufixo,
                'tamanho_numero' => $sequencia->tamanho_numero,
                'apenas_numero' => $sequencia->apenas_numero,
            ]
        ];
    }

    /**
     * Configurar sequência personalizada
     */
    public function configurarSequencia(string $dominoCodigo, array $configuracao): Sequencia
    {
        $ano = $configuracao['ano'] ?? now()->year;

        return DB::transaction(function () use ($dominoCodigo, $ano, $configuracao) {
            $sequencia = Sequencia::updateOrCreate([
                'dominio_codigo' => $dominoCodigo,
                'ano' => $ano
            ], array_merge([
                'is_ativo' => true,
                'reinicia_ano' => true,
                'inicio_contagem' => 1,
            ], $configuracao));

            Log::info("Sequência configurada", [
                'dominio_codigo' => $dominoCodigo,
                'ano' => $ano,
                'configuracao' => $configuracao
            ]);

            return $sequencia;
        });
    }

    /**
     * Resetar sequência (cuidado!)
     */
    public function resetarSequencia(string $dominoCodigo, int $ano, int $novoNumero = 0): bool
    {
        return DB::transaction(function () use ($dominoCodigo, $ano, $novoNumero) {
            $sequencia = Sequencia::where('dominio_codigo', $dominoCodigo)
                ->where('ano', $ano)
                ->first();

            if (!$sequencia) {
                return false;
            }

            $numeroAnterior = $sequencia->numero_atual;
            $sequencia->update(['numero_atual' => $novoNumero]);

            Log::warning("Sequência resetada", [
                'dominio_codigo' => $dominoCodigo,
                'ano' => $ano,
                'numero_anterior' => $numeroAnterior,
                'numero_novo' => $novoNumero,
                'user_id' => auth()->id()
            ]);

            return true;
        });
    }

    /**
     * Listar todas as sequências ativas
     */
    public function listarSequencias(): array
    {
        return Sequencia::disponivel()
            ->with('dominio')
            ->orderBy('dominio_codigo')
            ->orderBy('ano')
            ->get()
            ->map(function ($sequencia) {
                return [
                    'dominio_codigo' => $sequencia->dominio_codigo,
                    'dominio_nome' => $sequencia->dominio?->nome ?? 'Domínio não encontrado',
                    'ano' => $sequencia->ano,
                    'numero_atual' => $sequencia->numero_atual,
                    'proximo_numero' => $sequencia->proximo_numero_formatado,
                    'apenas_numero' => $sequencia->apenas_numero,
                    'configuracao' => [
                        'prefixo' => $sequencia->prefixo,
                        'sufixo' => $sequencia->sufixo,
                        'tamanho_numero' => $sequencia->tamanho_numero,
                    ]
                ];
            })
            ->toArray();
    }

    /**
     * Verificar sequências que precisam ser renovadas para o ano atual
     */
    public function verificarSequenciasParaRenovar(): array
    {
        $anoAtual = now()->year;

        return Sequencia::disponivel()
            ->where('reinicia_ano', true)
            ->where('ano', '<', $anoAtual)
            ->with('dominio')
            ->get()
            ->map(function ($sequencia) use ($anoAtual) {
                return [
                    'dominio_codigo' => $sequencia->dominio_codigo,
                    'dominio_nome' => $sequencia->dominio?->nome,
                    'ano_atual' => $sequencia->ano,
                    'ano_necessario' => $anoAtual,
                    'numero_atual' => $sequencia->numero_atual,
                ];
            })
            ->toArray();
    }
}
