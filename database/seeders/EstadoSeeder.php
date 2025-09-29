<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{

    public function run()
    {
        foreach ($this->getEstados() as $estado) {
            Estado::query()->create([
                'ibge_codigo' => $estado['ibge_codigo'],
                'nome' => $estado['nome'],
                'sigla' => $estado['sigla'],
            ]);
        }
    }

    public function getEstados()
    {
        return  [
            [
                "ibge_codigo"   => 11,
                "nome" => "Rondônia",
                "sigla" => "RO",
            ],
            [
                "ibge_codigo"   => 12,
                "nome" => "Acre",
                "sigla" => "AC",
            ],
            [
                "ibge_codigo"   => 13,
                "nome" => "Amazonas",
                "sigla" => "AM",
            ],
            [
                "ibge_codigo"   => 14,
                "nome" => "Roraima",
                "sigla" => "RR",
            ],
            [
                "ibge_codigo"   => 15,
                "nome" => "Pará",
                "sigla" => "PA",
            ],
            [
                "ibge_codigo"   => 16,
                "nome" => "Amapá",
                "sigla" => "AP",
            ],
            [
                "ibge_codigo"   => 17,
                "nome" => "Tocantins",
                "sigla" => "TO",
            ],
            [
                "ibge_codigo"   => 21,
                "nome" => "Maranhão",
                "sigla" => "MA",
            ],
            [
                "ibge_codigo"   => 22,
                "nome" => "Piauí",
                "sigla" => "PI",
            ],
            [
                "ibge_codigo"   => 23,
                "nome" => "Ceará",
                "sigla" => "CE",
            ],
            [
                "ibge_codigo"   => 24,
                "nome" => "Rio Grande do Norte",
                "sigla" => "RN",
            ],
            [
                "ibge_codigo"   => 25,
                "nome" => "Paraíba",
                "sigla" => "PB",
            ],
            [
                "ibge_codigo"   => 26,
                "nome" => "Pernambuco",
                "sigla" => "PE",
            ],
            [
                "ibge_codigo"   => 27,
                "nome" => "Alagoas",
                "sigla" => "AL",
            ],
            [
                "ibge_codigo"   => 28,
                "nome" => "Sergipe",
                "sigla" => "SE",
            ],
            [
                "ibge_codigo"   => 29,
                "nome" => "Bahia",
                "sigla" => "BA",
            ],
            [
                "ibge_codigo"   => 31,
                "nome" => "Minas Gerais",
                "sigla" => "MG",
            ],
            [
                "ibge_codigo"   => 32,
                "nome" => "Espírito Santo",
                "sigla" => "ES",
            ],
            [
                "ibge_codigo"   => 33,
                "nome" => "Rio de Janeiro",
                "sigla" => "RJ",
            ],
            [
                "ibge_codigo"   => 35,
                "nome" => "São Paulo",
                "sigla" => "SP",
            ],
            [
                "ibge_codigo"   => 41,
                "nome" => "Paraná",
                "sigla" => "PR",
            ],
            [
                "ibge_codigo"   => 42,
                "nome" => "Santa Catarina",
                "sigla" => "SC",
            ],
            [
                "ibge_codigo"   => 43,
                "nome" => "Rio Grande do Sul",
                "sigla" => "RS",
            ],
            [
                "ibge_codigo"   => 50,
                "nome" => "Mato Grosso do Sul",
                "sigla" => "MS",
            ],
            [
                "ibge_codigo"   => 51,
                "nome" => "Mato Grosso",
                "sigla" => "MT",
            ],
            [
                "ibge_codigo"   => 52,
                "nome" => "Goiás",
                "sigla" => "GO",
            ],
            [
                "ibge_codigo"   => 53,
                "nome" => "Distrito Federal",
                "sigla" => "DF",
            ],
        ];
    }
}
