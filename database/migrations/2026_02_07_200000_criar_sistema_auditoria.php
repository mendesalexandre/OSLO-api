<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Cria o sistema de auditoria via triggers PostgreSQL.
 *
 * Schema: auditoria
 * Tabela: auditoria.registro
 * Funções: fn_registrar_auditoria, fn_aplicar_auditoria,
 *          fn_remover_auditoria, fn_limpar_registros_antigos
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. Criar schema
        DB::unprepared('CREATE SCHEMA IF NOT EXISTS auditoria;');

        // 2. Criar tabela de registros
        DB::unprepared("
            CREATE TABLE IF NOT EXISTS auditoria.registro (
                id              BIGSERIAL PRIMARY KEY,
                tabela_schema   VARCHAR(128) NOT NULL DEFAULT 'public',
                tabela_nome     VARCHAR(128) NOT NULL,
                operacao        VARCHAR(10)  NOT NULL CHECK (operacao IN ('INSERT', 'UPDATE', 'DELETE')),
                usuario_id      BIGINT,
                registro_id     TEXT         NOT NULL,
                dados_anteriores JSONB,
                dados_novos     JSONB,
                campos_alterados TEXT[],
                ip_address      VARCHAR(45),
                user_agent      TEXT,
                registrado_em   TIMESTAMPTZ  NOT NULL DEFAULT NOW()
            );
        ");

        // 3. Criar índices
        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_auditoria_tabela_data    ON auditoria.registro (tabela_nome, registrado_em);');
        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_auditoria_usuario_data   ON auditoria.registro (usuario_id, registrado_em);');
        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_auditoria_registro_id    ON auditoria.registro (registro_id);');
        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_auditoria_operacao       ON auditoria.registro (operacao);');
        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_auditoria_dados_anteriores ON auditoria.registro USING GIN (dados_anteriores);');
        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_auditoria_dados_novos     ON auditoria.registro USING GIN (dados_novos);');

        // 4. Função principal do trigger
        DB::unprepared("
            CREATE OR REPLACE FUNCTION auditoria.fn_registrar_auditoria()
            RETURNS TRIGGER AS \$\$
            DECLARE
                v_usuario_id   BIGINT;
                v_ip_address   VARCHAR(45);
                v_user_agent   TEXT;
                v_dados_antigos JSONB;
                v_dados_novos  JSONB;
                v_campos_alterados TEXT[];
                v_registro_id  TEXT;
            BEGIN
                -- Ler variáveis de sessão (definidas pelo middleware Laravel)
                v_usuario_id := NULLIF(current_setting('app.usuario_id', TRUE), '')::BIGINT;
                v_ip_address := current_setting('app.ip_address', TRUE);
                v_user_agent := current_setting('app.user_agent', TRUE);

                IF TG_OP = 'INSERT' THEN
                    v_dados_novos := to_jsonb(NEW);
                    v_registro_id := NEW.id::TEXT;

                    INSERT INTO auditoria.registro (
                        tabela_schema, tabela_nome, operacao, usuario_id,
                        registro_id, dados_novos, ip_address, user_agent
                    ) VALUES (
                        TG_TABLE_SCHEMA, TG_TABLE_NAME, 'INSERT', v_usuario_id,
                        v_registro_id, v_dados_novos, v_ip_address, v_user_agent
                    );

                    RETURN NEW;

                ELSIF TG_OP = 'UPDATE' THEN
                    v_dados_antigos := to_jsonb(OLD);
                    v_dados_novos   := to_jsonb(NEW);

                    -- Só registrar se algo realmente mudou
                    IF v_dados_antigos = v_dados_novos THEN
                        RETURN NEW;
                    END IF;

                    -- Identificar campos que mudaram
                    SELECT array_agg(key) INTO v_campos_alterados
                    FROM jsonb_each(v_dados_novos) AS n(key, value)
                    WHERE NOT (v_dados_antigos @> jsonb_build_object(key, value));

                    IF v_campos_alterados IS NULL OR array_length(v_campos_alterados, 1) IS NULL THEN
                        RETURN NEW;
                    END IF;

                    v_registro_id := NEW.id::TEXT;

                    INSERT INTO auditoria.registro (
                        tabela_schema, tabela_nome, operacao, usuario_id,
                        registro_id, dados_anteriores, dados_novos,
                        campos_alterados, ip_address, user_agent
                    ) VALUES (
                        TG_TABLE_SCHEMA, TG_TABLE_NAME, 'UPDATE', v_usuario_id,
                        v_registro_id, v_dados_antigos, v_dados_novos,
                        v_campos_alterados, v_ip_address, v_user_agent
                    );

                    RETURN NEW;

                ELSIF TG_OP = 'DELETE' THEN
                    v_dados_antigos := to_jsonb(OLD);
                    v_registro_id   := OLD.id::TEXT;

                    INSERT INTO auditoria.registro (
                        tabela_schema, tabela_nome, operacao, usuario_id,
                        registro_id, dados_anteriores, ip_address, user_agent
                    ) VALUES (
                        TG_TABLE_SCHEMA, TG_TABLE_NAME, 'DELETE', v_usuario_id,
                        v_registro_id, v_dados_antigos, v_ip_address, v_user_agent
                    );

                    RETURN OLD;
                END IF;

                RETURN NULL;
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        // 5. Função para aplicar auditoria em uma tabela
        DB::unprepared("
            CREATE OR REPLACE FUNCTION auditoria.fn_aplicar_auditoria(p_schema TEXT, p_tabela TEXT)
            RETURNS VOID AS \$\$
            BEGIN
                -- Remover trigger existente (se houver)
                EXECUTE format(
                    'DROP TRIGGER IF EXISTS trg_auditoria_%I ON %I.%I',
                    p_tabela, p_schema, p_tabela
                );

                -- Criar trigger
                EXECUTE format(
                    'CREATE TRIGGER trg_auditoria_%I
                     AFTER INSERT OR UPDATE OR DELETE ON %I.%I
                     FOR EACH ROW EXECUTE FUNCTION auditoria.fn_registrar_auditoria()',
                    p_tabela, p_schema, p_tabela
                );
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        // 6. Função para remover auditoria de uma tabela
        DB::unprepared("
            CREATE OR REPLACE FUNCTION auditoria.fn_remover_auditoria(p_schema TEXT, p_tabela TEXT)
            RETURNS VOID AS \$\$
            BEGIN
                EXECUTE format(
                    'DROP TRIGGER IF EXISTS trg_auditoria_%I ON %I.%I',
                    p_tabela, p_schema, p_tabela
                );
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        // 7. Função de limpeza (retenção)
        DB::unprepared("
            CREATE OR REPLACE FUNCTION auditoria.fn_limpar_registros_antigos(p_dias INTEGER DEFAULT 365)
            RETURNS BIGINT AS \$\$
            DECLARE
                v_registros_excluidos BIGINT;
            BEGIN
                DELETE FROM auditoria.registro
                WHERE registrado_em < NOW() - (p_dias || ' days')::INTERVAL;

                GET DIAGNOSTICS v_registros_excluidos = ROW_COUNT;
                RETURN v_registros_excluidos;
            END;
            \$\$ LANGUAGE plpgsql;
        ");
    }

    public function down(): void
    {
        // Remover triggers de todas as tabelas auditadas
        DB::unprepared("
            DO \$\$
            DECLARE
                r RECORD;
            BEGIN
                FOR r IN
                    SELECT trigger_schema, event_object_table
                    FROM information_schema.triggers
                    WHERE trigger_name LIKE 'trg_auditoria_%'
                    GROUP BY trigger_schema, event_object_table
                LOOP
                    EXECUTE format(
                        'DROP TRIGGER IF EXISTS trg_auditoria_%I ON %I.%I',
                        r.event_object_table, r.trigger_schema, r.event_object_table
                    );
                END LOOP;
            END;
            \$\$;
        ");

        DB::unprepared('DROP FUNCTION IF EXISTS auditoria.fn_limpar_registros_antigos(INTEGER);');
        DB::unprepared('DROP FUNCTION IF EXISTS auditoria.fn_remover_auditoria(TEXT, TEXT);');
        DB::unprepared('DROP FUNCTION IF EXISTS auditoria.fn_aplicar_auditoria(TEXT, TEXT);');
        DB::unprepared('DROP FUNCTION IF EXISTS auditoria.fn_registrar_auditoria();');
        DB::unprepared('DROP TABLE IF EXISTS auditoria.registro;');
        DB::unprepared('DROP SCHEMA IF EXISTS auditoria;');
    }
};
