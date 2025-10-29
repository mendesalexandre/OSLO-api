<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CaixaSeeder::class,
            TipoDocumentoSeeder::class,
            EtapaSeeder::class,
            UsuarioSeeder::class,
            FeriadoSeeder::class,
            PermissionSeeder::class,
            DominioSeeder::class,
            EstadoSeeder::class,
            CidadeSeeder::class,
            NaturezaSeeder::class,
            TipoPagamentoSeeder::class,
            // UsuarioSeeder::class,
            ConfiguracaoDoiSeeder::class,
            // MeioPagamentoSeeder::class,
            // TransacaoSeeder::class,
        ]);
    }
}
