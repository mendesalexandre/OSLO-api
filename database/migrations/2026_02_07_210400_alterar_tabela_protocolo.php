<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adiciona colunas financeiras e de solicitante ao protocolo.
 * Altera coluna numero para VARCHAR para suportar formato "2025/000001".
 */
return new class extends Migration
{
    public function up(): void
    {
        // Alterar tipo da coluna numero para varchar
        DB::statement('ALTER TABLE protocolo ALTER COLUMN numero TYPE VARCHAR(30) USING numero::VARCHAR');

        Schema::table('protocolo', function (Blueprint $table) {
            $table->integer('ano')->nullable()->after('numero');
            $table->string('solicitante_nome', 200)->nullable()->after('status');
            $table->string('solicitante_cpf_cnpj', 18)->nullable()->after('solicitante_nome');
            $table->string('solicitante_telefone', 20)->nullable()->after('solicitante_cpf_cnpj');
            $table->string('solicitante_email', 200)->nullable()->after('solicitante_telefone');
            $table->string('matricula', 50)->nullable()->after('solicitante_email');
            $table->text('observacao')->nullable()->after('matricula');
            $table->decimal('valor_total', 15, 2)->default(0)->after('observacao');
            $table->decimal('valor_desconto', 15, 2)->default(0)->after('valor_total');
            $table->decimal('valor_isento', 15, 2)->default(0)->after('valor_desconto');
            $table->decimal('valor_final', 15, 2)->default(0)->after('valor_isento');
            $table->decimal('valor_pago', 15, 2)->default(0)->after('valor_final');
        });

        // Adicionar unique constraint ao numero se não existir
        DB::statement('
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint
                    WHERE conname = \'protocolo_numero_unique\'
                ) THEN
                    ALTER TABLE protocolo ADD CONSTRAINT protocolo_numero_unique UNIQUE (numero);
                END IF;
            END $$;
        ');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE protocolo DROP CONSTRAINT IF EXISTS protocolo_numero_unique');

        Schema::table('protocolo', function (Blueprint $table) {
            $table->dropColumn([
                'ano',
                'solicitante_nome',
                'solicitante_cpf_cnpj',
                'solicitante_telefone',
                'solicitante_email',
                'matricula',
                'observacao',
                'valor_total',
                'valor_desconto',
                'valor_isento',
                'valor_final',
                'valor_pago',
            ]);
        });

        DB::statement('ALTER TABLE protocolo ALTER COLUMN numero TYPE BIGINT USING numero::BIGINT');
    }
};
