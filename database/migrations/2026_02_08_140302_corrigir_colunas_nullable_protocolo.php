<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Torna colunas antigas nullable já que agora usamos solicitante_nome
 * ao invés de solicitante_id (FK).
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE protocolo ALTER COLUMN solicitante_id DROP NOT NULL');
        DB::statement('ALTER TABLE protocolo ALTER COLUMN cliente_id DROP NOT NULL');
        DB::statement('ALTER TABLE protocolo ALTER COLUMN natureza_id DROP NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE protocolo ALTER COLUMN solicitante_id SET NOT NULL');
        DB::statement('ALTER TABLE protocolo ALTER COLUMN cliente_id SET NOT NULL');
        DB::statement('ALTER TABLE protocolo ALTER COLUMN natureza_id SET NOT NULL');
    }
};
