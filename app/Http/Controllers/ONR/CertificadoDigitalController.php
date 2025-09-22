<?php

namespace App\Http\Controllers\ONR;

use App\Http\Controllers\Controller;
use App\Models\ONR\CertificadoDigital;
use App\Services\Lacuna\Certificado;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CertificadoDigitalController extends Controller
{
    private const CERTIFICADO_PATH = 'certificados/certificado_atual.pfx';
    private const CACHE_KEY_INFO = 'certificado_digital_info';
    private const CACHE_TTL = 3600; // 1 hora

    public function upload(Request $request): JsonResponse
    {
        try {
            // Validação dos dados - removendo mimes e adicionando validação manual
            $validator = Validator::make($request->all(), [
                'certificado' => 'required|file|max:5120', // Removido mimes:pfx,p12
                'senha' => 'required|string|min:1|max:255',
                'nome' => 'nullable|string|max:100',
                'descricao' => 'nullable|string|max:500',
            ], [
                'certificado.required' => 'O arquivo do certificado é obrigatório.',
                'certificado.max' => 'O arquivo não pode ter mais que 5MB.',
                'senha.required' => 'A senha do certificado é obrigatória.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $certificadoFile = $request->file('certificado');

            // Validação simples da extensão
            $extension = strtolower($certificadoFile->getClientOriginalExtension());
            if (!in_array($extension, ['pfx', 'p12'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'O certificado deve ser um arquivo .pfx ou .p12.'
                ], 422);
            }

            $senha = $request->input('senha');

            // Testar se o certificado é válido antes de salvar
            $validacao = $this->validarCertificado($certificadoFile->getPathname(), $senha);

            if (!$validacao['valido']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificado inválido: ' . $validacao['erro']
                ], 422);
            }

            // Verificar se certificado já existe (por serial ou titular)
            $certificadoExistente = null;
            if (isset($validacao['info']['serial'])) {
                $certificadoExistente = CertificadoDigital::query()
                    ->where('serial', $validacao['info']['serial'])
                    ->where('ativo', true)
                    ->first();
            }

            if ($certificadoExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este certificado já está cadastrado no sistema.',
                    'data' => [
                        'certificado_existente' => [
                            'id' => $certificadoExistente->id,
                            'nome' => $certificadoExistente->nome,
                            'titular' => $certificadoExistente->titular,
                            'criado_em' => $certificadoExistente->data_cadastro
                        ]
                    ]
                ], 422);
            }

            // Salvar novo certificado
            $caminhoCompleto = $certificadoFile->storeAs(
                'certificados',
                'certificado_' . time() . '.' . $extension,
                'local'
            );

            // Converter arquivo para base64 como backup
            $arquivoBase64 = base64_encode(file_get_contents($certificadoFile->getPathname()));

            // Criar registro na tabela
            $certificadoId = CertificadoDigital::query()->insertGetId([
                'nome' => $request->input('nome', 'Certificado Digital'),
                'descricao' => $request->input('descricao'),
                'arquivo_original' => $certificadoFile->getClientOriginalName(),
                'senha_criptografada' => encrypt($senha),
                'certificado_base64' => $arquivoBase64, // Backup em base64
                'caminho_arquivo' => $caminhoCompleto,
                'tamanho_bytes' => $certificadoFile->getSize(),
                'tamanho_formatado' => $this->formatBytes($certificadoFile->getSize()),
                'titular' => $validacao['info']['titular'] ?? null,
                'emissor' => $validacao['info']['emissor'] ?? null,
                'serial' => $validacao['info']['serial'] ?? null,
                'algoritmo' => $validacao['info']['algoritmo'] ?? null,
                'valido_de' => $validacao['info']['valido_de'] ?? null,
                'valido_ate' => $validacao['info']['valido_ate'] ?? null,
                'ativo' => true,
                'testado' => true,
                'ultima_validacao' => now(),
                'erro_validacao' => null,
                'criado_por' => auth()->id(),
                'atualizado_por' => auth()->id(),
                'data_cadastro' => now(), // changed from created_at
                'data_alteracao' => now(), // changed from updated_at
                'data_exclusao' => null, // added for soft deletes
            ]);

            $metadados = [
                'id' => $certificadoId,
                'nome' => $request->input('nome', 'Certificado Digital'),
                'descricao' => $request->input('descricao'),
                'arquivo_original' => $certificadoFile->getClientOriginalName(),
                'tamanho' => $certificadoFile->getSize(),
                'caminho' => $caminhoCompleto,
                'info' => $validacao['info']
            ];

            // Limpar cache
            Cache::forget(self::CACHE_KEY_INFO);

            Log::info('Certificado digital criado com sucesso', [
                'id' => $certificadoId,
                'arquivo' => $certificadoFile->getClientOriginalName(),
                'tamanho' => $this->formatBytes($certificadoFile->getSize()),
                'usuario' => auth()->id(),
                'valido_ate' => $validacao['info']['valido_ate'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificado digital enviado, validado e salvo com sucesso.',
                'data' => [
                    'id' => $certificadoId,
                    'caminho' => $caminhoCompleto,
                    'info' => $validacao['info'],
                    'metadados' => $metadados
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao fazer upload do certificado digital', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obter informações do certificado atual
     */
    public function info(): JsonResponse
    {
        try {
            $info = Cache::remember(self::CACHE_KEY_INFO, self::CACHE_TTL, function () {
                return $this->obterInformacoesCertificado();
            });

            return response()->json([
                'success' => true,
                'data' => $info
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter informações do certificado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Testar certificado atual
     */
    public function testar(): JsonResponse
    {
        try {
            if (!$this->certificadoExiste()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhum certificado encontrado. Faça o upload primeiro.'
                ], 404);
            }

            // Testar instanciação da classe Certificado
            $certificado = new Certificado();
            $chavePublica = $certificado->extrairCertificadoPublicoBase64();

            // Verificar se conseguiu extrair a chave
            if (empty($chavePublica)) {
                throw new \Exception('Não foi possível extrair a chave pública do certificado');
            }

            $info = $this->obterInformacoesCertificado();

            return response()->json([
                'success' => true,
                'message' => 'Certificado testado com sucesso.',
                'data' => [
                    'status' => 'válido',
                    'chave_publica_extraida' => true,
                    'tamanho_chave' => strlen($chavePublica),
                    'info' => $info,
                    'testado_em' => now()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao testar certificado digital', [
                'erro' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao testar certificado: ' . $e->getMessage(),
                'data' => [
                    'status' => 'inválido',
                    'testado_em' => now()
                ]
            ], 422);
        }
    }

    /**
     * Remover certificado atual
     */
    public function remover(): JsonResponse
    {
        try {
            if (!$this->certificadoExiste()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhum certificado encontrado.'
                ], 404);
            }

            // Backup antes de remover
            $this->backupCertificadoAnterior();

            // Remover arquivos
            Storage::disk('local')->delete(self::CERTIFICADO_PATH);
            Storage::disk('local')->delete('certificados/senha.txt');
            Storage::disk('local')->delete('certificados/metadados.json');

            // Limpar cache
            Cache::forget(self::CACHE_KEY_INFO);

            Log::info('Certificado digital removido', [
                'removido_por' => auth()->id(),
                'removido_em' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificado removido com sucesso.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover certificado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar histórico de certificados (backups)
     */
    public function historico(): JsonResponse
    {
        try {
            $arquivos = Storage::disk('local')->files('certificados/backup');
            $historico = [];

            foreach ($arquivos as $arquivo) {
                if (str_ends_with($arquivo, '.pfx')) {
                    $info = Storage::disk('local')->lastModified($arquivo);
                    $tamanho = Storage::disk('local')->size($arquivo);

                    $historico[] = [
                        'arquivo' => basename($arquivo),
                        'data_backup' => Carbon::createFromTimestamp($info),
                        'tamanho' => $this->formatBytes($tamanho),
                        'tamanho_bytes' => $tamanho
                    ];
                }
            }

            // Ordenar por data (mais recente primeiro)
            usort($historico, fn($a, $b) => $b['data_backup'] <=> $a['data_backup']);

            return response()->json([
                'success' => true,
                'data' => [
                    'historico' => $historico,
                    'total' => count($historico)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter histórico: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validar certificado antes de salvar
     */
    private function validarCertificado(string $caminho, string $senha): array
    {
        try {
            // Verificar se o arquivo pode ser lido como certificado
            $certificadoData = file_get_contents($caminho);

            if (!openssl_pkcs12_read($certificadoData, $certs, $senha)) {
                return [
                    'valido' => false,
                    'erro' => 'Senha incorreta ou arquivo corrompido'
                ];
            }

            // Extrair informações do certificado
            $certInfo = openssl_x509_parse($certs['cert']);

            if (!$certInfo) {
                return [
                    'valido' => false,
                    'erro' => 'Não foi possível analisar o certificado'
                ];
            }

            // Verificar validade
            $validoAte = Carbon::createFromTimestamp($certInfo['validTo_time_t']);

            if ($validoAte->isPast()) {
                return [
                    'valido' => false,
                    'erro' => 'Certificado expirado em ' . $validoAte->format('d/m/Y')
                ];
            }

            return [
                'valido' => true,
                'info' => [
                    'titular' => $certInfo['subject']['CN'] ?? 'N/A',
                    'emissor' => $certInfo['issuer']['CN'] ?? 'N/A',
                    'valido_de' => Carbon::createFromTimestamp($certInfo['validFrom_time_t']),
                    'valido_ate' => $validoAte,
                    'serial' => $certInfo['serialNumber'] ?? 'N/A',
                    'algoritmo' => $certInfo['signatureTypeLN'] ?? 'N/A'
                ]
            ];
        } catch (\Exception $e) {
            return [
                'valido' => false,
                'erro' => 'Erro ao validar certificado: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Salvar senha do certificado de forma segura
     */
    private function salvarSenhaCertificado(string $senha): void
    {
        $senhaCriptografada = encrypt($senha);
        Storage::disk('local')->put('certificados/senha.txt', $senhaCriptografada);
    }

    /**
     * Salvar metadados do certificado
     */
    private function salvarMetadados(array $metadados): void
    {
        Storage::disk('local')->put(
            'certificados/metadados.json',
            json_encode($metadados, JSON_PRETTY_PRINT)
        );
    }

    /**
     * Fazer backup do certificado anterior
     */
    private function backupCertificadoAnterior(): void
    {
        if (Storage::disk('local')->exists(self::CERTIFICADO_PATH)) {
            $timestamp = now()->format('Y-m-d_H-i-s');
            $backupPath = "certificados/backup/certificado_{$timestamp}.pfx";

            Storage::disk('local')->copy(self::CERTIFICADO_PATH, $backupPath);
        }
    }

    /**
     * Verificar se certificado existe
     */
    private function certificadoExiste(): bool
    {
        return Storage::disk('local')->exists(self::CERTIFICADO_PATH);
    }

    /**
     * Obter informações do certificado atual
     */
    private function obterInformacoesCertificado(): array
    {
        if (!$this->certificadoExiste()) {
            return [
                'existe' => false,
                'message' => 'Nenhum certificado configurado'
            ];
        }

        $metadados = [];
        if (Storage::disk('local')->exists('certificados/metadados.json')) {
            $metadados = json_decode(
                Storage::disk('local')->get('certificados/metadados.json'),
                true
            );
        }

        $info = Storage::disk('local')->lastModified(self::CERTIFICADO_PATH);
        $tamanho = Storage::disk('local')->size(self::CERTIFICADO_PATH);

        return [
            'existe' => true,
            'caminho' => self::CERTIFICADO_PATH,
            'tamanho' => $this->formatBytes($tamanho),
            'tamanho_bytes' => $tamanho,
            'ultima_modificacao' => Carbon::createFromTimestamp($info),
            'metadados' => $metadados
        ];
    }

    /**
     * Formatar bytes em formato legível
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
