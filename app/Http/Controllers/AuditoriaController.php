<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuditoriaController extends Controller
{
    use ApiResponseTrait, AuthorizesRequests;

    /**
     * Listar registros de auditoria com filtros.
     *
     * Query params: tabela, operacao, usuario_id, data_inicio, data_fim, limite, pagina
     */
    public function listar(Request $request): JsonResponse
    {
        $limite = min((int) $request->get('limite', 50), 500);
        $pagina = max((int) $request->get('pagina', 1), 1);
        $offset = ($pagina - 1) * $limite;

        $query = DB::table('auditoria.registro')
            ->when($request->filled('tabela'), fn ($q) => $q->where('tabela_nome', $request->tabela))
            ->when($request->filled('operacao'), fn ($q) => $q->where('operacao', strtoupper($request->operacao)))
            ->when($request->filled('usuario_id'), fn ($q) => $q->where('usuario_id', $request->usuario_id))
            ->when($request->filled('data_inicio'), fn ($q) => $q->where('registrado_em', '>=', $request->data_inicio))
            ->when($request->filled('data_fim'), fn ($q) => $q->where('registrado_em', '<=', $request->data_fim))
            ->orderByDesc('registrado_em');

        $total = $query->count();

        $registros = $query
            ->offset($offset)
            ->limit($limite)
            ->get()
            ->map(fn ($r) => $this->formatarRegistro($r));

        return $this->successResponse($registros, [
            'pagination' => [
                'current_page' => $pagina,
                'per_page' => $limite,
                'total' => $total,
                'last_page' => (int) ceil($total / $limite),
            ],
        ]);
    }

    /**
     * Listar auditoria de uma tabela específica.
     */
    public function porTabela(Request $request, string $tabela): JsonResponse
    {
        $limite = min((int) $request->get('limite', 50), 500);

        $registros = DB::table('auditoria.registro')
            ->where('tabela_nome', $tabela)
            ->orderByDesc('registrado_em')
            ->limit($limite)
            ->get()
            ->map(fn ($r) => $this->formatarRegistro($r));

        return $this->successResponse($registros);
    }

    /**
     * Histórico de auditoria de um registro específico.
     */
    public function porRegistro(string $tabela, string $registroId): JsonResponse
    {
        $registros = DB::table('auditoria.registro')
            ->where('tabela_nome', $tabela)
            ->where('registro_id', $registroId)
            ->orderByDesc('registrado_em')
            ->get()
            ->map(fn ($r) => $this->formatarRegistro($r));

        return $this->successResponse($registros);
    }

    /**
     * Auditoria filtrada por usuário.
     */
    public function porUsuario(Request $request, int $usuarioId): JsonResponse
    {
        $limite = min((int) $request->get('limite', 50), 500);

        $registros = DB::table('auditoria.registro')
            ->where('usuario_id', $usuarioId)
            ->orderByDesc('registrado_em')
            ->limit($limite)
            ->get()
            ->map(fn ($r) => $this->formatarRegistro($r));

        return $this->successResponse($registros);
    }

    /**
     * Listar tabelas que possuem trigger de auditoria ativo.
     */
    public function tabelasAuditadas(): JsonResponse
    {
        $tabelas = DB::table('information_schema.triggers')
            ->select('event_object_schema as schema', 'event_object_table as tabela')
            ->where('trigger_name', 'LIKE', 'trg_auditoria_%')
            ->distinct()
            ->orderBy('event_object_schema')
            ->orderBy('event_object_table')
            ->get();

        return $this->successResponse($tabelas);
    }

    /**
     * Estatísticas de auditoria.
     *
     * Retorna totais por tabela/operação e totais diários (últimos 30 dias).
     */
    public function estatisticas(): JsonResponse
    {
        // Totais por tabela e operação
        $porTabelaOperacao = DB::table('auditoria.registro')
            ->select('tabela_nome', 'operacao', DB::raw('COUNT(*) as total'))
            ->groupBy('tabela_nome', 'operacao')
            ->orderBy('tabela_nome')
            ->orderBy('operacao')
            ->get();

        // Totais diários (últimos 30 dias)
        $porDia = DB::table('auditoria.registro')
            ->select(DB::raw("DATE(registrado_em) as dia"), DB::raw('COUNT(*) as total'))
            ->where('registrado_em', '>=', DB::raw("NOW() - INTERVAL '30 days'"))
            ->groupBy(DB::raw('DATE(registrado_em)'))
            ->orderByDesc('dia')
            ->get();

        return $this->successResponse([
            'por_tabela_operacao' => $porTabelaOperacao,
            'por_dia' => $porDia,
        ]);
    }

    /**
     * Formata um registro de auditoria decodificando JSONB e TEXT[].
     */
    private function formatarRegistro(object $registro): object
    {
        $registro->dados_anteriores = $registro->dados_anteriores
            ? json_decode($registro->dados_anteriores, true)
            : null;

        $registro->dados_novos = $registro->dados_novos
            ? json_decode($registro->dados_novos, true)
            : null;

        $registro->campos_alterados = $registro->campos_alterados
            ? $this->parsePgArray($registro->campos_alterados)
            : [];

        return $registro;
    }

    /**
     * Parseia um array PostgreSQL TEXT[] no formato {valor1,valor2,valor3}.
     */
    private function parsePgArray(string $pgArray): array
    {
        $pgArray = trim($pgArray, '{}');

        if ($pgArray === '') {
            return [];
        }

        return str_getcsv($pgArray);
    }
}
