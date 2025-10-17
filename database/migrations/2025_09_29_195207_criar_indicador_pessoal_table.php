<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicador_pessoal', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_ativo')->default(true);
            $table->string('nome');
            $table->string('cpf_cnpj', 14);

            // RG
            $table->string('rg_ie')->nullable();
            $table->string('rg_orgao_expedidor')->nullable();
            $table->char('rg_uf_emissao', 2)->nullable();
            $table->date('rg_data_emissao')->nullable();

            // CNH
            $table->string('cnh')->nullable();
            $table->string('cnh_orgao_expedidor')->nullable();
            $table->date('cnh_data_emissao')->nullable();
            $table->date('cnh_data_validade')->nullable();
            $table->string('cnh_categoria', 10)->nullable(); // A, B, C, D, E, AB, etc

            // Passaporte
            $table->string('passaporte')->nullable();
            $table->string('passaporte_orgao_expedidor')->nullable();
            $table->char('passaporte_pais_emissao', 3)->nullable(); // Código ISO do país
            $table->date('passaporte_data_emissao')->nullable();
            $table->date('passaporte_data_validade')->nullable();

            $table->string('email', 100)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->date('data_casamento')->nullable();
            $table->date('data_divorcio')->nullable();
            $table->date('data_obito')->nullable();

            // VERSIONAMENTO DO INDICADOR
            $table->unsignedBigInteger('versao')->default(1);

            // $table->foreignId('nacionalidade_id')->constrained('nacionalidade');
            // $table->foreignId('estado_civil_id')->constrained('estado_civil');
            // $table->foreignId('sexo_id')->constrained('sexo');
            // $table->foreignId('tipo_pessoa_id')->constrained('tipo_pessoa');
            // $table->foreignId('profissao_id')->constrained('profissao');
            // $table->foreignId('escolaridade_id')->constrained('escolaridade');
            // $table->foreignId('endereco_id')->constrained('endereco');
            $table->foreignId('conjuge_id')->nullable()->constrained('indicador_pessoal');

            // COAF - PEP
            $table->boolean('pessoa_politicamente_exposta')->default(false);
            $table->boolean('servidor_publico')->default(false);
            $table->string('pep_nivel_funcao')->nullable();
            $table->string('pep_sigla_funcao')->nullable();
            $table->string('pep_nome_orgao')->nullable();
            $table->date('pep_data_inicio_exercicio')->nullable();
            $table->date('pep_data_fim_exercicio')->nullable();
            $table->date('pep_data_carencia')->nullable();
            $table->date('pep_data_atualizacao')->nullable();

            //NOME PAI E MÃE
            $table->string('nome_mae')->nullable();
            $table->string('nome_pai')->nullable();

            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent();
            $table->timestamp('data_exclusao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicador_pessoal');
    }
};
