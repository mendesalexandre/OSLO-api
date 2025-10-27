<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('doi_lote', function (Blueprint $table) {
            // 1. Remove a constraint antiga
            DB::statement("ALTER TABLE lote_doi DROP CONSTRAINT IF EXISTS lote_doi_status_check");

            // 2. Cria nova constraint com todos os valores (antigos + novos)
            DB::statement("ALTER TABLE lote_doi ADD CONSTRAINT lote_doi_status_check CHECK (status::text = ANY (ARRAY['criado'::character varying, 'enviando'::character varying, 'concluido'::character varying, 'erro'::character varying, 'gerado'::character varying, 'enviado'::character varying, 'estornado'::character varying, 'confirmado'::character varying, 'processando'::character varying, 'cancelado'::character varying]::text[]))");
        });
    }


    public function down(): void
    {
        Schema::table('doi_lote', function (Blueprint $table) {});
    }
};
