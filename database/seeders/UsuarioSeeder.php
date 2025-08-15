<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'nome' => 'Administrador',
            'email' => 'administrador@sistemaoslo.com.br',
            'email_verificado_em' => now(),
            'senha' => Hash::make('password'),
        ]);
    }
}
