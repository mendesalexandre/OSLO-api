<?php

namespace App\Enums;

enum ONRStatusEnum: string
{
    // Status originais
    case PENDENTE = 'Pendente';
    case EM_PROCESSAMENTO = 'Em Processamento';
    case CONCLUIDO = 'Concluído';
    case CANCELADO = 'Cancelado';
    case ERRO = 'Erro';
    case DEVOLVIDO = 'Devolvido';
    case AGUARDANDO_PAGAMENTO = 'Aguardando Pagamento';
    case PAGO = 'Pago';
    case DESCONHECIDO = 'Desconhecido';

        // Status do batch - Geral
    case INICIADO = 'Iniciado';
    case CONCLUIDA = 'Concluída';

        // Status do batch - Sincronização
    case SINCRONIZANDO = 'Sincronizando';
    case SINCRONIZADA = 'Sincronizada';
    case ERRO_SINCRONIZACAO = 'Erro na Sincronização';
    case FALHA_SINCRONIZACAO = 'Falha na Sincronização';

        // Status do batch - Validação
    case VALIDANDO = 'Validando';
    case VALIDADA = 'Validada';
    case AGUARDANDO_HORARIO = 'Aguardando Horário Comercial';
    case TIPO_NAO_ELEGIVEL = 'Tipo Não Elegível';
    case ARQUIVO_TIFF_NAO_ENCONTRADO = 'Arquivo TIFF Não Encontrado';
    case ERRO_VALIDACAO = 'Erro na Validação';
    case FALHA_VALIDACAO = 'Falha na Validação';

        // Status do batch - Emissão
    case EMITINDO = 'Emitindo';
    case EMITIDA = 'Emitida';
    case SIMULADA = 'Simulada (Ambiente Local)';
    case ENVIADO_AO_CLIENTE = 'Enviado ao cliente e não finalizado';
    case ENVIADO_E_FINALIZADO = 'Enviado ao cliente e finalizado o pedido na ONR';
    case ERRO_EMISSAO = 'Erro na Emissão';
    case FALHA_EMISSAO = 'Falha na Emissão';

        // Status específicos de devolução
    case DEVOLVIDA_AUTOMATICAMENTE = 'Devolvida Automaticamente';

    /**
     * Retorna status organizados por categoria
     */
    public static function getStatusPorCategoria(): array
    {
        return [
            'geral' => [
                self::PENDENTE,
                self::EM_PROCESSAMENTO,
                self::INICIADO,
                self::CONCLUIDO,
                self::CONCLUIDA,
                self::CANCELADO,
                self::ERRO,
                self::DEVOLVIDO,
            ],
            'sincronizacao' => [
                self::SINCRONIZANDO,
                self::SINCRONIZADA,
                self::ERRO_SINCRONIZACAO,
                self::FALHA_SINCRONIZACAO,
            ],
            'validacao' => [
                self::VALIDANDO,
                self::VALIDADA,
                self::AGUARDANDO_HORARIO,
                self::TIPO_NAO_ELEGIVEL,
                self::ARQUIVO_TIFF_NAO_ENCONTRADO,
                self::ERRO_VALIDACAO,
                self::FALHA_VALIDACAO,
            ],
            'emissao' => [
                self::EMITINDO,
                self::EMITIDA,
                self::SIMULADA,
                self::ENVIADO_AO_CLIENTE,
                self::ENVIADO_E_FINALIZADO,
                self::ERRO_EMISSAO,
                self::FALHA_EMISSAO,
            ],
            'pagamento' => [
                self::AGUARDANDO_PAGAMENTO,
                self::PAGO,
            ],
            'devolucao' => [
                self::DEVOLVIDO,
                self::DEVOLVIDA_AUTOMATICAMENTE,
            ],
        ];
    }

    /**
     * Verifica se é um status de erro
     */
    public function isErro(): bool
    {
        return in_array($this, [
            self::ERRO,
            self::ERRO_SINCRONIZACAO,
            self::FALHA_SINCRONIZACAO,
            self::ERRO_VALIDACAO,
            self::FALHA_VALIDACAO,
            self::ERRO_EMISSAO,
            self::FALHA_EMISSAO,
        ]);
    }

    /**
     * Verifica se é um status de sucesso
     */
    public function isSucesso(): bool
    {
        return in_array($this, [
            self::CONCLUIDO,
            self::CONCLUIDA,
            self::SINCRONIZADA,
            self::VALIDADA,
            self::EMITIDA,
            self::ENVIADO_AO_CLIENTE,
            self::ENVIADO_E_FINALIZADO,
            self::PAGO,
        ]);
    }

    /**
     * Verifica se é um status em processamento
     */
    public function isProcessando(): bool
    {
        return in_array($this, [
            self::EM_PROCESSAMENTO,
            self::INICIADO,
            self::SINCRONIZANDO,
            self::VALIDANDO,
            self::EMITINDO,
            self::AGUARDANDO_HORARIO,
        ]);
    }

    /**
     * Verifica se é um status final
     */
    public function isFinal(): bool
    {
        return in_array($this, [
            self::CONCLUIDO,
            self::CONCLUIDA,
            self::CANCELADO,
            self::EMITIDA,
            self::ENVIADO_E_FINALIZADO,
            self::DEVOLVIDO,
            self::DEVOLVIDA_AUTOMATICAMENTE,
            self::SIMULADA,
            self::PAGO,
        ]) || $this->isErro();
    }

    /**
     * Retorna a cor para exibição no frontend
     */
    public function getCor(): string
    {
        return match ($this) {
            self::PENDENTE,
            self::AGUARDANDO_PAGAMENTO,
            self::AGUARDANDO_HORARIO => 'warning',
            self::EM_PROCESSAMENTO, self::INICIADO, self::SINCRONIZANDO, self::VALIDANDO, self::EMITINDO => 'info',
            self::CONCLUIDO, self::CONCLUIDA, self::SINCRONIZADA, self::VALIDADA, self::EMITIDA, self::ENVIADO_AO_CLIENTE, self::ENVIADO_E_FINALIZADO, self::PAGO, self::SIMULADA => 'success',
            self::CANCELADO, self::DEVOLVIDO, self::DEVOLVIDA_AUTOMATICAMENTE, self::TIPO_NAO_ELEGIVEL => 'secondary',
            self::ARQUIVO_TIFF_NAO_ENCONTRADO => 'warning',
            default => 'danger', // Todos os erros
        };
    }

    /**
     * Retorna o ícone para exibição no frontend
     */
    public function getIcone(): string
    {
        return match ($this) {
            self::PENDENTE, self::AGUARDANDO_PAGAMENTO, self::AGUARDANDO_HORARIO => 'clock',
            self::EM_PROCESSAMENTO, self::INICIADO, self::SINCRONIZANDO, self::VALIDANDO, self::EMITINDO => 'gear',
            self::CONCLUIDO, self::CONCLUIDA, self::SINCRONIZADA, self::VALIDADA, self::EMITIDA, self::PAGO => 'check-circle',
            self::ENVIADO_AO_CLIENTE => 'send',
            self::ENVIADO_E_FINALIZADO => 'check-circle-fill',
            self::SIMULADA => 'flask',
            self::CANCELADO => 'x-circle',
            self::DEVOLVIDO, self::DEVOLVIDA_AUTOMATICAMENTE => 'arrow-return-left',
            self::TIPO_NAO_ELEGIVEL => 'exclamation-triangle',
            self::ARQUIVO_TIFF_NAO_ENCONTRADO => 'file-x',
            default => 'exclamation-circle', // Todos os erros
        };
    }
}
