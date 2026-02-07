<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Trait para consultar o histórico de auditoria via triggers PostgreSQL.
 *
 * Consulta a tabela auditoria.registro preenchida pelos triggers.
 * Diferente do AuditableTrait (que usa Eloquent hooks), este trait
 * apenas fornece métodos de leitura do log de auditoria.
 */
trait Auditavel
{
    /**
     * Histórico de auditoria deste registro específico.
     */
    public function auditoria(int $limite = 50): Collection
    {
        return DB::table('auditoria.registro')
            ->where('tabela_schema', $this->getAuditoriaSchema())
            ->where('tabela_nome', $this->getTable())
            ->where('registro_id', (string) $this->getKey())
            ->orderByDesc('registrado_em')
            ->limit($limite)
            ->get()
            ->map(fn ($registro) => self::formatarRegistroAuditoria($registro));
    }

    /**
     * Última alteração deste registro.
     */
    public function ultimaAlteracao(): ?object
    {
        $registro = DB::table('auditoria.registro')
            ->where('tabela_schema', $this->getAuditoriaSchema())
            ->where('tabela_nome', $this->getTable())
            ->where('registro_id', (string) $this->getKey())
            ->orderByDesc('registrado_em')
            ->first();

        return $registro ? self::formatarRegistroAuditoria($registro) : null;
    }

    /**
     * Histórico de auditoria de toda a tabela.
     */
    public static function auditoriaTabela(int $limite = 100): Collection
    {
        $modelo = new static;

        return DB::table('auditoria.registro')
            ->where('tabela_schema', $modelo->getAuditoriaSchema())
            ->where('tabela_nome', $modelo->getTable())
            ->orderByDesc('registrado_em')
            ->limit($limite)
            ->get()
            ->map(fn ($registro) => self::formatarRegistroAuditoria($registro));
    }

    /**
     * Histórico de auditoria da tabela filtrado por usuário.
     */
    public static function auditoriaPorUsuario(int $usuarioId, int $limite = 50): Collection
    {
        $modelo = new static;

        return DB::table('auditoria.registro')
            ->where('tabela_schema', $modelo->getAuditoriaSchema())
            ->where('tabela_nome', $modelo->getTable())
            ->where('usuario_id', $usuarioId)
            ->orderByDesc('registrado_em')
            ->limit($limite)
            ->get()
            ->map(fn ($registro) => self::formatarRegistroAuditoria($registro));
    }

    /**
     * Histórico de auditoria da tabela filtrado por período.
     */
    public static function auditoriaPorPeriodo(string $inicio, string $fim, int $limite = 500): Collection
    {
        $modelo = new static;

        return DB::table('auditoria.registro')
            ->where('tabela_schema', $modelo->getAuditoriaSchema())
            ->where('tabela_nome', $modelo->getTable())
            ->whereBetween('registrado_em', [$inicio, $fim])
            ->orderByDesc('registrado_em')
            ->limit($limite)
            ->get()
            ->map(fn ($registro) => self::formatarRegistroAuditoria($registro));
    }

    /**
     * Retorna o schema da tabela para consultas de auditoria.
     */
    private function getAuditoriaSchema(): string
    {
        return 'public';
    }

    /**
     * Formata um registro de auditoria decodificando JSONB e TEXT[].
     */
    private static function formatarRegistroAuditoria(object $registro): object
    {
        $registro->dados_anteriores = $registro->dados_anteriores
            ? json_decode($registro->dados_anteriores, true)
            : null;

        $registro->dados_novos = $registro->dados_novos
            ? json_decode($registro->dados_novos, true)
            : null;

        $registro->campos_alterados = $registro->campos_alterados
            ? self::parsePgArray($registro->campos_alterados)
            : [];

        return $registro;
    }

    /**
     * Parseia um array PostgreSQL TEXT[] no formato {valor1,valor2,valor3}.
     */
    private static function parsePgArray(string $pgArray): array
    {
        $pgArray = trim($pgArray, '{}');

        if ($pgArray === '') {
            return [];
        }

        return str_getcsv($pgArray);
    }
}
