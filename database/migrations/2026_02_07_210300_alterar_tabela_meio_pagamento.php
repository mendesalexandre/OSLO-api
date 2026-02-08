<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adiciona forma_pagamento_id e identificador à tabela meio_pagamento.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meio_pagamento', function (Blueprint $table) {
            $table->foreignId('forma_pagamento_id')
                ->nullable()
                ->after('id')
                ->constrained('forma_pagamento');
            $table->string('identificador', 100)
                ->nullable()
                ->after('descricao');
        });
    }

    public function down(): void
    {
        Schema::table('meio_pagamento', function (Blueprint $table) {
            $table->dropForeign(['forma_pagamento_id']);
            $table->dropColumn(['forma_pagamento_id', 'identificador']);
        });
    }
};
