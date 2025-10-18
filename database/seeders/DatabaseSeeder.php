<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory()->create();
        $this->call([
            TipoDocumentoSeeder::class,
            UsuarioSeeder::class,
            FeriadoSeeder::class,
            PermissionSeeder::class,
            DominioSeeder::class,
            EstadoSeeder::class,
            CidadeSeeder::class,
            NaturezaSeeder::class
        ]);
    }
}
