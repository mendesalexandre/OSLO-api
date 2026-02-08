<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'administrador@sistemaoslo.com.br'],
            [
                'nome' => 'Administrador',
                'email_verificado_em' => now(),
                'senha' => Hash::make('password'),
                'is_ativo' => true,
            ]
        );

        // Associar ao grupo Administrador se existir
        $grupo = Grupo::where('nome', 'Administrador')->first();
        if ($grupo) {
            $user->grupos()->syncWithoutDetaching([$grupo->id]);
        }
    }
}
