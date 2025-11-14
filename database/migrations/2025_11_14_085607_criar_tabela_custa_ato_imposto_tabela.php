<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabela_custa_ato_imposto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tabela_custa_ato_id')
                ->constrained('tabela_custa_ato', 'id')
                ->cascadeOnDelete();

            $table->foreignId('tabela_custa_imposto_id')
                ->constrained('tabela_custa_imposto', 'id')
                ->cascadeOnDelete();

            $table->boolean('aplicavel')->default(true); // Se aplica ou não

            $table->timestamps();

            // Único por ato + imposto
            $table->unique(['tabela_custa_ato_id', 'tabela_custa_imposto_id'], 'ato_imposto_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabela_custa_ato_imposto');
    }
};
