<?php

namespace Database\Seeders;

use App\Models\Cidade;
use App\Models\Estado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CidadeSeeder extends Seeder
{
    // Boa Esperança do Norte - MT
    public function run()
    {
        foreach (array_chunk($this->getCidades(), 1000) as $cidade) {
            DB::table('cidade')->insert($cidade);
        }

        Cidade::query()->get()->each(function ($cidade) {
            $cidade->estado_id = Estado::query()->where('ibge_codigo', '=', $cidade->ibge_estado_id)->first()->id;
            $cidade->save();
        });
    }

    public function getCidades()
    {
        return [
            [
                "ibge_codigo"       => 1100015,
                "ibge_estado_id" => 11,
                "nome"     => "Alta Floresta d'Oeste",
            ],
            [
                "ibge_codigo"       => 1100023,
                "ibge_estado_id" => 11,
                "nome"     => "Ariquemes",
            ],
            [
                "ibge_codigo"       => 1100031,
                "ibge_estado_id" => 11,
                "nome"     => "Cabixi",
            ],
            [
                "ibge_codigo"       => 1100049,
                "ibge_estado_id" => 11,
                "nome"     => "Cacoal",
            ],
            [
                "ibge_codigo"       => 1100056,
                "ibge_estado_id" => 11,
                "nome"     => "Cerejeiras",
            ],
            [
                "ibge_codigo"       => 1100064,
                "ibge_estado_id" => 11,
                "nome"     => "Colorado do Oeste",
            ],
            [
                "ibge_codigo"       => 1100072,
                "ibge_estado_id" => 11,
                "nome"     => "Corumbiara",
            ],
            [
                "ibge_codigo"       => 1100080,
                "ibge_estado_id" => 11,
                "nome"     => "Costa Marques",
            ],
            [
                "ibge_codigo"       => 1100098,
                "ibge_estado_id" => 11,
                "nome"     => "Espigão d'Oeste",
            ],
            [
                "ibge_codigo"       => 1100106,
                "ibge_estado_id" => 11,
                "nome"     => "Guajará-Mirim",
            ],
            [
                "ibge_codigo"       => 1100114,
                "ibge_estado_id" => 11,
                "nome"     => "Jaru",
            ],
            [
                "ibge_codigo"       => 1100122,
                "ibge_estado_id" => 11,
                "nome"     => "Ji-Paraná",
            ],
            [
                "ibge_codigo"       => 1100130,
                "ibge_estado_id" => 11,
                "nome"     => "Machadinho d'Oeste",
            ],
            [
                "ibge_codigo"       => 1100148,
                "ibge_estado_id" => 11,
                "nome"     => "Nova Brasilândia d'Oeste",
            ],
            [
                "ibge_codigo"       => 1100155,
                "ibge_estado_id" => 11,
                "nome"     => "Ouro Preto do Oeste",
            ],
            [
                "ibge_codigo"       => 1100189,
                "ibge_estado_id" => 11,
                "nome"     => "Pimenta Bueno",
            ],
            [
                "ibge_codigo"       => 1100205,
                "ibge_estado_id" => 11,
                "nome"     => "Porto Velho",
            ],
            [
                "ibge_codigo"       => 1100254,
                "ibge_estado_id" => 11,
                "nome"     => "Presidente Médici",
            ],
            [
                "ibge_codigo"       => 1100262,
                "ibge_estado_id" => 11,
                "nome"     => "Rio Crespo",
            ],
            [
                "ibge_codigo"       => 1100288,
                "ibge_estado_id" => 11,
                "nome"     => "Rolim de Moura",
            ],
            [
                "ibge_codigo"       => 1100296,
                "ibge_estado_id" => 11,
                "nome"     => "Santa Luzia d'Oeste",
            ],
            [
                "ibge_codigo"       => 1100304,
                "ibge_estado_id" => 11,
                "nome"     => "Vilhena",
            ],
            [
                "ibge_codigo"       => 1100320,
                "ibge_estado_id" => 11,
                "nome"     => "São Miguel do Guaporé",
            ],
            [
                "ibge_codigo"       => 1100338,
                "ibge_estado_id" => 11,
                "nome"     => "Nova Mamoré",
            ],
            [
                "ibge_codigo"       => 1100346,
                "ibge_estado_id" => 11,
                "nome"     => "Alvorada d'Oeste",
            ],
            [
                "ibge_codigo"       => 1100379,
                "ibge_estado_id" => 11,
                "nome"     => "Alto Alegre dos Parecis",
            ],
            [
                "ibge_codigo"       => 1100403,
                "ibge_estado_id" => 11,
                "nome"     => "Alto Paraíso",
            ],
            [
                "ibge_codigo"       => 1100452,
                "ibge_estado_id" => 11,
                "nome"     => "Buritis",
            ],
            [
                "ibge_codigo"       => 1100502,
                "ibge_estado_id" => 11,
                "nome"     => "Novo Horizonte do Oeste",
            ],
            [
                "ibge_codigo"       => 1100601,
                "ibge_estado_id" => 11,
                "nome"     => "Cacaulândia",
            ],
            [
                "ibge_codigo"       => 1100700,
                "ibge_estado_id" => 11,
                "nome"     => "Campo Novo de Rondônia",
            ],
            [
                "ibge_codigo"       => 1100809,
                "ibge_estado_id" => 11,
                "nome"     => "Candeias do Jamari",
            ],
            [
                "ibge_codigo"       => 1100908,
                "ibge_estado_id" => 11,
                "nome"     => "Castanheiras",
            ],
            [
                "ibge_codigo"       => 1100924,
                "ibge_estado_id" => 11,
                "nome"     => "Chupinguaia",
            ],
            [
                "ibge_codigo"       => 1100940,
                "ibge_estado_id" => 11,
                "nome"     => "Cujubim",
            ],
            [
                "ibge_codigo"       => 1101005,
                "ibge_estado_id" => 11,
                "nome"     => "Governador Jorge Teixeira",
            ],
            [
                "ibge_codigo"       => 1101104,
                "ibge_estado_id" => 11,
                "nome"     => "Itapuã do Oeste",
            ],
            [
                "ibge_codigo"       => 1101203,
                "ibge_estado_id" => 11,
                "nome"     => "Ministro Andreazza",
            ],
            [
                "ibge_codigo"       => 1101302,
                "ibge_estado_id" => 11,
                "nome"     => "Mirante da Serra",
            ],
            [
                "ibge_codigo"       => 1101401,
                "ibge_estado_id" => 11,
                "nome"     => "Monte Negro",
            ],
            [
                "ibge_codigo"       => 1101435,
                "ibge_estado_id" => 11,
                "nome"     => "Nova União",
            ],
            [
                "ibge_codigo"       => 1101450,
                "ibge_estado_id" => 11,
                "nome"     => "Parecis",
            ],
            [
                "ibge_codigo"       => 1101468,
                "ibge_estado_id" => 11,
                "nome"     => "Pimenteiras do Oeste",
            ],
            [
                "ibge_codigo"       => 1101476,
                "ibge_estado_id" => 11,
                "nome"     => "Primavera de Rondônia",
            ],
            [
                "ibge_codigo"       => 1101484,
                "ibge_estado_id" => 11,
                "nome"     => "São Felipe d'Oeste",
            ],
            [
                "ibge_codigo"       => 1101492,
                "ibge_estado_id" => 11,
                "nome"     => "São Francisco do Guaporé",
            ],
            [
                "ibge_codigo"       => 1101500,
                "ibge_estado_id" => 11,
                "nome"     => "Seringueiras",
            ],
            [
                "ibge_codigo"       => 1101559,
                "ibge_estado_id" => 11,
                "nome"     => "Teixeirópolis",
            ],
            [
                "ibge_codigo"       => 1101609,
                "ibge_estado_id" => 11,
                "nome"     => "Theobroma",
            ],
            [
                "ibge_codigo"       => 1101708,
                "ibge_estado_id" => 11,
                "nome"     => "Urupá",
            ],
            [
                "ibge_codigo"       => 1101757,
                "ibge_estado_id" => 11,
                "nome"     => "Vale do Anari",
            ],
            [
                "ibge_codigo"       => 1101807,
                "ibge_estado_id" => 11,
                "nome"     => "Vale do Paraíso",
            ],
            [
                "ibge_codigo"       => 1200013,
                "ibge_estado_id" => 12,
                "nome"     => "Acrelândia",
            ],
            [
                "ibge_codigo"       => 1200054,
                "ibge_estado_id" => 12,
                "nome"     => "Assis Brasil",
            ],
            [
                "ibge_codigo"       => 1200104,
                "ibge_estado_id" => 12,
                "nome"     => "Brasiléia",
            ],
            [
                "ibge_codigo"       => 1200138,
                "ibge_estado_id" => 12,
                "nome"     => "Bujari",
            ],
            [
                "ibge_codigo"       => 1200179,
                "ibge_estado_id" => 12,
                "nome"     => "Capixaba",
            ],
            [
                "ibge_codigo"       => 1200203,
                "ibge_estado_id" => 12,
                "nome"     => "Cruzeiro do Sul",
            ],
            [
                "ibge_codigo"       => 1200252,
                "ibge_estado_id" => 12,
                "nome"     => "Epitaciolândia",
            ],
            [
                "ibge_codigo"       => 1200302,
                "ibge_estado_id" => 12,
                "nome"     => "Feijó",
            ],
            [
                "ibge_codigo"       => 1200328,
                "ibge_estado_id" => 12,
                "nome"     => "Jordão",
            ],
            [
                "ibge_codigo"       => 1200336,
                "ibge_estado_id" => 12,
                "nome"     => "Mâncio Lima",
            ],
            [
                "ibge_codigo"       => 1200344,
                "ibge_estado_id" => 12,
                "nome"     => "Manoel Urbano",
            ],
            [
                "ibge_codigo"       => 1200351,
                "ibge_estado_id" => 12,
                "nome"     => "Marechal Thaumaturgo",
            ],
            [
                "ibge_codigo"       => 1200385,
                "ibge_estado_id" => 12,
                "nome"     => "Plácido de Castro",
            ],
            [
                "ibge_codigo"       => 1200393,
                "ibge_estado_id" => 12,
                "nome"     => "Porto Walter",
            ],
            [
                "ibge_codigo"       => 1200401,
                "ibge_estado_id" => 12,
                "nome"     => "Rio Branco",
            ],
            [
                "ibge_codigo"       => 1200427,
                "ibge_estado_id" => 12,
                "nome"     => "Rodrigues Alves",
            ],
            [
                "ibge_codigo"       => 1200435,
                "ibge_estado_id" => 12,
                "nome"     => "Santa Rosa do Purus",
            ],
            [
                "ibge_codigo"       => 1200450,
                "ibge_estado_id" => 12,
                "nome"     => "Senador Guiomard",
            ],
            [
                "ibge_codigo"       => 1200500,
                "ibge_estado_id" => 12,
                "nome"     => "Sena Madureira",
            ],
            [
                "ibge_codigo"       => 1200609,
                "ibge_estado_id" => 12,
                "nome"     => "Tarauacá",
            ],
            [
                "ibge_codigo"       => 1200708,
                "ibge_estado_id" => 12,
                "nome"     => "Xapuri",
            ],
            [
                "ibge_codigo"       => 1200807,
                "ibge_estado_id" => 12,
                "nome"     => "Porto Acre",
            ],
            [
                "ibge_codigo"       => 1300029,
                "ibge_estado_id" => 13,
                "nome"     => "Alvarães",
            ],
            [
                "ibge_codigo"       => 1300060,
                "ibge_estado_id" => 13,
                "nome"     => "Amaturá",
            ],
            [
                "ibge_codigo"       => 1300086,
                "ibge_estado_id" => 13,
                "nome"     => "Anamã",
            ],
            [
                "ibge_codigo"       => 1300102,
                "ibge_estado_id" => 13,
                "nome"     => "Anori",
            ],
            [
                "ibge_codigo"       => 1300144,
                "ibge_estado_id" => 13,
                "nome"     => "Apuí",
            ],
            [
                "ibge_codigo"       => 1300201,
                "ibge_estado_id" => 13,
                "nome"     => "Atalaia do Norte",
            ],
            [
                "ibge_codigo"       => 1300300,
                "ibge_estado_id" => 13,
                "nome"     => "Autazes",
            ],
            [
                "ibge_codigo"       => 1300409,
                "ibge_estado_id" => 13,
                "nome"     => "Barcelos",
            ],
            [
                "ibge_codigo"       => 1300508,
                "ibge_estado_id" => 13,
                "nome"     => "Barreirinha",
            ],
            [
                "ibge_codigo"       => 1300607,
                "ibge_estado_id" => 13,
                "nome"     => "Benjamin Constant",
            ],
            [
                "ibge_codigo"       => 1300631,
                "ibge_estado_id" => 13,
                "nome"     => "Beruri",
            ],
            [
                "ibge_codigo"       => 1300680,
                "ibge_estado_id" => 13,
                "nome"     => "Boa Vista do Ramos",
            ],
            [
                "ibge_codigo"       => 1300706,
                "ibge_estado_id" => 13,
                "nome"     => "Boca do Acre",
            ],
            [
                "ibge_codigo"       => 1300805,
                "ibge_estado_id" => 13,
                "nome"     => "Borba",
            ],
            [
                "ibge_codigo"       => 1300839,
                "ibge_estado_id" => 13,
                "nome"     => "Caapiranga",
            ],
            [
                "ibge_codigo"       => 1300904,
                "ibge_estado_id" => 13,
                "nome"     => "Canutama",
            ],
            [
                "ibge_codigo"       => 1301001,
                "ibge_estado_id" => 13,
                "nome"     => "Carauari",
            ],
            [
                "ibge_codigo"       => 1301100,
                "ibge_estado_id" => 13,
                "nome"     => "Careiro",
            ],
            [
                "ibge_codigo"       => 1301159,
                "ibge_estado_id" => 13,
                "nome"     => "Careiro da Várzea",
            ],
            [
                "ibge_codigo"       => 1301209,
                "ibge_estado_id" => 13,
                "nome"     => "Coari",
            ],
            [
                "ibge_codigo"       => 1301308,
                "ibge_estado_id" => 13,
                "nome"     => "Codajás",
            ],
            [
                "ibge_codigo"       => 1301407,
                "ibge_estado_id" => 13,
                "nome"     => "Eirunepé",
            ],
            [
                "ibge_codigo"       => 1301506,
                "ibge_estado_id" => 13,
                "nome"     => "Envira",
            ],
            [
                "ibge_codigo"       => 1301605,
                "ibge_estado_id" => 13,
                "nome"     => "Fonte Boa",
            ],
            [
                "ibge_codigo"       => 1301654,
                "ibge_estado_id" => 13,
                "nome"     => "Guajará",
            ],
            [
                "ibge_codigo"       => 1301704,
                "ibge_estado_id" => 13,
                "nome"     => "Humaitá",
            ],
            [
                "ibge_codigo"       => 1301803,
                "ibge_estado_id" => 13,
                "nome"     => "Ipixuna",
            ],
            [
                "ibge_codigo"       => 1301852,
                "ibge_estado_id" => 13,
                "nome"     => "Iranduba",
            ],
            [
                "ibge_codigo"       => 1301902,
                "ibge_estado_id" => 13,
                "nome"     => "Itacoatiara",
            ],
            [
                "ibge_codigo"       => 1301951,
                "ibge_estado_id" => 13,
                "nome"     => "Itamarati",
            ],
            [
                "ibge_codigo"       => 1302009,
                "ibge_estado_id" => 13,
                "nome"     => "Itapiranga",
            ],
            [
                "ibge_codigo"       => 1302108,
                "ibge_estado_id" => 13,
                "nome"     => "Japurá",
            ],
            [
                "ibge_codigo"       => 1302207,
                "ibge_estado_id" => 13,
                "nome"     => "Juruá",
            ],
            [
                "ibge_codigo"       => 1302306,
                "ibge_estado_id" => 13,
                "nome"     => "Jutaí",
            ],
            [
                "ibge_codigo"       => 1302405,
                "ibge_estado_id" => 13,
                "nome"     => "Lábrea",
            ],
            [
                "ibge_codigo"       => 1302504,
                "ibge_estado_id" => 13,
                "nome"     => "Manacapuru",
            ],
            [
                "ibge_codigo"       => 1302553,
                "ibge_estado_id" => 13,
                "nome"     => "Manaquiri",
            ],
            [
                "ibge_codigo"       => 1302603,
                "ibge_estado_id" => 13,
                "nome"     => "Manaus",
            ],
            [
                "ibge_codigo"       => 1302702,
                "ibge_estado_id" => 13,
                "nome"     => "Manicoré",
            ],
            [
                "ibge_codigo"       => 1302801,
                "ibge_estado_id" => 13,
                "nome"     => "Maraã",
            ],
            [
                "ibge_codigo"       => 1302900,
                "ibge_estado_id" => 13,
                "nome"     => "Maués",
            ],
            [
                "ibge_codigo"       => 1303007,
                "ibge_estado_id" => 13,
                "nome"     => "Nhamundá",
            ],
            [
                "ibge_codigo"       => 1303106,
                "ibge_estado_id" => 13,
                "nome"     => "Nova Olinda do Norte",
            ],
            [
                "ibge_codigo"       => 1303205,
                "ibge_estado_id" => 13,
                "nome"     => "Novo Airão",
            ],
            [
                "ibge_codigo"       => 1303304,
                "ibge_estado_id" => 13,
                "nome"     => "Novo Aripuanã",
            ],
            [
                "ibge_codigo"       => 1303403,
                "ibge_estado_id" => 13,
                "nome"     => "Parintins",
            ],
            [
                "ibge_codigo"       => 1303502,
                "ibge_estado_id" => 13,
                "nome"     => "Pauini",
            ],
            [
                "ibge_codigo"       => 1303536,
                "ibge_estado_id" => 13,
                "nome"     => "Presidente Figueiredo",
            ],
            [
                "ibge_codigo"       => 1303569,
                "ibge_estado_id" => 13,
                "nome"     => "Rio Preto da Eva",
            ],
            [
                "ibge_codigo"       => 1303601,
                "ibge_estado_id" => 13,
                "nome"     => "Santa Isabel do Rio Negro",
            ],
            [
                "ibge_codigo"       => 1303700,
                "ibge_estado_id" => 13,
                "nome"     => "Santo Antônio do Içá",
            ],
            [
                "ibge_codigo"       => 1303809,
                "ibge_estado_id" => 13,
                "nome"     => "São Gabriel da Cachoeira",
            ],
            [
                "ibge_codigo"       => 1303908,
                "ibge_estado_id" => 13,
                "nome"     => "São Paulo de Olivença",
            ],
            [
                "ibge_codigo"       => 1303957,
                "ibge_estado_id" => 13,
                "nome"     => "São Sebastião do Uatumã",
            ],
            [
                "ibge_codigo"       => 1304005,
                "ibge_estado_id" => 13,
                "nome"     => "Silves",
            ],
            [
                "ibge_codigo"       => 1304062,
                "ibge_estado_id" => 13,
                "nome"     => "Tabatinga",
            ],
            [
                "ibge_codigo"       => 1304104,
                "ibge_estado_id" => 13,
                "nome"     => "Tapauá",
            ],
            [
                "ibge_codigo"       => 1304203,
                "ibge_estado_id" => 13,
                "nome"     => "Tefé",
            ],
            [
                "ibge_codigo"       => 1304237,
                "ibge_estado_id" => 13,
                "nome"     => "Tonantins",
            ],
            [
                "ibge_codigo"       => 1304260,
                "ibge_estado_id" => 13,
                "nome"     => "Uarini",
            ],
            [
                "ibge_codigo"       => 1304302,
                "ibge_estado_id" => 13,
                "nome"     => "Urucará",
            ],
            [
                "ibge_codigo"       => 1304401,
                "ibge_estado_id" => 13,
                "nome"     => "Urucurituba",
            ],
            [
                "ibge_codigo"       => 1400027,
                "ibge_estado_id" => 14,
                "nome"     => "Amajari",
            ],
            [
                "ibge_codigo"       => 1400050,
                "ibge_estado_id" => 14,
                "nome"     => "Alto Alegre",
            ],
            [
                "ibge_codigo"       => 1400100,
                "ibge_estado_id" => 14,
                "nome"     => "Boa Vista",
            ],
            [
                "ibge_codigo"       => 1400159,
                "ibge_estado_id" => 14,
                "nome"     => "Bonfim",
            ],
            [
                "ibge_codigo"       => 1400175,
                "ibge_estado_id" => 14,
                "nome"     => "Cantá",
            ],
            [
                "ibge_codigo"       => 1400209,
                "ibge_estado_id" => 14,
                "nome"     => "Caracaraí",
            ],
            [
                "ibge_codigo"       => 1400233,
                "ibge_estado_id" => 14,
                "nome"     => "Caroebe",
            ],
            [
                "ibge_codigo"       => 1400282,
                "ibge_estado_id" => 14,
                "nome"     => "Iracema",
            ],
            [
                "ibge_codigo"       => 1400308,
                "ibge_estado_id" => 14,
                "nome"     => "Mucajaí",
            ],
            [
                "ibge_codigo"       => 1400407,
                "ibge_estado_id" => 14,
                "nome"     => "Normandia",
            ],
            [
                "ibge_codigo"       => 1400456,
                "ibge_estado_id" => 14,
                "nome"     => "Pacaraima",
            ],
            [
                "ibge_codigo"       => 1400472,
                "ibge_estado_id" => 14,
                "nome"     => "Rorainópolis",
            ],
            [
                "ibge_codigo"       => 1400506,
                "ibge_estado_id" => 14,
                "nome"     => "São João da Baliza",
            ],
            [
                "ibge_codigo"       => 1400605,
                "ibge_estado_id" => 14,
                "nome"     => "São Luiz",
            ],
            [
                "ibge_codigo"       => 1400704,
                "ibge_estado_id" => 14,
                "nome"     => "Uiramutã",
            ],
            [
                "ibge_codigo"       => 1500107,
                "ibge_estado_id" => 15,
                "nome"     => "Abaetetuba",
            ],
            [
                "ibge_codigo"       => 1500131,
                "ibge_estado_id" => 15,
                "nome"     => "Abel Figueiredo",
            ],
            [
                "ibge_codigo"       => 1500206,
                "ibge_estado_id" => 15,
                "nome"     => "Acará",
            ],
            [
                "ibge_codigo"       => 1500305,
                "ibge_estado_id" => 15,
                "nome"     => "Afuá",
            ],
            [
                "ibge_codigo"       => 1500347,
                "ibge_estado_id" => 15,
                "nome"     => "Água Azul do Norte",
            ],
            [
                "ibge_codigo"       => 1500404,
                "ibge_estado_id" => 15,
                "nome"     => "Alenquer",
            ],
            [
                "ibge_codigo"       => 1500503,
                "ibge_estado_id" => 15,
                "nome"     => "Almeirim",
            ],
            [
                "ibge_codigo"       => 1500602,
                "ibge_estado_id" => 15,
                "nome"     => "Altamira",
            ],
            [
                "ibge_codigo"       => 1500701,
                "ibge_estado_id" => 15,
                "nome"     => "Anajás",
            ],
            [
                "ibge_codigo"       => 1500800,
                "ibge_estado_id" => 15,
                "nome"     => "Ananindeua",
            ],
            [
                "ibge_codigo"       => 1500859,
                "ibge_estado_id" => 15,
                "nome"     => "Anapu",
            ],
            [
                "ibge_codigo"       => 1500909,
                "ibge_estado_id" => 15,
                "nome"     => "Augusto Corrêa",
            ],
            [
                "ibge_codigo"       => 1500958,
                "ibge_estado_id" => 15,
                "nome"     => "Aurora do Pará",
            ],
            [
                "ibge_codigo"       => 1501006,
                "ibge_estado_id" => 15,
                "nome"     => "Aveiro",
            ],
            [
                "ibge_codigo"       => 1501105,
                "ibge_estado_id" => 15,
                "nome"     => "Bagre",
            ],
            [
                "ibge_codigo"       => 1501204,
                "ibge_estado_id" => 15,
                "nome"     => "Baião",
            ],
            [
                "ibge_codigo"       => 1501253,
                "ibge_estado_id" => 15,
                "nome"     => "Bannach",
            ],
            [
                "ibge_codigo"       => 1501303,
                "ibge_estado_id" => 15,
                "nome"     => "Barcarena",
            ],
            [
                "ibge_codigo"       => 1501402,
                "ibge_estado_id" => 15,
                "nome"     => "Belém",
            ],
            [
                "ibge_codigo"       => 1501451,
                "ibge_estado_id" => 15,
                "nome"     => "Belterra",
            ],
            [
                "ibge_codigo"       => 1501501,
                "ibge_estado_id" => 15,
                "nome"     => "Benevides",
            ],
            [
                "ibge_codigo"       => 1501576,
                "ibge_estado_id" => 15,
                "nome"     => "Bom Jesus do Tocantins",
            ],
            [
                "ibge_codigo"       => 1501600,
                "ibge_estado_id" => 15,
                "nome"     => "Bonito",
            ],
            [
                "ibge_codigo"       => 1501709,
                "ibge_estado_id" => 15,
                "nome"     => "Bragança",
            ],
            [
                "ibge_codigo"       => 1501725,
                "ibge_estado_id" => 15,
                "nome"     => "Brasil Novo",
            ],
            [
                "ibge_codigo"       => 1501758,
                "ibge_estado_id" => 15,
                "nome"     => "Brejo Grande do Araguaia",
            ],
            [
                "ibge_codigo"       => 1501782,
                "ibge_estado_id" => 15,
                "nome"     => "Breu Branco",
            ],
            [
                "ibge_codigo"       => 1501808,
                "ibge_estado_id" => 15,
                "nome"     => "Breves",
            ],
            [
                "ibge_codigo"       => 1501907,
                "ibge_estado_id" => 15,
                "nome"     => "Bujaru",
            ],
            [
                "ibge_codigo"       => 1501956,
                "ibge_estado_id" => 15,
                "nome"     => "Cachoeira do Piriá",
            ],
            [
                "ibge_codigo"       => 1502004,
                "ibge_estado_id" => 15,
                "nome"     => "Cachoeira do Arari",
            ],
            [
                "ibge_codigo"       => 1502103,
                "ibge_estado_id" => 15,
                "nome"     => "Cametá",
            ],
            [
                "ibge_codigo"       => 1502152,
                "ibge_estado_id" => 15,
                "nome"     => "Canaã dos Carajás",
            ],
            [
                "ibge_codigo"       => 1502202,
                "ibge_estado_id" => 15,
                "nome"     => "Capanema",
            ],
            [
                "ibge_codigo"       => 1502301,
                "ibge_estado_id" => 15,
                "nome"     => "Capitão Poço",
            ],
            [
                "ibge_codigo"       => 1502400,
                "ibge_estado_id" => 15,
                "nome"     => "Castanhal",
            ],
            [
                "ibge_codigo"       => 1502509,
                "ibge_estado_id" => 15,
                "nome"     => "Chaves",
            ],
            [
                "ibge_codigo"       => 1502608,
                "ibge_estado_id" => 15,
                "nome"     => "Colares",
            ],
            [
                "ibge_codigo"       => 1502707,
                "ibge_estado_id" => 15,
                "nome"     => "Conceição do Araguaia",
            ],
            [
                "ibge_codigo"       => 1502756,
                "ibge_estado_id" => 15,
                "nome"     => "Concórdia do Pará",
            ],
            [
                "ibge_codigo"       => 1502764,
                "ibge_estado_id" => 15,
                "nome"     => "Cumaru do Norte",
            ],
            [
                "ibge_codigo"       => 1502772,
                "ibge_estado_id" => 15,
                "nome"     => "Curionópolis",
            ],
            [
                "ibge_codigo"       => 1502806,
                "ibge_estado_id" => 15,
                "nome"     => "Curralinho",
            ],
            [
                "ibge_codigo"       => 1502855,
                "ibge_estado_id" => 15,
                "nome"     => "Curuá",
            ],
            [
                "ibge_codigo"       => 1502905,
                "ibge_estado_id" => 15,
                "nome"     => "Curuçá",
            ],
            [
                "ibge_codigo"       => 1502939,
                "ibge_estado_id" => 15,
                "nome"     => "Dom Eliseu",
            ],
            [
                "ibge_codigo"       => 1502954,
                "ibge_estado_id" => 15,
                "nome"     => "Eldorado dos Carajás",
            ],
            [
                "ibge_codigo"       => 1503002,
                "ibge_estado_id" => 15,
                "nome"     => "Faro",
            ],
            [
                "ibge_codigo"       => 1503044,
                "ibge_estado_id" => 15,
                "nome"     => "Floresta do Araguaia",
            ],
            [
                "ibge_codigo"       => 1503077,
                "ibge_estado_id" => 15,
                "nome"     => "Garrafão do Norte",
            ],
            [
                "ibge_codigo"       => 1503093,
                "ibge_estado_id" => 15,
                "nome"     => "Goianésia do Pará",
            ],
            [
                "ibge_codigo"       => 1503101,
                "ibge_estado_id" => 15,
                "nome"     => "Gurupá",
            ],
            [
                "ibge_codigo"       => 1503200,
                "ibge_estado_id" => 15,
                "nome"     => "Igarapé-Açu",
            ],
            [
                "ibge_codigo"       => 1503309,
                "ibge_estado_id" => 15,
                "nome"     => "Igarapé-Miri",
            ],
            [
                "ibge_codigo"       => 1503408,
                "ibge_estado_id" => 15,
                "nome"     => "Inhangapi",
            ],
            [
                "ibge_codigo"       => 1503457,
                "ibge_estado_id" => 15,
                "nome"     => "Ipixuna do Pará",
            ],
            [
                "ibge_codigo"       => 1503507,
                "ibge_estado_id" => 15,
                "nome"     => "Irituia",
            ],
            [
                "ibge_codigo"       => 1503606,
                "ibge_estado_id" => 15,
                "nome"     => "Itaituba",
            ],
            [
                "ibge_codigo"       => 1503705,
                "ibge_estado_id" => 15,
                "nome"     => "Itupiranga",
            ],
            [
                "ibge_codigo"       => 1503754,
                "ibge_estado_id" => 15,
                "nome"     => "Jacareacanga",
            ],
            [
                "ibge_codigo"       => 1503804,
                "ibge_estado_id" => 15,
                "nome"     => "Jacundá",
            ],
            [
                "ibge_codigo"       => 1503903,
                "ibge_estado_id" => 15,
                "nome"     => "Juruti",
            ],
            [
                "ibge_codigo"       => 1504000,
                "ibge_estado_id" => 15,
                "nome"     => "Limoeiro do Ajuru",
            ],
            [
                "ibge_codigo"       => 1504059,
                "ibge_estado_id" => 15,
                "nome"     => "Mãe do Rio",
            ],
            [
                "ibge_codigo"       => 1504109,
                "ibge_estado_id" => 15,
                "nome"     => "Magalhães Barata",
            ],
            [
                "ibge_codigo"       => 1504208,
                "ibge_estado_id" => 15,
                "nome"     => "Marabá",
            ],
            [
                "ibge_codigo"       => 1504307,
                "ibge_estado_id" => 15,
                "nome"     => "Maracanã",
            ],
            [
                "ibge_codigo"       => 1504406,
                "ibge_estado_id" => 15,
                "nome"     => "Marapanim",
            ],
            [
                "ibge_codigo"       => 1504422,
                "ibge_estado_id" => 15,
                "nome"     => "Marituba",
            ],
            [
                "ibge_codigo"       => 1504455,
                "ibge_estado_id" => 15,
                "nome"     => "Medicilândia",
            ],
            [
                "ibge_codigo"       => 1504505,
                "ibge_estado_id" => 15,
                "nome"     => "Melgaço",
            ],
            [
                "ibge_codigo"       => 1504604,
                "ibge_estado_id" => 15,
                "nome"     => "Mocajuba",
            ],
            [
                "ibge_codigo"       => 1504703,
                "ibge_estado_id" => 15,
                "nome"     => "Moju",
            ],
            [
                "ibge_codigo"       => 1504752,
                "ibge_estado_id" => 15,
                "nome"     => "Mojuí dos Campos",
            ],
            [
                "ibge_codigo"       => 1504802,
                "ibge_estado_id" => 15,
                "nome"     => "Monte Alegre",
            ],
            [
                "ibge_codigo"       => 1504901,
                "ibge_estado_id" => 15,
                "nome"     => "Muaná",
            ],
            [
                "ibge_codigo"       => 1504950,
                "ibge_estado_id" => 15,
                "nome"     => "Nova Esperança do Piriá",
            ],
            [
                "ibge_codigo"       => 1504976,
                "ibge_estado_id" => 15,
                "nome"     => "Nova Ipixuna",
            ],
            [
                "ibge_codigo"       => 1505007,
                "ibge_estado_id" => 15,
                "nome"     => "Nova Timboteua",
            ],
            [
                "ibge_codigo"       => 1505031,
                "ibge_estado_id" => 15,
                "nome"     => "Novo Progresso",
            ],
            [
                "ibge_codigo"       => 1505064,
                "ibge_estado_id" => 15,
                "nome"     => "Novo Repartimento",
            ],
            [
                "ibge_codigo"       => 1505106,
                "ibge_estado_id" => 15,
                "nome"     => "Óbidos",
            ],
            [
                "ibge_codigo"       => 1505205,
                "ibge_estado_id" => 15,
                "nome"     => "Oeiras do Pará",
            ],
            [
                "ibge_codigo"       => 1505304,
                "ibge_estado_id" => 15,
                "nome"     => "Oriximiná",
            ],
            [
                "ibge_codigo"       => 1505403,
                "ibge_estado_id" => 15,
                "nome"     => "Ourém",
            ],
            [
                "ibge_codigo"       => 1505437,
                "ibge_estado_id" => 15,
                "nome"     => "Ourilândia do Norte",
            ],
            [
                "ibge_codigo"       => 1505486,
                "ibge_estado_id" => 15,
                "nome"     => "Pacajá",
            ],
            [
                "ibge_codigo"       => 1505494,
                "ibge_estado_id" => 15,
                "nome"     => "Palestina do Pará",
            ],
            [
                "ibge_codigo"       => 1505502,
                "ibge_estado_id" => 15,
                "nome"     => "Paragominas",
            ],
            [
                "ibge_codigo"       => 1505536,
                "ibge_estado_id" => 15,
                "nome"     => "Parauapebas",
            ],
            [
                "ibge_codigo"       => 1505551,
                "ibge_estado_id" => 15,
                "nome"     => "Pau d'Arco",
            ],
            [
                "ibge_codigo"       => 1505601,
                "ibge_estado_id" => 15,
                "nome"     => "Peixe-Boi",
            ],
            [
                "ibge_codigo"       => 1505635,
                "ibge_estado_id" => 15,
                "nome"     => "Piçarra",
            ],
            [
                "ibge_codigo"       => 1505650,
                "ibge_estado_id" => 15,
                "nome"     => "Placas",
            ],
            [
                "ibge_codigo"       => 1505700,
                "ibge_estado_id" => 15,
                "nome"     => "Ponta de Pedras",
            ],
            [
                "ibge_codigo"       => 1505809,
                "ibge_estado_id" => 15,
                "nome"     => "Portel",
            ],
            [
                "ibge_codigo"       => 1505908,
                "ibge_estado_id" => 15,
                "nome"     => "Porto de Moz",
            ],
            [
                "ibge_codigo"       => 1506005,
                "ibge_estado_id" => 15,
                "nome"     => "Prainha",
            ],
            [
                "ibge_codigo"       => 1506104,
                "ibge_estado_id" => 15,
                "nome"     => "Primavera",
            ],
            [
                "ibge_codigo"       => 1506112,
                "ibge_estado_id" => 15,
                "nome"     => "Quatipuru",
            ],
            [
                "ibge_codigo"       => 1506138,
                "ibge_estado_id" => 15,
                "nome"     => "Redenção",
            ],
            [
                "ibge_codigo"       => 1506161,
                "ibge_estado_id" => 15,
                "nome"     => "Rio Maria",
            ],
            [
                "ibge_codigo"       => 1506187,
                "ibge_estado_id" => 15,
                "nome"     => "Rondon do Pará",
            ],
            [
                "ibge_codigo"       => 1506195,
                "ibge_estado_id" => 15,
                "nome"     => "Rurópolis",
            ],
            [
                "ibge_codigo"       => 1506203,
                "ibge_estado_id" => 15,
                "nome"     => "Salinópolis",
            ],
            [
                "ibge_codigo"       => 1506302,
                "ibge_estado_id" => 15,
                "nome"     => "Salvaterra",
            ],
            [
                "ibge_codigo"       => 1506351,
                "ibge_estado_id" => 15,
                "nome"     => "Santa Bárbara do Pará",
            ],
            [
                "ibge_codigo"       => 1506401,
                "ibge_estado_id" => 15,
                "nome"     => "Santa Cruz do Arari",
            ],
            [
                "ibge_codigo"       => 1506500,
                "ibge_estado_id" => 15,
                "nome"     => "Santa Isabel do Pará",
            ],
            [
                "ibge_codigo"       => 1506559,
                "ibge_estado_id" => 15,
                "nome"     => "Santa Luzia do Pará",
            ],
            [
                "ibge_codigo"       => 1506583,
                "ibge_estado_id" => 15,
                "nome"     => "Santa Maria das Barreiras",
            ],
            [
                "ibge_codigo"       => 1506609,
                "ibge_estado_id" => 15,
                "nome"     => "Santa Maria do Pará",
            ],
            [
                "ibge_codigo"       => 1506708,
                "ibge_estado_id" => 15,
                "nome"     => "Santana do Araguaia",
            ],
            [
                "ibge_codigo"       => 1506807,
                "ibge_estado_id" => 15,
                "nome"     => "Santarém",
            ],
            [
                "ibge_codigo"       => 1506906,
                "ibge_estado_id" => 15,
                "nome"     => "Santarém Novo",
            ],
            [
                "ibge_codigo"       => 1507003,
                "ibge_estado_id" => 15,
                "nome"     => "Santo Antônio do Tauá",
            ],
            [
                "ibge_codigo"       => 1507102,
                "ibge_estado_id" => 15,
                "nome"     => "São Caetano de Odivelas",
            ],
            [
                "ibge_codigo"       => 1507151,
                "ibge_estado_id" => 15,
                "nome"     => "São Domingos do Araguaia",
            ],
            [
                "ibge_codigo"       => 1507201,
                "ibge_estado_id" => 15,
                "nome"     => "São Domingos do Capim",
            ],
            [
                "ibge_codigo"       => 1507300,
                "ibge_estado_id" => 15,
                "nome"     => "São Félix do Xingu",
            ],
            [
                "ibge_codigo"       => 1507409,
                "ibge_estado_id" => 15,
                "nome"     => "São Francisco do Pará",
            ],
            [
                "ibge_codigo"       => 1507458,
                "ibge_estado_id" => 15,
                "nome"     => "São Geraldo do Araguaia",
            ],
            [
                "ibge_codigo"       => 1507466,
                "ibge_estado_id" => 15,
                "nome"     => "São João da Ponta",
            ],
            [
                "ibge_codigo"       => 1507474,
                "ibge_estado_id" => 15,
                "nome"     => "São João de Pirabas",
            ],
            [
                "ibge_codigo"       => 1507508,
                "ibge_estado_id" => 15,
                "nome"     => "São João do Araguaia",
            ],
            [
                "ibge_codigo"       => 1507607,
                "ibge_estado_id" => 15,
                "nome"     => "São Miguel do Guamá",
            ],
            [
                "ibge_codigo"       => 1507706,
                "ibge_estado_id" => 15,
                "nome"     => "São Sebastião da Boa Vista",
            ],
            [
                "ibge_codigo"       => 1507755,
                "ibge_estado_id" => 15,
                "nome"     => "Sapucaia",
            ],
            [
                "ibge_codigo"       => 1507805,
                "ibge_estado_id" => 15,
                "nome"     => "Senador José Porfírio",
            ],
            [
                "ibge_codigo"       => 1507904,
                "ibge_estado_id" => 15,
                "nome"     => "Soure",
            ],
            [
                "ibge_codigo"       => 1507953,
                "ibge_estado_id" => 15,
                "nome"     => "Tailândia",
            ],
            [
                "ibge_codigo"       => 1507961,
                "ibge_estado_id" => 15,
                "nome"     => "Terra Alta",
            ],
            [
                "ibge_codigo"       => 1507979,
                "ibge_estado_id" => 15,
                "nome"     => "Terra Santa",
            ],
            [
                "ibge_codigo"       => 1508001,
                "ibge_estado_id" => 15,
                "nome"     => "Tomé-Açu",
            ],
            [
                "ibge_codigo"       => 1508035,
                "ibge_estado_id" => 15,
                "nome"     => "Tracuateua",
            ],
            [
                "ibge_codigo"       => 1508050,
                "ibge_estado_id" => 15,
                "nome"     => "Trairão",
            ],
            [
                "ibge_codigo"       => 1508084,
                "ibge_estado_id" => 15,
                "nome"     => "Tucumã",
            ],
            [
                "ibge_codigo"       => 1508100,
                "ibge_estado_id" => 15,
                "nome"     => "Tucuruí",
            ],
            [
                "ibge_codigo"       => 1508126,
                "ibge_estado_id" => 15,
                "nome"     => "Ulianópolis",
            ],
            [
                "ibge_codigo"       => 1508159,
                "ibge_estado_id" => 15,
                "nome"     => "Uruará",
            ],
            [
                "ibge_codigo"       => 1508209,
                "ibge_estado_id" => 15,
                "nome"     => "Vigia",
            ],
            [
                "ibge_codigo"       => 1508308,
                "ibge_estado_id" => 15,
                "nome"     => "Viseu",
            ],
            [
                "ibge_codigo"       => 1508357,
                "ibge_estado_id" => 15,
                "nome"     => "Vitória do Xingu",
            ],
            [
                "ibge_codigo"       => 1508407,
                "ibge_estado_id" => 15,
                "nome"     => "Xinguara",
            ],
            [
                "ibge_codigo"       => 1600055,
                "ibge_estado_id" => 16,
                "nome"     => "Serra do Navio",
            ],
            [
                "ibge_codigo"       => 1600105,
                "ibge_estado_id" => 16,
                "nome"     => "Amapá",
            ],
            [
                "ibge_codigo"       => 1600154,
                "ibge_estado_id" => 16,
                "nome"     => "Pedra Branca do Amaparí",
            ],
            [
                "ibge_codigo"       => 1600204,
                "ibge_estado_id" => 16,
                "nome"     => "Calçoene",
            ],
            [
                "ibge_codigo"       => 1600212,
                "ibge_estado_id" => 16,
                "nome"     => "Cutias",
            ],
            [
                "ibge_codigo"       => 1600238,
                "ibge_estado_id" => 16,
                "nome"     => "Ferreira Gomes",
            ],
            [
                "ibge_codigo"       => 1600253,
                "ibge_estado_id" => 16,
                "nome"     => "Itaubal",
            ],
            [
                "ibge_codigo"       => 1600279,
                "ibge_estado_id" => 16,
                "nome"     => "Laranjal do Jari",
            ],
            [
                "ibge_codigo"       => 1600303,
                "ibge_estado_id" => 16,
                "nome"     => "Macapá",
            ],
            [
                "ibge_codigo"       => 1600402,
                "ibge_estado_id" => 16,
                "nome"     => "Mazagão",
            ],
            [
                "ibge_codigo"       => 1600501,
                "ibge_estado_id" => 16,
                "nome"     => "Oiapoque",
            ],
            [
                "ibge_codigo"       => 1600535,
                "ibge_estado_id" => 16,
                "nome"     => "Porto Grande",
            ],
            [
                "ibge_codigo"       => 1600550,
                "ibge_estado_id" => 16,
                "nome"     => "Pracuúba",
            ],
            [
                "ibge_codigo"       => 1600600,
                "ibge_estado_id" => 16,
                "nome"     => "Santana",
            ],
            [
                "ibge_codigo"       => 1600709,
                "ibge_estado_id" => 16,
                "nome"     => "Tartarugalzinho",
            ],
            [
                "ibge_codigo"       => 1600808,
                "ibge_estado_id" => 16,
                "nome"     => "Vitória do Jari",
            ],
            [
                "ibge_codigo"       => 1700251,
                "ibge_estado_id" => 17,
                "nome"     => "Abreulândia",
            ],
            [
                "ibge_codigo"       => 1700301,
                "ibge_estado_id" => 17,
                "nome"     => "Aguiarnópolis",
            ],
            [
                "ibge_codigo"       => 1700350,
                "ibge_estado_id" => 17,
                "nome"     => "Aliança do Tocantins",
            ],
            [
                "ibge_codigo"       => 1700400,
                "ibge_estado_id" => 17,
                "nome"     => "Almas",
            ],
            [
                "ibge_codigo"       => 1700707,
                "ibge_estado_id" => 17,
                "nome"     => "Alvorada",
            ],
            [
                "ibge_codigo"       => 1701002,
                "ibge_estado_id" => 17,
                "nome"     => "Ananás",
            ],
            [
                "ibge_codigo"       => 1701051,
                "ibge_estado_id" => 17,
                "nome"     => "Angico",
            ],
            [
                "ibge_codigo"       => 1701101,
                "ibge_estado_id" => 17,
                "nome"     => "Aparecida do Rio Negro",
            ],
            [
                "ibge_codigo"       => 1701309,
                "ibge_estado_id" => 17,
                "nome"     => "Aragominas",
            ],
            [
                "ibge_codigo"       => 1701903,
                "ibge_estado_id" => 17,
                "nome"     => "Araguacema",
            ],
            [
                "ibge_codigo"       => 1702000,
                "ibge_estado_id" => 17,
                "nome"     => "Araguaçu",
            ],
            [
                "ibge_codigo"       => 1702109,
                "ibge_estado_id" => 17,
                "nome"     => "Araguaína",
            ],
            [
                "ibge_codigo"       => 1702158,
                "ibge_estado_id" => 17,
                "nome"     => "Araguanã",
            ],
            [
                "ibge_codigo"       => 1702208,
                "ibge_estado_id" => 17,
                "nome"     => "Araguatins",
            ],
            [
                "ibge_codigo"       => 1702307,
                "ibge_estado_id" => 17,
                "nome"     => "Arapoema",
            ],
            [
                "ibge_codigo"       => 1702406,
                "ibge_estado_id" => 17,
                "nome"     => "Arraias",
            ],
            [
                "ibge_codigo"       => 1702554,
                "ibge_estado_id" => 17,
                "nome"     => "Augustinópolis",
            ],
            [
                "ibge_codigo"       => 1702703,
                "ibge_estado_id" => 17,
                "nome"     => "Aurora do Tocantins",
            ],
            [
                "ibge_codigo"       => 1702901,
                "ibge_estado_id" => 17,
                "nome"     => "Axixá do Tocantins",
            ],
            [
                "ibge_codigo"       => 1703008,
                "ibge_estado_id" => 17,
                "nome"     => "Babaçulândia",
            ],
            [
                "ibge_codigo"       => 1703057,
                "ibge_estado_id" => 17,
                "nome"     => "Bandeirantes do Tocantins",
            ],
            [
                "ibge_codigo"       => 1703073,
                "ibge_estado_id" => 17,
                "nome"     => "Barra do Ouro",
            ],
            [
                "ibge_codigo"       => 1703107,
                "ibge_estado_id" => 17,
                "nome"     => "Barrolândia",
            ],
            [
                "ibge_codigo"       => 1703206,
                "ibge_estado_id" => 17,
                "nome"     => "Bernardo Sayão",
            ],
            [
                "ibge_codigo"       => 1703305,
                "ibge_estado_id" => 17,
                "nome"     => "Bom Jesus do Tocantins",
            ],
            [
                "ibge_codigo"       => 1703602,
                "ibge_estado_id" => 17,
                "nome"     => "Brasilândia do Tocantins",
            ],
            [
                "ibge_codigo"       => 1703701,
                "ibge_estado_id" => 17,
                "nome"     => "Brejinho de Nazaré",
            ],
            [
                "ibge_codigo"       => 1703800,
                "ibge_estado_id" => 17,
                "nome"     => "Buriti do Tocantins",
            ],
            [
                "ibge_codigo"       => 1703826,
                "ibge_estado_id" => 17,
                "nome"     => "Cachoeirinha",
            ],
            [
                "ibge_codigo"       => 1703842,
                "ibge_estado_id" => 17,
                "nome"     => "Campos Lindos",
            ],
            [
                "ibge_codigo"       => 1703867,
                "ibge_estado_id" => 17,
                "nome"     => "Cariri do Tocantins",
            ],
            [
                "ibge_codigo"       => 1703883,
                "ibge_estado_id" => 17,
                "nome"     => "Carmolândia",
            ],
            [
                "ibge_codigo"       => 1703891,
                "ibge_estado_id" => 17,
                "nome"     => "Carrasco Bonito",
            ],
            [
                "ibge_codigo"       => 1703909,
                "ibge_estado_id" => 17,
                "nome"     => "Caseara",
            ],
            [
                "ibge_codigo"       => 1704105,
                "ibge_estado_id" => 17,
                "nome"     => "Centenário",
            ],
            [
                "ibge_codigo"       => 1704600,
                "ibge_estado_id" => 17,
                "nome"     => "Chapada de Areia",
            ],
            [
                "ibge_codigo"       => 1705102,
                "ibge_estado_id" => 17,
                "nome"     => "Chapada da Natividade",
            ],
            [
                "ibge_codigo"       => 1705508,
                "ibge_estado_id" => 17,
                "nome"     => "Colinas do Tocantins",
            ],
            [
                "ibge_codigo"       => 1705557,
                "ibge_estado_id" => 17,
                "nome"     => "Combinado",
            ],
            [
                "ibge_codigo"       => 1705607,
                "ibge_estado_id" => 17,
                "nome"     => "Conceição do Tocantins",
            ],
            [
                "ibge_codigo"       => 1706001,
                "ibge_estado_id" => 17,
                "nome"     => "Couto Magalhães",
            ],
            [
                "ibge_codigo"       => 1706100,
                "ibge_estado_id" => 17,
                "nome"     => "Cristalândia",
            ],
            [
                "ibge_codigo"       => 1706258,
                "ibge_estado_id" => 17,
                "nome"     => "Crixás do Tocantins",
            ],
            [
                "ibge_codigo"       => 1706506,
                "ibge_estado_id" => 17,
                "nome"     => "Darcinópolis",
            ],
            [
                "ibge_codigo"       => 1707009,
                "ibge_estado_id" => 17,
                "nome"     => "Dianópolis",
            ],
            [
                "ibge_codigo"       => 1707108,
                "ibge_estado_id" => 17,
                "nome"     => "Divinópolis do Tocantins",
            ],
            [
                "ibge_codigo"       => 1707207,
                "ibge_estado_id" => 17,
                "nome"     => "Dois Irmãos do Tocantins",
            ],
            [
                "ibge_codigo"       => 1707306,
                "ibge_estado_id" => 17,
                "nome"     => "Dueré",
            ],
            [
                "ibge_codigo"       => 1707405,
                "ibge_estado_id" => 17,
                "nome"     => "Esperantina",
            ],
            [
                "ibge_codigo"       => 1707553,
                "ibge_estado_id" => 17,
                "nome"     => "Fátima",
            ],
            [
                "ibge_codigo"       => 1707652,
                "ibge_estado_id" => 17,
                "nome"     => "Figueirópolis",
            ],
            [
                "ibge_codigo"       => 1707702,
                "ibge_estado_id" => 17,
                "nome"     => "Filadélfia",
            ],
            [
                "ibge_codigo"       => 1708205,
                "ibge_estado_id" => 17,
                "nome"     => "Formoso do Araguaia",
            ],
            [
                "ibge_codigo"       => 1708254,
                "ibge_estado_id" => 17,
                "nome"     => "Fortaleza do Tabocão",
            ],
            [
                "ibge_codigo"       => 1708304,
                "ibge_estado_id" => 17,
                "nome"     => "Goianorte",
            ],
            [
                "ibge_codigo"       => 1709005,
                "ibge_estado_id" => 17,
                "nome"     => "Goiatins",
            ],
            [
                "ibge_codigo"       => 1709302,
                "ibge_estado_id" => 17,
                "nome"     => "Guaraí",
            ],
            [
                "ibge_codigo"       => 1709500,
                "ibge_estado_id" => 17,
                "nome"     => "Gurupi",
            ],
            [
                "ibge_codigo"       => 1709807,
                "ibge_estado_id" => 17,
                "nome"     => "Ipueiras",
            ],
            [
                "ibge_codigo"       => 1710508,
                "ibge_estado_id" => 17,
                "nome"     => "Itacajá",
            ],
            [
                "ibge_codigo"       => 1710706,
                "ibge_estado_id" => 17,
                "nome"     => "Itaguatins",
            ],
            [
                "ibge_codigo"       => 1710904,
                "ibge_estado_id" => 17,
                "nome"     => "Itapiratins",
            ],
            [
                "ibge_codigo"       => 1711100,
                "ibge_estado_id" => 17,
                "nome"     => "Itaporã do Tocantins",
            ],
            [
                "ibge_codigo"       => 1711506,
                "ibge_estado_id" => 17,
                "nome"     => "Jaú do Tocantins",
            ],
            [
                "ibge_codigo"       => 1711803,
                "ibge_estado_id" => 17,
                "nome"     => "Juarina",
            ],
            [
                "ibge_codigo"       => 1711902,
                "ibge_estado_id" => 17,
                "nome"     => "Lagoa da Confusão",
            ],
            [
                "ibge_codigo"       => 1711951,
                "ibge_estado_id" => 17,
                "nome"     => "Lagoa do Tocantins",
            ],
            [
                "ibge_codigo"       => 1712009,
                "ibge_estado_id" => 17,
                "nome"     => "Lajeado",
            ],
            [
                "ibge_codigo"       => 1712157,
                "ibge_estado_id" => 17,
                "nome"     => "Lavandeira",
            ],
            [
                "ibge_codigo"       => 1712405,
                "ibge_estado_id" => 17,
                "nome"     => "Lizarda",
            ],
            [
                "ibge_codigo"       => 1712454,
                "ibge_estado_id" => 17,
                "nome"     => "Luzinópolis",
            ],
            [
                "ibge_codigo"       => 1712504,
                "ibge_estado_id" => 17,
                "nome"     => "Marianópolis do Tocantins",
            ],
            [
                "ibge_codigo"       => 1712702,
                "ibge_estado_id" => 17,
                "nome"     => "Mateiros",
            ],
            [
                "ibge_codigo"       => 1712801,
                "ibge_estado_id" => 17,
                "nome"     => "Maurilândia do Tocantins",
            ],
            [
                "ibge_codigo"       => 1713205,
                "ibge_estado_id" => 17,
                "nome"     => "Miracema do Tocantins",
            ],
            [
                "ibge_codigo"       => 1713304,
                "ibge_estado_id" => 17,
                "nome"     => "Miranorte",
            ],
            [
                "ibge_codigo"       => 1713601,
                "ibge_estado_id" => 17,
                "nome"     => "Monte do Carmo",
            ],
            [
                "ibge_codigo"       => 1713700,
                "ibge_estado_id" => 17,
                "nome"     => "Monte Santo do Tocantins",
            ],
            [
                "ibge_codigo"       => 1713809,
                "ibge_estado_id" => 17,
                "nome"     => "Palmeiras do Tocantins",
            ],
            [
                "ibge_codigo"       => 1713957,
                "ibge_estado_id" => 17,
                "nome"     => "Muricilândia",
            ],
            [
                "ibge_codigo"       => 1714203,
                "ibge_estado_id" => 17,
                "nome"     => "Natividade",
            ],
            [
                "ibge_codigo"       => 1714302,
                "ibge_estado_id" => 17,
                "nome"     => "Nazaré",
            ],
            [
                "ibge_codigo"       => 1714880,
                "ibge_estado_id" => 17,
                "nome"     => "Nova Olinda",
            ],
            [
                "ibge_codigo"       => 1715002,
                "ibge_estado_id" => 17,
                "nome"     => "Nova Rosalândia",
            ],
            [
                "ibge_codigo"       => 1715101,
                "ibge_estado_id" => 17,
                "nome"     => "Novo Acordo",
            ],
            [
                "ibge_codigo"       => 1715150,
                "ibge_estado_id" => 17,
                "nome"     => "Novo Alegre",
            ],
            [
                "ibge_codigo"       => 1715259,
                "ibge_estado_id" => 17,
                "nome"     => "Novo Jardim",
            ],
            [
                "ibge_codigo"       => 1715507,
                "ibge_estado_id" => 17,
                "nome"     => "Oliveira de Fátima",
            ],
            [
                "ibge_codigo"       => 1715705,
                "ibge_estado_id" => 17,
                "nome"     => "Palmeirante",
            ],
            [
                "ibge_codigo"       => 1715754,
                "ibge_estado_id" => 17,
                "nome"     => "Palmeirópolis",
            ],
            [
                "ibge_codigo"       => 1716109,
                "ibge_estado_id" => 17,
                "nome"     => "Paraíso do Tocantins",
            ],
            [
                "ibge_codigo"       => 1716208,
                "ibge_estado_id" => 17,
                "nome"     => "Paranã",
            ],
            [
                "ibge_codigo"       => 1716307,
                "ibge_estado_id" => 17,
                "nome"     => "Pau d'Arco",
            ],
            [
                "ibge_codigo"       => 1716505,
                "ibge_estado_id" => 17,
                "nome"     => "Pedro Afonso",
            ],
            [
                "ibge_codigo"       => 1716604,
                "ibge_estado_id" => 17,
                "nome"     => "Peixe",
            ],
            [
                "ibge_codigo"       => 1716653,
                "ibge_estado_id" => 17,
                "nome"     => "Pequizeiro",
            ],
            [
                "ibge_codigo"       => 1716703,
                "ibge_estado_id" => 17,
                "nome"     => "Colméia",
            ],
            [
                "ibge_codigo"       => 1717008,
                "ibge_estado_id" => 17,
                "nome"     => "Pindorama do Tocantins",
            ],
            [
                "ibge_codigo"       => 1717206,
                "ibge_estado_id" => 17,
                "nome"     => "Piraquê",
            ],
            [
                "ibge_codigo"       => 1717503,
                "ibge_estado_id" => 17,
                "nome"     => "Pium",
            ],
            [
                "ibge_codigo"       => 1717800,
                "ibge_estado_id" => 17,
                "nome"     => "Ponte Alta do Bom Jesus",
            ],
            [
                "ibge_codigo"       => 1717909,
                "ibge_estado_id" => 17,
                "nome"     => "Ponte Alta do Tocantins",
            ],
            [
                "ibge_codigo"       => 1718006,
                "ibge_estado_id" => 17,
                "nome"     => "Porto Alegre do Tocantins",
            ],
            [
                "ibge_codigo"       => 1718204,
                "ibge_estado_id" => 17,
                "nome"     => "Porto Nacional",
            ],
            [
                "ibge_codigo"       => 1718303,
                "ibge_estado_id" => 17,
                "nome"     => "Praia Norte",
            ],
            [
                "ibge_codigo"       => 1718402,
                "ibge_estado_id" => 17,
                "nome"     => "Presidente Kennedy",
            ],
            [
                "ibge_codigo"       => 1718451,
                "ibge_estado_id" => 17,
                "nome"     => "Pugmil",
            ],
            [
                "ibge_codigo"       => 1718501,
                "ibge_estado_id" => 17,
                "nome"     => "Recursolândia",
            ],
            [
                "ibge_codigo"       => 1718550,
                "ibge_estado_id" => 17,
                "nome"     => "Riachinho",
            ],
            [
                "ibge_codigo"       => 1718659,
                "ibge_estado_id" => 17,
                "nome"     => "Rio da Conceição",
            ],
            [
                "ibge_codigo"       => 1718709,
                "ibge_estado_id" => 17,
                "nome"     => "Rio dos Bois",
            ],
            [
                "ibge_codigo"       => 1718758,
                "ibge_estado_id" => 17,
                "nome"     => "Rio Sono",
            ],
            [
                "ibge_codigo"       => 1718808,
                "ibge_estado_id" => 17,
                "nome"     => "Sampaio",
            ],
            [
                "ibge_codigo"       => 1718840,
                "ibge_estado_id" => 17,
                "nome"     => "Sandolândia",
            ],
            [
                "ibge_codigo"       => 1718865,
                "ibge_estado_id" => 17,
                "nome"     => "Santa Fé do Araguaia",
            ],
            [
                "ibge_codigo"       => 1718881,
                "ibge_estado_id" => 17,
                "nome"     => "Santa Maria do Tocantins",
            ],
            [
                "ibge_codigo"       => 1718899,
                "ibge_estado_id" => 17,
                "nome"     => "Santa Rita do Tocantins",
            ],
            [
                "ibge_codigo"       => 1718907,
                "ibge_estado_id" => 17,
                "nome"     => "Santa Rosa do Tocantins",
            ],
            [
                "ibge_codigo"       => 1719004,
                "ibge_estado_id" => 17,
                "nome"     => "Santa Tereza do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720002,
                "ibge_estado_id" => 17,
                "nome"     => "Santa Terezinha do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720101,
                "ibge_estado_id" => 17,
                "nome"     => "São Bento do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720150,
                "ibge_estado_id" => 17,
                "nome"     => "São Félix do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720200,
                "ibge_estado_id" => 17,
                "nome"     => "São Miguel do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720259,
                "ibge_estado_id" => 17,
                "nome"     => "São Salvador do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720309,
                "ibge_estado_id" => 17,
                "nome"     => "São Sebastião do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720499,
                "ibge_estado_id" => 17,
                "nome"     => "São Valério",
            ],
            [
                "ibge_codigo"       => 1720655,
                "ibge_estado_id" => 17,
                "nome"     => "Silvanópolis",
            ],
            [
                "ibge_codigo"       => 1720804,
                "ibge_estado_id" => 17,
                "nome"     => "Sítio Novo do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720853,
                "ibge_estado_id" => 17,
                "nome"     => "Sucupira",
            ],
            [
                "ibge_codigo"       => 1720903,
                "ibge_estado_id" => 17,
                "nome"     => "Taguatinga",
            ],
            [
                "ibge_codigo"       => 1720937,
                "ibge_estado_id" => 17,
                "nome"     => "Taipas do Tocantins",
            ],
            [
                "ibge_codigo"       => 1720978,
                "ibge_estado_id" => 17,
                "nome"     => "Talismã",
            ],
            [
                "ibge_codigo"       => 1721000,
                "ibge_estado_id" => 17,
                "nome"     => "Palmas",
            ],
            [
                "ibge_codigo"       => 1721109,
                "ibge_estado_id" => 17,
                "nome"     => "Tocantínia",
            ],
            [
                "ibge_codigo"       => 1721208,
                "ibge_estado_id" => 17,
                "nome"     => "Tocantinópolis",
            ],
            [
                "ibge_codigo"       => 1721257,
                "ibge_estado_id" => 17,
                "nome"     => "Tupirama",
            ],
            [
                "ibge_codigo"       => 1721307,
                "ibge_estado_id" => 17,
                "nome"     => "Tupiratins",
            ],
            [
                "ibge_codigo"       => 1722081,
                "ibge_estado_id" => 17,
                "nome"     => "Wanderlândia",
            ],
            [
                "ibge_codigo"       => 1722107,
                "ibge_estado_id" => 17,
                "nome"     => "Xambioá",
            ],
            [
                "ibge_codigo"       => 2100055,
                "ibge_estado_id" => 21,
                "nome"     => "Açailândia",
            ],
            [
                "ibge_codigo"       => 2100105,
                "ibge_estado_id" => 21,
                "nome"     => "Afonso Cunha",
            ],
            [
                "ibge_codigo"       => 2100154,
                "ibge_estado_id" => 21,
                "nome"     => "Água Doce do Maranhão",
            ],
            [
                "ibge_codigo"       => 2100204,
                "ibge_estado_id" => 21,
                "nome"     => "Alcântara",
            ],
            [
                "ibge_codigo"       => 2100303,
                "ibge_estado_id" => 21,
                "nome"     => "Aldeias Altas",
            ],
            [
                "ibge_codigo"       => 2100402,
                "ibge_estado_id" => 21,
                "nome"     => "Altamira do Maranhão",
            ],
            [
                "ibge_codigo"       => 2100436,
                "ibge_estado_id" => 21,
                "nome"     => "Alto Alegre do Maranhão",
            ],
            [
                "ibge_codigo"       => 2100477,
                "ibge_estado_id" => 21,
                "nome"     => "Alto Alegre do Pindaré",
            ],
            [
                "ibge_codigo"       => 2100501,
                "ibge_estado_id" => 21,
                "nome"     => "Alto Parnaíba",
            ],
            [
                "ibge_codigo"       => 2100550,
                "ibge_estado_id" => 21,
                "nome"     => "Amapá do Maranhão",
            ],
            [
                "ibge_codigo"       => 2100600,
                "ibge_estado_id" => 21,
                "nome"     => "Amarante do Maranhão",
            ],
            [
                "ibge_codigo"       => 2100709,
                "ibge_estado_id" => 21,
                "nome"     => "Anajatuba",
            ],
            [
                "ibge_codigo"       => 2100808,
                "ibge_estado_id" => 21,
                "nome"     => "Anapurus",
            ],
            [
                "ibge_codigo"       => 2100832,
                "ibge_estado_id" => 21,
                "nome"     => "Apicum-Açu",
            ],
            [
                "ibge_codigo"       => 2100873,
                "ibge_estado_id" => 21,
                "nome"     => "Araguanã",
            ],
            [
                "ibge_codigo"       => 2100907,
                "ibge_estado_id" => 21,
                "nome"     => "Araioses",
            ],
            [
                "ibge_codigo"       => 2100956,
                "ibge_estado_id" => 21,
                "nome"     => "Arame",
            ],
            [
                "ibge_codigo"       => 2101004,
                "ibge_estado_id" => 21,
                "nome"     => "Arari",
            ],
            [
                "ibge_codigo"       => 2101103,
                "ibge_estado_id" => 21,
                "nome"     => "Axixá",
            ],
            [
                "ibge_codigo"       => 2101202,
                "ibge_estado_id" => 21,
                "nome"     => "Bacabal",
            ],
            [
                "ibge_codigo"       => 2101251,
                "ibge_estado_id" => 21,
                "nome"     => "Bacabeira",
            ],
            [
                "ibge_codigo"       => 2101301,
                "ibge_estado_id" => 21,
                "nome"     => "Bacuri",
            ],
            [
                "ibge_codigo"       => 2101350,
                "ibge_estado_id" => 21,
                "nome"     => "Bacurituba",
            ],
            [
                "ibge_codigo"       => 2101400,
                "ibge_estado_id" => 21,
                "nome"     => "Balsas",
            ],
            [
                "ibge_codigo"       => 2101509,
                "ibge_estado_id" => 21,
                "nome"     => "Barão de Grajaú",
            ],
            [
                "ibge_codigo"       => 2101608,
                "ibge_estado_id" => 21,
                "nome"     => "Barra do Corda",
            ],
            [
                "ibge_codigo"       => 2101707,
                "ibge_estado_id" => 21,
                "nome"     => "Barreirinhas",
            ],
            [
                "ibge_codigo"       => 2101731,
                "ibge_estado_id" => 21,
                "nome"     => "Belágua",
            ],
            [
                "ibge_codigo"       => 2101772,
                "ibge_estado_id" => 21,
                "nome"     => "Bela Vista do Maranhão",
            ],
            [
                "ibge_codigo"       => 2101806,
                "ibge_estado_id" => 21,
                "nome"     => "Benedito Leite",
            ],
            [
                "ibge_codigo"       => 2101905,
                "ibge_estado_id" => 21,
                "nome"     => "Bequimão",
            ],
            [
                "ibge_codigo"       => 2101939,
                "ibge_estado_id" => 21,
                "nome"     => "Bernardo do Mearim",
            ],
            [
                "ibge_codigo"       => 2101970,
                "ibge_estado_id" => 21,
                "nome"     => "Boa Vista do Gurupi",
            ],
            [
                "ibge_codigo"       => 2102002,
                "ibge_estado_id" => 21,
                "nome"     => "Bom Jardim",
            ],
            [
                "ibge_codigo"       => 2102036,
                "ibge_estado_id" => 21,
                "nome"     => "Bom Jesus das Selvas",
            ],
            [
                "ibge_codigo"       => 2102077,
                "ibge_estado_id" => 21,
                "nome"     => "Bom Lugar",
            ],
            [
                "ibge_codigo"       => 2102101,
                "ibge_estado_id" => 21,
                "nome"     => "Brejo",
            ],
            [
                "ibge_codigo"       => 2102150,
                "ibge_estado_id" => 21,
                "nome"     => "Brejo de Areia",
            ],
            [
                "ibge_codigo"       => 2102200,
                "ibge_estado_id" => 21,
                "nome"     => "Buriti",
            ],
            [
                "ibge_codigo"       => 2102309,
                "ibge_estado_id" => 21,
                "nome"     => "Buriti Bravo",
            ],
            [
                "ibge_codigo"       => 2102325,
                "ibge_estado_id" => 21,
                "nome"     => "Buriticupu",
            ],
            [
                "ibge_codigo"       => 2102358,
                "ibge_estado_id" => 21,
                "nome"     => "Buritirana",
            ],
            [
                "ibge_codigo"       => 2102374,
                "ibge_estado_id" => 21,
                "nome"     => "Cachoeira Grande",
            ],
            [
                "ibge_codigo"       => 2102408,
                "ibge_estado_id" => 21,
                "nome"     => "Cajapió",
            ],
            [
                "ibge_codigo"       => 2102507,
                "ibge_estado_id" => 21,
                "nome"     => "Cajari",
            ],
            [
                "ibge_codigo"       => 2102556,
                "ibge_estado_id" => 21,
                "nome"     => "Campestre do Maranhão",
            ],
            [
                "ibge_codigo"       => 2102606,
                "ibge_estado_id" => 21,
                "nome"     => "Cândido Mendes",
            ],
            [
                "ibge_codigo"       => 2102705,
                "ibge_estado_id" => 21,
                "nome"     => "Cantanhede",
            ],
            [
                "ibge_codigo"       => 2102754,
                "ibge_estado_id" => 21,
                "nome"     => "Capinzal do Norte",
            ],
            [
                "ibge_codigo"       => 2102804,
                "ibge_estado_id" => 21,
                "nome"     => "Carolina",
            ],
            [
                "ibge_codigo"       => 2102903,
                "ibge_estado_id" => 21,
                "nome"     => "Carutapera",
            ],
            [
                "ibge_codigo"       => 2103000,
                "ibge_estado_id" => 21,
                "nome"     => "Caxias",
            ],
            [
                "ibge_codigo"       => 2103109,
                "ibge_estado_id" => 21,
                "nome"     => "Cedral",
            ],
            [
                "ibge_codigo"       => 2103125,
                "ibge_estado_id" => 21,
                "nome"     => "Central do Maranhão",
            ],
            [
                "ibge_codigo"       => 2103158,
                "ibge_estado_id" => 21,
                "nome"     => "Centro do Guilherme",
            ],
            [
                "ibge_codigo"       => 2103174,
                "ibge_estado_id" => 21,
                "nome"     => "Centro Novo do Maranhão",
            ],
            [
                "ibge_codigo"       => 2103208,
                "ibge_estado_id" => 21,
                "nome"     => "Chapadinha",
            ],
            [
                "ibge_codigo"       => 2103257,
                "ibge_estado_id" => 21,
                "nome"     => "Cidelândia",
            ],
            [
                "ibge_codigo"       => 2103307,
                "ibge_estado_id" => 21,
                "nome"     => "Codó",
            ],
            [
                "ibge_codigo"       => 2103406,
                "ibge_estado_id" => 21,
                "nome"     => "Coelho Neto",
            ],
            [
                "ibge_codigo"       => 2103505,
                "ibge_estado_id" => 21,
                "nome"     => "Colinas",
            ],
            [
                "ibge_codigo"       => 2103554,
                "ibge_estado_id" => 21,
                "nome"     => "Conceição do Lago-Açu",
            ],
            [
                "ibge_codigo"       => 2103604,
                "ibge_estado_id" => 21,
                "nome"     => "Coroatá",
            ],
            [
                "ibge_codigo"       => 2103703,
                "ibge_estado_id" => 21,
                "nome"     => "Cururupu",
            ],
            [
                "ibge_codigo"       => 2103752,
                "ibge_estado_id" => 21,
                "nome"     => "Davinópolis",
            ],
            [
                "ibge_codigo"       => 2103802,
                "ibge_estado_id" => 21,
                "nome"     => "Dom Pedro",
            ],
            [
                "ibge_codigo"       => 2103901,
                "ibge_estado_id" => 21,
                "nome"     => "Duque Bacelar",
            ],
            [
                "ibge_codigo"       => 2104008,
                "ibge_estado_id" => 21,
                "nome"     => "Esperantinópolis",
            ],
            [
                "ibge_codigo"       => 2104057,
                "ibge_estado_id" => 21,
                "nome"     => "Estreito",
            ],
            [
                "ibge_codigo"       => 2104073,
                "ibge_estado_id" => 21,
                "nome"     => "Feira Nova do Maranhão",
            ],
            [
                "ibge_codigo"       => 2104081,
                "ibge_estado_id" => 21,
                "nome"     => "Fernando Falcão",
            ],
            [
                "ibge_codigo"       => 2104099,
                "ibge_estado_id" => 21,
                "nome"     => "Formosa da Serra Negra",
            ],
            [
                "ibge_codigo"       => 2104107,
                "ibge_estado_id" => 21,
                "nome"     => "Fortaleza dos Nogueiras",
            ],
            [
                "ibge_codigo"       => 2104206,
                "ibge_estado_id" => 21,
                "nome"     => "Fortuna",
            ],
            [
                "ibge_codigo"       => 2104305,
                "ibge_estado_id" => 21,
                "nome"     => "Godofredo Viana",
            ],
            [
                "ibge_codigo"       => 2104404,
                "ibge_estado_id" => 21,
                "nome"     => "Gonçalves Dias",
            ],
            [
                "ibge_codigo"       => 2104503,
                "ibge_estado_id" => 21,
                "nome"     => "Governador Archer",
            ],
            [
                "ibge_codigo"       => 2104552,
                "ibge_estado_id" => 21,
                "nome"     => "Governador Edison Lobão",
            ],
            [
                "ibge_codigo"       => 2104602,
                "ibge_estado_id" => 21,
                "nome"     => "Governador Eugênio Barros",
            ],
            [
                "ibge_codigo"       => 2104628,
                "ibge_estado_id" => 21,
                "nome"     => "Governador Luiz Rocha",
            ],
            [
                "ibge_codigo"       => 2104651,
                "ibge_estado_id" => 21,
                "nome"     => "Governador Newton Bello",
            ],
            [
                "ibge_codigo"       => 2104677,
                "ibge_estado_id" => 21,
                "nome"     => "Governador Nunes Freire",
            ],
            [
                "ibge_codigo"       => 2104701,
                "ibge_estado_id" => 21,
                "nome"     => "Graça Aranha",
            ],
            [
                "ibge_codigo"       => 2104800,
                "ibge_estado_id" => 21,
                "nome"     => "Grajaú",
            ],
            [
                "ibge_codigo"       => 2104909,
                "ibge_estado_id" => 21,
                "nome"     => "Guimarães",
            ],
            [
                "ibge_codigo"       => 2105005,
                "ibge_estado_id" => 21,
                "nome"     => "Humberto de Campos",
            ],
            [
                "ibge_codigo"       => 2105104,
                "ibge_estado_id" => 21,
                "nome"     => "Icatu",
            ],
            [
                "ibge_codigo"       => 2105153,
                "ibge_estado_id" => 21,
                "nome"     => "Igarapé do Meio",
            ],
            [
                "ibge_codigo"       => 2105203,
                "ibge_estado_id" => 21,
                "nome"     => "Igarapé Grande",
            ],
            [
                "ibge_codigo"       => 2105302,
                "ibge_estado_id" => 21,
                "nome"     => "Imperatriz",
            ],
            [
                "ibge_codigo"       => 2105351,
                "ibge_estado_id" => 21,
                "nome"     => "Itaipava do Grajaú",
            ],
            [
                "ibge_codigo"       => 2105401,
                "ibge_estado_id" => 21,
                "nome"     => "Itapecuru Mirim",
            ],
            [
                "ibge_codigo"       => 2105427,
                "ibge_estado_id" => 21,
                "nome"     => "Itinga do Maranhão",
            ],
            [
                "ibge_codigo"       => 2105450,
                "ibge_estado_id" => 21,
                "nome"     => "Jatobá",
            ],
            [
                "ibge_codigo"       => 2105476,
                "ibge_estado_id" => 21,
                "nome"     => "Jenipapo dos Vieiras",
            ],
            [
                "ibge_codigo"       => 2105500,
                "ibge_estado_id" => 21,
                "nome"     => "João Lisboa",
            ],
            [
                "ibge_codigo"       => 2105609,
                "ibge_estado_id" => 21,
                "nome"     => "Joselândia",
            ],
            [
                "ibge_codigo"       => 2105658,
                "ibge_estado_id" => 21,
                "nome"     => "Junco do Maranhão",
            ],
            [
                "ibge_codigo"       => 2105708,
                "ibge_estado_id" => 21,
                "nome"     => "Lago da Pedra",
            ],
            [
                "ibge_codigo"       => 2105807,
                "ibge_estado_id" => 21,
                "nome"     => "Lago do Junco",
            ],
            [
                "ibge_codigo"       => 2105906,
                "ibge_estado_id" => 21,
                "nome"     => "Lago Verde",
            ],
            [
                "ibge_codigo"       => 2105922,
                "ibge_estado_id" => 21,
                "nome"     => "Lagoa do Mato",
            ],
            [
                "ibge_codigo"       => 2105948,
                "ibge_estado_id" => 21,
                "nome"     => "Lago dos Rodrigues",
            ],
            [
                "ibge_codigo"       => 2105963,
                "ibge_estado_id" => 21,
                "nome"     => "Lagoa Grande do Maranhão",
            ],
            [
                "ibge_codigo"       => 2105989,
                "ibge_estado_id" => 21,
                "nome"     => "Lajeado Novo",
            ],
            [
                "ibge_codigo"       => 2106003,
                "ibge_estado_id" => 21,
                "nome"     => "Lima Campos",
            ],
            [
                "ibge_codigo"       => 2106102,
                "ibge_estado_id" => 21,
                "nome"     => "Loreto",
            ],
            [
                "ibge_codigo"       => 2106201,
                "ibge_estado_id" => 21,
                "nome"     => "Luís Domingues",
            ],
            [
                "ibge_codigo"       => 2106300,
                "ibge_estado_id" => 21,
                "nome"     => "Magalhães de Almeida",
            ],
            [
                "ibge_codigo"       => 2106326,
                "ibge_estado_id" => 21,
                "nome"     => "Maracaçumé",
            ],
            [
                "ibge_codigo"       => 2106359,
                "ibge_estado_id" => 21,
                "nome"     => "Marajá do Sena",
            ],
            [
                "ibge_codigo"       => 2106375,
                "ibge_estado_id" => 21,
                "nome"     => "Maranhãozinho",
            ],
            [
                "ibge_codigo"       => 2106409,
                "ibge_estado_id" => 21,
                "nome"     => "Mata Roma",
            ],
            [
                "ibge_codigo"       => 2106508,
                "ibge_estado_id" => 21,
                "nome"     => "Matinha",
            ],
            [
                "ibge_codigo"       => 2106607,
                "ibge_estado_id" => 21,
                "nome"     => "Matões",
            ],
            [
                "ibge_codigo"       => 2106631,
                "ibge_estado_id" => 21,
                "nome"     => "Matões do Norte",
            ],
            [
                "ibge_codigo"       => 2106672,
                "ibge_estado_id" => 21,
                "nome"     => "Milagres do Maranhão",
            ],
            [
                "ibge_codigo"       => 2106706,
                "ibge_estado_id" => 21,
                "nome"     => "Mirador",
            ],
            [
                "ibge_codigo"       => 2106755,
                "ibge_estado_id" => 21,
                "nome"     => "Miranda do Norte",
            ],
            [
                "ibge_codigo"       => 2106805,
                "ibge_estado_id" => 21,
                "nome"     => "Mirinzal",
            ],
            [
                "ibge_codigo"       => 2106904,
                "ibge_estado_id" => 21,
                "nome"     => "Monção",
            ],
            [
                "ibge_codigo"       => 2107001,
                "ibge_estado_id" => 21,
                "nome"     => "Montes Altos",
            ],
            [
                "ibge_codigo"       => 2107100,
                "ibge_estado_id" => 21,
                "nome"     => "Morros",
            ],
            [
                "ibge_codigo"       => 2107209,
                "ibge_estado_id" => 21,
                "nome"     => "Nina Rodrigues",
            ],
            [
                "ibge_codigo"       => 2107258,
                "ibge_estado_id" => 21,
                "nome"     => "Nova Colinas",
            ],
            [
                "ibge_codigo"       => 2107308,
                "ibge_estado_id" => 21,
                "nome"     => "Nova Iorque",
            ],
            [
                "ibge_codigo"       => 2107357,
                "ibge_estado_id" => 21,
                "nome"     => "Nova Olinda do Maranhão",
            ],
            [
                "ibge_codigo"       => 2107407,
                "ibge_estado_id" => 21,
                "nome"     => "Olho d'Água das Cunhãs",
            ],
            [
                "ibge_codigo"       => 2107456,
                "ibge_estado_id" => 21,
                "nome"     => "Olinda Nova do Maranhão",
            ],
            [
                "ibge_codigo"       => 2107506,
                "ibge_estado_id" => 21,
                "nome"     => "Paço do Lumiar",
            ],
            [
                "ibge_codigo"       => 2107605,
                "ibge_estado_id" => 21,
                "nome"     => "Palmeirândia",
            ],
            [
                "ibge_codigo"       => 2107704,
                "ibge_estado_id" => 21,
                "nome"     => "Paraibano",
            ],
            [
                "ibge_codigo"       => 2107803,
                "ibge_estado_id" => 21,
                "nome"     => "Parnarama",
            ],
            [
                "ibge_codigo"       => 2107902,
                "ibge_estado_id" => 21,
                "nome"     => "Passagem Franca",
            ],
            [
                "ibge_codigo"       => 2108009,
                "ibge_estado_id" => 21,
                "nome"     => "Pastos Bons",
            ],
            [
                "ibge_codigo"       => 2108058,
                "ibge_estado_id" => 21,
                "nome"     => "Paulino Neves",
            ],
            [
                "ibge_codigo"       => 2108108,
                "ibge_estado_id" => 21,
                "nome"     => "Paulo Ramos",
            ],
            [
                "ibge_codigo"       => 2108207,
                "ibge_estado_id" => 21,
                "nome"     => "Pedreiras",
            ],
            [
                "ibge_codigo"       => 2108256,
                "ibge_estado_id" => 21,
                "nome"     => "Pedro do Rosário",
            ],
            [
                "ibge_codigo"       => 2108306,
                "ibge_estado_id" => 21,
                "nome"     => "Penalva",
            ],
            [
                "ibge_codigo"       => 2108405,
                "ibge_estado_id" => 21,
                "nome"     => "Peri Mirim",
            ],
            [
                "ibge_codigo"       => 2108454,
                "ibge_estado_id" => 21,
                "nome"     => "Peritoró",
            ],
            [
                "ibge_codigo"       => 2108504,
                "ibge_estado_id" => 21,
                "nome"     => "Pindaré-Mirim",
            ],
            [
                "ibge_codigo"       => 2108603,
                "ibge_estado_id" => 21,
                "nome"     => "Pinheiro",
            ],
            [
                "ibge_codigo"       => 2108702,
                "ibge_estado_id" => 21,
                "nome"     => "Pio XII",
            ],
            [
                "ibge_codigo"       => 2108801,
                "ibge_estado_id" => 21,
                "nome"     => "Pirapemas",
            ],
            [
                "ibge_codigo"       => 2108900,
                "ibge_estado_id" => 21,
                "nome"     => "Poção de Pedras",
            ],
            [
                "ibge_codigo"       => 2109007,
                "ibge_estado_id" => 21,
                "nome"     => "Porto Franco",
            ],
            [
                "ibge_codigo"       => 2109056,
                "ibge_estado_id" => 21,
                "nome"     => "Porto Rico do Maranhão",
            ],
            [
                "ibge_codigo"       => 2109106,
                "ibge_estado_id" => 21,
                "nome"     => "Presidente Dutra",
            ],
            [
                "ibge_codigo"       => 2109205,
                "ibge_estado_id" => 21,
                "nome"     => "Presidente Juscelino",
            ],
            [
                "ibge_codigo"       => 2109239,
                "ibge_estado_id" => 21,
                "nome"     => "Presidente Médici",
            ],
            [
                "ibge_codigo"       => 2109270,
                "ibge_estado_id" => 21,
                "nome"     => "Presidente Sarney",
            ],
            [
                "ibge_codigo"       => 2109304,
                "ibge_estado_id" => 21,
                "nome"     => "Presidente Vargas",
            ],
            [
                "ibge_codigo"       => 2109403,
                "ibge_estado_id" => 21,
                "nome"     => "Primeira Cruz",
            ],
            [
                "ibge_codigo"       => 2109452,
                "ibge_estado_id" => 21,
                "nome"     => "Raposa",
            ],
            [
                "ibge_codigo"       => 2109502,
                "ibge_estado_id" => 21,
                "nome"     => "Riachão",
            ],
            [
                "ibge_codigo"       => 2109551,
                "ibge_estado_id" => 21,
                "nome"     => "Ribamar Fiquene",
            ],
            [
                "ibge_codigo"       => 2109601,
                "ibge_estado_id" => 21,
                "nome"     => "Rosário",
            ],
            [
                "ibge_codigo"       => 2109700,
                "ibge_estado_id" => 21,
                "nome"     => "Sambaíba",
            ],
            [
                "ibge_codigo"       => 2109759,
                "ibge_estado_id" => 21,
                "nome"     => "Santa Filomena do Maranhão",
            ],
            [
                "ibge_codigo"       => 2109809,
                "ibge_estado_id" => 21,
                "nome"     => "Santa Helena",
            ],
            [
                "ibge_codigo"       => 2109908,
                "ibge_estado_id" => 21,
                "nome"     => "Santa Inês",
            ],
            [
                "ibge_codigo"       => 2110005,
                "ibge_estado_id" => 21,
                "nome"     => "Santa Luzia",
            ],
            [
                "ibge_codigo"       => 2110039,
                "ibge_estado_id" => 21,
                "nome"     => "Santa Luzia do Paruá",
            ],
            [
                "ibge_codigo"       => 2110104,
                "ibge_estado_id" => 21,
                "nome"     => "Santa Quitéria do Maranhão",
            ],
            [
                "ibge_codigo"       => 2110203,
                "ibge_estado_id" => 21,
                "nome"     => "Santa Rita",
            ],
            [
                "ibge_codigo"       => 2110237,
                "ibge_estado_id" => 21,
                "nome"     => "Santana do Maranhão",
            ],
            [
                "ibge_codigo"       => 2110278,
                "ibge_estado_id" => 21,
                "nome"     => "Santo Amaro do Maranhão",
            ],
            [
                "ibge_codigo"       => 2110302,
                "ibge_estado_id" => 21,
                "nome"     => "Santo Antônio dos Lopes",
            ],
            [
                "ibge_codigo"       => 2110401,
                "ibge_estado_id" => 21,
                "nome"     => "São Benedito do Rio Preto",
            ],
            [
                "ibge_codigo"       => 2110500,
                "ibge_estado_id" => 21,
                "nome"     => "São Bento",
            ],
            [
                "ibge_codigo"       => 2110609,
                "ibge_estado_id" => 21,
                "nome"     => "São Bernardo",
            ],
            [
                "ibge_codigo"       => 2110658,
                "ibge_estado_id" => 21,
                "nome"     => "São Domingos do Azeitão",
            ],
            [
                "ibge_codigo"       => 2110708,
                "ibge_estado_id" => 21,
                "nome"     => "São Domingos do Maranhão",
            ],
            [
                "ibge_codigo"       => 2110807,
                "ibge_estado_id" => 21,
                "nome"     => "São Félix de Balsas",
            ],
            [
                "ibge_codigo"       => 2110856,
                "ibge_estado_id" => 21,
                "nome"     => "São Francisco do Brejão",
            ],
            [
                "ibge_codigo"       => 2110906,
                "ibge_estado_id" => 21,
                "nome"     => "São Francisco do Maranhão",
            ],
            [
                "ibge_codigo"       => 2111003,
                "ibge_estado_id" => 21,
                "nome"     => "São João Batista",
            ],
            [
                "ibge_codigo"       => 2111029,
                "ibge_estado_id" => 21,
                "nome"     => "São João do Carú",
            ],
            [
                "ibge_codigo"       => 2111052,
                "ibge_estado_id" => 21,
                "nome"     => "São João do Paraíso",
            ],
            [
                "ibge_codigo"       => 2111078,
                "ibge_estado_id" => 21,
                "nome"     => "São João do Soter",
            ],
            [
                "ibge_codigo"       => 2111102,
                "ibge_estado_id" => 21,
                "nome"     => "São João dos Patos",
            ],
            [
                "ibge_codigo"       => 2111201,
                "ibge_estado_id" => 21,
                "nome"     => "São José de Ribamar",
            ],
            [
                "ibge_codigo"       => 2111250,
                "ibge_estado_id" => 21,
                "nome"     => "São José dos Basílios",
            ],
            [
                "ibge_codigo"       => 2111300,
                "ibge_estado_id" => 21,
                "nome"     => "São Luís",
            ],
            [
                "ibge_codigo"       => 2111409,
                "ibge_estado_id" => 21,
                "nome"     => "São Luís Gonzaga do Maranhão",
            ],
            [
                "ibge_codigo"       => 2111508,
                "ibge_estado_id" => 21,
                "nome"     => "São Mateus do Maranhão",
            ],
            [
                "ibge_codigo"       => 2111532,
                "ibge_estado_id" => 21,
                "nome"     => "São Pedro da Água Branca",
            ],
            [
                "ibge_codigo"       => 2111573,
                "ibge_estado_id" => 21,
                "nome"     => "São Pedro dos Crentes",
            ],
            [
                "ibge_codigo"       => 2111607,
                "ibge_estado_id" => 21,
                "nome"     => "São Raimundo das Mangabeiras",
            ],
            [
                "ibge_codigo"       => 2111631,
                "ibge_estado_id" => 21,
                "nome"     => "São Raimundo do Doca Bezerra",
            ],
            [
                "ibge_codigo"       => 2111672,
                "ibge_estado_id" => 21,
                "nome"     => "São Roberto",
            ],
            [
                "ibge_codigo"       => 2111706,
                "ibge_estado_id" => 21,
                "nome"     => "São Vicente Ferrer",
            ],
            [
                "ibge_codigo"       => 2111722,
                "ibge_estado_id" => 21,
                "nome"     => "Satubinha",
            ],
            [
                "ibge_codigo"       => 2111748,
                "ibge_estado_id" => 21,
                "nome"     => "Senador Alexandre Costa",
            ],
            [
                "ibge_codigo"       => 2111763,
                "ibge_estado_id" => 21,
                "nome"     => "Senador La Rocque",
            ],
            [
                "ibge_codigo"       => 2111789,
                "ibge_estado_id" => 21,
                "nome"     => "Serrano do Maranhão",
            ],
            [
                "ibge_codigo"       => 2111805,
                "ibge_estado_id" => 21,
                "nome"     => "Sítio Novo",
            ],
            [
                "ibge_codigo"       => 2111904,
                "ibge_estado_id" => 21,
                "nome"     => "Sucupira do Norte",
            ],
            [
                "ibge_codigo"       => 2111953,
                "ibge_estado_id" => 21,
                "nome"     => "Sucupira do Riachão",
            ],
            [
                "ibge_codigo"       => 2112001,
                "ibge_estado_id" => 21,
                "nome"     => "Tasso Fragoso",
            ],
            [
                "ibge_codigo"       => 2112100,
                "ibge_estado_id" => 21,
                "nome"     => "Timbiras",
            ],
            [
                "ibge_codigo"       => 2112209,
                "ibge_estado_id" => 21,
                "nome"     => "Timon",
            ],
            [
                "ibge_codigo"       => 2112233,
                "ibge_estado_id" => 21,
                "nome"     => "Trizidela do Vale",
            ],
            [
                "ibge_codigo"       => 2112274,
                "ibge_estado_id" => 21,
                "nome"     => "Tufilândia",
            ],
            [
                "ibge_codigo"       => 2112308,
                "ibge_estado_id" => 21,
                "nome"     => "Tuntum",
            ],
            [
                "ibge_codigo"       => 2112407,
                "ibge_estado_id" => 21,
                "nome"     => "Turiaçu",
            ],
            [
                "ibge_codigo"       => 2112456,
                "ibge_estado_id" => 21,
                "nome"     => "Turilândia",
            ],
            [
                "ibge_codigo"       => 2112506,
                "ibge_estado_id" => 21,
                "nome"     => "Tutóia",
            ],
            [
                "ibge_codigo"       => 2112605,
                "ibge_estado_id" => 21,
                "nome"     => "Urbano Santos",
            ],
            [
                "ibge_codigo"       => 2112704,
                "ibge_estado_id" => 21,
                "nome"     => "Vargem Grande",
            ],
            [
                "ibge_codigo"       => 2112803,
                "ibge_estado_id" => 21,
                "nome"     => "Viana",
            ],
            [
                "ibge_codigo"       => 2112852,
                "ibge_estado_id" => 21,
                "nome"     => "Vila Nova dos Martírios",
            ],
            [
                "ibge_codigo"       => 2112902,
                "ibge_estado_id" => 21,
                "nome"     => "Vitória do Mearim",
            ],
            [
                "ibge_codigo"       => 2113009,
                "ibge_estado_id" => 21,
                "nome"     => "Vitorino Freire",
            ],
            [
                "ibge_codigo"       => 2114007,
                "ibge_estado_id" => 21,
                "nome"     => "Zé Doca",
            ],
            [
                "ibge_codigo"       => 2200053,
                "ibge_estado_id" => 22,
                "nome"     => "Acauã",
            ],
            [
                "ibge_codigo"       => 2200103,
                "ibge_estado_id" => 22,
                "nome"     => "Agricolândia",
            ],
            [
                "ibge_codigo"       => 2200202,
                "ibge_estado_id" => 22,
                "nome"     => "Água Branca",
            ],
            [
                "ibge_codigo"       => 2200251,
                "ibge_estado_id" => 22,
                "nome"     => "Alagoinha do Piauí",
            ],
            [
                "ibge_codigo"       => 2200277,
                "ibge_estado_id" => 22,
                "nome"     => "Alegrete do Piauí",
            ],
            [
                "ibge_codigo"       => 2200301,
                "ibge_estado_id" => 22,
                "nome"     => "Alto Longá",
            ],
            [
                "ibge_codigo"       => 2200400,
                "ibge_estado_id" => 22,
                "nome"     => "Altos",
            ],
            [
                "ibge_codigo"       => 2200459,
                "ibge_estado_id" => 22,
                "nome"     => "Alvorada do Gurguéia",
            ],
            [
                "ibge_codigo"       => 2200509,
                "ibge_estado_id" => 22,
                "nome"     => "Amarante",
            ],
            [
                "ibge_codigo"       => 2200608,
                "ibge_estado_id" => 22,
                "nome"     => "Angical do Piauí",
            ],
            [
                "ibge_codigo"       => 2200707,
                "ibge_estado_id" => 22,
                "nome"     => "Anísio de Abreu",
            ],
            [
                "ibge_codigo"       => 2200806,
                "ibge_estado_id" => 22,
                "nome"     => "Antônio Almeida",
            ],
            [
                "ibge_codigo"       => 2200905,
                "ibge_estado_id" => 22,
                "nome"     => "Aroazes",
            ],
            [
                "ibge_codigo"       => 2200954,
                "ibge_estado_id" => 22,
                "nome"     => "Aroeiras do Itaim",
            ],
            [
                "ibge_codigo"       => 2201002,
                "ibge_estado_id" => 22,
                "nome"     => "Arraial",
            ],
            [
                "ibge_codigo"       => 2201051,
                "ibge_estado_id" => 22,
                "nome"     => "Assunção do Piauí",
            ],
            [
                "ibge_codigo"       => 2201101,
                "ibge_estado_id" => 22,
                "nome"     => "Avelino Lopes",
            ],
            [
                "ibge_codigo"       => 2201150,
                "ibge_estado_id" => 22,
                "nome"     => "Baixa Grande do Ribeiro",
            ],
            [
                "ibge_codigo"       => 2201176,
                "ibge_estado_id" => 22,
                "nome"     => "Barra d'Alcântara",
            ],
            [
                "ibge_codigo"       => 2201200,
                "ibge_estado_id" => 22,
                "nome"     => "Barras",
            ],
            [
                "ibge_codigo"       => 2201309,
                "ibge_estado_id" => 22,
                "nome"     => "Barreiras do Piauí",
            ],
            [
                "ibge_codigo"       => 2201408,
                "ibge_estado_id" => 22,
                "nome"     => "Barro Duro",
            ],
            [
                "ibge_codigo"       => 2201507,
                "ibge_estado_id" => 22,
                "nome"     => "Batalha",
            ],
            [
                "ibge_codigo"       => 2201556,
                "ibge_estado_id" => 22,
                "nome"     => "Bela Vista do Piauí",
            ],
            [
                "ibge_codigo"       => 2201572,
                "ibge_estado_id" => 22,
                "nome"     => "Belém do Piauí",
            ],
            [
                "ibge_codigo"       => 2201606,
                "ibge_estado_id" => 22,
                "nome"     => "Beneditinos",
            ],
            [
                "ibge_codigo"       => 2201705,
                "ibge_estado_id" => 22,
                "nome"     => "Bertolínia",
            ],
            [
                "ibge_codigo"       => 2201739,
                "ibge_estado_id" => 22,
                "nome"     => "Betânia do Piauí",
            ],
            [
                "ibge_codigo"       => 2201770,
                "ibge_estado_id" => 22,
                "nome"     => "Boa Hora",
            ],
            [
                "ibge_codigo"       => 2201804,
                "ibge_estado_id" => 22,
                "nome"     => "Bocaina",
            ],
            [
                "ibge_codigo"       => 2201903,
                "ibge_estado_id" => 22,
                "nome"     => "Bom Jesus",
            ],
            [
                "ibge_codigo"       => 2201919,
                "ibge_estado_id" => 22,
                "nome"     => "Bom Princípio do Piauí",
            ],
            [
                "ibge_codigo"       => 2201929,
                "ibge_estado_id" => 22,
                "nome"     => "Bonfim do Piauí",
            ],
            [
                "ibge_codigo"       => 2201945,
                "ibge_estado_id" => 22,
                "nome"     => "Boqueirão do Piauí",
            ],
            [
                "ibge_codigo"       => 2201960,
                "ibge_estado_id" => 22,
                "nome"     => "Brasileira",
            ],
            [
                "ibge_codigo"       => 2201988,
                "ibge_estado_id" => 22,
                "nome"     => "Brejo do Piauí",
            ],
            [
                "ibge_codigo"       => 2202000,
                "ibge_estado_id" => 22,
                "nome"     => "Buriti dos Lopes",
            ],
            [
                "ibge_codigo"       => 2202026,
                "ibge_estado_id" => 22,
                "nome"     => "Buriti dos Montes",
            ],
            [
                "ibge_codigo"       => 2202059,
                "ibge_estado_id" => 22,
                "nome"     => "Cabeceiras do Piauí",
            ],
            [
                "ibge_codigo"       => 2202075,
                "ibge_estado_id" => 22,
                "nome"     => "Cajazeiras do Piauí",
            ],
            [
                "ibge_codigo"       => 2202083,
                "ibge_estado_id" => 22,
                "nome"     => "Cajueiro da Praia",
            ],
            [
                "ibge_codigo"       => 2202091,
                "ibge_estado_id" => 22,
                "nome"     => "Caldeirão Grande do Piauí",
            ],
            [
                "ibge_codigo"       => 2202109,
                "ibge_estado_id" => 22,
                "nome"     => "Campinas do Piauí",
            ],
            [
                "ibge_codigo"       => 2202117,
                "ibge_estado_id" => 22,
                "nome"     => "Campo Alegre do Fidalgo",
            ],
            [
                "ibge_codigo"       => 2202133,
                "ibge_estado_id" => 22,
                "nome"     => "Campo Grande do Piauí",
            ],
            [
                "ibge_codigo"       => 2202174,
                "ibge_estado_id" => 22,
                "nome"     => "Campo Largo do Piauí",
            ],
            [
                "ibge_codigo"       => 2202208,
                "ibge_estado_id" => 22,
                "nome"     => "Campo Maior",
            ],
            [
                "ibge_codigo"       => 2202251,
                "ibge_estado_id" => 22,
                "nome"     => "Canavieira",
            ],
            [
                "ibge_codigo"       => 2202307,
                "ibge_estado_id" => 22,
                "nome"     => "Canto do Buriti",
            ],
            [
                "ibge_codigo"       => 2202406,
                "ibge_estado_id" => 22,
                "nome"     => "Capitão de Campos",
            ],
            [
                "ibge_codigo"       => 2202455,
                "ibge_estado_id" => 22,
                "nome"     => "Capitão Gervásio Oliveira",
            ],
            [
                "ibge_codigo"       => 2202505,
                "ibge_estado_id" => 22,
                "nome"     => "Caracol",
            ],
            [
                "ibge_codigo"       => 2202539,
                "ibge_estado_id" => 22,
                "nome"     => "Caraúbas do Piauí",
            ],
            [
                "ibge_codigo"       => 2202554,
                "ibge_estado_id" => 22,
                "nome"     => "Caridade do Piauí",
            ],
            [
                "ibge_codigo"       => 2202604,
                "ibge_estado_id" => 22,
                "nome"     => "Castelo do Piauí",
            ],
            [
                "ibge_codigo"       => 2202653,
                "ibge_estado_id" => 22,
                "nome"     => "Caxingó",
            ],
            [
                "ibge_codigo"       => 2202703,
                "ibge_estado_id" => 22,
                "nome"     => "Cocal",
            ],
            [
                "ibge_codigo"       => 2202711,
                "ibge_estado_id" => 22,
                "nome"     => "Cocal de Telha",
            ],
            [
                "ibge_codigo"       => 2202729,
                "ibge_estado_id" => 22,
                "nome"     => "Cocal dos Alves",
            ],
            [
                "ibge_codigo"       => 2202737,
                "ibge_estado_id" => 22,
                "nome"     => "Coivaras",
            ],
            [
                "ibge_codigo"       => 2202752,
                "ibge_estado_id" => 22,
                "nome"     => "Colônia do Gurguéia",
            ],
            [
                "ibge_codigo"       => 2202778,
                "ibge_estado_id" => 22,
                "nome"     => "Colônia do Piauí",
            ],
            [
                "ibge_codigo"       => 2202802,
                "ibge_estado_id" => 22,
                "nome"     => "Conceição do Canindé",
            ],
            [
                "ibge_codigo"       => 2202851,
                "ibge_estado_id" => 22,
                "nome"     => "Coronel José Dias",
            ],
            [
                "ibge_codigo"       => 2202901,
                "ibge_estado_id" => 22,
                "nome"     => "Corrente",
            ],
            [
                "ibge_codigo"       => 2203008,
                "ibge_estado_id" => 22,
                "nome"     => "Cristalândia do Piauí",
            ],
            [
                "ibge_codigo"       => 2203107,
                "ibge_estado_id" => 22,
                "nome"     => "Cristino Castro",
            ],
            [
                "ibge_codigo"       => 2203206,
                "ibge_estado_id" => 22,
                "nome"     => "Curimatá",
            ],
            [
                "ibge_codigo"       => 2203230,
                "ibge_estado_id" => 22,
                "nome"     => "Currais",
            ],
            [
                "ibge_codigo"       => 2203255,
                "ibge_estado_id" => 22,
                "nome"     => "Curralinhos",
            ],
            [
                "ibge_codigo"       => 2203271,
                "ibge_estado_id" => 22,
                "nome"     => "Curral Novo do Piauí",
            ],
            [
                "ibge_codigo"       => 2203305,
                "ibge_estado_id" => 22,
                "nome"     => "Demerval Lobão",
            ],
            [
                "ibge_codigo"       => 2203354,
                "ibge_estado_id" => 22,
                "nome"     => "Dirceu Arcoverde",
            ],
            [
                "ibge_codigo"       => 2203404,
                "ibge_estado_id" => 22,
                "nome"     => "Dom Expedito Lopes",
            ],
            [
                "ibge_codigo"       => 2203420,
                "ibge_estado_id" => 22,
                "nome"     => "Domingos Mourão",
            ],
            [
                "ibge_codigo"       => 2203453,
                "ibge_estado_id" => 22,
                "nome"     => "Dom Inocêncio",
            ],
            [
                "ibge_codigo"       => 2203503,
                "ibge_estado_id" => 22,
                "nome"     => "Elesbão Veloso",
            ],
            [
                "ibge_codigo"       => 2203602,
                "ibge_estado_id" => 22,
                "nome"     => "Eliseu Martins",
            ],
            [
                "ibge_codigo"       => 2203701,
                "ibge_estado_id" => 22,
                "nome"     => "Esperantina",
            ],
            [
                "ibge_codigo"       => 2203750,
                "ibge_estado_id" => 22,
                "nome"     => "Fartura do Piauí",
            ],
            [
                "ibge_codigo"       => 2203800,
                "ibge_estado_id" => 22,
                "nome"     => "Flores do Piauí",
            ],
            [
                "ibge_codigo"       => 2203859,
                "ibge_estado_id" => 22,
                "nome"     => "Floresta do Piauí",
            ],
            [
                "ibge_codigo"       => 2203909,
                "ibge_estado_id" => 22,
                "nome"     => "Floriano",
            ],
            [
                "ibge_codigo"       => 2204006,
                "ibge_estado_id" => 22,
                "nome"     => "Francinópolis",
            ],
            [
                "ibge_codigo"       => 2204105,
                "ibge_estado_id" => 22,
                "nome"     => "Francisco Ayres",
            ],
            [
                "ibge_codigo"       => 2204154,
                "ibge_estado_id" => 22,
                "nome"     => "Francisco Macedo",
            ],
            [
                "ibge_codigo"       => 2204204,
                "ibge_estado_id" => 22,
                "nome"     => "Francisco Santos",
            ],
            [
                "ibge_codigo"       => 2204303,
                "ibge_estado_id" => 22,
                "nome"     => "Fronteiras",
            ],
            [
                "ibge_codigo"       => 2204352,
                "ibge_estado_id" => 22,
                "nome"     => "Geminiano",
            ],
            [
                "ibge_codigo"       => 2204402,
                "ibge_estado_id" => 22,
                "nome"     => "Gilbués",
            ],
            [
                "ibge_codigo"       => 2204501,
                "ibge_estado_id" => 22,
                "nome"     => "Guadalupe",
            ],
            [
                "ibge_codigo"       => 2204550,
                "ibge_estado_id" => 22,
                "nome"     => "Guaribas",
            ],
            [
                "ibge_codigo"       => 2204600,
                "ibge_estado_id" => 22,
                "nome"     => "Hugo Napoleão",
            ],
            [
                "ibge_codigo"       => 2204659,
                "ibge_estado_id" => 22,
                "nome"     => "Ilha Grande",
            ],
            [
                "ibge_codigo"       => 2204709,
                "ibge_estado_id" => 22,
                "nome"     => "Inhuma",
            ],
            [
                "ibge_codigo"       => 2204808,
                "ibge_estado_id" => 22,
                "nome"     => "Ipiranga do Piauí",
            ],
            [
                "ibge_codigo"       => 2204907,
                "ibge_estado_id" => 22,
                "nome"     => "Isaías Coelho",
            ],
            [
                "ibge_codigo"       => 2205003,
                "ibge_estado_id" => 22,
                "nome"     => "Itainópolis",
            ],
            [
                "ibge_codigo"       => 2205102,
                "ibge_estado_id" => 22,
                "nome"     => "Itaueira",
            ],
            [
                "ibge_codigo"       => 2205151,
                "ibge_estado_id" => 22,
                "nome"     => "Jacobina do Piauí",
            ],
            [
                "ibge_codigo"       => 2205201,
                "ibge_estado_id" => 22,
                "nome"     => "Jaicós",
            ],
            [
                "ibge_codigo"       => 2205250,
                "ibge_estado_id" => 22,
                "nome"     => "Jardim do Mulato",
            ],
            [
                "ibge_codigo"       => 2205276,
                "ibge_estado_id" => 22,
                "nome"     => "Jatobá do Piauí",
            ],
            [
                "ibge_codigo"       => 2205300,
                "ibge_estado_id" => 22,
                "nome"     => "Jerumenha",
            ],
            [
                "ibge_codigo"       => 2205359,
                "ibge_estado_id" => 22,
                "nome"     => "João Costa",
            ],
            [
                "ibge_codigo"       => 2205409,
                "ibge_estado_id" => 22,
                "nome"     => "Joaquim Pires",
            ],
            [
                "ibge_codigo"       => 2205458,
                "ibge_estado_id" => 22,
                "nome"     => "Joca Marques",
            ],
            [
                "ibge_codigo"       => 2205508,
                "ibge_estado_id" => 22,
                "nome"     => "José de Freitas",
            ],
            [
                "ibge_codigo"       => 2205516,
                "ibge_estado_id" => 22,
                "nome"     => "Juazeiro do Piauí",
            ],
            [
                "ibge_codigo"       => 2205524,
                "ibge_estado_id" => 22,
                "nome"     => "Júlio Borges",
            ],
            [
                "ibge_codigo"       => 2205532,
                "ibge_estado_id" => 22,
                "nome"     => "Jurema",
            ],
            [
                "ibge_codigo"       => 2205540,
                "ibge_estado_id" => 22,
                "nome"     => "Lagoinha do Piauí",
            ],
            [
                "ibge_codigo"       => 2205557,
                "ibge_estado_id" => 22,
                "nome"     => "Lagoa Alegre",
            ],
            [
                "ibge_codigo"       => 2205565,
                "ibge_estado_id" => 22,
                "nome"     => "Lagoa do Barro do Piauí",
            ],
            [
                "ibge_codigo"       => 2205573,
                "ibge_estado_id" => 22,
                "nome"     => "Lagoa de São Francisco",
            ],
            [
                "ibge_codigo"       => 2205581,
                "ibge_estado_id" => 22,
                "nome"     => "Lagoa do Piauí",
            ],
            [
                "ibge_codigo"       => 2205599,
                "ibge_estado_id" => 22,
                "nome"     => "Lagoa do Sítio",
            ],
            [
                "ibge_codigo"       => 2205607,
                "ibge_estado_id" => 22,
                "nome"     => "Landri Sales",
            ],
            [
                "ibge_codigo"       => 2205706,
                "ibge_estado_id" => 22,
                "nome"     => "Luís Correia",
            ],
            [
                "ibge_codigo"       => 2205805,
                "ibge_estado_id" => 22,
                "nome"     => "Luzilândia",
            ],
            [
                "ibge_codigo"       => 2205854,
                "ibge_estado_id" => 22,
                "nome"     => "Madeiro",
            ],
            [
                "ibge_codigo"       => 2205904,
                "ibge_estado_id" => 22,
                "nome"     => "Manoel Emídio",
            ],
            [
                "ibge_codigo"       => 2205953,
                "ibge_estado_id" => 22,
                "nome"     => "Marcolândia",
            ],
            [
                "ibge_codigo"       => 2206001,
                "ibge_estado_id" => 22,
                "nome"     => "Marcos Parente",
            ],
            [
                "ibge_codigo"       => 2206050,
                "ibge_estado_id" => 22,
                "nome"     => "Massapê do Piauí",
            ],
            [
                "ibge_codigo"       => 2206100,
                "ibge_estado_id" => 22,
                "nome"     => "Matias Olímpio",
            ],
            [
                "ibge_codigo"       => 2206209,
                "ibge_estado_id" => 22,
                "nome"     => "Miguel Alves",
            ],
            [
                "ibge_codigo"       => 2206308,
                "ibge_estado_id" => 22,
                "nome"     => "Miguel Leão",
            ],
            [
                "ibge_codigo"       => 2206357,
                "ibge_estado_id" => 22,
                "nome"     => "Milton Brandão",
            ],
            [
                "ibge_codigo"       => 2206407,
                "ibge_estado_id" => 22,
                "nome"     => "Monsenhor Gil",
            ],
            [
                "ibge_codigo"       => 2206506,
                "ibge_estado_id" => 22,
                "nome"     => "Monsenhor Hipólito",
            ],
            [
                "ibge_codigo"       => 2206605,
                "ibge_estado_id" => 22,
                "nome"     => "Monte Alegre do Piauí",
            ],
            [
                "ibge_codigo"       => 2206654,
                "ibge_estado_id" => 22,
                "nome"     => "Morro Cabeça no Tempo",
            ],
            [
                "ibge_codigo"       => 2206670,
                "ibge_estado_id" => 22,
                "nome"     => "Morro do Chapéu do Piauí",
            ],
            [
                "ibge_codigo"       => 2206696,
                "ibge_estado_id" => 22,
                "nome"     => "Murici dos Portelas",
            ],
            [
                "ibge_codigo"       => 2206704,
                "ibge_estado_id" => 22,
                "nome"     => "Nazaré do Piauí",
            ],
            [
                "ibge_codigo"       => 2206720,
                "ibge_estado_id" => 22,
                "nome"     => "Nazária",
            ],
            [
                "ibge_codigo"       => 2206753,
                "ibge_estado_id" => 22,
                "nome"     => "Nossa Senhora de Nazaré",
            ],
            [
                "ibge_codigo"       => 2206803,
                "ibge_estado_id" => 22,
                "nome"     => "Nossa Senhora dos Remédios",
            ],
            [
                "ibge_codigo"       => 2206902,
                "ibge_estado_id" => 22,
                "nome"     => "Novo Oriente do Piauí",
            ],
            [
                "ibge_codigo"       => 2206951,
                "ibge_estado_id" => 22,
                "nome"     => "Novo Santo Antônio",
            ],
            [
                "ibge_codigo"       => 2207009,
                "ibge_estado_id" => 22,
                "nome"     => "Oeiras",
            ],
            [
                "ibge_codigo"       => 2207108,
                "ibge_estado_id" => 22,
                "nome"     => "Olho d'Água do Piauí",
            ],
            [
                "ibge_codigo"       => 2207207,
                "ibge_estado_id" => 22,
                "nome"     => "Padre Marcos",
            ],
            [
                "ibge_codigo"       => 2207306,
                "ibge_estado_id" => 22,
                "nome"     => "Paes Landim",
            ],
            [
                "ibge_codigo"       => 2207355,
                "ibge_estado_id" => 22,
                "nome"     => "Pajeú do Piauí",
            ],
            [
                "ibge_codigo"       => 2207405,
                "ibge_estado_id" => 22,
                "nome"     => "Palmeira do Piauí",
            ],
            [
                "ibge_codigo"       => 2207504,
                "ibge_estado_id" => 22,
                "nome"     => "Palmeirais",
            ],
            [
                "ibge_codigo"       => 2207553,
                "ibge_estado_id" => 22,
                "nome"     => "Paquetá",
            ],
            [
                "ibge_codigo"       => 2207603,
                "ibge_estado_id" => 22,
                "nome"     => "Parnaguá",
            ],
            [
                "ibge_codigo"       => 2207702,
                "ibge_estado_id" => 22,
                "nome"     => "Parnaíba",
            ],
            [
                "ibge_codigo"       => 2207751,
                "ibge_estado_id" => 22,
                "nome"     => "Passagem Franca do Piauí",
            ],
            [
                "ibge_codigo"       => 2207777,
                "ibge_estado_id" => 22,
                "nome"     => "Patos do Piauí",
            ],
            [
                "ibge_codigo"       => 2207793,
                "ibge_estado_id" => 22,
                "nome"     => "Pau d'Arco do Piauí",
            ],
            [
                "ibge_codigo"       => 2207801,
                "ibge_estado_id" => 22,
                "nome"     => "Paulistana",
            ],
            [
                "ibge_codigo"       => 2207850,
                "ibge_estado_id" => 22,
                "nome"     => "Pavussu",
            ],
            [
                "ibge_codigo"       => 2207900,
                "ibge_estado_id" => 22,
                "nome"     => "Pedro II",
            ],
            [
                "ibge_codigo"       => 2207934,
                "ibge_estado_id" => 22,
                "nome"     => "Pedro Laurentino",
            ],
            [
                "ibge_codigo"       => 2207959,
                "ibge_estado_id" => 22,
                "nome"     => "Nova Santa Rita",
            ],
            [
                "ibge_codigo"       => 2208007,
                "ibge_estado_id" => 22,
                "nome"     => "Picos",
            ],
            [
                "ibge_codigo"       => 2208106,
                "ibge_estado_id" => 22,
                "nome"     => "Pimenteiras",
            ],
            [
                "ibge_codigo"       => 2208205,
                "ibge_estado_id" => 22,
                "nome"     => "Pio IX",
            ],
            [
                "ibge_codigo"       => 2208304,
                "ibge_estado_id" => 22,
                "nome"     => "Piracuruca",
            ],
            [
                "ibge_codigo"       => 2208403,
                "ibge_estado_id" => 22,
                "nome"     => "Piripiri",
            ],
            [
                "ibge_codigo"       => 2208502,
                "ibge_estado_id" => 22,
                "nome"     => "Porto",
            ],
            [
                "ibge_codigo"       => 2208551,
                "ibge_estado_id" => 22,
                "nome"     => "Porto Alegre do Piauí",
            ],
            [
                "ibge_codigo"       => 2208601,
                "ibge_estado_id" => 22,
                "nome"     => "Prata do Piauí",
            ],
            [
                "ibge_codigo"       => 2208650,
                "ibge_estado_id" => 22,
                "nome"     => "Queimada Nova",
            ],
            [
                "ibge_codigo"       => 2208700,
                "ibge_estado_id" => 22,
                "nome"     => "Redenção do Gurguéia",
            ],
            [
                "ibge_codigo"       => 2208809,
                "ibge_estado_id" => 22,
                "nome"     => "Regeneração",
            ],
            [
                "ibge_codigo"       => 2208858,
                "ibge_estado_id" => 22,
                "nome"     => "Riacho Frio",
            ],
            [
                "ibge_codigo"       => 2208874,
                "ibge_estado_id" => 22,
                "nome"     => "Ribeira do Piauí",
            ],
            [
                "ibge_codigo"       => 2208908,
                "ibge_estado_id" => 22,
                "nome"     => "Ribeiro Gonçalves",
            ],
            [
                "ibge_codigo"       => 2209005,
                "ibge_estado_id" => 22,
                "nome"     => "Rio Grande do Piauí",
            ],
            [
                "ibge_codigo"       => 2209104,
                "ibge_estado_id" => 22,
                "nome"     => "Santa Cruz do Piauí",
            ],
            [
                "ibge_codigo"       => 2209153,
                "ibge_estado_id" => 22,
                "nome"     => "Santa Cruz dos Milagres",
            ],
            [
                "ibge_codigo"       => 2209203,
                "ibge_estado_id" => 22,
                "nome"     => "Santa Filomena",
            ],
            [
                "ibge_codigo"       => 2209302,
                "ibge_estado_id" => 22,
                "nome"     => "Santa Luz",
            ],
            [
                "ibge_codigo"       => 2209351,
                "ibge_estado_id" => 22,
                "nome"     => "Santana do Piauí",
            ],
            [
                "ibge_codigo"       => 2209377,
                "ibge_estado_id" => 22,
                "nome"     => "Santa Rosa do Piauí",
            ],
            [
                "ibge_codigo"       => 2209401,
                "ibge_estado_id" => 22,
                "nome"     => "Santo Antônio de Lisboa",
            ],
            [
                "ibge_codigo"       => 2209450,
                "ibge_estado_id" => 22,
                "nome"     => "Santo Antônio dos Milagres",
            ],
            [
                "ibge_codigo"       => 2209500,
                "ibge_estado_id" => 22,
                "nome"     => "Santo Inácio do Piauí",
            ],
            [
                "ibge_codigo"       => 2209559,
                "ibge_estado_id" => 22,
                "nome"     => "São Braz do Piauí",
            ],
            [
                "ibge_codigo"       => 2209609,
                "ibge_estado_id" => 22,
                "nome"     => "São Félix do Piauí",
            ],
            [
                "ibge_codigo"       => 2209658,
                "ibge_estado_id" => 22,
                "nome"     => "São Francisco de Assis do Piauí",
            ],
            [
                "ibge_codigo"       => 2209708,
                "ibge_estado_id" => 22,
                "nome"     => "São Francisco do Piauí",
            ],
            [
                "ibge_codigo"       => 2209757,
                "ibge_estado_id" => 22,
                "nome"     => "São Gonçalo do Gurguéia",
            ],
            [
                "ibge_codigo"       => 2209807,
                "ibge_estado_id" => 22,
                "nome"     => "São Gonçalo do Piauí",
            ],
            [
                "ibge_codigo"       => 2209856,
                "ibge_estado_id" => 22,
                "nome"     => "São João da Canabrava",
            ],
            [
                "ibge_codigo"       => 2209872,
                "ibge_estado_id" => 22,
                "nome"     => "São João da Fronteira",
            ],
            [
                "ibge_codigo"       => 2209906,
                "ibge_estado_id" => 22,
                "nome"     => "São João da Serra",
            ],
            [
                "ibge_codigo"       => 2209955,
                "ibge_estado_id" => 22,
                "nome"     => "São João da Varjota",
            ],
            [
                "ibge_codigo"       => 2209971,
                "ibge_estado_id" => 22,
                "nome"     => "São João do Arraial",
            ],
            [
                "ibge_codigo"       => 2210003,
                "ibge_estado_id" => 22,
                "nome"     => "São João do Piauí",
            ],
            [
                "ibge_codigo"       => 2210052,
                "ibge_estado_id" => 22,
                "nome"     => "São José do Divino",
            ],
            [
                "ibge_codigo"       => 2210102,
                "ibge_estado_id" => 22,
                "nome"     => "São José do Peixe",
            ],
            [
                "ibge_codigo"       => 2210201,
                "ibge_estado_id" => 22,
                "nome"     => "São José do Piauí",
            ],
            [
                "ibge_codigo"       => 2210300,
                "ibge_estado_id" => 22,
                "nome"     => "São Julião",
            ],
            [
                "ibge_codigo"       => 2210359,
                "ibge_estado_id" => 22,
                "nome"     => "São Lourenço do Piauí",
            ],
            [
                "ibge_codigo"       => 2210375,
                "ibge_estado_id" => 22,
                "nome"     => "São Luis do Piauí",
            ],
            [
                "ibge_codigo"       => 2210383,
                "ibge_estado_id" => 22,
                "nome"     => "São Miguel da Baixa Grande",
            ],
            [
                "ibge_codigo"       => 2210391,
                "ibge_estado_id" => 22,
                "nome"     => "São Miguel do Fidalgo",
            ],
            [
                "ibge_codigo"       => 2210409,
                "ibge_estado_id" => 22,
                "nome"     => "São Miguel do Tapuio",
            ],
            [
                "ibge_codigo"       => 2210508,
                "ibge_estado_id" => 22,
                "nome"     => "São Pedro do Piauí",
            ],
            [
                "ibge_codigo"       => 2210607,
                "ibge_estado_id" => 22,
                "nome"     => "São Raimundo Nonato",
            ],
            [
                "ibge_codigo"       => 2210623,
                "ibge_estado_id" => 22,
                "nome"     => "Sebastião Barros",
            ],
            [
                "ibge_codigo"       => 2210631,
                "ibge_estado_id" => 22,
                "nome"     => "Sebastião Leal",
            ],
            [
                "ibge_codigo"       => 2210656,
                "ibge_estado_id" => 22,
                "nome"     => "Sigefredo Pacheco",
            ],
            [
                "ibge_codigo"       => 2210706,
                "ibge_estado_id" => 22,
                "nome"     => "Simões",
            ],
            [
                "ibge_codigo"       => 2210805,
                "ibge_estado_id" => 22,
                "nome"     => "Simplício Mendes",
            ],
            [
                "ibge_codigo"       => 2210904,
                "ibge_estado_id" => 22,
                "nome"     => "Socorro do Piauí",
            ],
            [
                "ibge_codigo"       => 2210938,
                "ibge_estado_id" => 22,
                "nome"     => "Sussuapara",
            ],
            [
                "ibge_codigo"       => 2210953,
                "ibge_estado_id" => 22,
                "nome"     => "Tamboril do Piauí",
            ],
            [
                "ibge_codigo"       => 2210979,
                "ibge_estado_id" => 22,
                "nome"     => "Tanque do Piauí",
            ],
            [
                "ibge_codigo"       => 2211001,
                "ibge_estado_id" => 22,
                "nome"     => "Teresina",
            ],
            [
                "ibge_codigo"       => 2211100,
                "ibge_estado_id" => 22,
                "nome"     => "União",
            ],
            [
                "ibge_codigo"       => 2211209,
                "ibge_estado_id" => 22,
                "nome"     => "Uruçuí",
            ],
            [
                "ibge_codigo"       => 2211308,
                "ibge_estado_id" => 22,
                "nome"     => "Valença do Piauí",
            ],
            [
                "ibge_codigo"       => 2211357,
                "ibge_estado_id" => 22,
                "nome"     => "Várzea Branca",
            ],
            [
                "ibge_codigo"       => 2211407,
                "ibge_estado_id" => 22,
                "nome"     => "Várzea Grande",
            ],
            [
                "ibge_codigo"       => 2211506,
                "ibge_estado_id" => 22,
                "nome"     => "Vera Mendes",
            ],
            [
                "ibge_codigo"       => 2211605,
                "ibge_estado_id" => 22,
                "nome"     => "Vila Nova do Piauí",
            ],
            [
                "ibge_codigo"       => 2211704,
                "ibge_estado_id" => 22,
                "nome"     => "Wall Ferraz",
            ],
            [
                "ibge_codigo"       => 2300101,
                "ibge_estado_id" => 23,
                "nome"     => "Abaiara",
            ],
            [
                "ibge_codigo"       => 2300150,
                "ibge_estado_id" => 23,
                "nome"     => "Acarape",
            ],
            [
                "ibge_codigo"       => 2300200,
                "ibge_estado_id" => 23,
                "nome"     => "Acaraú",
            ],
            [
                "ibge_codigo"       => 2300309,
                "ibge_estado_id" => 23,
                "nome"     => "Acopiara",
            ],
            [
                "ibge_codigo"       => 2300408,
                "ibge_estado_id" => 23,
                "nome"     => "Aiuaba",
            ],
            [
                "ibge_codigo"       => 2300507,
                "ibge_estado_id" => 23,
                "nome"     => "Alcântaras",
            ],
            [
                "ibge_codigo"       => 2300606,
                "ibge_estado_id" => 23,
                "nome"     => "Altaneira",
            ],
            [
                "ibge_codigo"       => 2300705,
                "ibge_estado_id" => 23,
                "nome"     => "Alto Santo",
            ],
            [
                "ibge_codigo"       => 2300754,
                "ibge_estado_id" => 23,
                "nome"     => "Amontada",
            ],
            [
                "ibge_codigo"       => 2300804,
                "ibge_estado_id" => 23,
                "nome"     => "Antonina do Norte",
            ],
            [
                "ibge_codigo"       => 2300903,
                "ibge_estado_id" => 23,
                "nome"     => "Apuiarés",
            ],
            [
                "ibge_codigo"       => 2301000,
                "ibge_estado_id" => 23,
                "nome"     => "Aquiraz",
            ],
            [
                "ibge_codigo"       => 2301109,
                "ibge_estado_id" => 23,
                "nome"     => "Aracati",
            ],
            [
                "ibge_codigo"       => 2301208,
                "ibge_estado_id" => 23,
                "nome"     => "Aracoiaba",
            ],
            [
                "ibge_codigo"       => 2301257,
                "ibge_estado_id" => 23,
                "nome"     => "Ararendá",
            ],
            [
                "ibge_codigo"       => 2301307,
                "ibge_estado_id" => 23,
                "nome"     => "Araripe",
            ],
            [
                "ibge_codigo"       => 2301406,
                "ibge_estado_id" => 23,
                "nome"     => "Aratuba",
            ],
            [
                "ibge_codigo"       => 2301505,
                "ibge_estado_id" => 23,
                "nome"     => "Arneiroz",
            ],
            [
                "ibge_codigo"       => 2301604,
                "ibge_estado_id" => 23,
                "nome"     => "Assaré",
            ],
            [
                "ibge_codigo"       => 2301703,
                "ibge_estado_id" => 23,
                "nome"     => "Aurora",
            ],
            [
                "ibge_codigo"       => 2301802,
                "ibge_estado_id" => 23,
                "nome"     => "Baixio",
            ],
            [
                "ibge_codigo"       => 2301851,
                "ibge_estado_id" => 23,
                "nome"     => "Banabuiú",
            ],
            [
                "ibge_codigo"       => 2301901,
                "ibge_estado_id" => 23,
                "nome"     => "Barbalha",
            ],
            [
                "ibge_codigo"       => 2301950,
                "ibge_estado_id" => 23,
                "nome"     => "Barreira",
            ],
            [
                "ibge_codigo"       => 2302008,
                "ibge_estado_id" => 23,
                "nome"     => "Barro",
            ],
            [
                "ibge_codigo"       => 2302057,
                "ibge_estado_id" => 23,
                "nome"     => "Barroquinha",
            ],
            [
                "ibge_codigo"       => 2302107,
                "ibge_estado_id" => 23,
                "nome"     => "Baturité",
            ],
            [
                "ibge_codigo"       => 2302206,
                "ibge_estado_id" => 23,
                "nome"     => "Beberibe",
            ],
            [
                "ibge_codigo"       => 2302305,
                "ibge_estado_id" => 23,
                "nome"     => "Bela Cruz",
            ],
            [
                "ibge_codigo"       => 2302404,
                "ibge_estado_id" => 23,
                "nome"     => "Boa Viagem",
            ],
            [
                "ibge_codigo"       => 2302503,
                "ibge_estado_id" => 23,
                "nome"     => "Brejo Santo",
            ],
            [
                "ibge_codigo"       => 2302602,
                "ibge_estado_id" => 23,
                "nome"     => "Camocim",
            ],
            [
                "ibge_codigo"       => 2302701,
                "ibge_estado_id" => 23,
                "nome"     => "Campos Sales",
            ],
            [
                "ibge_codigo"       => 2302800,
                "ibge_estado_id" => 23,
                "nome"     => "Canindé",
            ],
            [
                "ibge_codigo"       => 2302909,
                "ibge_estado_id" => 23,
                "nome"     => "Capistrano",
            ],
            [
                "ibge_codigo"       => 2303006,
                "ibge_estado_id" => 23,
                "nome"     => "Caridade",
            ],
            [
                "ibge_codigo"       => 2303105,
                "ibge_estado_id" => 23,
                "nome"     => "Cariré",
            ],
            [
                "ibge_codigo"       => 2303204,
                "ibge_estado_id" => 23,
                "nome"     => "Caririaçu",
            ],
            [
                "ibge_codigo"       => 2303303,
                "ibge_estado_id" => 23,
                "nome"     => "Cariús",
            ],
            [
                "ibge_codigo"       => 2303402,
                "ibge_estado_id" => 23,
                "nome"     => "Carnaubal",
            ],
            [
                "ibge_codigo"       => 2303501,
                "ibge_estado_id" => 23,
                "nome"     => "Cascavel",
            ],
            [
                "ibge_codigo"       => 2303600,
                "ibge_estado_id" => 23,
                "nome"     => "Catarina",
            ],
            [
                "ibge_codigo"       => 2303659,
                "ibge_estado_id" => 23,
                "nome"     => "Catunda",
            ],
            [
                "ibge_codigo"       => 2303709,
                "ibge_estado_id" => 23,
                "nome"     => "Caucaia",
            ],
            [
                "ibge_codigo"       => 2303808,
                "ibge_estado_id" => 23,
                "nome"     => "Cedro",
            ],
            [
                "ibge_codigo"       => 2303907,
                "ibge_estado_id" => 23,
                "nome"     => "Chaval",
            ],
            [
                "ibge_codigo"       => 2303931,
                "ibge_estado_id" => 23,
                "nome"     => "Choró",
            ],
            [
                "ibge_codigo"       => 2303956,
                "ibge_estado_id" => 23,
                "nome"     => "Chorozinho",
            ],
            [
                "ibge_codigo"       => 2304004,
                "ibge_estado_id" => 23,
                "nome"     => "Coreaú",
            ],
            [
                "ibge_codigo"       => 2304103,
                "ibge_estado_id" => 23,
                "nome"     => "Crateús",
            ],
            [
                "ibge_codigo"       => 2304202,
                "ibge_estado_id" => 23,
                "nome"     => "Crato",
            ],
            [
                "ibge_codigo"       => 2304236,
                "ibge_estado_id" => 23,
                "nome"     => "Croatá",
            ],
            [
                "ibge_codigo"       => 2304251,
                "ibge_estado_id" => 23,
                "nome"     => "Cruz",
            ],
            [
                "ibge_codigo"       => 2304269,
                "ibge_estado_id" => 23,
                "nome"     => "Deputado Irapuan Pinheiro",
            ],
            [
                "ibge_codigo"       => 2304277,
                "ibge_estado_id" => 23,
                "nome"     => "Ererê",
            ],
            [
                "ibge_codigo"       => 2304285,
                "ibge_estado_id" => 23,
                "nome"     => "Eusébio",
            ],
            [
                "ibge_codigo"       => 2304301,
                "ibge_estado_id" => 23,
                "nome"     => "Farias Brito",
            ],
            [
                "ibge_codigo"       => 2304350,
                "ibge_estado_id" => 23,
                "nome"     => "Forquilha",
            ],
            [
                "ibge_codigo"       => 2304400,
                "ibge_estado_id" => 23,
                "nome"     => "Fortaleza",
            ],
            [
                "ibge_codigo"       => 2304459,
                "ibge_estado_id" => 23,
                "nome"     => "Fortim",
            ],
            [
                "ibge_codigo"       => 2304509,
                "ibge_estado_id" => 23,
                "nome"     => "Frecheirinha",
            ],
            [
                "ibge_codigo"       => 2304608,
                "ibge_estado_id" => 23,
                "nome"     => "General Sampaio",
            ],
            [
                "ibge_codigo"       => 2304657,
                "ibge_estado_id" => 23,
                "nome"     => "Graça",
            ],
            [
                "ibge_codigo"       => 2304707,
                "ibge_estado_id" => 23,
                "nome"     => "Granja",
            ],
            [
                "ibge_codigo"       => 2304806,
                "ibge_estado_id" => 23,
                "nome"     => "Granjeiro",
            ],
            [
                "ibge_codigo"       => 2304905,
                "ibge_estado_id" => 23,
                "nome"     => "Groaíras",
            ],
            [
                "ibge_codigo"       => 2304954,
                "ibge_estado_id" => 23,
                "nome"     => "Guaiúba",
            ],
            [
                "ibge_codigo"       => 2305001,
                "ibge_estado_id" => 23,
                "nome"     => "Guaraciaba do Norte",
            ],
            [
                "ibge_codigo"       => 2305100,
                "ibge_estado_id" => 23,
                "nome"     => "Guaramiranga",
            ],
            [
                "ibge_codigo"       => 2305209,
                "ibge_estado_id" => 23,
                "nome"     => "Hidrolândia",
            ],
            [
                "ibge_codigo"       => 2305233,
                "ibge_estado_id" => 23,
                "nome"     => "Horizonte",
            ],
            [
                "ibge_codigo"       => 2305266,
                "ibge_estado_id" => 23,
                "nome"     => "Ibaretama",
            ],
            [
                "ibge_codigo"       => 2305308,
                "ibge_estado_id" => 23,
                "nome"     => "Ibiapina",
            ],
            [
                "ibge_codigo"       => 2305332,
                "ibge_estado_id" => 23,
                "nome"     => "Ibicuitinga",
            ],
            [
                "ibge_codigo"       => 2305357,
                "ibge_estado_id" => 23,
                "nome"     => "Icapuí",
            ],
            [
                "ibge_codigo"       => 2305407,
                "ibge_estado_id" => 23,
                "nome"     => "Icó",
            ],
            [
                "ibge_codigo"       => 2305506,
                "ibge_estado_id" => 23,
                "nome"     => "Iguatu",
            ],
            [
                "ibge_codigo"       => 2305605,
                "ibge_estado_id" => 23,
                "nome"     => "Independência",
            ],
            [
                "ibge_codigo"       => 2305654,
                "ibge_estado_id" => 23,
                "nome"     => "Ipaporanga",
            ],
            [
                "ibge_codigo"       => 2305704,
                "ibge_estado_id" => 23,
                "nome"     => "Ipaumirim",
            ],
            [
                "ibge_codigo"       => 2305803,
                "ibge_estado_id" => 23,
                "nome"     => "Ipu",
            ],
            [
                "ibge_codigo"       => 2305902,
                "ibge_estado_id" => 23,
                "nome"     => "Ipueiras",
            ],
            [
                "ibge_codigo"       => 2306009,
                "ibge_estado_id" => 23,
                "nome"     => "Iracema",
            ],
            [
                "ibge_codigo"       => 2306108,
                "ibge_estado_id" => 23,
                "nome"     => "Irauçuba",
            ],
            [
                "ibge_codigo"       => 2306207,
                "ibge_estado_id" => 23,
                "nome"     => "Itaiçaba",
            ],
            [
                "ibge_codigo"       => 2306256,
                "ibge_estado_id" => 23,
                "nome"     => "Itaitinga",
            ],
            [
                "ibge_codigo"       => 2306306,
                "ibge_estado_id" => 23,
                "nome"     => "Itapagé",
            ],
            [
                "ibge_codigo"       => 2306405,
                "ibge_estado_id" => 23,
                "nome"     => "Itapipoca",
            ],
            [
                "ibge_codigo"       => 2306504,
                "ibge_estado_id" => 23,
                "nome"     => "Itapiúna",
            ],
            [
                "ibge_codigo"       => 2306553,
                "ibge_estado_id" => 23,
                "nome"     => "Itarema",
            ],
            [
                "ibge_codigo"       => 2306603,
                "ibge_estado_id" => 23,
                "nome"     => "Itatira",
            ],
            [
                "ibge_codigo"       => 2306702,
                "ibge_estado_id" => 23,
                "nome"     => "Jaguaretama",
            ],
            [
                "ibge_codigo"       => 2306801,
                "ibge_estado_id" => 23,
                "nome"     => "Jaguaribara",
            ],
            [
                "ibge_codigo"       => 2306900,
                "ibge_estado_id" => 23,
                "nome"     => "Jaguaribe",
            ],
            [
                "ibge_codigo"       => 2307007,
                "ibge_estado_id" => 23,
                "nome"     => "Jaguaruana",
            ],
            [
                "ibge_codigo"       => 2307106,
                "ibge_estado_id" => 23,
                "nome"     => "Jardim",
            ],
            [
                "ibge_codigo"       => 2307205,
                "ibge_estado_id" => 23,
                "nome"     => "Jati",
            ],
            [
                "ibge_codigo"       => 2307254,
                "ibge_estado_id" => 23,
                "nome"     => "Jijoca de Jericoacoara",
            ],
            [
                "ibge_codigo"       => 2307304,
                "ibge_estado_id" => 23,
                "nome"     => "Juazeiro do Norte",
            ],
            [
                "ibge_codigo"       => 2307403,
                "ibge_estado_id" => 23,
                "nome"     => "Jucás",
            ],
            [
                "ibge_codigo"       => 2307502,
                "ibge_estado_id" => 23,
                "nome"     => "Lavras da Mangabeira",
            ],
            [
                "ibge_codigo"       => 2307601,
                "ibge_estado_id" => 23,
                "nome"     => "Limoeiro do Norte",
            ],
            [
                "ibge_codigo"       => 2307635,
                "ibge_estado_id" => 23,
                "nome"     => "Madalena",
            ],
            [
                "ibge_codigo"       => 2307650,
                "ibge_estado_id" => 23,
                "nome"     => "Maracanaú",
            ],
            [
                "ibge_codigo"       => 2307700,
                "ibge_estado_id" => 23,
                "nome"     => "Maranguape",
            ],
            [
                "ibge_codigo"       => 2307809,
                "ibge_estado_id" => 23,
                "nome"     => "Marco",
            ],
            [
                "ibge_codigo"       => 2307908,
                "ibge_estado_id" => 23,
                "nome"     => "Martinópole",
            ],
            [
                "ibge_codigo"       => 2308005,
                "ibge_estado_id" => 23,
                "nome"     => "Massapê",
            ],
            [
                "ibge_codigo"       => 2308104,
                "ibge_estado_id" => 23,
                "nome"     => "Mauriti",
            ],
            [
                "ibge_codigo"       => 2308203,
                "ibge_estado_id" => 23,
                "nome"     => "Meruoca",
            ],
            [
                "ibge_codigo"       => 2308302,
                "ibge_estado_id" => 23,
                "nome"     => "Milagres",
            ],
            [
                "ibge_codigo"       => 2308351,
                "ibge_estado_id" => 23,
                "nome"     => "Milhã",
            ],
            [
                "ibge_codigo"       => 2308377,
                "ibge_estado_id" => 23,
                "nome"     => "Miraíma",
            ],
            [
                "ibge_codigo"       => 2308401,
                "ibge_estado_id" => 23,
                "nome"     => "Missão Velha",
            ],
            [
                "ibge_codigo"       => 2308500,
                "ibge_estado_id" => 23,
                "nome"     => "Mombaça",
            ],
            [
                "ibge_codigo"       => 2308609,
                "ibge_estado_id" => 23,
                "nome"     => "Monsenhor Tabosa",
            ],
            [
                "ibge_codigo"       => 2308708,
                "ibge_estado_id" => 23,
                "nome"     => "Morada Nova",
            ],
            [
                "ibge_codigo"       => 2308807,
                "ibge_estado_id" => 23,
                "nome"     => "Moraújo",
            ],
            [
                "ibge_codigo"       => 2308906,
                "ibge_estado_id" => 23,
                "nome"     => "Morrinhos",
            ],
            [
                "ibge_codigo"       => 2309003,
                "ibge_estado_id" => 23,
                "nome"     => "Mucambo",
            ],
            [
                "ibge_codigo"       => 2309102,
                "ibge_estado_id" => 23,
                "nome"     => "Mulungu",
            ],
            [
                "ibge_codigo"       => 2309201,
                "ibge_estado_id" => 23,
                "nome"     => "Nova Olinda",
            ],
            [
                "ibge_codigo"       => 2309300,
                "ibge_estado_id" => 23,
                "nome"     => "Nova Russas",
            ],
            [
                "ibge_codigo"       => 2309409,
                "ibge_estado_id" => 23,
                "nome"     => "Novo Oriente",
            ],
            [
                "ibge_codigo"       => 2309458,
                "ibge_estado_id" => 23,
                "nome"     => "Ocara",
            ],
            [
                "ibge_codigo"       => 2309508,
                "ibge_estado_id" => 23,
                "nome"     => "Orós",
            ],
            [
                "ibge_codigo"       => 2309607,
                "ibge_estado_id" => 23,
                "nome"     => "Pacajus",
            ],
            [
                "ibge_codigo"       => 2309706,
                "ibge_estado_id" => 23,
                "nome"     => "Pacatuba",
            ],
            [
                "ibge_codigo"       => 2309805,
                "ibge_estado_id" => 23,
                "nome"     => "Pacoti",
            ],
            [
                "ibge_codigo"       => 2309904,
                "ibge_estado_id" => 23,
                "nome"     => "Pacujá",
            ],
            [
                "ibge_codigo"       => 2310001,
                "ibge_estado_id" => 23,
                "nome"     => "Palhano",
            ],
            [
                "ibge_codigo"       => 2310100,
                "ibge_estado_id" => 23,
                "nome"     => "Palmácia",
            ],
            [
                "ibge_codigo"       => 2310209,
                "ibge_estado_id" => 23,
                "nome"     => "Paracuru",
            ],
            [
                "ibge_codigo"       => 2310258,
                "ibge_estado_id" => 23,
                "nome"     => "Paraipaba",
            ],
            [
                "ibge_codigo"       => 2310308,
                "ibge_estado_id" => 23,
                "nome"     => "Parambu",
            ],
            [
                "ibge_codigo"       => 2310407,
                "ibge_estado_id" => 23,
                "nome"     => "Paramoti",
            ],
            [
                "ibge_codigo"       => 2310506,
                "ibge_estado_id" => 23,
                "nome"     => "Pedra Branca",
            ],
            [
                "ibge_codigo"       => 2310605,
                "ibge_estado_id" => 23,
                "nome"     => "Penaforte",
            ],
            [
                "ibge_codigo"       => 2310704,
                "ibge_estado_id" => 23,
                "nome"     => "Pentecoste",
            ],
            [
                "ibge_codigo"       => 2310803,
                "ibge_estado_id" => 23,
                "nome"     => "Pereiro",
            ],
            [
                "ibge_codigo"       => 2310852,
                "ibge_estado_id" => 23,
                "nome"     => "Pindoretama",
            ],
            [
                "ibge_codigo"       => 2310902,
                "ibge_estado_id" => 23,
                "nome"     => "Piquet Carneiro",
            ],
            [
                "ibge_codigo"       => 2310951,
                "ibge_estado_id" => 23,
                "nome"     => "Pires Ferreira",
            ],
            [
                "ibge_codigo"       => 2311009,
                "ibge_estado_id" => 23,
                "nome"     => "Poranga",
            ],
            [
                "ibge_codigo"       => 2311108,
                "ibge_estado_id" => 23,
                "nome"     => "Porteiras",
            ],
            [
                "ibge_codigo"       => 2311207,
                "ibge_estado_id" => 23,
                "nome"     => "Potengi",
            ],
            [
                "ibge_codigo"       => 2311231,
                "ibge_estado_id" => 23,
                "nome"     => "Potiretama",
            ],
            [
                "ibge_codigo"       => 2311264,
                "ibge_estado_id" => 23,
                "nome"     => "Quiterianópolis",
            ],
            [
                "ibge_codigo"       => 2311306,
                "ibge_estado_id" => 23,
                "nome"     => "Quixadá",
            ],
            [
                "ibge_codigo"       => 2311355,
                "ibge_estado_id" => 23,
                "nome"     => "Quixelô",
            ],
            [
                "ibge_codigo"       => 2311405,
                "ibge_estado_id" => 23,
                "nome"     => "Quixeramobim",
            ],
            [
                "ibge_codigo"       => 2311504,
                "ibge_estado_id" => 23,
                "nome"     => "Quixeré",
            ],
            [
                "ibge_codigo"       => 2311603,
                "ibge_estado_id" => 23,
                "nome"     => "Redenção",
            ],
            [
                "ibge_codigo"       => 2311702,
                "ibge_estado_id" => 23,
                "nome"     => "Reriutaba",
            ],
            [
                "ibge_codigo"       => 2311801,
                "ibge_estado_id" => 23,
                "nome"     => "Russas",
            ],
            [
                "ibge_codigo"       => 2311900,
                "ibge_estado_id" => 23,
                "nome"     => "Saboeiro",
            ],
            [
                "ibge_codigo"       => 2311959,
                "ibge_estado_id" => 23,
                "nome"     => "Salitre",
            ],
            [
                "ibge_codigo"       => 2312007,
                "ibge_estado_id" => 23,
                "nome"     => "Santana do Acaraú",
            ],
            [
                "ibge_codigo"       => 2312106,
                "ibge_estado_id" => 23,
                "nome"     => "Santana do Cariri",
            ],
            [
                "ibge_codigo"       => 2312205,
                "ibge_estado_id" => 23,
                "nome"     => "Santa Quitéria",
            ],
            [
                "ibge_codigo"       => 2312304,
                "ibge_estado_id" => 23,
                "nome"     => "São Benedito",
            ],
            [
                "ibge_codigo"       => 2312403,
                "ibge_estado_id" => 23,
                "nome"     => "São Gonçalo do Amarante",
            ],
            [
                "ibge_codigo"       => 2312502,
                "ibge_estado_id" => 23,
                "nome"     => "São João do Jaguaribe",
            ],
            [
                "ibge_codigo"       => 2312601,
                "ibge_estado_id" => 23,
                "nome"     => "São Luís do Curu",
            ],
            [
                "ibge_codigo"       => 2312700,
                "ibge_estado_id" => 23,
                "nome"     => "Senador Pompeu",
            ],
            [
                "ibge_codigo"       => 2312809,
                "ibge_estado_id" => 23,
                "nome"     => "Senador Sá",
            ],
            [
                "ibge_codigo"       => 2312908,
                "ibge_estado_id" => 23,
                "nome"     => "Sobral",
            ],
            [
                "ibge_codigo"       => 2313005,
                "ibge_estado_id" => 23,
                "nome"     => "Solonópole",
            ],
            [
                "ibge_codigo"       => 2313104,
                "ibge_estado_id" => 23,
                "nome"     => "Tabuleiro do Norte",
            ],
            [
                "ibge_codigo"       => 2313203,
                "ibge_estado_id" => 23,
                "nome"     => "Tamboril",
            ],
            [
                "ibge_codigo"       => 2313252,
                "ibge_estado_id" => 23,
                "nome"     => "Tarrafas",
            ],
            [
                "ibge_codigo"       => 2313302,
                "ibge_estado_id" => 23,
                "nome"     => "Tauá",
            ],
            [
                "ibge_codigo"       => 2313351,
                "ibge_estado_id" => 23,
                "nome"     => "Tejuçuoca",
            ],
            [
                "ibge_codigo"       => 2313401,
                "ibge_estado_id" => 23,
                "nome"     => "Tianguá",
            ],
            [
                "ibge_codigo"       => 2313500,
                "ibge_estado_id" => 23,
                "nome"     => "Trairi",
            ],
            [
                "ibge_codigo"       => 2313559,
                "ibge_estado_id" => 23,
                "nome"     => "Tururu",
            ],
            [
                "ibge_codigo"       => 2313609,
                "ibge_estado_id" => 23,
                "nome"     => "Ubajara",
            ],
            [
                "ibge_codigo"       => 2313708,
                "ibge_estado_id" => 23,
                "nome"     => "Umari",
            ],
            [
                "ibge_codigo"       => 2313757,
                "ibge_estado_id" => 23,
                "nome"     => "Umirim",
            ],
            [
                "ibge_codigo"       => 2313807,
                "ibge_estado_id" => 23,
                "nome"     => "Uruburetama",
            ],
            [
                "ibge_codigo"       => 2313906,
                "ibge_estado_id" => 23,
                "nome"     => "Uruoca",
            ],
            [
                "ibge_codigo"       => 2313955,
                "ibge_estado_id" => 23,
                "nome"     => "Varjota",
            ],
            [
                "ibge_codigo"       => 2314003,
                "ibge_estado_id" => 23,
                "nome"     => "Várzea Alegre",
            ],
            [
                "ibge_codigo"       => 2314102,
                "ibge_estado_id" => 23,
                "nome"     => "Viçosa do Ceará",
            ],
            [
                "ibge_codigo"       => 2400109,
                "ibge_estado_id" => 24,
                "nome"     => "Acari",
            ],
            [
                "ibge_codigo"       => 2400208,
                "ibge_estado_id" => 24,
                "nome"     => "Açu",
            ],
            [
                "ibge_codigo"       => 2400307,
                "ibge_estado_id" => 24,
                "nome"     => "Afonso Bezerra",
            ],
            [
                "ibge_codigo"       => 2400406,
                "ibge_estado_id" => 24,
                "nome"     => "Água Nova",
            ],
            [
                "ibge_codigo"       => 2400505,
                "ibge_estado_id" => 24,
                "nome"     => "Alexandria",
            ],
            [
                "ibge_codigo"       => 2400604,
                "ibge_estado_id" => 24,
                "nome"     => "Almino Afonso",
            ],
            [
                "ibge_codigo"       => 2400703,
                "ibge_estado_id" => 24,
                "nome"     => "Alto do Rodrigues",
            ],
            [
                "ibge_codigo"       => 2400802,
                "ibge_estado_id" => 24,
                "nome"     => "Angicos",
            ],
            [
                "ibge_codigo"       => 2400901,
                "ibge_estado_id" => 24,
                "nome"     => "Antônio Martins",
            ],
            [
                "ibge_codigo"       => 2401008,
                "ibge_estado_id" => 24,
                "nome"     => "Apodi",
            ],
            [
                "ibge_codigo"       => 2401107,
                "ibge_estado_id" => 24,
                "nome"     => "Areia Branca",
            ],
            [
                "ibge_codigo"       => 2401206,
                "ibge_estado_id" => 24,
                "nome"     => "Arês",
            ],
            [
                "ibge_codigo"       => 2401305,
                "ibge_estado_id" => 24,
                "nome"     => "Augusto Severo",
            ],
            [
                "ibge_codigo"       => 2401404,
                "ibge_estado_id" => 24,
                "nome"     => "Baía Formosa",
            ],
            [
                "ibge_codigo"       => 2401453,
                "ibge_estado_id" => 24,
                "nome"     => "Baraúna",
            ],
            [
                "ibge_codigo"       => 2401503,
                "ibge_estado_id" => 24,
                "nome"     => "Barcelona",
            ],
            [
                "ibge_codigo"       => 2401602,
                "ibge_estado_id" => 24,
                "nome"     => "Bento Fernandes",
            ],
            [
                "ibge_codigo"       => 2401651,
                "ibge_estado_id" => 24,
                "nome"     => "Bodó",
            ],
            [
                "ibge_codigo"       => 2401701,
                "ibge_estado_id" => 24,
                "nome"     => "Bom Jesus",
            ],
            [
                "ibge_codigo"       => 2401800,
                "ibge_estado_id" => 24,
                "nome"     => "Brejinho",
            ],
            [
                "ibge_codigo"       => 2401859,
                "ibge_estado_id" => 24,
                "nome"     => "Caiçara do Norte",
            ],
            [
                "ibge_codigo"       => 2401909,
                "ibge_estado_id" => 24,
                "nome"     => "Caiçara do Rio do Vento",
            ],
            [
                "ibge_codigo"       => 2402006,
                "ibge_estado_id" => 24,
                "nome"     => "Caicó",
            ],
            [
                "ibge_codigo"       => 2402105,
                "ibge_estado_id" => 24,
                "nome"     => "Campo Redondo",
            ],
            [
                "ibge_codigo"       => 2402204,
                "ibge_estado_id" => 24,
                "nome"     => "Canguaretama",
            ],
            [
                "ibge_codigo"       => 2402303,
                "ibge_estado_id" => 24,
                "nome"     => "Caraúbas",
            ],
            [
                "ibge_codigo"       => 2402402,
                "ibge_estado_id" => 24,
                "nome"     => "Carnaúba dos Dantas",
            ],
            [
                "ibge_codigo"       => 2402501,
                "ibge_estado_id" => 24,
                "nome"     => "Carnaubais",
            ],
            [
                "ibge_codigo"       => 2402600,
                "ibge_estado_id" => 24,
                "nome"     => "Ceará-Mirim",
            ],
            [
                "ibge_codigo"       => 2402709,
                "ibge_estado_id" => 24,
                "nome"     => "Cerro Corá",
            ],
            [
                "ibge_codigo"       => 2402808,
                "ibge_estado_id" => 24,
                "nome"     => "Coronel Ezequiel",
            ],
            [
                "ibge_codigo"       => 2402907,
                "ibge_estado_id" => 24,
                "nome"     => "Coronel João Pessoa",
            ],
            [
                "ibge_codigo"       => 2403004,
                "ibge_estado_id" => 24,
                "nome"     => "Cruzeta",
            ],
            [
                "ibge_codigo"       => 2403103,
                "ibge_estado_id" => 24,
                "nome"     => "Currais Novos",
            ],
            [
                "ibge_codigo"       => 2403202,
                "ibge_estado_id" => 24,
                "nome"     => "Doutor Severiano",
            ],
            [
                "ibge_codigo"       => 2403251,
                "ibge_estado_id" => 24,
                "nome"     => "Parnamirim",
            ],
            [
                "ibge_codigo"       => 2403301,
                "ibge_estado_id" => 24,
                "nome"     => "Encanto",
            ],
            [
                "ibge_codigo"       => 2403400,
                "ibge_estado_id" => 24,
                "nome"     => "Equador",
            ],
            [
                "ibge_codigo"       => 2403509,
                "ibge_estado_id" => 24,
                "nome"     => "Espírito Santo",
            ],
            [
                "ibge_codigo"       => 2403608,
                "ibge_estado_id" => 24,
                "nome"     => "Extremoz",
            ],
            [
                "ibge_codigo"       => 2403707,
                "ibge_estado_id" => 24,
                "nome"     => "Felipe Guerra",
            ],
            [
                "ibge_codigo"       => 2403756,
                "ibge_estado_id" => 24,
                "nome"     => "Fernando Pedroza",
            ],
            [
                "ibge_codigo"       => 2403806,
                "ibge_estado_id" => 24,
                "nome"     => "Florânia",
            ],
            [
                "ibge_codigo"       => 2403905,
                "ibge_estado_id" => 24,
                "nome"     => "Francisco Dantas",
            ],
            [
                "ibge_codigo"       => 2404002,
                "ibge_estado_id" => 24,
                "nome"     => "Frutuoso Gomes",
            ],
            [
                "ibge_codigo"       => 2404101,
                "ibge_estado_id" => 24,
                "nome"     => "Galinhos",
            ],
            [
                "ibge_codigo"       => 2404200,
                "ibge_estado_id" => 24,
                "nome"     => "Goianinha",
            ],
            [
                "ibge_codigo"       => 2404309,
                "ibge_estado_id" => 24,
                "nome"     => "Governador Dix-Sept Rosado",
            ],
            [
                "ibge_codigo"       => 2404408,
                "ibge_estado_id" => 24,
                "nome"     => "Grossos",
            ],
            [
                "ibge_codigo"       => 2404507,
                "ibge_estado_id" => 24,
                "nome"     => "Guamaré",
            ],
            [
                "ibge_codigo"       => 2404606,
                "ibge_estado_id" => 24,
                "nome"     => "Ielmo Marinho",
            ],
            [
                "ibge_codigo"       => 2404705,
                "ibge_estado_id" => 24,
                "nome"     => "Ipanguaçu",
            ],
            [
                "ibge_codigo"       => 2404804,
                "ibge_estado_id" => 24,
                "nome"     => "Ipueira",
            ],
            [
                "ibge_codigo"       => 2404853,
                "ibge_estado_id" => 24,
                "nome"     => "Itajá",
            ],
            [
                "ibge_codigo"       => 2404903,
                "ibge_estado_id" => 24,
                "nome"     => "Itaú",
            ],
            [
                "ibge_codigo"       => 2405009,
                "ibge_estado_id" => 24,
                "nome"     => "Jaçanã",
            ],
            [
                "ibge_codigo"       => 2405108,
                "ibge_estado_id" => 24,
                "nome"     => "Jandaíra",
            ],
            [
                "ibge_codigo"       => 2405207,
                "ibge_estado_id" => 24,
                "nome"     => "Janduís",
            ],
            [
                "ibge_codigo"       => 2405306,
                "ibge_estado_id" => 24,
                "nome"     => "Januário Cicco",
            ],
            [
                "ibge_codigo"       => 2405405,
                "ibge_estado_id" => 24,
                "nome"     => "Japi",
            ],
            [
                "ibge_codigo"       => 2405504,
                "ibge_estado_id" => 24,
                "nome"     => "Jardim de Angicos",
            ],
            [
                "ibge_codigo"       => 2405603,
                "ibge_estado_id" => 24,
                "nome"     => "Jardim de Piranhas",
            ],
            [
                "ibge_codigo"       => 2405702,
                "ibge_estado_id" => 24,
                "nome"     => "Jardim do Seridó",
            ],
            [
                "ibge_codigo"       => 2405801,
                "ibge_estado_id" => 24,
                "nome"     => "João Câmara",
            ],
            [
                "ibge_codigo"       => 2405900,
                "ibge_estado_id" => 24,
                "nome"     => "João Dias",
            ],
            [
                "ibge_codigo"       => 2406007,
                "ibge_estado_id" => 24,
                "nome"     => "José da Penha",
            ],
            [
                "ibge_codigo"       => 2406106,
                "ibge_estado_id" => 24,
                "nome"     => "Jucurutu",
            ],
            [
                "ibge_codigo"       => 2406155,
                "ibge_estado_id" => 24,
                "nome"     => "Jundiá",
            ],
            [
                "ibge_codigo"       => 2406205,
                "ibge_estado_id" => 24,
                "nome"     => "Lagoa d'Anta",
            ],
            [
                "ibge_codigo"       => 2406304,
                "ibge_estado_id" => 24,
                "nome"     => "Lagoa de Pedras",
            ],
            [
                "ibge_codigo"       => 2406403,
                "ibge_estado_id" => 24,
                "nome"     => "Lagoa de Velhos",
            ],
            [
                "ibge_codigo"       => 2406502,
                "ibge_estado_id" => 24,
                "nome"     => "Lagoa Nova",
            ],
            [
                "ibge_codigo"       => 2406601,
                "ibge_estado_id" => 24,
                "nome"     => "Lagoa Salgada",
            ],
            [
                "ibge_codigo"       => 2406700,
                "ibge_estado_id" => 24,
                "nome"     => "Lajes",
            ],
            [
                "ibge_codigo"       => 2406809,
                "ibge_estado_id" => 24,
                "nome"     => "Lajes Pintadas",
            ],
            [
                "ibge_codigo"       => 2406908,
                "ibge_estado_id" => 24,
                "nome"     => "Lucrécia",
            ],
            [
                "ibge_codigo"       => 2407005,
                "ibge_estado_id" => 24,
                "nome"     => "Luís Gomes",
            ],
            [
                "ibge_codigo"       => 2407104,
                "ibge_estado_id" => 24,
                "nome"     => "Macaíba",
            ],
            [
                "ibge_codigo"       => 2407203,
                "ibge_estado_id" => 24,
                "nome"     => "Macau",
            ],
            [
                "ibge_codigo"       => 2407252,
                "ibge_estado_id" => 24,
                "nome"     => "Major Sales",
            ],
            [
                "ibge_codigo"       => 2407302,
                "ibge_estado_id" => 24,
                "nome"     => "Marcelino Vieira",
            ],
            [
                "ibge_codigo"       => 2407401,
                "ibge_estado_id" => 24,
                "nome"     => "Martins",
            ],
            [
                "ibge_codigo"       => 2407500,
                "ibge_estado_id" => 24,
                "nome"     => "Maxaranguape",
            ],
            [
                "ibge_codigo"       => 2407609,
                "ibge_estado_id" => 24,
                "nome"     => "Messias Targino",
            ],
            [
                "ibge_codigo"       => 2407708,
                "ibge_estado_id" => 24,
                "nome"     => "Montanhas",
            ],
            [
                "ibge_codigo"       => 2407807,
                "ibge_estado_id" => 24,
                "nome"     => "Monte Alegre",
            ],
            [
                "ibge_codigo"       => 2407906,
                "ibge_estado_id" => 24,
                "nome"     => "Monte das Gameleiras",
            ],
            [
                "ibge_codigo"       => 2408003,
                "ibge_estado_id" => 24,
                "nome"     => "Mossoró",
            ],
            [
                "ibge_codigo"       => 2408102,
                "ibge_estado_id" => 24,
                "nome"     => "Natal",
            ],
            [
                "ibge_codigo"       => 2408201,
                "ibge_estado_id" => 24,
                "nome"     => "Nísia Floresta",
            ],
            [
                "ibge_codigo"       => 2408300,
                "ibge_estado_id" => 24,
                "nome"     => "Nova Cruz",
            ],
            [
                "ibge_codigo"       => 2408409,
                "ibge_estado_id" => 24,
                "nome"     => "Olho-d'Água do Borges",
            ],
            [
                "ibge_codigo"       => 2408508,
                "ibge_estado_id" => 24,
                "nome"     => "Ouro Branco",
            ],
            [
                "ibge_codigo"       => 2408607,
                "ibge_estado_id" => 24,
                "nome"     => "Paraná",
            ],
            [
                "ibge_codigo"       => 2408706,
                "ibge_estado_id" => 24,
                "nome"     => "Paraú",
            ],
            [
                "ibge_codigo"       => 2408805,
                "ibge_estado_id" => 24,
                "nome"     => "Parazinho",
            ],
            [
                "ibge_codigo"       => 2408904,
                "ibge_estado_id" => 24,
                "nome"     => "Parelhas",
            ],
            [
                "ibge_codigo"       => 2408953,
                "ibge_estado_id" => 24,
                "nome"     => "Rio do Fogo",
            ],
            [
                "ibge_codigo"       => 2409100,
                "ibge_estado_id" => 24,
                "nome"     => "Passa e Fica",
            ],
            [
                "ibge_codigo"       => 2409209,
                "ibge_estado_id" => 24,
                "nome"     => "Passagem",
            ],
            [
                "ibge_codigo"       => 2409308,
                "ibge_estado_id" => 24,
                "nome"     => "Patu",
            ],
            [
                "ibge_codigo"       => 2409332,
                "ibge_estado_id" => 24,
                "nome"     => "Santa Maria",
            ],
            [
                "ibge_codigo"       => 2409407,
                "ibge_estado_id" => 24,
                "nome"     => "Pau dos Ferros",
            ],
            [
                "ibge_codigo"       => 2409506,
                "ibge_estado_id" => 24,
                "nome"     => "Pedra Grande",
            ],
            [
                "ibge_codigo"       => 2409605,
                "ibge_estado_id" => 24,
                "nome"     => "Pedra Preta",
            ],
            [
                "ibge_codigo"       => 2409704,
                "ibge_estado_id" => 24,
                "nome"     => "Pedro Avelino",
            ],
            [
                "ibge_codigo"       => 2409803,
                "ibge_estado_id" => 24,
                "nome"     => "Pedro Velho",
            ],
            [
                "ibge_codigo"       => 2409902,
                "ibge_estado_id" => 24,
                "nome"     => "Pendências",
            ],
            [
                "ibge_codigo"       => 2410009,
                "ibge_estado_id" => 24,
                "nome"     => "Pilões",
            ],
            [
                "ibge_codigo"       => 2410108,
                "ibge_estado_id" => 24,
                "nome"     => "Poço Branco",
            ],
            [
                "ibge_codigo"       => 2410207,
                "ibge_estado_id" => 24,
                "nome"     => "Portalegre",
            ],
            [
                "ibge_codigo"       => 2410256,
                "ibge_estado_id" => 24,
                "nome"     => "Porto do Mangue",
            ],
            [
                "ibge_codigo"       => 2410306,
                "ibge_estado_id" => 24,
                "nome"     => "Serra Caiada",
            ],
            [
                "ibge_codigo"       => 2410405,
                "ibge_estado_id" => 24,
                "nome"     => "Pureza",
            ],
            [
                "ibge_codigo"       => 2410504,
                "ibge_estado_id" => 24,
                "nome"     => "Rafael Fernandes",
            ],
            [
                "ibge_codigo"       => 2410603,
                "ibge_estado_id" => 24,
                "nome"     => "Rafael Godeiro",
            ],
            [
                "ibge_codigo"       => 2410702,
                "ibge_estado_id" => 24,
                "nome"     => "Riacho da Cruz",
            ],
            [
                "ibge_codigo"       => 2410801,
                "ibge_estado_id" => 24,
                "nome"     => "Riacho de Santana",
            ],
            [
                "ibge_codigo"       => 2410900,
                "ibge_estado_id" => 24,
                "nome"     => "Riachuelo",
            ],
            [
                "ibge_codigo"       => 2411007,
                "ibge_estado_id" => 24,
                "nome"     => "Rodolfo Fernandes",
            ],
            [
                "ibge_codigo"       => 2411056,
                "ibge_estado_id" => 24,
                "nome"     => "Tibau",
            ],
            [
                "ibge_codigo"       => 2411106,
                "ibge_estado_id" => 24,
                "nome"     => "Ruy Barbosa",
            ],
            [
                "ibge_codigo"       => 2411205,
                "ibge_estado_id" => 24,
                "nome"     => "Santa Cruz",
            ],
            [
                "ibge_codigo"       => 2411403,
                "ibge_estado_id" => 24,
                "nome"     => "Santana do Matos",
            ],
            [
                "ibge_codigo"       => 2411429,
                "ibge_estado_id" => 24,
                "nome"     => "Santana do Seridó",
            ],
            [
                "ibge_codigo"       => 2411502,
                "ibge_estado_id" => 24,
                "nome"     => "Santo Antônio",
            ],
            [
                "ibge_codigo"       => 2411601,
                "ibge_estado_id" => 24,
                "nome"     => "São Bento do Norte",
            ],
            [
                "ibge_codigo"       => 2411700,
                "ibge_estado_id" => 24,
                "nome"     => "São Bento do Trairí",
            ],
            [
                "ibge_codigo"       => 2411809,
                "ibge_estado_id" => 24,
                "nome"     => "São Fernando",
            ],
            [
                "ibge_codigo"       => 2411908,
                "ibge_estado_id" => 24,
                "nome"     => "São Francisco do Oeste",
            ],
            [
                "ibge_codigo"       => 2412005,
                "ibge_estado_id" => 24,
                "nome"     => "São Gonçalo do Amarante",
            ],
            [
                "ibge_codigo"       => 2412104,
                "ibge_estado_id" => 24,
                "nome"     => "São João do Sabugi",
            ],
            [
                "ibge_codigo"       => 2412203,
                "ibge_estado_id" => 24,
                "nome"     => "São José de Mipibu",
            ],
            [
                "ibge_codigo"       => 2412302,
                "ibge_estado_id" => 24,
                "nome"     => "São José do Campestre",
            ],
            [
                "ibge_codigo"       => 2412401,
                "ibge_estado_id" => 24,
                "nome"     => "São José do Seridó",
            ],
            [
                "ibge_codigo"       => 2412500,
                "ibge_estado_id" => 24,
                "nome"     => "São Miguel",
            ],
            [
                "ibge_codigo"       => 2412559,
                "ibge_estado_id" => 24,
                "nome"     => "São Miguel do Gostoso",
            ],
            [
                "ibge_codigo"       => 2412609,
                "ibge_estado_id" => 24,
                "nome"     => "São Paulo do Potengi",
            ],
            [
                "ibge_codigo"       => 2412708,
                "ibge_estado_id" => 24,
                "nome"     => "São Pedro",
            ],
            [
                "ibge_codigo"       => 2412807,
                "ibge_estado_id" => 24,
                "nome"     => "São Rafael",
            ],
            [
                "ibge_codigo"       => 2412906,
                "ibge_estado_id" => 24,
                "nome"     => "São Tomé",
            ],
            [
                "ibge_codigo"       => 2413003,
                "ibge_estado_id" => 24,
                "nome"     => "São Vicente",
            ],
            [
                "ibge_codigo"       => 2413102,
                "ibge_estado_id" => 24,
                "nome"     => "Senador Elói de Souza",
            ],
            [
                "ibge_codigo"       => 2413201,
                "ibge_estado_id" => 24,
                "nome"     => "Senador Georgino Avelino",
            ],
            [
                "ibge_codigo"       => 2413300,
                "ibge_estado_id" => 24,
                "nome"     => "Serra de São Bento",
            ],
            [
                "ibge_codigo"       => 2413359,
                "ibge_estado_id" => 24,
                "nome"     => "Serra do Mel",
            ],
            [
                "ibge_codigo"       => 2413409,
                "ibge_estado_id" => 24,
                "nome"     => "Serra Negra do Norte",
            ],
            [
                "ibge_codigo"       => 2413508,
                "ibge_estado_id" => 24,
                "nome"     => "Serrinha",
            ],
            [
                "ibge_codigo"       => 2413557,
                "ibge_estado_id" => 24,
                "nome"     => "Serrinha dos Pintos",
            ],
            [
                "ibge_codigo"       => 2413607,
                "ibge_estado_id" => 24,
                "nome"     => "Severiano Melo",
            ],
            [
                "ibge_codigo"       => 2413706,
                "ibge_estado_id" => 24,
                "nome"     => "Sítio Novo",
            ],
            [
                "ibge_codigo"       => 2413805,
                "ibge_estado_id" => 24,
                "nome"     => "Taboleiro Grande",
            ],
            [
                "ibge_codigo"       => 2413904,
                "ibge_estado_id" => 24,
                "nome"     => "Taipu",
            ],
            [
                "ibge_codigo"       => 2414001,
                "ibge_estado_id" => 24,
                "nome"     => "Tangará",
            ],
            [
                "ibge_codigo"       => 2414100,
                "ibge_estado_id" => 24,
                "nome"     => "Tenente Ananias",
            ],
            [
                "ibge_codigo"       => 2414159,
                "ibge_estado_id" => 24,
                "nome"     => "Tenente Laurentino Cruz",
            ],
            [
                "ibge_codigo"       => 2414209,
                "ibge_estado_id" => 24,
                "nome"     => "Tibau do Sul",
            ],
            [
                "ibge_codigo"       => 2414308,
                "ibge_estado_id" => 24,
                "nome"     => "Timbaúba dos Batistas",
            ],
            [
                "ibge_codigo"       => 2414407,
                "ibge_estado_id" => 24,
                "nome"     => "Touros",
            ],
            [
                "ibge_codigo"       => 2414456,
                "ibge_estado_id" => 24,
                "nome"     => "Triunfo Potiguar",
            ],
            [
                "ibge_codigo"       => 2414506,
                "ibge_estado_id" => 24,
                "nome"     => "Umarizal",
            ],
            [
                "ibge_codigo"       => 2414605,
                "ibge_estado_id" => 24,
                "nome"     => "Upanema",
            ],
            [
                "ibge_codigo"       => 2414704,
                "ibge_estado_id" => 24,
                "nome"     => "Várzea",
            ],
            [
                "ibge_codigo"       => 2414753,
                "ibge_estado_id" => 24,
                "nome"     => "Venha-Ver",
            ],
            [
                "ibge_codigo"       => 2414803,
                "ibge_estado_id" => 24,
                "nome"     => "Vera Cruz",
            ],
            [
                "ibge_codigo"       => 2414902,
                "ibge_estado_id" => 24,
                "nome"     => "Viçosa",
            ],
            [
                "ibge_codigo"       => 2415008,
                "ibge_estado_id" => 24,
                "nome"     => "Vila Flor",
            ],
            [
                "ibge_codigo"       => 2500106,
                "ibge_estado_id" => 25,
                "nome"     => "Água Branca",
            ],
            [
                "ibge_codigo"       => 2500205,
                "ibge_estado_id" => 25,
                "nome"     => "Aguiar",
            ],
            [
                "ibge_codigo"       => 2500304,
                "ibge_estado_id" => 25,
                "nome"     => "Alagoa Grande",
            ],
            [
                "ibge_codigo"       => 2500403,
                "ibge_estado_id" => 25,
                "nome"     => "Alagoa Nova",
            ],
            [
                "ibge_codigo"       => 2500502,
                "ibge_estado_id" => 25,
                "nome"     => "Alagoinha",
            ],
            [
                "ibge_codigo"       => 2500536,
                "ibge_estado_id" => 25,
                "nome"     => "Alcantil",
            ],
            [
                "ibge_codigo"       => 2500577,
                "ibge_estado_id" => 25,
                "nome"     => "Algodão de Jandaíra",
            ],
            [
                "ibge_codigo"       => 2500601,
                "ibge_estado_id" => 25,
                "nome"     => "Alhandra",
            ],
            [
                "ibge_codigo"       => 2500700,
                "ibge_estado_id" => 25,
                "nome"     => "São João do Rio do Peixe",
            ],
            [
                "ibge_codigo"       => 2500734,
                "ibge_estado_id" => 25,
                "nome"     => "Amparo",
            ],
            [
                "ibge_codigo"       => 2500775,
                "ibge_estado_id" => 25,
                "nome"     => "Aparecida",
            ],
            [
                "ibge_codigo"       => 2500809,
                "ibge_estado_id" => 25,
                "nome"     => "Araçagi",
            ],
            [
                "ibge_codigo"       => 2500908,
                "ibge_estado_id" => 25,
                "nome"     => "Arara",
            ],
            [
                "ibge_codigo"       => 2501005,
                "ibge_estado_id" => 25,
                "nome"     => "Araruna",
            ],
            [
                "ibge_codigo"       => 2501104,
                "ibge_estado_id" => 25,
                "nome"     => "Areia",
            ],
            [
                "ibge_codigo"       => 2501153,
                "ibge_estado_id" => 25,
                "nome"     => "Areia de Baraúnas",
            ],
            [
                "ibge_codigo"       => 2501203,
                "ibge_estado_id" => 25,
                "nome"     => "Areial",
            ],
            [
                "ibge_codigo"       => 2501302,
                "ibge_estado_id" => 25,
                "nome"     => "Aroeiras",
            ],
            [
                "ibge_codigo"       => 2501351,
                "ibge_estado_id" => 25,
                "nome"     => "Assunção",
            ],
            [
                "ibge_codigo"       => 2501401,
                "ibge_estado_id" => 25,
                "nome"     => "Baía da Traição",
            ],
            [
                "ibge_codigo"       => 2501500,
                "ibge_estado_id" => 25,
                "nome"     => "Bananeiras",
            ],
            [
                "ibge_codigo"       => 2501534,
                "ibge_estado_id" => 25,
                "nome"     => "Baraúna",
            ],
            [
                "ibge_codigo"       => 2501575,
                "ibge_estado_id" => 25,
                "nome"     => "Barra de Santana",
            ],
            [
                "ibge_codigo"       => 2501609,
                "ibge_estado_id" => 25,
                "nome"     => "Barra de Santa Rosa",
            ],
            [
                "ibge_codigo"       => 2501708,
                "ibge_estado_id" => 25,
                "nome"     => "Barra de São Miguel",
            ],
            [
                "ibge_codigo"       => 2501807,
                "ibge_estado_id" => 25,
                "nome"     => "Bayeux",
            ],
            [
                "ibge_codigo"       => 2501906,
                "ibge_estado_id" => 25,
                "nome"     => "Belém",
            ],
            [
                "ibge_codigo"       => 2502003,
                "ibge_estado_id" => 25,
                "nome"     => "Belém do Brejo do Cruz",
            ],
            [
                "ibge_codigo"       => 2502052,
                "ibge_estado_id" => 25,
                "nome"     => "Bernardino Batista",
            ],
            [
                "ibge_codigo"       => 2502102,
                "ibge_estado_id" => 25,
                "nome"     => "Boa Ventura",
            ],
            [
                "ibge_codigo"       => 2502151,
                "ibge_estado_id" => 25,
                "nome"     => "Boa Vista",
            ],
            [
                "ibge_codigo"       => 2502201,
                "ibge_estado_id" => 25,
                "nome"     => "Bom Jesus",
            ],
            [
                "ibge_codigo"       => 2502300,
                "ibge_estado_id" => 25,
                "nome"     => "Bom Sucesso",
            ],
            [
                "ibge_codigo"       => 2502409,
                "ibge_estado_id" => 25,
                "nome"     => "Bonito de Santa Fé",
            ],
            [
                "ibge_codigo"       => 2502508,
                "ibge_estado_id" => 25,
                "nome"     => "Boqueirão",
            ],
            [
                "ibge_codigo"       => 2502607,
                "ibge_estado_id" => 25,
                "nome"     => "Igaracy",
            ],
            [
                "ibge_codigo"       => 2502706,
                "ibge_estado_id" => 25,
                "nome"     => "Borborema",
            ],
            [
                "ibge_codigo"       => 2502805,
                "ibge_estado_id" => 25,
                "nome"     => "Brejo do Cruz",
            ],
            [
                "ibge_codigo"       => 2502904,
                "ibge_estado_id" => 25,
                "nome"     => "Brejo dos Santos",
            ],
            [
                "ibge_codigo"       => 2503001,
                "ibge_estado_id" => 25,
                "nome"     => "Caaporã",
            ],
            [
                "ibge_codigo"       => 2503100,
                "ibge_estado_id" => 25,
                "nome"     => "Cabaceiras",
            ],
            [
                "ibge_codigo"       => 2503209,
                "ibge_estado_id" => 25,
                "nome"     => "Cabedelo",
            ],
            [
                "ibge_codigo"       => 2503308,
                "ibge_estado_id" => 25,
                "nome"     => "Cachoeira dos Índios",
            ],
            [
                "ibge_codigo"       => 2503407,
                "ibge_estado_id" => 25,
                "nome"     => "Cacimba de Areia",
            ],
            [
                "ibge_codigo"       => 2503506,
                "ibge_estado_id" => 25,
                "nome"     => "Cacimba de Dentro",
            ],
            [
                "ibge_codigo"       => 2503555,
                "ibge_estado_id" => 25,
                "nome"     => "Cacimbas",
            ],
            [
                "ibge_codigo"       => 2503605,
                "ibge_estado_id" => 25,
                "nome"     => "Caiçara",
            ],
            [
                "ibge_codigo"       => 2503704,
                "ibge_estado_id" => 25,
                "nome"     => "Cajazeiras",
            ],
            [
                "ibge_codigo"       => 2503753,
                "ibge_estado_id" => 25,
                "nome"     => "Cajazeirinhas",
            ],
            [
                "ibge_codigo"       => 2503803,
                "ibge_estado_id" => 25,
                "nome"     => "Caldas Brandão",
            ],
            [
                "ibge_codigo"       => 2503902,
                "ibge_estado_id" => 25,
                "nome"     => "Camalaú",
            ],
            [
                "ibge_codigo"       => 2504009,
                "ibge_estado_id" => 25,
                "nome"     => "Campina Grande",
            ],
            [
                "ibge_codigo"       => 2504033,
                "ibge_estado_id" => 25,
                "nome"     => "Capim",
            ],
            [
                "ibge_codigo"       => 2504074,
                "ibge_estado_id" => 25,
                "nome"     => "Caraúbas",
            ],
            [
                "ibge_codigo"       => 2504108,
                "ibge_estado_id" => 25,
                "nome"     => "Carrapateira",
            ],
            [
                "ibge_codigo"       => 2504157,
                "ibge_estado_id" => 25,
                "nome"     => "Casserengue",
            ],
            [
                "ibge_codigo"       => 2504207,
                "ibge_estado_id" => 25,
                "nome"     => "Catingueira",
            ],
            [
                "ibge_codigo"       => 2504306,
                "ibge_estado_id" => 25,
                "nome"     => "Catolé do Rocha",
            ],
            [
                "ibge_codigo"       => 2504355,
                "ibge_estado_id" => 25,
                "nome"     => "Caturité",
            ],
            [
                "ibge_codigo"       => 2504405,
                "ibge_estado_id" => 25,
                "nome"     => "Conceição",
            ],
            [
                "ibge_codigo"       => 2504504,
                "ibge_estado_id" => 25,
                "nome"     => "Condado",
            ],
            [
                "ibge_codigo"       => 2504603,
                "ibge_estado_id" => 25,
                "nome"     => "Conde",
            ],
            [
                "ibge_codigo"       => 2504702,
                "ibge_estado_id" => 25,
                "nome"     => "Congo",
            ],
            [
                "ibge_codigo"       => 2504801,
                "ibge_estado_id" => 25,
                "nome"     => "Coremas",
            ],
            [
                "ibge_codigo"       => 2504850,
                "ibge_estado_id" => 25,
                "nome"     => "Coxixola",
            ],
            [
                "ibge_codigo"       => 2504900,
                "ibge_estado_id" => 25,
                "nome"     => "Cruz do Espírito Santo",
            ],
            [
                "ibge_codigo"       => 2505006,
                "ibge_estado_id" => 25,
                "nome"     => "Cubati",
            ],
            [
                "ibge_codigo"       => 2505105,
                "ibge_estado_id" => 25,
                "nome"     => "Cuité",
            ],
            [
                "ibge_codigo"       => 2505204,
                "ibge_estado_id" => 25,
                "nome"     => "Cuitegi",
            ],
            [
                "ibge_codigo"       => 2505238,
                "ibge_estado_id" => 25,
                "nome"     => "Cuité de Mamanguape",
            ],
            [
                "ibge_codigo"       => 2505279,
                "ibge_estado_id" => 25,
                "nome"     => "Curral de Cima",
            ],
            [
                "ibge_codigo"       => 2505303,
                "ibge_estado_id" => 25,
                "nome"     => "Curral Velho",
            ],
            [
                "ibge_codigo"       => 2505352,
                "ibge_estado_id" => 25,
                "nome"     => "Damião",
            ],
            [
                "ibge_codigo"       => 2505402,
                "ibge_estado_id" => 25,
                "nome"     => "Desterro",
            ],
            [
                "ibge_codigo"       => 2505501,
                "ibge_estado_id" => 25,
                "nome"     => "Vista Serrana",
            ],
            [
                "ibge_codigo"       => 2505600,
                "ibge_estado_id" => 25,
                "nome"     => "Diamante",
            ],
            [
                "ibge_codigo"       => 2505709,
                "ibge_estado_id" => 25,
                "nome"     => "Dona Inês",
            ],
            [
                "ibge_codigo"       => 2505808,
                "ibge_estado_id" => 25,
                "nome"     => "Duas Estradas",
            ],
            [
                "ibge_codigo"       => 2505907,
                "ibge_estado_id" => 25,
                "nome"     => "Emas",
            ],
            [
                "ibge_codigo"       => 2506004,
                "ibge_estado_id" => 25,
                "nome"     => "Esperança",
            ],
            [
                "ibge_codigo"       => 2506103,
                "ibge_estado_id" => 25,
                "nome"     => "Fagundes",
            ],
            [
                "ibge_codigo"       => 2506202,
                "ibge_estado_id" => 25,
                "nome"     => "Frei Martinho",
            ],
            [
                "ibge_codigo"       => 2506251,
                "ibge_estado_id" => 25,
                "nome"     => "Gado Bravo",
            ],
            [
                "ibge_codigo"       => 2506301,
                "ibge_estado_id" => 25,
                "nome"     => "Guarabira",
            ],
            [
                "ibge_codigo"       => 2506400,
                "ibge_estado_id" => 25,
                "nome"     => "Gurinhém",
            ],
            [
                "ibge_codigo"       => 2506509,
                "ibge_estado_id" => 25,
                "nome"     => "Gurjão",
            ],
            [
                "ibge_codigo"       => 2506608,
                "ibge_estado_id" => 25,
                "nome"     => "Ibiara",
            ],
            [
                "ibge_codigo"       => 2506707,
                "ibge_estado_id" => 25,
                "nome"     => "Imaculada",
            ],
            [
                "ibge_codigo"       => 2506806,
                "ibge_estado_id" => 25,
                "nome"     => "Ingá",
            ],
            [
                "ibge_codigo"       => 2506905,
                "ibge_estado_id" => 25,
                "nome"     => "Itabaiana",
            ],
            [
                "ibge_codigo"       => 2507002,
                "ibge_estado_id" => 25,
                "nome"     => "Itaporanga",
            ],
            [
                "ibge_codigo"       => 2507101,
                "ibge_estado_id" => 25,
                "nome"     => "Itapororoca",
            ],
            [
                "ibge_codigo"       => 2507200,
                "ibge_estado_id" => 25,
                "nome"     => "Itatuba",
            ],
            [
                "ibge_codigo"       => 2507309,
                "ibge_estado_id" => 25,
                "nome"     => "Jacaraú",
            ],
            [
                "ibge_codigo"       => 2507408,
                "ibge_estado_id" => 25,
                "nome"     => "Jericó",
            ],
            [
                "ibge_codigo"       => 2507507,
                "ibge_estado_id" => 25,
                "nome"     => "João Pessoa",
            ],
            [
                "ibge_codigo"       => 2507606,
                "ibge_estado_id" => 25,
                "nome"     => "Juarez Távora",
            ],
            [
                "ibge_codigo"       => 2507705,
                "ibge_estado_id" => 25,
                "nome"     => "Juazeirinho",
            ],
            [
                "ibge_codigo"       => 2507804,
                "ibge_estado_id" => 25,
                "nome"     => "Junco do Seridó",
            ],
            [
                "ibge_codigo"       => 2507903,
                "ibge_estado_id" => 25,
                "nome"     => "Juripiranga",
            ],
            [
                "ibge_codigo"       => 2508000,
                "ibge_estado_id" => 25,
                "nome"     => "Juru",
            ],
            [
                "ibge_codigo"       => 2508109,
                "ibge_estado_id" => 25,
                "nome"     => "Lagoa",
            ],
            [
                "ibge_codigo"       => 2508208,
                "ibge_estado_id" => 25,
                "nome"     => "Lagoa de Dentro",
            ],
            [
                "ibge_codigo"       => 2508307,
                "ibge_estado_id" => 25,
                "nome"     => "Lagoa Seca",
            ],
            [
                "ibge_codigo"       => 2508406,
                "ibge_estado_id" => 25,
                "nome"     => "Lastro",
            ],
            [
                "ibge_codigo"       => 2508505,
                "ibge_estado_id" => 25,
                "nome"     => "Livramento",
            ],
            [
                "ibge_codigo"       => 2508554,
                "ibge_estado_id" => 25,
                "nome"     => "Logradouro",
            ],
            [
                "ibge_codigo"       => 2508604,
                "ibge_estado_id" => 25,
                "nome"     => "Lucena",
            ],
            [
                "ibge_codigo"       => 2508703,
                "ibge_estado_id" => 25,
                "nome"     => "Mãe d'Água",
            ],
            [
                "ibge_codigo"       => 2508802,
                "ibge_estado_id" => 25,
                "nome"     => "Malta",
            ],
            [
                "ibge_codigo"       => 2508901,
                "ibge_estado_id" => 25,
                "nome"     => "Mamanguape",
            ],
            [
                "ibge_codigo"       => 2509008,
                "ibge_estado_id" => 25,
                "nome"     => "Manaíra",
            ],
            [
                "ibge_codigo"       => 2509057,
                "ibge_estado_id" => 25,
                "nome"     => "Marcação",
            ],
            [
                "ibge_codigo"       => 2509107,
                "ibge_estado_id" => 25,
                "nome"     => "Mari",
            ],
            [
                "ibge_codigo"       => 2509156,
                "ibge_estado_id" => 25,
                "nome"     => "Marizópolis",
            ],
            [
                "ibge_codigo"       => 2509206,
                "ibge_estado_id" => 25,
                "nome"     => "Massaranduba",
            ],
            [
                "ibge_codigo"       => 2509305,
                "ibge_estado_id" => 25,
                "nome"     => "Mataraca",
            ],
            [
                "ibge_codigo"       => 2509339,
                "ibge_estado_id" => 25,
                "nome"     => "Matinhas",
            ],
            [
                "ibge_codigo"       => 2509370,
                "ibge_estado_id" => 25,
                "nome"     => "Mato Grosso",
            ],
            [
                "ibge_codigo"       => 2509396,
                "ibge_estado_id" => 25,
                "nome"     => "Maturéia",
            ],
            [
                "ibge_codigo"       => 2509404,
                "ibge_estado_id" => 25,
                "nome"     => "Mogeiro",
            ],
            [
                "ibge_codigo"       => 2509503,
                "ibge_estado_id" => 25,
                "nome"     => "Montadas",
            ],
            [
                "ibge_codigo"       => 2509602,
                "ibge_estado_id" => 25,
                "nome"     => "Monte Horebe",
            ],
            [
                "ibge_codigo"       => 2509701,
                "ibge_estado_id" => 25,
                "nome"     => "Monteiro",
            ],
            [
                "ibge_codigo"       => 2509800,
                "ibge_estado_id" => 25,
                "nome"     => "Mulungu",
            ],
            [
                "ibge_codigo"       => 2509909,
                "ibge_estado_id" => 25,
                "nome"     => "Natuba",
            ],
            [
                "ibge_codigo"       => 2510006,
                "ibge_estado_id" => 25,
                "nome"     => "Nazarezinho",
            ],
            [
                "ibge_codigo"       => 2510105,
                "ibge_estado_id" => 25,
                "nome"     => "Nova Floresta",
            ],
            [
                "ibge_codigo"       => 2510204,
                "ibge_estado_id" => 25,
                "nome"     => "Nova Olinda",
            ],
            [
                "ibge_codigo"       => 2510303,
                "ibge_estado_id" => 25,
                "nome"     => "Nova Palmeira",
            ],
            [
                "ibge_codigo"       => 2510402,
                "ibge_estado_id" => 25,
                "nome"     => "Olho d'Água",
            ],
            [
                "ibge_codigo"       => 2510501,
                "ibge_estado_id" => 25,
                "nome"     => "Olivedos",
            ],
            [
                "ibge_codigo"       => 2510600,
                "ibge_estado_id" => 25,
                "nome"     => "Ouro Velho",
            ],
            [
                "ibge_codigo"       => 2510659,
                "ibge_estado_id" => 25,
                "nome"     => "Parari",
            ],
            [
                "ibge_codigo"       => 2510709,
                "ibge_estado_id" => 25,
                "nome"     => "Passagem",
            ],
            [
                "ibge_codigo"       => 2510808,
                "ibge_estado_id" => 25,
                "nome"     => "Patos",
            ],
            [
                "ibge_codigo"       => 2510907,
                "ibge_estado_id" => 25,
                "nome"     => "Paulista",
            ],
            [
                "ibge_codigo"       => 2511004,
                "ibge_estado_id" => 25,
                "nome"     => "Pedra Branca",
            ],
            [
                "ibge_codigo"       => 2511103,
                "ibge_estado_id" => 25,
                "nome"     => "Pedra Lavrada",
            ],
            [
                "ibge_codigo"       => 2511202,
                "ibge_estado_id" => 25,
                "nome"     => "Pedras de Fogo",
            ],
            [
                "ibge_codigo"       => 2511301,
                "ibge_estado_id" => 25,
                "nome"     => "Piancó",
            ],
            [
                "ibge_codigo"       => 2511400,
                "ibge_estado_id" => 25,
                "nome"     => "Picuí",
            ],
            [
                "ibge_codigo"       => 2511509,
                "ibge_estado_id" => 25,
                "nome"     => "Pilar",
            ],
            [
                "ibge_codigo"       => 2511608,
                "ibge_estado_id" => 25,
                "nome"     => "Pilões",
            ],
            [
                "ibge_codigo"       => 2511707,
                "ibge_estado_id" => 25,
                "nome"     => "Pilõezinhos",
            ],
            [
                "ibge_codigo"       => 2511806,
                "ibge_estado_id" => 25,
                "nome"     => "Pirpirituba",
            ],
            [
                "ibge_codigo"       => 2511905,
                "ibge_estado_id" => 25,
                "nome"     => "Pitimbu",
            ],
            [
                "ibge_codigo"       => 2512002,
                "ibge_estado_id" => 25,
                "nome"     => "Pocinhos",
            ],
            [
                "ibge_codigo"       => 2512036,
                "ibge_estado_id" => 25,
                "nome"     => "Poço Dantas",
            ],
            [
                "ibge_codigo"       => 2512077,
                "ibge_estado_id" => 25,
                "nome"     => "Poço de José de Moura",
            ],
            [
                "ibge_codigo"       => 2512101,
                "ibge_estado_id" => 25,
                "nome"     => "Pombal",
            ],
            [
                "ibge_codigo"       => 2512200,
                "ibge_estado_id" => 25,
                "nome"     => "Prata",
            ],
            [
                "ibge_codigo"       => 2512309,
                "ibge_estado_id" => 25,
                "nome"     => "Princesa Isabel",
            ],
            [
                "ibge_codigo"       => 2512408,
                "ibge_estado_id" => 25,
                "nome"     => "Puxinanã",
            ],
            [
                "ibge_codigo"       => 2512507,
                "ibge_estado_id" => 25,
                "nome"     => "Queimadas",
            ],
            [
                "ibge_codigo"       => 2512606,
                "ibge_estado_id" => 25,
                "nome"     => "Quixabá",
            ],
            [
                "ibge_codigo"       => 2512705,
                "ibge_estado_id" => 25,
                "nome"     => "Remígio",
            ],
            [
                "ibge_codigo"       => 2512721,
                "ibge_estado_id" => 25,
                "nome"     => "Pedro Régis",
            ],
            [
                "ibge_codigo"       => 2512747,
                "ibge_estado_id" => 25,
                "nome"     => "Riachão",
            ],
            [
                "ibge_codigo"       => 2512754,
                "ibge_estado_id" => 25,
                "nome"     => "Riachão do Bacamarte",
            ],
            [
                "ibge_codigo"       => 2512762,
                "ibge_estado_id" => 25,
                "nome"     => "Riachão do Poço",
            ],
            [
                "ibge_codigo"       => 2512788,
                "ibge_estado_id" => 25,
                "nome"     => "Riacho de Santo Antônio",
            ],
            [
                "ibge_codigo"       => 2512804,
                "ibge_estado_id" => 25,
                "nome"     => "Riacho dos Cavalos",
            ],
            [
                "ibge_codigo"       => 2512903,
                "ibge_estado_id" => 25,
                "nome"     => "Rio Tinto",
            ],
            [
                "ibge_codigo"       => 2513000,
                "ibge_estado_id" => 25,
                "nome"     => "Salgadinho",
            ],
            [
                "ibge_codigo"       => 2513109,
                "ibge_estado_id" => 25,
                "nome"     => "Salgado de São Félix",
            ],
            [
                "ibge_codigo"       => 2513158,
                "ibge_estado_id" => 25,
                "nome"     => "Santa Cecília",
            ],
            [
                "ibge_codigo"       => 2513208,
                "ibge_estado_id" => 25,
                "nome"     => "Santa Cruz",
            ],
            [
                "ibge_codigo"       => 2513307,
                "ibge_estado_id" => 25,
                "nome"     => "Santa Helena",
            ],
            [
                "ibge_codigo"       => 2513356,
                "ibge_estado_id" => 25,
                "nome"     => "Santa Inês",
            ],
            [
                "ibge_codigo"       => 2513406,
                "ibge_estado_id" => 25,
                "nome"     => "Santa Luzia",
            ],
            [
                "ibge_codigo"       => 2513505,
                "ibge_estado_id" => 25,
                "nome"     => "Santana de Mangueira",
            ],
            [
                "ibge_codigo"       => 2513604,
                "ibge_estado_id" => 25,
                "nome"     => "Santana dos Garrotes",
            ],
            [
                "ibge_codigo"       => 2513653,
                "ibge_estado_id" => 25,
                "nome"     => "Joca Claudino",
            ],
            [
                "ibge_codigo"       => 2513703,
                "ibge_estado_id" => 25,
                "nome"     => "Santa Rita",
            ],
            [
                "ibge_codigo"       => 2513802,
                "ibge_estado_id" => 25,
                "nome"     => "Santa Teresinha",
            ],
            [
                "ibge_codigo"       => 2513851,
                "ibge_estado_id" => 25,
                "nome"     => "Santo André",
            ],
            [
                "ibge_codigo"       => 2513901,
                "ibge_estado_id" => 25,
                "nome"     => "São Bento",
            ],
            [
                "ibge_codigo"       => 2513927,
                "ibge_estado_id" => 25,
                "nome"     => "São Bentinho",
            ],
            [
                "ibge_codigo"       => 2513943,
                "ibge_estado_id" => 25,
                "nome"     => "São Domingos do Cariri",
            ],
            [
                "ibge_codigo"       => 2513968,
                "ibge_estado_id" => 25,
                "nome"     => "São Domingos",
            ],
            [
                "ibge_codigo"       => 2513984,
                "ibge_estado_id" => 25,
                "nome"     => "São Francisco",
            ],
            [
                "ibge_codigo"       => 2514008,
                "ibge_estado_id" => 25,
                "nome"     => "São João do Cariri",
            ],
            [
                "ibge_codigo"       => 2514107,
                "ibge_estado_id" => 25,
                "nome"     => "São João do Tigre",
            ],
            [
                "ibge_codigo"       => 2514206,
                "ibge_estado_id" => 25,
                "nome"     => "São José da Lagoa Tapada",
            ],
            [
                "ibge_codigo"       => 2514305,
                "ibge_estado_id" => 25,
                "nome"     => "São José de Caiana",
            ],
            [
                "ibge_codigo"       => 2514404,
                "ibge_estado_id" => 25,
                "nome"     => "São José de Espinharas",
            ],
            [
                "ibge_codigo"       => 2514453,
                "ibge_estado_id" => 25,
                "nome"     => "São José dos Ramos",
            ],
            [
                "ibge_codigo"       => 2514503,
                "ibge_estado_id" => 25,
                "nome"     => "São José de Piranhas",
            ],
            [
                "ibge_codigo"       => 2514552,
                "ibge_estado_id" => 25,
                "nome"     => "São José de Princesa",
            ],
            [
                "ibge_codigo"       => 2514602,
                "ibge_estado_id" => 25,
                "nome"     => "São José do Bonfim",
            ],
            [
                "ibge_codigo"       => 2514651,
                "ibge_estado_id" => 25,
                "nome"     => "São José do Brejo do Cruz",
            ],
            [
                "ibge_codigo"       => 2514701,
                "ibge_estado_id" => 25,
                "nome"     => "São José do Sabugi",
            ],
            [
                "ibge_codigo"       => 2514800,
                "ibge_estado_id" => 25,
                "nome"     => "São José dos Cordeiros",
            ],
            [
                "ibge_codigo"       => 2514909,
                "ibge_estado_id" => 25,
                "nome"     => "São Mamede",
            ],
            [
                "ibge_codigo"       => 2515005,
                "ibge_estado_id" => 25,
                "nome"     => "São Miguel de Taipu",
            ],
            [
                "ibge_codigo"       => 2515104,
                "ibge_estado_id" => 25,
                "nome"     => "São Sebastião de Lagoa de Roça",
            ],
            [
                "ibge_codigo"       => 2515203,
                "ibge_estado_id" => 25,
                "nome"     => "São Sebastião do Umbuzeiro",
            ],
            [
                "ibge_codigo"       => 2515302,
                "ibge_estado_id" => 25,
                "nome"     => "Sapé",
            ],
            [
                "ibge_codigo"       => 2515401,
                "ibge_estado_id" => 25,
                "nome"     => "São Vicente do Seridó",
            ],
            [
                "ibge_codigo"       => 2515500,
                "ibge_estado_id" => 25,
                "nome"     => "Serra Branca",
            ],
            [
                "ibge_codigo"       => 2515609,
                "ibge_estado_id" => 25,
                "nome"     => "Serra da Raiz",
            ],
            [
                "ibge_codigo"       => 2515708,
                "ibge_estado_id" => 25,
                "nome"     => "Serra Grande",
            ],
            [
                "ibge_codigo"       => 2515807,
                "ibge_estado_id" => 25,
                "nome"     => "Serra Redonda",
            ],
            [
                "ibge_codigo"       => 2515906,
                "ibge_estado_id" => 25,
                "nome"     => "Serraria",
            ],
            [
                "ibge_codigo"       => 2515930,
                "ibge_estado_id" => 25,
                "nome"     => "Sertãozinho",
            ],
            [
                "ibge_codigo"       => 2515971,
                "ibge_estado_id" => 25,
                "nome"     => "Sobrado",
            ],
            [
                "ibge_codigo"       => 2516003,
                "ibge_estado_id" => 25,
                "nome"     => "Solânea",
            ],
            [
                "ibge_codigo"       => 2516102,
                "ibge_estado_id" => 25,
                "nome"     => "Soledade",
            ],
            [
                "ibge_codigo"       => 2516151,
                "ibge_estado_id" => 25,
                "nome"     => "Sossêgo",
            ],
            [
                "ibge_codigo"       => 2516201,
                "ibge_estado_id" => 25,
                "nome"     => "Sousa",
            ],
            [
                "ibge_codigo"       => 2516300,
                "ibge_estado_id" => 25,
                "nome"     => "Sumé",
            ],
            [
                "ibge_codigo"       => 2516409,
                "ibge_estado_id" => 25,
                "nome"     => "Tacima",
            ],
            [
                "ibge_codigo"       => 2516508,
                "ibge_estado_id" => 25,
                "nome"     => "Taperoá",
            ],
            [
                "ibge_codigo"       => 2516607,
                "ibge_estado_id" => 25,
                "nome"     => "Tavares",
            ],
            [
                "ibge_codigo"       => 2516706,
                "ibge_estado_id" => 25,
                "nome"     => "Teixeira",
            ],
            [
                "ibge_codigo"       => 2516755,
                "ibge_estado_id" => 25,
                "nome"     => "Tenório",
            ],
            [
                "ibge_codigo"       => 2516805,
                "ibge_estado_id" => 25,
                "nome"     => "Triunfo",
            ],
            [
                "ibge_codigo"       => 2516904,
                "ibge_estado_id" => 25,
                "nome"     => "Uiraúna",
            ],
            [
                "ibge_codigo"       => 2517001,
                "ibge_estado_id" => 25,
                "nome"     => "Umbuzeiro",
            ],
            [
                "ibge_codigo"       => 2517100,
                "ibge_estado_id" => 25,
                "nome"     => "Várzea",
            ],
            [
                "ibge_codigo"       => 2517209,
                "ibge_estado_id" => 25,
                "nome"     => "Vieirópolis",
            ],
            [
                "ibge_codigo"       => 2517407,
                "ibge_estado_id" => 25,
                "nome"     => "Zabelê",
            ],
            [
                "ibge_codigo"       => 2600054,
                "ibge_estado_id" => 26,
                "nome"     => "Abreu e Lima",
            ],
            [
                "ibge_codigo"       => 2600104,
                "ibge_estado_id" => 26,
                "nome"     => "Afogados da Ingazeira",
            ],
            [
                "ibge_codigo"       => 2600203,
                "ibge_estado_id" => 26,
                "nome"     => "Afrânio",
            ],
            [
                "ibge_codigo"       => 2600302,
                "ibge_estado_id" => 26,
                "nome"     => "Agrestina",
            ],
            [
                "ibge_codigo"       => 2600401,
                "ibge_estado_id" => 26,
                "nome"     => "Água Preta",
            ],
            [
                "ibge_codigo"       => 2600500,
                "ibge_estado_id" => 26,
                "nome"     => "Águas Belas",
            ],
            [
                "ibge_codigo"       => 2600609,
                "ibge_estado_id" => 26,
                "nome"     => "Alagoinha",
            ],
            [
                "ibge_codigo"       => 2600708,
                "ibge_estado_id" => 26,
                "nome"     => "Aliança",
            ],
            [
                "ibge_codigo"       => 2600807,
                "ibge_estado_id" => 26,
                "nome"     => "Altinho",
            ],
            [
                "ibge_codigo"       => 2600906,
                "ibge_estado_id" => 26,
                "nome"     => "Amaraji",
            ],
            [
                "ibge_codigo"       => 2601003,
                "ibge_estado_id" => 26,
                "nome"     => "Angelim",
            ],
            [
                "ibge_codigo"       => 2601052,
                "ibge_estado_id" => 26,
                "nome"     => "Araçoiaba",
            ],
            [
                "ibge_codigo"       => 2601102,
                "ibge_estado_id" => 26,
                "nome"     => "Araripina",
            ],
            [
                "ibge_codigo"       => 2601201,
                "ibge_estado_id" => 26,
                "nome"     => "Arcoverde",
            ],
            [
                "ibge_codigo"       => 2601300,
                "ibge_estado_id" => 26,
                "nome"     => "Barra de Guabiraba",
            ],
            [
                "ibge_codigo"       => 2601409,
                "ibge_estado_id" => 26,
                "nome"     => "Barreiros",
            ],
            [
                "ibge_codigo"       => 2601508,
                "ibge_estado_id" => 26,
                "nome"     => "Belém de Maria",
            ],
            [
                "ibge_codigo"       => 2601607,
                "ibge_estado_id" => 26,
                "nome"     => "Belém de São Francisco",
            ],
            [
                "ibge_codigo"       => 2601706,
                "ibge_estado_id" => 26,
                "nome"     => "Belo Jardim",
            ],
            [
                "ibge_codigo"       => 2601805,
                "ibge_estado_id" => 26,
                "nome"     => "Betânia",
            ],
            [
                "ibge_codigo"       => 2601904,
                "ibge_estado_id" => 26,
                "nome"     => "Bezerros",
            ],
            [
                "ibge_codigo"       => 2602001,
                "ibge_estado_id" => 26,
                "nome"     => "Bodocó",
            ],
            [
                "ibge_codigo"       => 2602100,
                "ibge_estado_id" => 26,
                "nome"     => "Bom Conselho",
            ],
            [
                "ibge_codigo"       => 2602209,
                "ibge_estado_id" => 26,
                "nome"     => "Bom Jardim",
            ],
            [
                "ibge_codigo"       => 2602308,
                "ibge_estado_id" => 26,
                "nome"     => "Bonito",
            ],
            [
                "ibge_codigo"       => 2602407,
                "ibge_estado_id" => 26,
                "nome"     => "Brejão",
            ],
            [
                "ibge_codigo"       => 2602506,
                "ibge_estado_id" => 26,
                "nome"     => "Brejinho",
            ],
            [
                "ibge_codigo"       => 2602605,
                "ibge_estado_id" => 26,
                "nome"     => "Brejo da Madre de Deus",
            ],
            [
                "ibge_codigo"       => 2602704,
                "ibge_estado_id" => 26,
                "nome"     => "Buenos Aires",
            ],
            [
                "ibge_codigo"       => 2602803,
                "ibge_estado_id" => 26,
                "nome"     => "Buíque",
            ],
            [
                "ibge_codigo"       => 2602902,
                "ibge_estado_id" => 26,
                "nome"     => "Cabo de Santo Agostinho",
            ],
            [
                "ibge_codigo"       => 2603009,
                "ibge_estado_id" => 26,
                "nome"     => "Cabrobó",
            ],
            [
                "ibge_codigo"       => 2603108,
                "ibge_estado_id" => 26,
                "nome"     => "Cachoeirinha",
            ],
            [
                "ibge_codigo"       => 2603207,
                "ibge_estado_id" => 26,
                "nome"     => "Caetés",
            ],
            [
                "ibge_codigo"       => 2603306,
                "ibge_estado_id" => 26,
                "nome"     => "Calçado",
            ],
            [
                "ibge_codigo"       => 2603405,
                "ibge_estado_id" => 26,
                "nome"     => "Calumbi",
            ],
            [
                "ibge_codigo"       => 2603454,
                "ibge_estado_id" => 26,
                "nome"     => "Camaragibe",
            ],
            [
                "ibge_codigo"       => 2603504,
                "ibge_estado_id" => 26,
                "nome"     => "Camocim de São Félix",
            ],
            [
                "ibge_codigo"       => 2603603,
                "ibge_estado_id" => 26,
                "nome"     => "Camutanga",
            ],
            [
                "ibge_codigo"       => 2603702,
                "ibge_estado_id" => 26,
                "nome"     => "Canhotinho",
            ],
            [
                "ibge_codigo"       => 2603801,
                "ibge_estado_id" => 26,
                "nome"     => "Capoeiras",
            ],
            [
                "ibge_codigo"       => 2603900,
                "ibge_estado_id" => 26,
                "nome"     => "Carnaíba",
            ],
            [
                "ibge_codigo"       => 2603926,
                "ibge_estado_id" => 26,
                "nome"     => "Carnaubeira da Penha",
            ],
            [
                "ibge_codigo"       => 2604007,
                "ibge_estado_id" => 26,
                "nome"     => "Carpina",
            ],
            [
                "ibge_codigo"       => 2604106,
                "ibge_estado_id" => 26,
                "nome"     => "Caruaru",
            ],
            [
                "ibge_codigo"       => 2604155,
                "ibge_estado_id" => 26,
                "nome"     => "Casinhas",
            ],
            [
                "ibge_codigo"       => 2604205,
                "ibge_estado_id" => 26,
                "nome"     => "Catende",
            ],
            [
                "ibge_codigo"       => 2604304,
                "ibge_estado_id" => 26,
                "nome"     => "Cedro",
            ],
            [
                "ibge_codigo"       => 2604403,
                "ibge_estado_id" => 26,
                "nome"     => "Chã de Alegria",
            ],
            [
                "ibge_codigo"       => 2604502,
                "ibge_estado_id" => 26,
                "nome"     => "Chã Grande",
            ],
            [
                "ibge_codigo"       => 2604601,
                "ibge_estado_id" => 26,
                "nome"     => "Condado",
            ],
            [
                "ibge_codigo"       => 2604700,
                "ibge_estado_id" => 26,
                "nome"     => "Correntes",
            ],
            [
                "ibge_codigo"       => 2604809,
                "ibge_estado_id" => 26,
                "nome"     => "Cortês",
            ],
            [
                "ibge_codigo"       => 2604908,
                "ibge_estado_id" => 26,
                "nome"     => "Cumaru",
            ],
            [
                "ibge_codigo"       => 2605004,
                "ibge_estado_id" => 26,
                "nome"     => "Cupira",
            ],
            [
                "ibge_codigo"       => 2605103,
                "ibge_estado_id" => 26,
                "nome"     => "Custódia",
            ],
            [
                "ibge_codigo"       => 2605152,
                "ibge_estado_id" => 26,
                "nome"     => "Dormentes",
            ],
            [
                "ibge_codigo"       => 2605202,
                "ibge_estado_id" => 26,
                "nome"     => "Escada",
            ],
            [
                "ibge_codigo"       => 2605301,
                "ibge_estado_id" => 26,
                "nome"     => "Exu",
            ],
            [
                "ibge_codigo"       => 2605400,
                "ibge_estado_id" => 26,
                "nome"     => "Feira Nova",
            ],
            [
                "ibge_codigo"       => 2605459,
                "ibge_estado_id" => 26,
                "nome"     => "Fernando de Noronha",
            ],
            [
                "ibge_codigo"       => 2605509,
                "ibge_estado_id" => 26,
                "nome"     => "Ferreiros",
            ],
            [
                "ibge_codigo"       => 2605608,
                "ibge_estado_id" => 26,
                "nome"     => "Flores",
            ],
            [
                "ibge_codigo"       => 2605707,
                "ibge_estado_id" => 26,
                "nome"     => "Floresta",
            ],
            [
                "ibge_codigo"       => 2605806,
                "ibge_estado_id" => 26,
                "nome"     => "Frei Miguelinho",
            ],
            [
                "ibge_codigo"       => 2605905,
                "ibge_estado_id" => 26,
                "nome"     => "Gameleira",
            ],
            [
                "ibge_codigo"       => 2606002,
                "ibge_estado_id" => 26,
                "nome"     => "Garanhuns",
            ],
            [
                "ibge_codigo"       => 2606101,
                "ibge_estado_id" => 26,
                "nome"     => "Glória do Goitá",
            ],
            [
                "ibge_codigo"       => 2606200,
                "ibge_estado_id" => 26,
                "nome"     => "Goiana",
            ],
            [
                "ibge_codigo"       => 2606309,
                "ibge_estado_id" => 26,
                "nome"     => "Granito",
            ],
            [
                "ibge_codigo"       => 2606408,
                "ibge_estado_id" => 26,
                "nome"     => "Gravatá",
            ],
            [
                "ibge_codigo"       => 2606507,
                "ibge_estado_id" => 26,
                "nome"     => "Iati",
            ],
            [
                "ibge_codigo"       => 2606606,
                "ibge_estado_id" => 26,
                "nome"     => "Ibimirim",
            ],
            [
                "ibge_codigo"       => 2606705,
                "ibge_estado_id" => 26,
                "nome"     => "Ibirajuba",
            ],
            [
                "ibge_codigo"       => 2606804,
                "ibge_estado_id" => 26,
                "nome"     => "Igarassu",
            ],
            [
                "ibge_codigo"       => 2606903,
                "ibge_estado_id" => 26,
                "nome"     => "Iguaraci",
            ],
            [
                "ibge_codigo"       => 2607000,
                "ibge_estado_id" => 26,
                "nome"     => "Inajá",
            ],
            [
                "ibge_codigo"       => 2607109,
                "ibge_estado_id" => 26,
                "nome"     => "Ingazeira",
            ],
            [
                "ibge_codigo"       => 2607208,
                "ibge_estado_id" => 26,
                "nome"     => "Ipojuca",
            ],
            [
                "ibge_codigo"       => 2607307,
                "ibge_estado_id" => 26,
                "nome"     => "Ipubi",
            ],
            [
                "ibge_codigo"       => 2607406,
                "ibge_estado_id" => 26,
                "nome"     => "Itacuruba",
            ],
            [
                "ibge_codigo"       => 2607505,
                "ibge_estado_id" => 26,
                "nome"     => "Itaíba",
            ],
            [
                "ibge_codigo"       => 2607604,
                "ibge_estado_id" => 26,
                "nome"     => "Ilha de Itamaracá",
            ],
            [
                "ibge_codigo"       => 2607653,
                "ibge_estado_id" => 26,
                "nome"     => "Itambé",
            ],
            [
                "ibge_codigo"       => 2607703,
                "ibge_estado_id" => 26,
                "nome"     => "Itapetim",
            ],
            [
                "ibge_codigo"       => 2607752,
                "ibge_estado_id" => 26,
                "nome"     => "Itapissuma",
            ],
            [
                "ibge_codigo"       => 2607802,
                "ibge_estado_id" => 26,
                "nome"     => "Itaquitinga",
            ],
            [
                "ibge_codigo"       => 2607901,
                "ibge_estado_id" => 26,
                "nome"     => "Jaboatão dos Guararapes",
            ],
            [
                "ibge_codigo"       => 2607950,
                "ibge_estado_id" => 26,
                "nome"     => "Jaqueira",
            ],
            [
                "ibge_codigo"       => 2608008,
                "ibge_estado_id" => 26,
                "nome"     => "Jataúba",
            ],
            [
                "ibge_codigo"       => 2608057,
                "ibge_estado_id" => 26,
                "nome"     => "Jatobá",
            ],
            [
                "ibge_codigo"       => 2608107,
                "ibge_estado_id" => 26,
                "nome"     => "João Alfredo",
            ],
            [
                "ibge_codigo"       => 2608206,
                "ibge_estado_id" => 26,
                "nome"     => "Joaquim Nabuco",
            ],
            [
                "ibge_codigo"       => 2608255,
                "ibge_estado_id" => 26,
                "nome"     => "Jucati",
            ],
            [
                "ibge_codigo"       => 2608305,
                "ibge_estado_id" => 26,
                "nome"     => "Jupi",
            ],
            [
                "ibge_codigo"       => 2608404,
                "ibge_estado_id" => 26,
                "nome"     => "Jurema",
            ],
            [
                "ibge_codigo"       => 2608453,
                "ibge_estado_id" => 26,
                "nome"     => "Lagoa do Carro",
            ],
            [
                "ibge_codigo"       => 2608503,
                "ibge_estado_id" => 26,
                "nome"     => "Lagoa do Itaenga",
            ],
            [
                "ibge_codigo"       => 2608602,
                "ibge_estado_id" => 26,
                "nome"     => "Lagoa do Ouro",
            ],
            [
                "ibge_codigo"       => 2608701,
                "ibge_estado_id" => 26,
                "nome"     => "Lagoa dos Gatos",
            ],
            [
                "ibge_codigo"       => 2608750,
                "ibge_estado_id" => 26,
                "nome"     => "Lagoa Grande",
            ],
            [
                "ibge_codigo"       => 2608800,
                "ibge_estado_id" => 26,
                "nome"     => "Lajedo",
            ],
            [
                "ibge_codigo"       => 2608909,
                "ibge_estado_id" => 26,
                "nome"     => "Limoeiro",
            ],
            [
                "ibge_codigo"       => 2609006,
                "ibge_estado_id" => 26,
                "nome"     => "Macaparana",
            ],
            [
                "ibge_codigo"       => 2609105,
                "ibge_estado_id" => 26,
                "nome"     => "Machados",
            ],
            [
                "ibge_codigo"       => 2609154,
                "ibge_estado_id" => 26,
                "nome"     => "Manari",
            ],
            [
                "ibge_codigo"       => 2609204,
                "ibge_estado_id" => 26,
                "nome"     => "Maraial",
            ],
            [
                "ibge_codigo"       => 2609303,
                "ibge_estado_id" => 26,
                "nome"     => "Mirandiba",
            ],
            [
                "ibge_codigo"       => 2609402,
                "ibge_estado_id" => 26,
                "nome"     => "Moreno",
            ],
            [
                "ibge_codigo"       => 2609501,
                "ibge_estado_id" => 26,
                "nome"     => "Nazaré da Mata",
            ],
            [
                "ibge_codigo"       => 2609600,
                "ibge_estado_id" => 26,
                "nome"     => "Olinda",
            ],
            [
                "ibge_codigo"       => 2609709,
                "ibge_estado_id" => 26,
                "nome"     => "Orobó",
            ],
            [
                "ibge_codigo"       => 2609808,
                "ibge_estado_id" => 26,
                "nome"     => "Orocó",
            ],
            [
                "ibge_codigo"       => 2609907,
                "ibge_estado_id" => 26,
                "nome"     => "Ouricuri",
            ],
            [
                "ibge_codigo"       => 2610004,
                "ibge_estado_id" => 26,
                "nome"     => "Palmares",
            ],
            [
                "ibge_codigo"       => 2610103,
                "ibge_estado_id" => 26,
                "nome"     => "Palmeirina",
            ],
            [
                "ibge_codigo"       => 2610202,
                "ibge_estado_id" => 26,
                "nome"     => "Panelas",
            ],
            [
                "ibge_codigo"       => 2610301,
                "ibge_estado_id" => 26,
                "nome"     => "Paranatama",
            ],
            [
                "ibge_codigo"       => 2610400,
                "ibge_estado_id" => 26,
                "nome"     => "Parnamirim",
            ],
            [
                "ibge_codigo"       => 2610509,
                "ibge_estado_id" => 26,
                "nome"     => "Passira",
            ],
            [
                "ibge_codigo"       => 2610608,
                "ibge_estado_id" => 26,
                "nome"     => "Paudalho",
            ],
            [
                "ibge_codigo"       => 2610707,
                "ibge_estado_id" => 26,
                "nome"     => "Paulista",
            ],
            [
                "ibge_codigo"       => 2610806,
                "ibge_estado_id" => 26,
                "nome"     => "Pedra",
            ],
            [
                "ibge_codigo"       => 2610905,
                "ibge_estado_id" => 26,
                "nome"     => "Pesqueira",
            ],
            [
                "ibge_codigo"       => 2611002,
                "ibge_estado_id" => 26,
                "nome"     => "Petrolândia",
            ],
            [
                "ibge_codigo"       => 2611101,
                "ibge_estado_id" => 26,
                "nome"     => "Petrolina",
            ],
            [
                "ibge_codigo"       => 2611200,
                "ibge_estado_id" => 26,
                "nome"     => "Poção",
            ],
            [
                "ibge_codigo"       => 2611309,
                "ibge_estado_id" => 26,
                "nome"     => "Pombos",
            ],
            [
                "ibge_codigo"       => 2611408,
                "ibge_estado_id" => 26,
                "nome"     => "Primavera",
            ],
            [
                "ibge_codigo"       => 2611507,
                "ibge_estado_id" => 26,
                "nome"     => "Quipapá",
            ],
            [
                "ibge_codigo"       => 2611533,
                "ibge_estado_id" => 26,
                "nome"     => "Quixaba",
            ],
            [
                "ibge_codigo"       => 2611606,
                "ibge_estado_id" => 26,
                "nome"     => "Recife",
            ],
            [
                "ibge_codigo"       => 2611705,
                "ibge_estado_id" => 26,
                "nome"     => "Riacho das Almas",
            ],
            [
                "ibge_codigo"       => 2611804,
                "ibge_estado_id" => 26,
                "nome"     => "Ribeirão",
            ],
            [
                "ibge_codigo"       => 2611903,
                "ibge_estado_id" => 26,
                "nome"     => "Rio Formoso",
            ],
            [
                "ibge_codigo"       => 2612000,
                "ibge_estado_id" => 26,
                "nome"     => "Sairé",
            ],
            [
                "ibge_codigo"       => 2612109,
                "ibge_estado_id" => 26,
                "nome"     => "Salgadinho",
            ],
            [
                "ibge_codigo"       => 2612208,
                "ibge_estado_id" => 26,
                "nome"     => "Salgueiro",
            ],
            [
                "ibge_codigo"       => 2612307,
                "ibge_estado_id" => 26,
                "nome"     => "Saloá",
            ],
            [
                "ibge_codigo"       => 2612406,
                "ibge_estado_id" => 26,
                "nome"     => "Sanharó",
            ],
            [
                "ibge_codigo"       => 2612455,
                "ibge_estado_id" => 26,
                "nome"     => "Santa Cruz",
            ],
            [
                "ibge_codigo"       => 2612471,
                "ibge_estado_id" => 26,
                "nome"     => "Santa Cruz da Baixa Verde",
            ],
            [
                "ibge_codigo"       => 2612505,
                "ibge_estado_id" => 26,
                "nome"     => "Santa Cruz do Capibaribe",
            ],
            [
                "ibge_codigo"       => 2612554,
                "ibge_estado_id" => 26,
                "nome"     => "Santa Filomena",
            ],
            [
                "ibge_codigo"       => 2612604,
                "ibge_estado_id" => 26,
                "nome"     => "Santa Maria da Boa Vista",
            ],
            [
                "ibge_codigo"       => 2612703,
                "ibge_estado_id" => 26,
                "nome"     => "Santa Maria do Cambucá",
            ],
            [
                "ibge_codigo"       => 2612802,
                "ibge_estado_id" => 26,
                "nome"     => "Santa Terezinha",
            ],
            [
                "ibge_codigo"       => 2612901,
                "ibge_estado_id" => 26,
                "nome"     => "São Benedito do Sul",
            ],
            [
                "ibge_codigo"       => 2613008,
                "ibge_estado_id" => 26,
                "nome"     => "São Bento do Una",
            ],
            [
                "ibge_codigo"       => 2613107,
                "ibge_estado_id" => 26,
                "nome"     => "São Caitano",
            ],
            [
                "ibge_codigo"       => 2613206,
                "ibge_estado_id" => 26,
                "nome"     => "São João",
            ],
            [
                "ibge_codigo"       => 2613305,
                "ibge_estado_id" => 26,
                "nome"     => "São Joaquim do Monte",
            ],
            [
                "ibge_codigo"       => 2613404,
                "ibge_estado_id" => 26,
                "nome"     => "São José da Coroa Grande",
            ],
            [
                "ibge_codigo"       => 2613503,
                "ibge_estado_id" => 26,
                "nome"     => "São José do Belmonte",
            ],
            [
                "ibge_codigo"       => 2613602,
                "ibge_estado_id" => 26,
                "nome"     => "São José do Egito",
            ],
            [
                "ibge_codigo"       => 2613701,
                "ibge_estado_id" => 26,
                "nome"     => "São Lourenço da Mata",
            ],
            [
                "ibge_codigo"       => 2613800,
                "ibge_estado_id" => 26,
                "nome"     => "São Vicente Ferrer",
            ],
            [
                "ibge_codigo"       => 2613909,
                "ibge_estado_id" => 26,
                "nome"     => "Serra Talhada",
            ],
            [
                "ibge_codigo"       => 2614006,
                "ibge_estado_id" => 26,
                "nome"     => "Serrita",
            ],
            [
                "ibge_codigo"       => 2614105,
                "ibge_estado_id" => 26,
                "nome"     => "Sertânia",
            ],
            [
                "ibge_codigo"       => 2614204,
                "ibge_estado_id" => 26,
                "nome"     => "Sirinhaém",
            ],
            [
                "ibge_codigo"       => 2614303,
                "ibge_estado_id" => 26,
                "nome"     => "Moreilândia",
            ],
            [
                "ibge_codigo"       => 2614402,
                "ibge_estado_id" => 26,
                "nome"     => "Solidão",
            ],
            [
                "ibge_codigo"       => 2614501,
                "ibge_estado_id" => 26,
                "nome"     => "Surubim",
            ],
            [
                "ibge_codigo"       => 2614600,
                "ibge_estado_id" => 26,
                "nome"     => "Tabira",
            ],
            [
                "ibge_codigo"       => 2614709,
                "ibge_estado_id" => 26,
                "nome"     => "Tacaimbó",
            ],
            [
                "ibge_codigo"       => 2614808,
                "ibge_estado_id" => 26,
                "nome"     => "Tacaratu",
            ],
            [
                "ibge_codigo"       => 2614857,
                "ibge_estado_id" => 26,
                "nome"     => "Tamandaré",
            ],
            [
                "ibge_codigo"       => 2615003,
                "ibge_estado_id" => 26,
                "nome"     => "Taquaritinga do Norte",
            ],
            [
                "ibge_codigo"       => 2615102,
                "ibge_estado_id" => 26,
                "nome"     => "Terezinha",
            ],
            [
                "ibge_codigo"       => 2615201,
                "ibge_estado_id" => 26,
                "nome"     => "Terra Nova",
            ],
            [
                "ibge_codigo"       => 2615300,
                "ibge_estado_id" => 26,
                "nome"     => "Timbaúba",
            ],
            [
                "ibge_codigo"       => 2615409,
                "ibge_estado_id" => 26,
                "nome"     => "Toritama",
            ],
            [
                "ibge_codigo"       => 2615508,
                "ibge_estado_id" => 26,
                "nome"     => "Tracunhaém",
            ],
            [
                "ibge_codigo"       => 2615607,
                "ibge_estado_id" => 26,
                "nome"     => "Trindade",
            ],
            [
                "ibge_codigo"       => 2615706,
                "ibge_estado_id" => 26,
                "nome"     => "Triunfo",
            ],
            [
                "ibge_codigo"       => 2615805,
                "ibge_estado_id" => 26,
                "nome"     => "Tupanatinga",
            ],
            [
                "ibge_codigo"       => 2615904,
                "ibge_estado_id" => 26,
                "nome"     => "Tuparetama",
            ],
            [
                "ibge_codigo"       => 2616001,
                "ibge_estado_id" => 26,
                "nome"     => "Venturosa",
            ],
            [
                "ibge_codigo"       => 2616100,
                "ibge_estado_id" => 26,
                "nome"     => "Verdejante",
            ],
            [
                "ibge_codigo"       => 2616183,
                "ibge_estado_id" => 26,
                "nome"     => "Vertente do Lério",
            ],
            [
                "ibge_codigo"       => 2616209,
                "ibge_estado_id" => 26,
                "nome"     => "Vertentes",
            ],
            [
                "ibge_codigo"       => 2616308,
                "ibge_estado_id" => 26,
                "nome"     => "Vicência",
            ],
            [
                "ibge_codigo"       => 2616407,
                "ibge_estado_id" => 26,
                "nome"     => "Vitória de Santo Antão",
            ],
            [
                "ibge_codigo"       => 2616506,
                "ibge_estado_id" => 26,
                "nome"     => "Xexéu",
            ],
            [
                "ibge_codigo"       => 2700102,
                "ibge_estado_id" => 27,
                "nome"     => "Água Branca",
            ],
            [
                "ibge_codigo"       => 2700201,
                "ibge_estado_id" => 27,
                "nome"     => "Anadia",
            ],
            [
                "ibge_codigo"       => 2700300,
                "ibge_estado_id" => 27,
                "nome"     => "Arapiraca",
            ],
            [
                "ibge_codigo"       => 2700409,
                "ibge_estado_id" => 27,
                "nome"     => "Atalaia",
            ],
            [
                "ibge_codigo"       => 2700508,
                "ibge_estado_id" => 27,
                "nome"     => "Barra de Santo Antônio",
            ],
            [
                "ibge_codigo"       => 2700607,
                "ibge_estado_id" => 27,
                "nome"     => "Barra de São Miguel",
            ],
            [
                "ibge_codigo"       => 2700706,
                "ibge_estado_id" => 27,
                "nome"     => "Batalha",
            ],
            [
                "ibge_codigo"       => 2700805,
                "ibge_estado_id" => 27,
                "nome"     => "Belém",
            ],
            [
                "ibge_codigo"       => 2700904,
                "ibge_estado_id" => 27,
                "nome"     => "Belo Monte",
            ],
            [
                "ibge_codigo"       => 2701001,
                "ibge_estado_id" => 27,
                "nome"     => "Boca da Mata",
            ],
            [
                "ibge_codigo"       => 2701100,
                "ibge_estado_id" => 27,
                "nome"     => "Branquinha",
            ],
            [
                "ibge_codigo"       => 2701209,
                "ibge_estado_id" => 27,
                "nome"     => "Cacimbinhas",
            ],
            [
                "ibge_codigo"       => 2701308,
                "ibge_estado_id" => 27,
                "nome"     => "Cajueiro",
            ],
            [
                "ibge_codigo"       => 2701357,
                "ibge_estado_id" => 27,
                "nome"     => "Campestre",
            ],
            [
                "ibge_codigo"       => 2701407,
                "ibge_estado_id" => 27,
                "nome"     => "Campo Alegre",
            ],
            [
                "ibge_codigo"       => 2701506,
                "ibge_estado_id" => 27,
                "nome"     => "Campo Grande",
            ],
            [
                "ibge_codigo"       => 2701605,
                "ibge_estado_id" => 27,
                "nome"     => "Canapi",
            ],
            [
                "ibge_codigo"       => 2701704,
                "ibge_estado_id" => 27,
                "nome"     => "Capela",
            ],
            [
                "ibge_codigo"       => 2701803,
                "ibge_estado_id" => 27,
                "nome"     => "Carneiros",
            ],
            [
                "ibge_codigo"       => 2701902,
                "ibge_estado_id" => 27,
                "nome"     => "Chã Preta",
            ],
            [
                "ibge_codigo"       => 2702009,
                "ibge_estado_id" => 27,
                "nome"     => "Coité do Nóia",
            ],
            [
                "ibge_codigo"       => 2702108,
                "ibge_estado_id" => 27,
                "nome"     => "Colônia Leopoldina",
            ],
            [
                "ibge_codigo"       => 2702207,
                "ibge_estado_id" => 27,
                "nome"     => "Coqueiro Seco",
            ],
            [
                "ibge_codigo"       => 2702306,
                "ibge_estado_id" => 27,
                "nome"     => "Coruripe",
            ],
            [
                "ibge_codigo"       => 2702355,
                "ibge_estado_id" => 27,
                "nome"     => "Craíbas",
            ],
            [
                "ibge_codigo"       => 2702405,
                "ibge_estado_id" => 27,
                "nome"     => "Delmiro Gouveia",
            ],
            [
                "ibge_codigo"       => 2702504,
                "ibge_estado_id" => 27,
                "nome"     => "Dois Riachos",
            ],
            [
                "ibge_codigo"       => 2702553,
                "ibge_estado_id" => 27,
                "nome"     => "Estrela de Alagoas",
            ],
            [
                "ibge_codigo"       => 2702603,
                "ibge_estado_id" => 27,
                "nome"     => "Feira Grande",
            ],
            [
                "ibge_codigo"       => 2702702,
                "ibge_estado_id" => 27,
                "nome"     => "Feliz Deserto",
            ],
            [
                "ibge_codigo"       => 2702801,
                "ibge_estado_id" => 27,
                "nome"     => "Flexeiras",
            ],
            [
                "ibge_codigo"       => 2702900,
                "ibge_estado_id" => 27,
                "nome"     => "Girau do Ponciano",
            ],
            [
                "ibge_codigo"       => 2703007,
                "ibge_estado_id" => 27,
                "nome"     => "Ibateguara",
            ],
            [
                "ibge_codigo"       => 2703106,
                "ibge_estado_id" => 27,
                "nome"     => "Igaci",
            ],
            [
                "ibge_codigo"       => 2703205,
                "ibge_estado_id" => 27,
                "nome"     => "Igreja Nova",
            ],
            [
                "ibge_codigo"       => 2703304,
                "ibge_estado_id" => 27,
                "nome"     => "Inhapi",
            ],
            [
                "ibge_codigo"       => 2703403,
                "ibge_estado_id" => 27,
                "nome"     => "Jacaré dos Homens",
            ],
            [
                "ibge_codigo"       => 2703502,
                "ibge_estado_id" => 27,
                "nome"     => "Jacuípe",
            ],
            [
                "ibge_codigo"       => 2703601,
                "ibge_estado_id" => 27,
                "nome"     => "Japaratinga",
            ],
            [
                "ibge_codigo"       => 2703700,
                "ibge_estado_id" => 27,
                "nome"     => "Jaramataia",
            ],
            [
                "ibge_codigo"       => 2703759,
                "ibge_estado_id" => 27,
                "nome"     => "Jequiá da Praia",
            ],
            [
                "ibge_codigo"       => 2703809,
                "ibge_estado_id" => 27,
                "nome"     => "Joaquim Gomes",
            ],
            [
                "ibge_codigo"       => 2703908,
                "ibge_estado_id" => 27,
                "nome"     => "Jundiá",
            ],
            [
                "ibge_codigo"       => 2704005,
                "ibge_estado_id" => 27,
                "nome"     => "Junqueiro",
            ],
            [
                "ibge_codigo"       => 2704104,
                "ibge_estado_id" => 27,
                "nome"     => "Lagoa da Canoa",
            ],
            [
                "ibge_codigo"       => 2704203,
                "ibge_estado_id" => 27,
                "nome"     => "Limoeiro de Anadia",
            ],
            [
                "ibge_codigo"       => 2704302,
                "ibge_estado_id" => 27,
                "nome"     => "Maceió",
            ],
            [
                "ibge_codigo"       => 2704401,
                "ibge_estado_id" => 27,
                "nome"     => "Major Isidoro",
            ],
            [
                "ibge_codigo"       => 2704500,
                "ibge_estado_id" => 27,
                "nome"     => "Maragogi",
            ],
            [
                "ibge_codigo"       => 2704609,
                "ibge_estado_id" => 27,
                "nome"     => "Maravilha",
            ],
            [
                "ibge_codigo"       => 2704708,
                "ibge_estado_id" => 27,
                "nome"     => "Marechal Deodoro",
            ],
            [
                "ibge_codigo"       => 2704807,
                "ibge_estado_id" => 27,
                "nome"     => "Maribondo",
            ],
            [
                "ibge_codigo"       => 2704906,
                "ibge_estado_id" => 27,
                "nome"     => "Mar Vermelho",
            ],
            [
                "ibge_codigo"       => 2705002,
                "ibge_estado_id" => 27,
                "nome"     => "Mata Grande",
            ],
            [
                "ibge_codigo"       => 2705101,
                "ibge_estado_id" => 27,
                "nome"     => "Matriz de Camaragibe",
            ],
            [
                "ibge_codigo"       => 2705200,
                "ibge_estado_id" => 27,
                "nome"     => "Messias",
            ],
            [
                "ibge_codigo"       => 2705309,
                "ibge_estado_id" => 27,
                "nome"     => "Minador do Negrão",
            ],
            [
                "ibge_codigo"       => 2705408,
                "ibge_estado_id" => 27,
                "nome"     => "Monteirópolis",
            ],
            [
                "ibge_codigo"       => 2705507,
                "ibge_estado_id" => 27,
                "nome"     => "Murici",
            ],
            [
                "ibge_codigo"       => 2705606,
                "ibge_estado_id" => 27,
                "nome"     => "Novo Lino",
            ],
            [
                "ibge_codigo"       => 2705705,
                "ibge_estado_id" => 27,
                "nome"     => "Olho d'Água das Flores",
            ],
            [
                "ibge_codigo"       => 2705804,
                "ibge_estado_id" => 27,
                "nome"     => "Olho d'Água do Casado",
            ],
            [
                "ibge_codigo"       => 2705903,
                "ibge_estado_id" => 27,
                "nome"     => "Olho d'Água Grande",
            ],
            [
                "ibge_codigo"       => 2706000,
                "ibge_estado_id" => 27,
                "nome"     => "Olivença",
            ],
            [
                "ibge_codigo"       => 2706109,
                "ibge_estado_id" => 27,
                "nome"     => "Ouro Branco",
            ],
            [
                "ibge_codigo"       => 2706208,
                "ibge_estado_id" => 27,
                "nome"     => "Palestina",
            ],
            [
                "ibge_codigo"       => 2706307,
                "ibge_estado_id" => 27,
                "nome"     => "Palmeira dos Índios",
            ],
            [
                "ibge_codigo"       => 2706406,
                "ibge_estado_id" => 27,
                "nome"     => "Pão de Açúcar",
            ],
            [
                "ibge_codigo"       => 2706422,
                "ibge_estado_id" => 27,
                "nome"     => "Pariconha",
            ],
            [
                "ibge_codigo"       => 2706448,
                "ibge_estado_id" => 27,
                "nome"     => "Paripueira",
            ],
            [
                "ibge_codigo"       => 2706505,
                "ibge_estado_id" => 27,
                "nome"     => "Passo de Camaragibe",
            ],
            [
                "ibge_codigo"       => 2706604,
                "ibge_estado_id" => 27,
                "nome"     => "Paulo Jacinto",
            ],
            [
                "ibge_codigo"       => 2706703,
                "ibge_estado_id" => 27,
                "nome"     => "Penedo",
            ],
            [
                "ibge_codigo"       => 2706802,
                "ibge_estado_id" => 27,
                "nome"     => "Piaçabuçu",
            ],
            [
                "ibge_codigo"       => 2706901,
                "ibge_estado_id" => 27,
                "nome"     => "Pilar",
            ],
            [
                "ibge_codigo"       => 2707008,
                "ibge_estado_id" => 27,
                "nome"     => "Pindoba",
            ],
            [
                "ibge_codigo"       => 2707107,
                "ibge_estado_id" => 27,
                "nome"     => "Piranhas",
            ],
            [
                "ibge_codigo"       => 2707206,
                "ibge_estado_id" => 27,
                "nome"     => "Poço das Trincheiras",
            ],
            [
                "ibge_codigo"       => 2707305,
                "ibge_estado_id" => 27,
                "nome"     => "Porto Calvo",
            ],
            [
                "ibge_codigo"       => 2707404,
                "ibge_estado_id" => 27,
                "nome"     => "Porto de Pedras",
            ],
            [
                "ibge_codigo"       => 2707503,
                "ibge_estado_id" => 27,
                "nome"     => "Porto Real do Colégio",
            ],
            [
                "ibge_codigo"       => 2707602,
                "ibge_estado_id" => 27,
                "nome"     => "Quebrangulo",
            ],
            [
                "ibge_codigo"       => 2707701,
                "ibge_estado_id" => 27,
                "nome"     => "Rio Largo",
            ],
            [
                "ibge_codigo"       => 2707800,
                "ibge_estado_id" => 27,
                "nome"     => "Roteiro",
            ],
            [
                "ibge_codigo"       => 2707909,
                "ibge_estado_id" => 27,
                "nome"     => "Santa Luzia do Norte",
            ],
            [
                "ibge_codigo"       => 2708006,
                "ibge_estado_id" => 27,
                "nome"     => "Santana do Ipanema",
            ],
            [
                "ibge_codigo"       => 2708105,
                "ibge_estado_id" => 27,
                "nome"     => "Santana do Mundaú",
            ],
            [
                "ibge_codigo"       => 2708204,
                "ibge_estado_id" => 27,
                "nome"     => "São Brás",
            ],
            [
                "ibge_codigo"       => 2708303,
                "ibge_estado_id" => 27,
                "nome"     => "São José da Laje",
            ],
            [
                "ibge_codigo"       => 2708402,
                "ibge_estado_id" => 27,
                "nome"     => "São José da Tapera",
            ],
            [
                "ibge_codigo"       => 2708501,
                "ibge_estado_id" => 27,
                "nome"     => "São Luís do Quitunde",
            ],
            [
                "ibge_codigo"       => 2708600,
                "ibge_estado_id" => 27,
                "nome"     => "São Miguel dos Campos",
            ],
            [
                "ibge_codigo"       => 2708709,
                "ibge_estado_id" => 27,
                "nome"     => "São Miguel dos Milagres",
            ],
            [
                "ibge_codigo"       => 2708808,
                "ibge_estado_id" => 27,
                "nome"     => "São Sebastião",
            ],
            [
                "ibge_codigo"       => 2708907,
                "ibge_estado_id" => 27,
                "nome"     => "Satuba",
            ],
            [
                "ibge_codigo"       => 2708956,
                "ibge_estado_id" => 27,
                "nome"     => "Senador Rui Palmeira",
            ],
            [
                "ibge_codigo"       => 2709004,
                "ibge_estado_id" => 27,
                "nome"     => "Tanque d'Arca",
            ],
            [
                "ibge_codigo"       => 2709103,
                "ibge_estado_id" => 27,
                "nome"     => "Taquarana",
            ],
            [
                "ibge_codigo"       => 2709152,
                "ibge_estado_id" => 27,
                "nome"     => "Teotônio Vilela",
            ],
            [
                "ibge_codigo"       => 2709202,
                "ibge_estado_id" => 27,
                "nome"     => "Traipu",
            ],
            [
                "ibge_codigo"       => 2709301,
                "ibge_estado_id" => 27,
                "nome"     => "União dos Palmares",
            ],
            [
                "ibge_codigo"       => 2709400,
                "ibge_estado_id" => 27,
                "nome"     => "Viçosa",
            ],
            [
                "ibge_codigo"       => 2800100,
                "ibge_estado_id" => 28,
                "nome"     => "Amparo de São Francisco",
            ],
            [
                "ibge_codigo"       => 2800209,
                "ibge_estado_id" => 28,
                "nome"     => "Aquidabã",
            ],
            [
                "ibge_codigo"       => 2800308,
                "ibge_estado_id" => 28,
                "nome"     => "Aracaju",
            ],
            [
                "ibge_codigo"       => 2800407,
                "ibge_estado_id" => 28,
                "nome"     => "Arauá",
            ],
            [
                "ibge_codigo"       => 2800506,
                "ibge_estado_id" => 28,
                "nome"     => "Areia Branca",
            ],
            [
                "ibge_codigo"       => 2800605,
                "ibge_estado_id" => 28,
                "nome"     => "Barra dos Coqueiros",
            ],
            [
                "ibge_codigo"       => 2800670,
                "ibge_estado_id" => 28,
                "nome"     => "Boquim",
            ],
            [
                "ibge_codigo"       => 2800704,
                "ibge_estado_id" => 28,
                "nome"     => "Brejo Grande",
            ],
            [
                "ibge_codigo"       => 2801009,
                "ibge_estado_id" => 28,
                "nome"     => "Campo do Brito",
            ],
            [
                "ibge_codigo"       => 2801108,
                "ibge_estado_id" => 28,
                "nome"     => "Canhoba",
            ],
            [
                "ibge_codigo"       => 2801207,
                "ibge_estado_id" => 28,
                "nome"     => "Canindé de São Francisco",
            ],
            [
                "ibge_codigo"       => 2801306,
                "ibge_estado_id" => 28,
                "nome"     => "Capela",
            ],
            [
                "ibge_codigo"       => 2801405,
                "ibge_estado_id" => 28,
                "nome"     => "Carira",
            ],
            [
                "ibge_codigo"       => 2801504,
                "ibge_estado_id" => 28,
                "nome"     => "Carmópolis",
            ],
            [
                "ibge_codigo"       => 2801603,
                "ibge_estado_id" => 28,
                "nome"     => "Cedro de São João",
            ],
            [
                "ibge_codigo"       => 2801702,
                "ibge_estado_id" => 28,
                "nome"     => "Cristinápolis",
            ],
            [
                "ibge_codigo"       => 2801900,
                "ibge_estado_id" => 28,
                "nome"     => "Cumbe",
            ],
            [
                "ibge_codigo"       => 2802007,
                "ibge_estado_id" => 28,
                "nome"     => "Divina Pastora",
            ],
            [
                "ibge_codigo"       => 2802106,
                "ibge_estado_id" => 28,
                "nome"     => "Estância",
            ],
            [
                "ibge_codigo"       => 2802205,
                "ibge_estado_id" => 28,
                "nome"     => "Feira Nova",
            ],
            [
                "ibge_codigo"       => 2802304,
                "ibge_estado_id" => 28,
                "nome"     => "Frei Paulo",
            ],
            [
                "ibge_codigo"       => 2802403,
                "ibge_estado_id" => 28,
                "nome"     => "Gararu",
            ],
            [
                "ibge_codigo"       => 2802502,
                "ibge_estado_id" => 28,
                "nome"     => "General Maynard",
            ],
            [
                "ibge_codigo"       => 2802601,
                "ibge_estado_id" => 28,
                "nome"     => "Gracho Cardoso",
            ],
            [
                "ibge_codigo"       => 2802700,
                "ibge_estado_id" => 28,
                "nome"     => "Ilha das Flores",
            ],
            [
                "ibge_codigo"       => 2802809,
                "ibge_estado_id" => 28,
                "nome"     => "Indiaroba",
            ],
            [
                "ibge_codigo"       => 2802908,
                "ibge_estado_id" => 28,
                "nome"     => "Itabaiana",
            ],
            [
                "ibge_codigo"       => 2803005,
                "ibge_estado_id" => 28,
                "nome"     => "Itabaianinha",
            ],
            [
                "ibge_codigo"       => 2803104,
                "ibge_estado_id" => 28,
                "nome"     => "Itabi",
            ],
            [
                "ibge_codigo"       => 2803203,
                "ibge_estado_id" => 28,
                "nome"     => "Itaporanga d'Ajuda",
            ],
            [
                "ibge_codigo"       => 2803302,
                "ibge_estado_id" => 28,
                "nome"     => "Japaratuba",
            ],
            [
                "ibge_codigo"       => 2803401,
                "ibge_estado_id" => 28,
                "nome"     => "Japoatã",
            ],
            [
                "ibge_codigo"       => 2803500,
                "ibge_estado_id" => 28,
                "nome"     => "Lagarto",
            ],
            [
                "ibge_codigo"       => 2803609,
                "ibge_estado_id" => 28,
                "nome"     => "Laranjeiras",
            ],
            [
                "ibge_codigo"       => 2803708,
                "ibge_estado_id" => 28,
                "nome"     => "Macambira",
            ],
            [
                "ibge_codigo"       => 2803807,
                "ibge_estado_id" => 28,
                "nome"     => "Malhada dos Bois",
            ],
            [
                "ibge_codigo"       => 2803906,
                "ibge_estado_id" => 28,
                "nome"     => "Malhador",
            ],
            [
                "ibge_codigo"       => 2804003,
                "ibge_estado_id" => 28,
                "nome"     => "Maruim",
            ],
            [
                "ibge_codigo"       => 2804102,
                "ibge_estado_id" => 28,
                "nome"     => "Moita Bonita",
            ],
            [
                "ibge_codigo"       => 2804201,
                "ibge_estado_id" => 28,
                "nome"     => "Monte Alegre de Sergipe",
            ],
            [
                "ibge_codigo"       => 2804300,
                "ibge_estado_id" => 28,
                "nome"     => "Muribeca",
            ],
            [
                "ibge_codigo"       => 2804409,
                "ibge_estado_id" => 28,
                "nome"     => "Neópolis",
            ],
            [
                "ibge_codigo"       => 2804458,
                "ibge_estado_id" => 28,
                "nome"     => "Nossa Senhora Aparecida",
            ],
            [
                "ibge_codigo"       => 2804508,
                "ibge_estado_id" => 28,
                "nome"     => "Nossa Senhora da Glória",
            ],
            [
                "ibge_codigo"       => 2804607,
                "ibge_estado_id" => 28,
                "nome"     => "Nossa Senhora das Dores",
            ],
            [
                "ibge_codigo"       => 2804706,
                "ibge_estado_id" => 28,
                "nome"     => "Nossa Senhora de Lourdes",
            ],
            [
                "ibge_codigo"       => 2804805,
                "ibge_estado_id" => 28,
                "nome"     => "Nossa Senhora do Socorro",
            ],
            [
                "ibge_codigo"       => 2804904,
                "ibge_estado_id" => 28,
                "nome"     => "Pacatuba",
            ],
            [
                "ibge_codigo"       => 2805000,
                "ibge_estado_id" => 28,
                "nome"     => "Pedra Mole",
            ],
            [
                "ibge_codigo"       => 2805109,
                "ibge_estado_id" => 28,
                "nome"     => "Pedrinhas",
            ],
            [
                "ibge_codigo"       => 2805208,
                "ibge_estado_id" => 28,
                "nome"     => "Pinhão",
            ],
            [
                "ibge_codigo"       => 2805307,
                "ibge_estado_id" => 28,
                "nome"     => "Pirambu",
            ],
            [
                "ibge_codigo"       => 2805406,
                "ibge_estado_id" => 28,
                "nome"     => "Poço Redondo",
            ],
            [
                "ibge_codigo"       => 2805505,
                "ibge_estado_id" => 28,
                "nome"     => "Poço Verde",
            ],
            [
                "ibge_codigo"       => 2805604,
                "ibge_estado_id" => 28,
                "nome"     => "Porto da Folha",
            ],
            [
                "ibge_codigo"       => 2805703,
                "ibge_estado_id" => 28,
                "nome"     => "Propriá",
            ],
            [
                "ibge_codigo"       => 2805802,
                "ibge_estado_id" => 28,
                "nome"     => "Riachão do Dantas",
            ],
            [
                "ibge_codigo"       => 2805901,
                "ibge_estado_id" => 28,
                "nome"     => "Riachuelo",
            ],
            [
                "ibge_codigo"       => 2806008,
                "ibge_estado_id" => 28,
                "nome"     => "Ribeirópolis",
            ],
            [
                "ibge_codigo"       => 2806107,
                "ibge_estado_id" => 28,
                "nome"     => "Rosário do Catete",
            ],
            [
                "ibge_codigo"       => 2806206,
                "ibge_estado_id" => 28,
                "nome"     => "Salgado",
            ],
            [
                "ibge_codigo"       => 2806305,
                "ibge_estado_id" => 28,
                "nome"     => "Santa Luzia do Itanhy",
            ],
            [
                "ibge_codigo"       => 2806404,
                "ibge_estado_id" => 28,
                "nome"     => "Santana do São Francisco",
            ],
            [
                "ibge_codigo"       => 2806503,
                "ibge_estado_id" => 28,
                "nome"     => "Santa Rosa de Lima",
            ],
            [
                "ibge_codigo"       => 2806602,
                "ibge_estado_id" => 28,
                "nome"     => "Santo Amaro das Brotas",
            ],
            [
                "ibge_codigo"       => 2806701,
                "ibge_estado_id" => 28,
                "nome"     => "São Cristóvão",
            ],
            [
                "ibge_codigo"       => 2806800,
                "ibge_estado_id" => 28,
                "nome"     => "São Domingos",
            ],
            [
                "ibge_codigo"       => 2806909,
                "ibge_estado_id" => 28,
                "nome"     => "São Francisco",
            ],
            [
                "ibge_codigo"       => 2807006,
                "ibge_estado_id" => 28,
                "nome"     => "São Miguel do Aleixo",
            ],
            [
                "ibge_codigo"       => 2807105,
                "ibge_estado_id" => 28,
                "nome"     => "Simão Dias",
            ],
            [
                "ibge_codigo"       => 2807204,
                "ibge_estado_id" => 28,
                "nome"     => "Siriri",
            ],
            [
                "ibge_codigo"       => 2807303,
                "ibge_estado_id" => 28,
                "nome"     => "Telha",
            ],
            [
                "ibge_codigo"       => 2807402,
                "ibge_estado_id" => 28,
                "nome"     => "Tobias Barreto",
            ],
            [
                "ibge_codigo"       => 2807501,
                "ibge_estado_id" => 28,
                "nome"     => "Tomar do Geru",
            ],
            [
                "ibge_codigo"       => 2807600,
                "ibge_estado_id" => 28,
                "nome"     => "Umbaúba",
            ],
            [
                "ibge_codigo"       => 2900108,
                "ibge_estado_id" => 29,
                "nome"     => "Abaíra",
            ],
            [
                "ibge_codigo"       => 2900207,
                "ibge_estado_id" => 29,
                "nome"     => "Abaré",
            ],
            [
                "ibge_codigo"       => 2900306,
                "ibge_estado_id" => 29,
                "nome"     => "Acajutiba",
            ],
            [
                "ibge_codigo"       => 2900355,
                "ibge_estado_id" => 29,
                "nome"     => "Adustina",
            ],
            [
                "ibge_codigo"       => 2900405,
                "ibge_estado_id" => 29,
                "nome"     => "Água Fria",
            ],
            [
                "ibge_codigo"       => 2900504,
                "ibge_estado_id" => 29,
                "nome"     => "Érico Cardoso",
            ],
            [
                "ibge_codigo"       => 2900603,
                "ibge_estado_id" => 29,
                "nome"     => "Aiquara",
            ],
            [
                "ibge_codigo"       => 2900702,
                "ibge_estado_id" => 29,
                "nome"     => "Alagoinhas",
            ],
            [
                "ibge_codigo"       => 2900801,
                "ibge_estado_id" => 29,
                "nome"     => "Alcobaça",
            ],
            [
                "ibge_codigo"       => 2900900,
                "ibge_estado_id" => 29,
                "nome"     => "Almadina",
            ],
            [
                "ibge_codigo"       => 2901007,
                "ibge_estado_id" => 29,
                "nome"     => "Amargosa",
            ],
            [
                "ibge_codigo"       => 2901106,
                "ibge_estado_id" => 29,
                "nome"     => "Amélia Rodrigues",
            ],
            [
                "ibge_codigo"       => 2901155,
                "ibge_estado_id" => 29,
                "nome"     => "América Dourada",
            ],
            [
                "ibge_codigo"       => 2901205,
                "ibge_estado_id" => 29,
                "nome"     => "Anagé",
            ],
            [
                "ibge_codigo"       => 2901304,
                "ibge_estado_id" => 29,
                "nome"     => "Andaraí",
            ],
            [
                "ibge_codigo"       => 2901353,
                "ibge_estado_id" => 29,
                "nome"     => "Andorinha",
            ],
            [
                "ibge_codigo"       => 2901403,
                "ibge_estado_id" => 29,
                "nome"     => "Angical",
            ],
            [
                "ibge_codigo"       => 2901502,
                "ibge_estado_id" => 29,
                "nome"     => "Anguera",
            ],
            [
                "ibge_codigo"       => 2901601,
                "ibge_estado_id" => 29,
                "nome"     => "Antas",
            ],
            [
                "ibge_codigo"       => 2901700,
                "ibge_estado_id" => 29,
                "nome"     => "Antônio Cardoso",
            ],
            [
                "ibge_codigo"       => 2901809,
                "ibge_estado_id" => 29,
                "nome"     => "Antônio Gonçalves",
            ],
            [
                "ibge_codigo"       => 2901908,
                "ibge_estado_id" => 29,
                "nome"     => "Aporá",
            ],
            [
                "ibge_codigo"       => 2901957,
                "ibge_estado_id" => 29,
                "nome"     => "Apuarema",
            ],
            [
                "ibge_codigo"       => 2902005,
                "ibge_estado_id" => 29,
                "nome"     => "Aracatu",
            ],
            [
                "ibge_codigo"       => 2902054,
                "ibge_estado_id" => 29,
                "nome"     => "Araças",
            ],
            [
                "ibge_codigo"       => 2902104,
                "ibge_estado_id" => 29,
                "nome"     => "Araci",
            ],
            [
                "ibge_codigo"       => 2902203,
                "ibge_estado_id" => 29,
                "nome"     => "Aramari",
            ],
            [
                "ibge_codigo"       => 2902252,
                "ibge_estado_id" => 29,
                "nome"     => "Arataca",
            ],
            [
                "ibge_codigo"       => 2902302,
                "ibge_estado_id" => 29,
                "nome"     => "Aratuípe",
            ],
            [
                "ibge_codigo"       => 2902401,
                "ibge_estado_id" => 29,
                "nome"     => "Aurelino Leal",
            ],
            [
                "ibge_codigo"       => 2902500,
                "ibge_estado_id" => 29,
                "nome"     => "Baianópolis",
            ],
            [
                "ibge_codigo"       => 2902609,
                "ibge_estado_id" => 29,
                "nome"     => "Baixa Grande",
            ],
            [
                "ibge_codigo"       => 2902658,
                "ibge_estado_id" => 29,
                "nome"     => "Banzaê",
            ],
            [
                "ibge_codigo"       => 2902708,
                "ibge_estado_id" => 29,
                "nome"     => "Barra",
            ],
            [
                "ibge_codigo"       => 2902807,
                "ibge_estado_id" => 29,
                "nome"     => "Barra da Estiva",
            ],
            [
                "ibge_codigo"       => 2902906,
                "ibge_estado_id" => 29,
                "nome"     => "Barra do Choça",
            ],
            [
                "ibge_codigo"       => 2903003,
                "ibge_estado_id" => 29,
                "nome"     => "Barra do Mendes",
            ],
            [
                "ibge_codigo"       => 2903102,
                "ibge_estado_id" => 29,
                "nome"     => "Barra do Rocha",
            ],
            [
                "ibge_codigo"       => 2903201,
                "ibge_estado_id" => 29,
                "nome"     => "Barreiras",
            ],
            [
                "ibge_codigo"       => 2903235,
                "ibge_estado_id" => 29,
                "nome"     => "Barro Alto",
            ],
            [
                "ibge_codigo"       => 2903276,
                "ibge_estado_id" => 29,
                "nome"     => "Barrocas",
            ],
            [
                "ibge_codigo"       => 2903300,
                "ibge_estado_id" => 29,
                "nome"     => "Barro Preto",
            ],
            [
                "ibge_codigo"       => 2903409,
                "ibge_estado_id" => 29,
                "nome"     => "Belmonte",
            ],
            [
                "ibge_codigo"       => 2903508,
                "ibge_estado_id" => 29,
                "nome"     => "Belo Campo",
            ],
            [
                "ibge_codigo"       => 2903607,
                "ibge_estado_id" => 29,
                "nome"     => "Biritinga",
            ],
            [
                "ibge_codigo"       => 2903706,
                "ibge_estado_id" => 29,
                "nome"     => "Boa Nova",
            ],
            [
                "ibge_codigo"       => 2903805,
                "ibge_estado_id" => 29,
                "nome"     => "Boa Vista do Tupim",
            ],
            [
                "ibge_codigo"       => 2903904,
                "ibge_estado_id" => 29,
                "nome"     => "Bom Jesus da Lapa",
            ],
            [
                "ibge_codigo"       => 2903953,
                "ibge_estado_id" => 29,
                "nome"     => "Bom Jesus da Serra",
            ],
            [
                "ibge_codigo"       => 2904001,
                "ibge_estado_id" => 29,
                "nome"     => "Boninal",
            ],
            [
                "ibge_codigo"       => 2904050,
                "ibge_estado_id" => 29,
                "nome"     => "Bonito",
            ],
            [
                "ibge_codigo"       => 2904100,
                "ibge_estado_id" => 29,
                "nome"     => "Boquira",
            ],
            [
                "ibge_codigo"       => 2904209,
                "ibge_estado_id" => 29,
                "nome"     => "Botuporã",
            ],
            [
                "ibge_codigo"       => 2904308,
                "ibge_estado_id" => 29,
                "nome"     => "Brejões",
            ],
            [
                "ibge_codigo"       => 2904407,
                "ibge_estado_id" => 29,
                "nome"     => "Brejolândia",
            ],
            [
                "ibge_codigo"       => 2904506,
                "ibge_estado_id" => 29,
                "nome"     => "Brotas de Macaúbas",
            ],
            [
                "ibge_codigo"       => 2904605,
                "ibge_estado_id" => 29,
                "nome"     => "Brumado",
            ],
            [
                "ibge_codigo"       => 2904704,
                "ibge_estado_id" => 29,
                "nome"     => "Buerarema",
            ],
            [
                "ibge_codigo"       => 2904753,
                "ibge_estado_id" => 29,
                "nome"     => "Buritirama",
            ],
            [
                "ibge_codigo"       => 2904803,
                "ibge_estado_id" => 29,
                "nome"     => "Caatiba",
            ],
            [
                "ibge_codigo"       => 2904852,
                "ibge_estado_id" => 29,
                "nome"     => "Cabaceiras do Paraguaçu",
            ],
            [
                "ibge_codigo"       => 2904902,
                "ibge_estado_id" => 29,
                "nome"     => "Cachoeira",
            ],
            [
                "ibge_codigo"       => 2905008,
                "ibge_estado_id" => 29,
                "nome"     => "Caculé",
            ],
            [
                "ibge_codigo"       => 2905107,
                "ibge_estado_id" => 29,
                "nome"     => "Caém",
            ],
            [
                "ibge_codigo"       => 2905156,
                "ibge_estado_id" => 29,
                "nome"     => "Caetanos",
            ],
            [
                "ibge_codigo"       => 2905206,
                "ibge_estado_id" => 29,
                "nome"     => "Caetité",
            ],
            [
                "ibge_codigo"       => 2905305,
                "ibge_estado_id" => 29,
                "nome"     => "Cafarnaum",
            ],
            [
                "ibge_codigo"       => 2905404,
                "ibge_estado_id" => 29,
                "nome"     => "Cairu",
            ],
            [
                "ibge_codigo"       => 2905503,
                "ibge_estado_id" => 29,
                "nome"     => "Caldeirão Grande",
            ],
            [
                "ibge_codigo"       => 2905602,
                "ibge_estado_id" => 29,
                "nome"     => "Camacan",
            ],
            [
                "ibge_codigo"       => 2905701,
                "ibge_estado_id" => 29,
                "nome"     => "Camaçari",
            ],
            [
                "ibge_codigo"       => 2905800,
                "ibge_estado_id" => 29,
                "nome"     => "Camamu",
            ],
            [
                "ibge_codigo"       => 2905909,
                "ibge_estado_id" => 29,
                "nome"     => "Campo Alegre de Lourdes",
            ],
            [
                "ibge_codigo"       => 2906006,
                "ibge_estado_id" => 29,
                "nome"     => "Campo Formoso",
            ],
            [
                "ibge_codigo"       => 2906105,
                "ibge_estado_id" => 29,
                "nome"     => "Canápolis",
            ],
            [
                "ibge_codigo"       => 2906204,
                "ibge_estado_id" => 29,
                "nome"     => "Canarana",
            ],
            [
                "ibge_codigo"       => 2906303,
                "ibge_estado_id" => 29,
                "nome"     => "Canavieiras",
            ],
            [
                "ibge_codigo"       => 2906402,
                "ibge_estado_id" => 29,
                "nome"     => "Candeal",
            ],
            [
                "ibge_codigo"       => 2906501,
                "ibge_estado_id" => 29,
                "nome"     => "Candeias",
            ],
            [
                "ibge_codigo"       => 2906600,
                "ibge_estado_id" => 29,
                "nome"     => "Candiba",
            ],
            [
                "ibge_codigo"       => 2906709,
                "ibge_estado_id" => 29,
                "nome"     => "Cândido Sales",
            ],
            [
                "ibge_codigo"       => 2906808,
                "ibge_estado_id" => 29,
                "nome"     => "Cansanção",
            ],
            [
                "ibge_codigo"       => 2906824,
                "ibge_estado_id" => 29,
                "nome"     => "Canudos",
            ],
            [
                "ibge_codigo"       => 2906857,
                "ibge_estado_id" => 29,
                "nome"     => "Capela do Alto Alegre",
            ],
            [
                "ibge_codigo"       => 2906873,
                "ibge_estado_id" => 29,
                "nome"     => "Capim Grosso",
            ],
            [
                "ibge_codigo"       => 2906899,
                "ibge_estado_id" => 29,
                "nome"     => "Caraíbas",
            ],
            [
                "ibge_codigo"       => 2906907,
                "ibge_estado_id" => 29,
                "nome"     => "Caravelas",
            ],
            [
                "ibge_codigo"       => 2907004,
                "ibge_estado_id" => 29,
                "nome"     => "Cardeal da Silva",
            ],
            [
                "ibge_codigo"       => 2907103,
                "ibge_estado_id" => 29,
                "nome"     => "Carinhanha",
            ],
            [
                "ibge_codigo"       => 2907202,
                "ibge_estado_id" => 29,
                "nome"     => "Casa Nova",
            ],
            [
                "ibge_codigo"       => 2907301,
                "ibge_estado_id" => 29,
                "nome"     => "Castro Alves",
            ],
            [
                "ibge_codigo"       => 2907400,
                "ibge_estado_id" => 29,
                "nome"     => "Catolândia",
            ],
            [
                "ibge_codigo"       => 2907509,
                "ibge_estado_id" => 29,
                "nome"     => "Catu",
            ],
            [
                "ibge_codigo"       => 2907558,
                "ibge_estado_id" => 29,
                "nome"     => "Caturama",
            ],
            [
                "ibge_codigo"       => 2907608,
                "ibge_estado_id" => 29,
                "nome"     => "Central",
            ],
            [
                "ibge_codigo"       => 2907707,
                "ibge_estado_id" => 29,
                "nome"     => "Chorrochó",
            ],
            [
                "ibge_codigo"       => 2907806,
                "ibge_estado_id" => 29,
                "nome"     => "Cícero Dantas",
            ],
            [
                "ibge_codigo"       => 2907905,
                "ibge_estado_id" => 29,
                "nome"     => "Cipó",
            ],
            [
                "ibge_codigo"       => 2908002,
                "ibge_estado_id" => 29,
                "nome"     => "Coaraci",
            ],
            [
                "ibge_codigo"       => 2908101,
                "ibge_estado_id" => 29,
                "nome"     => "Cocos",
            ],
            [
                "ibge_codigo"       => 2908200,
                "ibge_estado_id" => 29,
                "nome"     => "Conceição da Feira",
            ],
            [
                "ibge_codigo"       => 2908309,
                "ibge_estado_id" => 29,
                "nome"     => "Conceição do Almeida",
            ],
            [
                "ibge_codigo"       => 2908408,
                "ibge_estado_id" => 29,
                "nome"     => "Conceição do Coité",
            ],
            [
                "ibge_codigo"       => 2908507,
                "ibge_estado_id" => 29,
                "nome"     => "Conceição do Jacuípe",
            ],
            [
                "ibge_codigo"       => 2908606,
                "ibge_estado_id" => 29,
                "nome"     => "Conde",
            ],
            [
                "ibge_codigo"       => 2908705,
                "ibge_estado_id" => 29,
                "nome"     => "Condeúba",
            ],
            [
                "ibge_codigo"       => 2908804,
                "ibge_estado_id" => 29,
                "nome"     => "Contendas do Sincorá",
            ],
            [
                "ibge_codigo"       => 2908903,
                "ibge_estado_id" => 29,
                "nome"     => "Coração de Maria",
            ],
            [
                "ibge_codigo"       => 2909000,
                "ibge_estado_id" => 29,
                "nome"     => "Cordeiros",
            ],
            [
                "ibge_codigo"       => 2909109,
                "ibge_estado_id" => 29,
                "nome"     => "Coribe",
            ],
            [
                "ibge_codigo"       => 2909208,
                "ibge_estado_id" => 29,
                "nome"     => "Coronel João Sá",
            ],
            [
                "ibge_codigo"       => 2909307,
                "ibge_estado_id" => 29,
                "nome"     => "Correntina",
            ],
            [
                "ibge_codigo"       => 2909406,
                "ibge_estado_id" => 29,
                "nome"     => "Cotegipe",
            ],
            [
                "ibge_codigo"       => 2909505,
                "ibge_estado_id" => 29,
                "nome"     => "Cravolândia",
            ],
            [
                "ibge_codigo"       => 2909604,
                "ibge_estado_id" => 29,
                "nome"     => "Crisópolis",
            ],
            [
                "ibge_codigo"       => 2909703,
                "ibge_estado_id" => 29,
                "nome"     => "Cristópolis",
            ],
            [
                "ibge_codigo"       => 2909802,
                "ibge_estado_id" => 29,
                "nome"     => "Cruz das Almas",
            ],
            [
                "ibge_codigo"       => 2909901,
                "ibge_estado_id" => 29,
                "nome"     => "Curaçá",
            ],
            [
                "ibge_codigo"       => 2910008,
                "ibge_estado_id" => 29,
                "nome"     => "Dário Meira",
            ],
            [
                "ibge_codigo"       => 2910057,
                "ibge_estado_id" => 29,
                "nome"     => "Dias d'Ávila",
            ],
            [
                "ibge_codigo"       => 2910107,
                "ibge_estado_id" => 29,
                "nome"     => "Dom Basílio",
            ],
            [
                "ibge_codigo"       => 2910206,
                "ibge_estado_id" => 29,
                "nome"     => "Dom Macedo Costa",
            ],
            [
                "ibge_codigo"       => 2910305,
                "ibge_estado_id" => 29,
                "nome"     => "Elísio Medrado",
            ],
            [
                "ibge_codigo"       => 2910404,
                "ibge_estado_id" => 29,
                "nome"     => "Encruzilhada",
            ],
            [
                "ibge_codigo"       => 2910503,
                "ibge_estado_id" => 29,
                "nome"     => "Entre Rios",
            ],
            [
                "ibge_codigo"       => 2910602,
                "ibge_estado_id" => 29,
                "nome"     => "Esplanada",
            ],
            [
                "ibge_codigo"       => 2910701,
                "ibge_estado_id" => 29,
                "nome"     => "Euclides da Cunha",
            ],
            [
                "ibge_codigo"       => 2910727,
                "ibge_estado_id" => 29,
                "nome"     => "Eunápolis",
            ],
            [
                "ibge_codigo"       => 2910750,
                "ibge_estado_id" => 29,
                "nome"     => "Fátima",
            ],
            [
                "ibge_codigo"       => 2910776,
                "ibge_estado_id" => 29,
                "nome"     => "Feira da Mata",
            ],
            [
                "ibge_codigo"       => 2910800,
                "ibge_estado_id" => 29,
                "nome"     => "Feira de Santana",
            ],
            [
                "ibge_codigo"       => 2910859,
                "ibge_estado_id" => 29,
                "nome"     => "Filadélfia",
            ],
            [
                "ibge_codigo"       => 2910909,
                "ibge_estado_id" => 29,
                "nome"     => "Firmino Alves",
            ],
            [
                "ibge_codigo"       => 2911006,
                "ibge_estado_id" => 29,
                "nome"     => "Floresta Azul",
            ],
            [
                "ibge_codigo"       => 2911105,
                "ibge_estado_id" => 29,
                "nome"     => "Formosa do Rio Preto",
            ],
            [
                "ibge_codigo"       => 2911204,
                "ibge_estado_id" => 29,
                "nome"     => "Gandu",
            ],
            [
                "ibge_codigo"       => 2911253,
                "ibge_estado_id" => 29,
                "nome"     => "Gavião",
            ],
            [
                "ibge_codigo"       => 2911303,
                "ibge_estado_id" => 29,
                "nome"     => "Gentio do Ouro",
            ],
            [
                "ibge_codigo"       => 2911402,
                "ibge_estado_id" => 29,
                "nome"     => "Glória",
            ],
            [
                "ibge_codigo"       => 2911501,
                "ibge_estado_id" => 29,
                "nome"     => "Gongogi",
            ],
            [
                "ibge_codigo"       => 2911600,
                "ibge_estado_id" => 29,
                "nome"     => "Governador Mangabeira",
            ],
            [
                "ibge_codigo"       => 2911659,
                "ibge_estado_id" => 29,
                "nome"     => "Guajeru",
            ],
            [
                "ibge_codigo"       => 2911709,
                "ibge_estado_id" => 29,
                "nome"     => "Guanambi",
            ],
            [
                "ibge_codigo"       => 2911808,
                "ibge_estado_id" => 29,
                "nome"     => "Guaratinga",
            ],
            [
                "ibge_codigo"       => 2911857,
                "ibge_estado_id" => 29,
                "nome"     => "Heliópolis",
            ],
            [
                "ibge_codigo"       => 2911907,
                "ibge_estado_id" => 29,
                "nome"     => "Iaçu",
            ],
            [
                "ibge_codigo"       => 2912004,
                "ibge_estado_id" => 29,
                "nome"     => "Ibiassucê",
            ],
            [
                "ibge_codigo"       => 2912103,
                "ibge_estado_id" => 29,
                "nome"     => "Ibicaraí",
            ],
            [
                "ibge_codigo"       => 2912202,
                "ibge_estado_id" => 29,
                "nome"     => "Ibicoara",
            ],
            [
                "ibge_codigo"       => 2912301,
                "ibge_estado_id" => 29,
                "nome"     => "Ibicuí",
            ],
            [
                "ibge_codigo"       => 2912400,
                "ibge_estado_id" => 29,
                "nome"     => "Ibipeba",
            ],
            [
                "ibge_codigo"       => 2912509,
                "ibge_estado_id" => 29,
                "nome"     => "Ibipitanga",
            ],
            [
                "ibge_codigo"       => 2912608,
                "ibge_estado_id" => 29,
                "nome"     => "Ibiquera",
            ],
            [
                "ibge_codigo"       => 2912707,
                "ibge_estado_id" => 29,
                "nome"     => "Ibirapitanga",
            ],
            [
                "ibge_codigo"       => 2912806,
                "ibge_estado_id" => 29,
                "nome"     => "Ibirapuã",
            ],
            [
                "ibge_codigo"       => 2912905,
                "ibge_estado_id" => 29,
                "nome"     => "Ibirataia",
            ],
            [
                "ibge_codigo"       => 2913002,
                "ibge_estado_id" => 29,
                "nome"     => "Ibitiara",
            ],
            [
                "ibge_codigo"       => 2913101,
                "ibge_estado_id" => 29,
                "nome"     => "Ibititá",
            ],
            [
                "ibge_codigo"       => 2913200,
                "ibge_estado_id" => 29,
                "nome"     => "Ibotirama",
            ],
            [
                "ibge_codigo"       => 2913309,
                "ibge_estado_id" => 29,
                "nome"     => "Ichu",
            ],
            [
                "ibge_codigo"       => 2913408,
                "ibge_estado_id" => 29,
                "nome"     => "Igaporã",
            ],
            [
                "ibge_codigo"       => 2913457,
                "ibge_estado_id" => 29,
                "nome"     => "Igrapiúna",
            ],
            [
                "ibge_codigo"       => 2913507,
                "ibge_estado_id" => 29,
                "nome"     => "Iguaí",
            ],
            [
                "ibge_codigo"       => 2913606,
                "ibge_estado_id" => 29,
                "nome"     => "Ilhéus",
            ],
            [
                "ibge_codigo"       => 2913705,
                "ibge_estado_id" => 29,
                "nome"     => "Inhambupe",
            ],
            [
                "ibge_codigo"       => 2913804,
                "ibge_estado_id" => 29,
                "nome"     => "Ipecaetá",
            ],
            [
                "ibge_codigo"       => 2913903,
                "ibge_estado_id" => 29,
                "nome"     => "Ipiaú",
            ],
            [
                "ibge_codigo"       => 2914000,
                "ibge_estado_id" => 29,
                "nome"     => "Ipirá",
            ],
            [
                "ibge_codigo"       => 2914109,
                "ibge_estado_id" => 29,
                "nome"     => "Ipupiara",
            ],
            [
                "ibge_codigo"       => 2914208,
                "ibge_estado_id" => 29,
                "nome"     => "Irajuba",
            ],
            [
                "ibge_codigo"       => 2914307,
                "ibge_estado_id" => 29,
                "nome"     => "Iramaia",
            ],
            [
                "ibge_codigo"       => 2914406,
                "ibge_estado_id" => 29,
                "nome"     => "Iraquara",
            ],
            [
                "ibge_codigo"       => 2914505,
                "ibge_estado_id" => 29,
                "nome"     => "Irará",
            ],
            [
                "ibge_codigo"       => 2914604,
                "ibge_estado_id" => 29,
                "nome"     => "Irecê",
            ],
            [
                "ibge_codigo"       => 2914653,
                "ibge_estado_id" => 29,
                "nome"     => "Itabela",
            ],
            [
                "ibge_codigo"       => 2914703,
                "ibge_estado_id" => 29,
                "nome"     => "Itaberaba",
            ],
            [
                "ibge_codigo"       => 2914802,
                "ibge_estado_id" => 29,
                "nome"     => "Itabuna",
            ],
            [
                "ibge_codigo"       => 2914901,
                "ibge_estado_id" => 29,
                "nome"     => "Itacaré",
            ],
            [
                "ibge_codigo"       => 2915007,
                "ibge_estado_id" => 29,
                "nome"     => "Itaeté",
            ],
            [
                "ibge_codigo"       => 2915106,
                "ibge_estado_id" => 29,
                "nome"     => "Itagi",
            ],
            [
                "ibge_codigo"       => 2915205,
                "ibge_estado_id" => 29,
                "nome"     => "Itagibá",
            ],
            [
                "ibge_codigo"       => 2915304,
                "ibge_estado_id" => 29,
                "nome"     => "Itagimirim",
            ],
            [
                "ibge_codigo"       => 2915353,
                "ibge_estado_id" => 29,
                "nome"     => "Itaguaçu da Bahia",
            ],
            [
                "ibge_codigo"       => 2915403,
                "ibge_estado_id" => 29,
                "nome"     => "Itaju do Colônia",
            ],
            [
                "ibge_codigo"       => 2915502,
                "ibge_estado_id" => 29,
                "nome"     => "Itajuípe",
            ],
            [
                "ibge_codigo"       => 2915601,
                "ibge_estado_id" => 29,
                "nome"     => "Itamaraju",
            ],
            [
                "ibge_codigo"       => 2915700,
                "ibge_estado_id" => 29,
                "nome"     => "Itamari",
            ],
            [
                "ibge_codigo"       => 2915809,
                "ibge_estado_id" => 29,
                "nome"     => "Itambé",
            ],
            [
                "ibge_codigo"       => 2915908,
                "ibge_estado_id" => 29,
                "nome"     => "Itanagra",
            ],
            [
                "ibge_codigo"       => 2916005,
                "ibge_estado_id" => 29,
                "nome"     => "Itanhém",
            ],
            [
                "ibge_codigo"       => 2916104,
                "ibge_estado_id" => 29,
                "nome"     => "Itaparica",
            ],
            [
                "ibge_codigo"       => 2916203,
                "ibge_estado_id" => 29,
                "nome"     => "Itapé",
            ],
            [
                "ibge_codigo"       => 2916302,
                "ibge_estado_id" => 29,
                "nome"     => "Itapebi",
            ],
            [
                "ibge_codigo"       => 2916401,
                "ibge_estado_id" => 29,
                "nome"     => "Itapetinga",
            ],
            [
                "ibge_codigo"       => 2916500,
                "ibge_estado_id" => 29,
                "nome"     => "Itapicuru",
            ],
            [
                "ibge_codigo"       => 2916609,
                "ibge_estado_id" => 29,
                "nome"     => "Itapitanga",
            ],
            [
                "ibge_codigo"       => 2916708,
                "ibge_estado_id" => 29,
                "nome"     => "Itaquara",
            ],
            [
                "ibge_codigo"       => 2916807,
                "ibge_estado_id" => 29,
                "nome"     => "Itarantim",
            ],
            [
                "ibge_codigo"       => 2916856,
                "ibge_estado_id" => 29,
                "nome"     => "Itatim",
            ],
            [
                "ibge_codigo"       => 2916906,
                "ibge_estado_id" => 29,
                "nome"     => "Itiruçu",
            ],
            [
                "ibge_codigo"       => 2917003,
                "ibge_estado_id" => 29,
                "nome"     => "Itiúba",
            ],
            [
                "ibge_codigo"       => 2917102,
                "ibge_estado_id" => 29,
                "nome"     => "Itororó",
            ],
            [
                "ibge_codigo"       => 2917201,
                "ibge_estado_id" => 29,
                "nome"     => "Ituaçu",
            ],
            [
                "ibge_codigo"       => 2917300,
                "ibge_estado_id" => 29,
                "nome"     => "Ituberá",
            ],
            [
                "ibge_codigo"       => 2917334,
                "ibge_estado_id" => 29,
                "nome"     => "Iuiú",
            ],
            [
                "ibge_codigo"       => 2917359,
                "ibge_estado_id" => 29,
                "nome"     => "Jaborandi",
            ],
            [
                "ibge_codigo"       => 2917409,
                "ibge_estado_id" => 29,
                "nome"     => "Jacaraci",
            ],
            [
                "ibge_codigo"       => 2917508,
                "ibge_estado_id" => 29,
                "nome"     => "Jacobina",
            ],
            [
                "ibge_codigo"       => 2917607,
                "ibge_estado_id" => 29,
                "nome"     => "Jaguaquara",
            ],
            [
                "ibge_codigo"       => 2917706,
                "ibge_estado_id" => 29,
                "nome"     => "Jaguarari",
            ],
            [
                "ibge_codigo"       => 2917805,
                "ibge_estado_id" => 29,
                "nome"     => "Jaguaripe",
            ],
            [
                "ibge_codigo"       => 2917904,
                "ibge_estado_id" => 29,
                "nome"     => "Jandaíra",
            ],
            [
                "ibge_codigo"       => 2918001,
                "ibge_estado_id" => 29,
                "nome"     => "Jequié",
            ],
            [
                "ibge_codigo"       => 2918100,
                "ibge_estado_id" => 29,
                "nome"     => "Jeremoabo",
            ],
            [
                "ibge_codigo"       => 2918209,
                "ibge_estado_id" => 29,
                "nome"     => "Jiquiriçá",
            ],
            [
                "ibge_codigo"       => 2918308,
                "ibge_estado_id" => 29,
                "nome"     => "Jitaúna",
            ],
            [
                "ibge_codigo"       => 2918357,
                "ibge_estado_id" => 29,
                "nome"     => "João Dourado",
            ],
            [
                "ibge_codigo"       => 2918407,
                "ibge_estado_id" => 29,
                "nome"     => "Juazeiro",
            ],
            [
                "ibge_codigo"       => 2918456,
                "ibge_estado_id" => 29,
                "nome"     => "Jucuruçu",
            ],
            [
                "ibge_codigo"       => 2918506,
                "ibge_estado_id" => 29,
                "nome"     => "Jussara",
            ],
            [
                "ibge_codigo"       => 2918555,
                "ibge_estado_id" => 29,
                "nome"     => "Jussari",
            ],
            [
                "ibge_codigo"       => 2918605,
                "ibge_estado_id" => 29,
                "nome"     => "Jussiape",
            ],
            [
                "ibge_codigo"       => 2918704,
                "ibge_estado_id" => 29,
                "nome"     => "Lafaiete Coutinho",
            ],
            [
                "ibge_codigo"       => 2918753,
                "ibge_estado_id" => 29,
                "nome"     => "Lagoa Real",
            ],
            [
                "ibge_codigo"       => 2918803,
                "ibge_estado_id" => 29,
                "nome"     => "Laje",
            ],
            [
                "ibge_codigo"       => 2918902,
                "ibge_estado_id" => 29,
                "nome"     => "Lajedão",
            ],
            [
                "ibge_codigo"       => 2919009,
                "ibge_estado_id" => 29,
                "nome"     => "Lajedinho",
            ],
            [
                "ibge_codigo"       => 2919058,
                "ibge_estado_id" => 29,
                "nome"     => "Lajedo do Tabocal",
            ],
            [
                "ibge_codigo"       => 2919108,
                "ibge_estado_id" => 29,
                "nome"     => "Lamarão",
            ],
            [
                "ibge_codigo"       => 2919157,
                "ibge_estado_id" => 29,
                "nome"     => "Lapão",
            ],
            [
                "ibge_codigo"       => 2919207,
                "ibge_estado_id" => 29,
                "nome"     => "Lauro de Freitas",
            ],
            [
                "ibge_codigo"       => 2919306,
                "ibge_estado_id" => 29,
                "nome"     => "Lençóis",
            ],
            [
                "ibge_codigo"       => 2919405,
                "ibge_estado_id" => 29,
                "nome"     => "Licínio de Almeida",
            ],
            [
                "ibge_codigo"       => 2919504,
                "ibge_estado_id" => 29,
                "nome"     => "Livramento de Nossa Senhora",
            ],
            [
                "ibge_codigo"       => 2919553,
                "ibge_estado_id" => 29,
                "nome"     => "Luís Eduardo Magalhães",
            ],
            [
                "ibge_codigo"       => 2919603,
                "ibge_estado_id" => 29,
                "nome"     => "Macajuba",
            ],
            [
                "ibge_codigo"       => 2919702,
                "ibge_estado_id" => 29,
                "nome"     => "Macarani",
            ],
            [
                "ibge_codigo"       => 2919801,
                "ibge_estado_id" => 29,
                "nome"     => "Macaúbas",
            ],
            [
                "ibge_codigo"       => 2919900,
                "ibge_estado_id" => 29,
                "nome"     => "Macururé",
            ],
            [
                "ibge_codigo"       => 2919926,
                "ibge_estado_id" => 29,
                "nome"     => "Madre de Deus",
            ],
            [
                "ibge_codigo"       => 2919959,
                "ibge_estado_id" => 29,
                "nome"     => "Maetinga",
            ],
            [
                "ibge_codigo"       => 2920007,
                "ibge_estado_id" => 29,
                "nome"     => "Maiquinique",
            ],
            [
                "ibge_codigo"       => 2920106,
                "ibge_estado_id" => 29,
                "nome"     => "Mairi",
            ],
            [
                "ibge_codigo"       => 2920205,
                "ibge_estado_id" => 29,
                "nome"     => "Malhada",
            ],
            [
                "ibge_codigo"       => 2920304,
                "ibge_estado_id" => 29,
                "nome"     => "Malhada de Pedras",
            ],
            [
                "ibge_codigo"       => 2920403,
                "ibge_estado_id" => 29,
                "nome"     => "Manoel Vitorino",
            ],
            [
                "ibge_codigo"       => 2920452,
                "ibge_estado_id" => 29,
                "nome"     => "Mansidão",
            ],
            [
                "ibge_codigo"       => 2920502,
                "ibge_estado_id" => 29,
                "nome"     => "Maracás",
            ],
            [
                "ibge_codigo"       => 2920601,
                "ibge_estado_id" => 29,
                "nome"     => "Maragogipe",
            ],
            [
                "ibge_codigo"       => 2920700,
                "ibge_estado_id" => 29,
                "nome"     => "Maraú",
            ],
            [
                "ibge_codigo"       => 2920809,
                "ibge_estado_id" => 29,
                "nome"     => "Marcionílio Souza",
            ],
            [
                "ibge_codigo"       => 2920908,
                "ibge_estado_id" => 29,
                "nome"     => "Mascote",
            ],
            [
                "ibge_codigo"       => 2921005,
                "ibge_estado_id" => 29,
                "nome"     => "Mata de São João",
            ],
            [
                "ibge_codigo"       => 2921054,
                "ibge_estado_id" => 29,
                "nome"     => "Matina",
            ],
            [
                "ibge_codigo"       => 2921104,
                "ibge_estado_id" => 29,
                "nome"     => "Medeiros Neto",
            ],
            [
                "ibge_codigo"       => 2921203,
                "ibge_estado_id" => 29,
                "nome"     => "Miguel Calmon",
            ],
            [
                "ibge_codigo"       => 2921302,
                "ibge_estado_id" => 29,
                "nome"     => "Milagres",
            ],
            [
                "ibge_codigo"       => 2921401,
                "ibge_estado_id" => 29,
                "nome"     => "Mirangaba",
            ],
            [
                "ibge_codigo"       => 2921450,
                "ibge_estado_id" => 29,
                "nome"     => "Mirante",
            ],
            [
                "ibge_codigo"       => 2921500,
                "ibge_estado_id" => 29,
                "nome"     => "Monte Santo",
            ],
            [
                "ibge_codigo"       => 2921609,
                "ibge_estado_id" => 29,
                "nome"     => "Morpará",
            ],
            [
                "ibge_codigo"       => 2921708,
                "ibge_estado_id" => 29,
                "nome"     => "Morro do Chapéu",
            ],
            [
                "ibge_codigo"       => 2921807,
                "ibge_estado_id" => 29,
                "nome"     => "Mortugaba",
            ],
            [
                "ibge_codigo"       => 2921906,
                "ibge_estado_id" => 29,
                "nome"     => "Mucugê",
            ],
            [
                "ibge_codigo"       => 2922003,
                "ibge_estado_id" => 29,
                "nome"     => "Mucuri",
            ],
            [
                "ibge_codigo"       => 2922052,
                "ibge_estado_id" => 29,
                "nome"     => "Mulungu do Morro",
            ],
            [
                "ibge_codigo"       => 2922102,
                "ibge_estado_id" => 29,
                "nome"     => "Mundo Novo",
            ],
            [
                "ibge_codigo"       => 2922201,
                "ibge_estado_id" => 29,
                "nome"     => "Muniz Ferreira",
            ],
            [
                "ibge_codigo"       => 2922250,
                "ibge_estado_id" => 29,
                "nome"     => "Muquém de São Francisco",
            ],
            [
                "ibge_codigo"       => 2922300,
                "ibge_estado_id" => 29,
                "nome"     => "Muritiba",
            ],
            [
                "ibge_codigo"       => 2922409,
                "ibge_estado_id" => 29,
                "nome"     => "Mutuípe",
            ],
            [
                "ibge_codigo"       => 2922508,
                "ibge_estado_id" => 29,
                "nome"     => "Nazaré",
            ],
            [
                "ibge_codigo"       => 2922607,
                "ibge_estado_id" => 29,
                "nome"     => "Nilo Peçanha",
            ],
            [
                "ibge_codigo"       => 2922656,
                "ibge_estado_id" => 29,
                "nome"     => "Nordestina",
            ],
            [
                "ibge_codigo"       => 2922706,
                "ibge_estado_id" => 29,
                "nome"     => "Nova Canaã",
            ],
            [
                "ibge_codigo"       => 2922730,
                "ibge_estado_id" => 29,
                "nome"     => "Nova Fátima",
            ],
            [
                "ibge_codigo"       => 2922755,
                "ibge_estado_id" => 29,
                "nome"     => "Nova Ibiá",
            ],
            [
                "ibge_codigo"       => 2922805,
                "ibge_estado_id" => 29,
                "nome"     => "Nova Itarana",
            ],
            [
                "ibge_codigo"       => 2922854,
                "ibge_estado_id" => 29,
                "nome"     => "Nova Redenção",
            ],
            [
                "ibge_codigo"       => 2922904,
                "ibge_estado_id" => 29,
                "nome"     => "Nova Soure",
            ],
            [
                "ibge_codigo"       => 2923001,
                "ibge_estado_id" => 29,
                "nome"     => "Nova Viçosa",
            ],
            [
                "ibge_codigo"       => 2923035,
                "ibge_estado_id" => 29,
                "nome"     => "Novo Horizonte",
            ],
            [
                "ibge_codigo"       => 2923050,
                "ibge_estado_id" => 29,
                "nome"     => "Novo Triunfo",
            ],
            [
                "ibge_codigo"       => 2923100,
                "ibge_estado_id" => 29,
                "nome"     => "Olindina",
            ],
            [
                "ibge_codigo"       => 2923209,
                "ibge_estado_id" => 29,
                "nome"     => "Oliveira dos Brejinhos",
            ],
            [
                "ibge_codigo"       => 2923308,
                "ibge_estado_id" => 29,
                "nome"     => "Ouriçangas",
            ],
            [
                "ibge_codigo"       => 2923357,
                "ibge_estado_id" => 29,
                "nome"     => "Ourolândia",
            ],
            [
                "ibge_codigo"       => 2923407,
                "ibge_estado_id" => 29,
                "nome"     => "Palmas de Monte Alto",
            ],
            [
                "ibge_codigo"       => 2923506,
                "ibge_estado_id" => 29,
                "nome"     => "Palmeiras",
            ],
            [
                "ibge_codigo"       => 2923605,
                "ibge_estado_id" => 29,
                "nome"     => "Paramirim",
            ],
            [
                "ibge_codigo"       => 2923704,
                "ibge_estado_id" => 29,
                "nome"     => "Paratinga",
            ],
            [
                "ibge_codigo"       => 2923803,
                "ibge_estado_id" => 29,
                "nome"     => "Paripiranga",
            ],
            [
                "ibge_codigo"       => 2923902,
                "ibge_estado_id" => 29,
                "nome"     => "Pau Brasil",
            ],
            [
                "ibge_codigo"       => 2924009,
                "ibge_estado_id" => 29,
                "nome"     => "Paulo Afonso",
            ],
            [
                "ibge_codigo"       => 2924058,
                "ibge_estado_id" => 29,
                "nome"     => "Pé de Serra",
            ],
            [
                "ibge_codigo"       => 2924108,
                "ibge_estado_id" => 29,
                "nome"     => "Pedrão",
            ],
            [
                "ibge_codigo"       => 2924207,
                "ibge_estado_id" => 29,
                "nome"     => "Pedro Alexandre",
            ],
            [
                "ibge_codigo"       => 2924306,
                "ibge_estado_id" => 29,
                "nome"     => "Piatã",
            ],
            [
                "ibge_codigo"       => 2924405,
                "ibge_estado_id" => 29,
                "nome"     => "Pilão Arcado",
            ],
            [
                "ibge_codigo"       => 2924504,
                "ibge_estado_id" => 29,
                "nome"     => "Pindaí",
            ],
            [
                "ibge_codigo"       => 2924603,
                "ibge_estado_id" => 29,
                "nome"     => "Pindobaçu",
            ],
            [
                "ibge_codigo"       => 2924652,
                "ibge_estado_id" => 29,
                "nome"     => "Pintadas",
            ],
            [
                "ibge_codigo"       => 2924678,
                "ibge_estado_id" => 29,
                "nome"     => "Piraí do Norte",
            ],
            [
                "ibge_codigo"       => 2924702,
                "ibge_estado_id" => 29,
                "nome"     => "Piripá",
            ],
            [
                "ibge_codigo"       => 2924801,
                "ibge_estado_id" => 29,
                "nome"     => "Piritiba",
            ],
            [
                "ibge_codigo"       => 2924900,
                "ibge_estado_id" => 29,
                "nome"     => "Planaltino",
            ],
            [
                "ibge_codigo"       => 2925006,
                "ibge_estado_id" => 29,
                "nome"     => "Planalto",
            ],
            [
                "ibge_codigo"       => 2925105,
                "ibge_estado_id" => 29,
                "nome"     => "Poções",
            ],
            [
                "ibge_codigo"       => 2925204,
                "ibge_estado_id" => 29,
                "nome"     => "Pojuca",
            ],
            [
                "ibge_codigo"       => 2925253,
                "ibge_estado_id" => 29,
                "nome"     => "Ponto Novo",
            ],
            [
                "ibge_codigo"       => 2925303,
                "ibge_estado_id" => 29,
                "nome"     => "Porto Seguro",
            ],
            [
                "ibge_codigo"       => 2925402,
                "ibge_estado_id" => 29,
                "nome"     => "Potiraguá",
            ],
            [
                "ibge_codigo"       => 2925501,
                "ibge_estado_id" => 29,
                "nome"     => "Prado",
            ],
            [
                "ibge_codigo"       => 2925600,
                "ibge_estado_id" => 29,
                "nome"     => "Presidente Dutra",
            ],
            [
                "ibge_codigo"       => 2925709,
                "ibge_estado_id" => 29,
                "nome"     => "Presidente Jânio Quadros",
            ],
            [
                "ibge_codigo"       => 2925758,
                "ibge_estado_id" => 29,
                "nome"     => "Presidente Tancredo Neves",
            ],
            [
                "ibge_codigo"       => 2925808,
                "ibge_estado_id" => 29,
                "nome"     => "Queimadas",
            ],
            [
                "ibge_codigo"       => 2925907,
                "ibge_estado_id" => 29,
                "nome"     => "Quijingue",
            ],
            [
                "ibge_codigo"       => 2925931,
                "ibge_estado_id" => 29,
                "nome"     => "Quixabeira",
            ],
            [
                "ibge_codigo"       => 2925956,
                "ibge_estado_id" => 29,
                "nome"     => "Rafael Jambeiro",
            ],
            [
                "ibge_codigo"       => 2926004,
                "ibge_estado_id" => 29,
                "nome"     => "Remanso",
            ],
            [
                "ibge_codigo"       => 2926103,
                "ibge_estado_id" => 29,
                "nome"     => "Retirolândia",
            ],
            [
                "ibge_codigo"       => 2926202,
                "ibge_estado_id" => 29,
                "nome"     => "Riachão das Neves",
            ],
            [
                "ibge_codigo"       => 2926301,
                "ibge_estado_id" => 29,
                "nome"     => "Riachão do Jacuípe",
            ],
            [
                "ibge_codigo"       => 2926400,
                "ibge_estado_id" => 29,
                "nome"     => "Riacho de Santana",
            ],
            [
                "ibge_codigo"       => 2926509,
                "ibge_estado_id" => 29,
                "nome"     => "Ribeira do Amparo",
            ],
            [
                "ibge_codigo"       => 2926608,
                "ibge_estado_id" => 29,
                "nome"     => "Ribeira do Pombal",
            ],
            [
                "ibge_codigo"       => 2926657,
                "ibge_estado_id" => 29,
                "nome"     => "Ribeirão do Largo",
            ],
            [
                "ibge_codigo"       => 2926707,
                "ibge_estado_id" => 29,
                "nome"     => "Rio de Contas",
            ],
            [
                "ibge_codigo"       => 2926806,
                "ibge_estado_id" => 29,
                "nome"     => "Rio do Antônio",
            ],
            [
                "ibge_codigo"       => 2926905,
                "ibge_estado_id" => 29,
                "nome"     => "Rio do Pires",
            ],
            [
                "ibge_codigo"       => 2927002,
                "ibge_estado_id" => 29,
                "nome"     => "Rio Real",
            ],
            [
                "ibge_codigo"       => 2927101,
                "ibge_estado_id" => 29,
                "nome"     => "Rodelas",
            ],
            [
                "ibge_codigo"       => 2927200,
                "ibge_estado_id" => 29,
                "nome"     => "Ruy Barbosa",
            ],
            [
                "ibge_codigo"       => 2927309,
                "ibge_estado_id" => 29,
                "nome"     => "Salinas da Margarida",
            ],
            [
                "ibge_codigo"       => 2927408,
                "ibge_estado_id" => 29,
                "nome"     => "Salvador",
            ],
            [
                "ibge_codigo"       => 2927507,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Bárbara",
            ],
            [
                "ibge_codigo"       => 2927606,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Brígida",
            ],
            [
                "ibge_codigo"       => 2927705,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Cruz Cabrália",
            ],
            [
                "ibge_codigo"       => 2927804,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Cruz da Vitória",
            ],
            [
                "ibge_codigo"       => 2927903,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Inês",
            ],
            [
                "ibge_codigo"       => 2928000,
                "ibge_estado_id" => 29,
                "nome"     => "Santaluz",
            ],
            [
                "ibge_codigo"       => 2928059,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Luzia",
            ],
            [
                "ibge_codigo"       => 2928109,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Maria da Vitória",
            ],
            [
                "ibge_codigo"       => 2928208,
                "ibge_estado_id" => 29,
                "nome"     => "Santana",
            ],
            [
                "ibge_codigo"       => 2928307,
                "ibge_estado_id" => 29,
                "nome"     => "Santanópolis",
            ],
            [
                "ibge_codigo"       => 2928406,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Rita de Cássia",
            ],
            [
                "ibge_codigo"       => 2928505,
                "ibge_estado_id" => 29,
                "nome"     => "Santa Teresinha",
            ],
            [
                "ibge_codigo"       => 2928604,
                "ibge_estado_id" => 29,
                "nome"     => "Santo Amaro",
            ],
            [
                "ibge_codigo"       => 2928703,
                "ibge_estado_id" => 29,
                "nome"     => "Santo Antônio de Jesus",
            ],
            [
                "ibge_codigo"       => 2928802,
                "ibge_estado_id" => 29,
                "nome"     => "Santo Estêvão",
            ],
            [
                "ibge_codigo"       => 2928901,
                "ibge_estado_id" => 29,
                "nome"     => "São Desidério",
            ],
            [
                "ibge_codigo"       => 2928950,
                "ibge_estado_id" => 29,
                "nome"     => "São Domingos",
            ],
            [
                "ibge_codigo"       => 2929008,
                "ibge_estado_id" => 29,
                "nome"     => "São Félix",
            ],
            [
                "ibge_codigo"       => 2929057,
                "ibge_estado_id" => 29,
                "nome"     => "São Félix do Coribe",
            ],
            [
                "ibge_codigo"       => 2929107,
                "ibge_estado_id" => 29,
                "nome"     => "São Felipe",
            ],
            [
                "ibge_codigo"       => 2929206,
                "ibge_estado_id" => 29,
                "nome"     => "São Francisco do Conde",
            ],
            [
                "ibge_codigo"       => 2929255,
                "ibge_estado_id" => 29,
                "nome"     => "São Gabriel",
            ],
            [
                "ibge_codigo"       => 2929305,
                "ibge_estado_id" => 29,
                "nome"     => "São Gonçalo dos Campos",
            ],
            [
                "ibge_codigo"       => 2929354,
                "ibge_estado_id" => 29,
                "nome"     => "São José da Vitória",
            ],
            [
                "ibge_codigo"       => 2929370,
                "ibge_estado_id" => 29,
                "nome"     => "São José do Jacuípe",
            ],
            [
                "ibge_codigo"       => 2929404,
                "ibge_estado_id" => 29,
                "nome"     => "São Miguel das Matas",
            ],
            [
                "ibge_codigo"       => 2929503,
                "ibge_estado_id" => 29,
                "nome"     => "São Sebastião do Passé",
            ],
            [
                "ibge_codigo"       => 2929602,
                "ibge_estado_id" => 29,
                "nome"     => "Sapeaçu",
            ],
            [
                "ibge_codigo"       => 2929701,
                "ibge_estado_id" => 29,
                "nome"     => "Sátiro Dias",
            ],
            [
                "ibge_codigo"       => 2929750,
                "ibge_estado_id" => 29,
                "nome"     => "Saubara",
            ],
            [
                "ibge_codigo"       => 2929800,
                "ibge_estado_id" => 29,
                "nome"     => "Saúde",
            ],
            [
                "ibge_codigo"       => 2929909,
                "ibge_estado_id" => 29,
                "nome"     => "Seabra",
            ],
            [
                "ibge_codigo"       => 2930006,
                "ibge_estado_id" => 29,
                "nome"     => "Sebastião Laranjeiras",
            ],
            [
                "ibge_codigo"       => 2930105,
                "ibge_estado_id" => 29,
                "nome"     => "Senhor do Bonfim",
            ],
            [
                "ibge_codigo"       => 2930154,
                "ibge_estado_id" => 29,
                "nome"     => "Serra do Ramalho",
            ],
            [
                "ibge_codigo"       => 2930204,
                "ibge_estado_id" => 29,
                "nome"     => "Sento Sé",
            ],
            [
                "ibge_codigo"       => 2930303,
                "ibge_estado_id" => 29,
                "nome"     => "Serra Dourada",
            ],
            [
                "ibge_codigo"       => 2930402,
                "ibge_estado_id" => 29,
                "nome"     => "Serra Preta",
            ],
            [
                "ibge_codigo"       => 2930501,
                "ibge_estado_id" => 29,
                "nome"     => "Serrinha",
            ],
            [
                "ibge_codigo"       => 2930600,
                "ibge_estado_id" => 29,
                "nome"     => "Serrolândia",
            ],
            [
                "ibge_codigo"       => 2930709,
                "ibge_estado_id" => 29,
                "nome"     => "Simões Filho",
            ],
            [
                "ibge_codigo"       => 2930758,
                "ibge_estado_id" => 29,
                "nome"     => "Sítio do Mato",
            ],
            [
                "ibge_codigo"       => 2930766,
                "ibge_estado_id" => 29,
                "nome"     => "Sítio do Quinto",
            ],
            [
                "ibge_codigo"       => 2930774,
                "ibge_estado_id" => 29,
                "nome"     => "Sobradinho",
            ],
            [
                "ibge_codigo"       => 2930808,
                "ibge_estado_id" => 29,
                "nome"     => "Souto Soares",
            ],
            [
                "ibge_codigo"       => 2930907,
                "ibge_estado_id" => 29,
                "nome"     => "Tabocas do Brejo Velho",
            ],
            [
                "ibge_codigo"       => 2931004,
                "ibge_estado_id" => 29,
                "nome"     => "Tanhaçu",
            ],
            [
                "ibge_codigo"       => 2931053,
                "ibge_estado_id" => 29,
                "nome"     => "Tanque Novo",
            ],
            [
                "ibge_codigo"       => 2931103,
                "ibge_estado_id" => 29,
                "nome"     => "Tanquinho",
            ],
            [
                "ibge_codigo"       => 2931202,
                "ibge_estado_id" => 29,
                "nome"     => "Taperoá",
            ],
            [
                "ibge_codigo"       => 2931301,
                "ibge_estado_id" => 29,
                "nome"     => "Tapiramutá",
            ],
            [
                "ibge_codigo"       => 2931350,
                "ibge_estado_id" => 29,
                "nome"     => "Teixeira de Freitas",
            ],
            [
                "ibge_codigo"       => 2931400,
                "ibge_estado_id" => 29,
                "nome"     => "Teodoro Sampaio",
            ],
            [
                "ibge_codigo"       => 2931509,
                "ibge_estado_id" => 29,
                "nome"     => "Teofilândia",
            ],
            [
                "ibge_codigo"       => 2931608,
                "ibge_estado_id" => 29,
                "nome"     => "Teolândia",
            ],
            [
                "ibge_codigo"       => 2931707,
                "ibge_estado_id" => 29,
                "nome"     => "Terra Nova",
            ],
            [
                "ibge_codigo"       => 2931806,
                "ibge_estado_id" => 29,
                "nome"     => "Tremedal",
            ],
            [
                "ibge_codigo"       => 2931905,
                "ibge_estado_id" => 29,
                "nome"     => "Tucano",
            ],
            [
                "ibge_codigo"       => 2932002,
                "ibge_estado_id" => 29,
                "nome"     => "Uauá",
            ],
            [
                "ibge_codigo"       => 2932101,
                "ibge_estado_id" => 29,
                "nome"     => "Ubaíra",
            ],
            [
                "ibge_codigo"       => 2932200,
                "ibge_estado_id" => 29,
                "nome"     => "Ubaitaba",
            ],
            [
                "ibge_codigo"       => 2932309,
                "ibge_estado_id" => 29,
                "nome"     => "Ubatã",
            ],
            [
                "ibge_codigo"       => 2932408,
                "ibge_estado_id" => 29,
                "nome"     => "Uibaí",
            ],
            [
                "ibge_codigo"       => 2932457,
                "ibge_estado_id" => 29,
                "nome"     => "Umburanas",
            ],
            [
                "ibge_codigo"       => 2932507,
                "ibge_estado_id" => 29,
                "nome"     => "Una",
            ],
            [
                "ibge_codigo"       => 2932606,
                "ibge_estado_id" => 29,
                "nome"     => "Urandi",
            ],
            [
                "ibge_codigo"       => 2932705,
                "ibge_estado_id" => 29,
                "nome"     => "Uruçuca",
            ],
            [
                "ibge_codigo"       => 2932804,
                "ibge_estado_id" => 29,
                "nome"     => "Utinga",
            ],
            [
                "ibge_codigo"       => 2932903,
                "ibge_estado_id" => 29,
                "nome"     => "Valença",
            ],
            [
                "ibge_codigo"       => 2933000,
                "ibge_estado_id" => 29,
                "nome"     => "Valente",
            ],
            [
                "ibge_codigo"       => 2933059,
                "ibge_estado_id" => 29,
                "nome"     => "Várzea da Roça",
            ],
            [
                "ibge_codigo"       => 2933109,
                "ibge_estado_id" => 29,
                "nome"     => "Várzea do Poço",
            ],
            [
                "ibge_codigo"       => 2933158,
                "ibge_estado_id" => 29,
                "nome"     => "Várzea Nova",
            ],
            [
                "ibge_codigo"       => 2933174,
                "ibge_estado_id" => 29,
                "nome"     => "Varzedo",
            ],
            [
                "ibge_codigo"       => 2933208,
                "ibge_estado_id" => 29,
                "nome"     => "Vera Cruz",
            ],
            [
                "ibge_codigo"       => 2933257,
                "ibge_estado_id" => 29,
                "nome"     => "Vereda",
            ],
            [
                "ibge_codigo"       => 2933307,
                "ibge_estado_id" => 29,
                "nome"     => "Vitória da Conquista",
            ],
            [
                "ibge_codigo"       => 2933406,
                "ibge_estado_id" => 29,
                "nome"     => "Wagner",
            ],
            [
                "ibge_codigo"       => 2933455,
                "ibge_estado_id" => 29,
                "nome"     => "Wanderley",
            ],
            [
                "ibge_codigo"       => 2933505,
                "ibge_estado_id" => 29,
                "nome"     => "Wenceslau Guimarães",
            ],
            [
                "ibge_codigo"       => 2933604,
                "ibge_estado_id" => 29,
                "nome"     => "Xique-Xique",
            ],
            [
                "ibge_codigo"       => 3100104,
                "ibge_estado_id" => 31,
                "nome"     => "Abadia dos Dourados",
            ],
            [
                "ibge_codigo"       => 3100203,
                "ibge_estado_id" => 31,
                "nome"     => "Abaeté",
            ],
            [
                "ibge_codigo"       => 3100302,
                "ibge_estado_id" => 31,
                "nome"     => "Abre Campo",
            ],
            [
                "ibge_codigo"       => 3100401,
                "ibge_estado_id" => 31,
                "nome"     => "Acaiaca",
            ],
            [
                "ibge_codigo"       => 3100500,
                "ibge_estado_id" => 31,
                "nome"     => "Açucena",
            ],
            [
                "ibge_codigo"       => 3100609,
                "ibge_estado_id" => 31,
                "nome"     => "Água Boa",
            ],
            [
                "ibge_codigo"       => 3100708,
                "ibge_estado_id" => 31,
                "nome"     => "Água Comprida",
            ],
            [
                "ibge_codigo"       => 3100807,
                "ibge_estado_id" => 31,
                "nome"     => "Aguanil",
            ],
            [
                "ibge_codigo"       => 3100906,
                "ibge_estado_id" => 31,
                "nome"     => "Águas Formosas",
            ],
            [
                "ibge_codigo"       => 3101003,
                "ibge_estado_id" => 31,
                "nome"     => "Águas Vermelhas",
            ],
            [
                "ibge_codigo"       => 3101102,
                "ibge_estado_id" => 31,
                "nome"     => "Aimorés",
            ],
            [
                "ibge_codigo"       => 3101201,
                "ibge_estado_id" => 31,
                "nome"     => "Aiuruoca",
            ],
            [
                "ibge_codigo"       => 3101300,
                "ibge_estado_id" => 31,
                "nome"     => "Alagoa",
            ],
            [
                "ibge_codigo"       => 3101409,
                "ibge_estado_id" => 31,
                "nome"     => "Albertina",
            ],
            [
                "ibge_codigo"       => 3101508,
                "ibge_estado_id" => 31,
                "nome"     => "Além Paraíba",
            ],
            [
                "ibge_codigo"       => 3101607,
                "ibge_estado_id" => 31,
                "nome"     => "Alfenas",
            ],
            [
                "ibge_codigo"       => 3101631,
                "ibge_estado_id" => 31,
                "nome"     => "Alfredo Vasconcelos",
            ],
            [
                "ibge_codigo"       => 3101706,
                "ibge_estado_id" => 31,
                "nome"     => "Almenara",
            ],
            [
                "ibge_codigo"       => 3101805,
                "ibge_estado_id" => 31,
                "nome"     => "Alpercata",
            ],
            [
                "ibge_codigo"       => 3101904,
                "ibge_estado_id" => 31,
                "nome"     => "Alpinópolis",
            ],
            [
                "ibge_codigo"       => 3102001,
                "ibge_estado_id" => 31,
                "nome"     => "Alterosa",
            ],
            [
                "ibge_codigo"       => 3102050,
                "ibge_estado_id" => 31,
                "nome"     => "Alto Caparaó",
            ],
            [
                "ibge_codigo"       => 3102100,
                "ibge_estado_id" => 31,
                "nome"     => "Alto Rio Doce",
            ],
            [
                "ibge_codigo"       => 3102209,
                "ibge_estado_id" => 31,
                "nome"     => "Alvarenga",
            ],
            [
                "ibge_codigo"       => 3102308,
                "ibge_estado_id" => 31,
                "nome"     => "Alvinópolis",
            ],
            [
                "ibge_codigo"       => 3102407,
                "ibge_estado_id" => 31,
                "nome"     => "Alvorada de Minas",
            ],
            [
                "ibge_codigo"       => 3102506,
                "ibge_estado_id" => 31,
                "nome"     => "Amparo do Serra",
            ],
            [
                "ibge_codigo"       => 3102605,
                "ibge_estado_id" => 31,
                "nome"     => "Andradas",
            ],
            [
                "ibge_codigo"       => 3102704,
                "ibge_estado_id" => 31,
                "nome"     => "Cachoeira de Pajeú",
            ],
            [
                "ibge_codigo"       => 3102803,
                "ibge_estado_id" => 31,
                "nome"     => "Andrelândia",
            ],
            [
                "ibge_codigo"       => 3102852,
                "ibge_estado_id" => 31,
                "nome"     => "Angelândia",
            ],
            [
                "ibge_codigo"       => 3102902,
                "ibge_estado_id" => 31,
                "nome"     => "Antônio Carlos",
            ],
            [
                "ibge_codigo"       => 3103009,
                "ibge_estado_id" => 31,
                "nome"     => "Antônio Dias",
            ],
            [
                "ibge_codigo"       => 3103108,
                "ibge_estado_id" => 31,
                "nome"     => "Antônio Prado de Minas",
            ],
            [
                "ibge_codigo"       => 3103207,
                "ibge_estado_id" => 31,
                "nome"     => "Araçaí",
            ],
            [
                "ibge_codigo"       => 3103306,
                "ibge_estado_id" => 31,
                "nome"     => "Aracitaba",
            ],
            [
                "ibge_codigo"       => 3103405,
                "ibge_estado_id" => 31,
                "nome"     => "Araçuaí",
            ],
            [
                "ibge_codigo"       => 3103504,
                "ibge_estado_id" => 31,
                "nome"     => "Araguari",
            ],
            [
                "ibge_codigo"       => 3103603,
                "ibge_estado_id" => 31,
                "nome"     => "Arantina",
            ],
            [
                "ibge_codigo"       => 3103702,
                "ibge_estado_id" => 31,
                "nome"     => "Araponga",
            ],
            [
                "ibge_codigo"       => 3103751,
                "ibge_estado_id" => 31,
                "nome"     => "Araporã",
            ],
            [
                "ibge_codigo"       => 3103801,
                "ibge_estado_id" => 31,
                "nome"     => "Arapuá",
            ],
            [
                "ibge_codigo"       => 3103900,
                "ibge_estado_id" => 31,
                "nome"     => "Araújos",
            ],
            [
                "ibge_codigo"       => 3104007,
                "ibge_estado_id" => 31,
                "nome"     => "Araxá",
            ],
            [
                "ibge_codigo"       => 3104106,
                "ibge_estado_id" => 31,
                "nome"     => "Arceburgo",
            ],
            [
                "ibge_codigo"       => 3104205,
                "ibge_estado_id" => 31,
                "nome"     => "Arcos",
            ],
            [
                "ibge_codigo"       => 3104304,
                "ibge_estado_id" => 31,
                "nome"     => "Areado",
            ],
            [
                "ibge_codigo"       => 3104403,
                "ibge_estado_id" => 31,
                "nome"     => "Argirita",
            ],
            [
                "ibge_codigo"       => 3104452,
                "ibge_estado_id" => 31,
                "nome"     => "Aricanduva",
            ],
            [
                "ibge_codigo"       => 3104502,
                "ibge_estado_id" => 31,
                "nome"     => "Arinos",
            ],
            [
                "ibge_codigo"       => 3104601,
                "ibge_estado_id" => 31,
                "nome"     => "Astolfo Dutra",
            ],
            [
                "ibge_codigo"       => 3104700,
                "ibge_estado_id" => 31,
                "nome"     => "Ataléia",
            ],
            [
                "ibge_codigo"       => 3104809,
                "ibge_estado_id" => 31,
                "nome"     => "Augusto de Lima",
            ],
            [
                "ibge_codigo"       => 3104908,
                "ibge_estado_id" => 31,
                "nome"     => "Baependi",
            ],
            [
                "ibge_codigo"       => 3105004,
                "ibge_estado_id" => 31,
                "nome"     => "Baldim",
            ],
            [
                "ibge_codigo"       => 3105103,
                "ibge_estado_id" => 31,
                "nome"     => "Bambuí",
            ],
            [
                "ibge_codigo"       => 3105202,
                "ibge_estado_id" => 31,
                "nome"     => "Bandeira",
            ],
            [
                "ibge_codigo"       => 3105301,
                "ibge_estado_id" => 31,
                "nome"     => "Bandeira do Sul",
            ],
            [
                "ibge_codigo"       => 3105400,
                "ibge_estado_id" => 31,
                "nome"     => "Barão de Cocais",
            ],
            [
                "ibge_codigo"       => 3105509,
                "ibge_estado_id" => 31,
                "nome"     => "Barão de Monte Alto",
            ],
            [
                "ibge_codigo"       => 3105608,
                "ibge_estado_id" => 31,
                "nome"     => "Barbacena",
            ],
            [
                "ibge_codigo"       => 3105707,
                "ibge_estado_id" => 31,
                "nome"     => "Barra Longa",
            ],
            [
                "ibge_codigo"       => 3105905,
                "ibge_estado_id" => 31,
                "nome"     => "Barroso",
            ],
            [
                "ibge_codigo"       => 3106002,
                "ibge_estado_id" => 31,
                "nome"     => "Bela Vista de Minas",
            ],
            [
                "ibge_codigo"       => 3106101,
                "ibge_estado_id" => 31,
                "nome"     => "Belmiro Braga",
            ],
            [
                "ibge_codigo"       => 3106200,
                "ibge_estado_id" => 31,
                "nome"     => "Belo Horizonte",
            ],
            [
                "ibge_codigo"       => 3106309,
                "ibge_estado_id" => 31,
                "nome"     => "Belo Oriente",
            ],
            [
                "ibge_codigo"       => 3106408,
                "ibge_estado_id" => 31,
                "nome"     => "Belo Vale",
            ],
            [
                "ibge_codigo"       => 3106507,
                "ibge_estado_id" => 31,
                "nome"     => "Berilo",
            ],
            [
                "ibge_codigo"       => 3106606,
                "ibge_estado_id" => 31,
                "nome"     => "Bertópolis",
            ],
            [
                "ibge_codigo"       => 3106655,
                "ibge_estado_id" => 31,
                "nome"     => "Berizal",
            ],
            [
                "ibge_codigo"       => 3106705,
                "ibge_estado_id" => 31,
                "nome"     => "Betim",
            ],
            [
                "ibge_codigo"       => 3106804,
                "ibge_estado_id" => 31,
                "nome"     => "Bias Fortes",
            ],
            [
                "ibge_codigo"       => 3106903,
                "ibge_estado_id" => 31,
                "nome"     => "Bicas",
            ],
            [
                "ibge_codigo"       => 3107000,
                "ibge_estado_id" => 31,
                "nome"     => "Biquinhas",
            ],
            [
                "ibge_codigo"       => 3107109,
                "ibge_estado_id" => 31,
                "nome"     => "Boa Esperança",
            ],
            [
                "ibge_codigo"       => 3107208,
                "ibge_estado_id" => 31,
                "nome"     => "Bocaina de Minas",
            ],
            [
                "ibge_codigo"       => 3107307,
                "ibge_estado_id" => 31,
                "nome"     => "Bocaiúva",
            ],
            [
                "ibge_codigo"       => 3107406,
                "ibge_estado_id" => 31,
                "nome"     => "Bom Despacho",
            ],
            [
                "ibge_codigo"       => 3107505,
                "ibge_estado_id" => 31,
                "nome"     => "Bom Jardim de Minas",
            ],
            [
                "ibge_codigo"       => 3107604,
                "ibge_estado_id" => 31,
                "nome"     => "Bom Jesus da Penha",
            ],
            [
                "ibge_codigo"       => 3107703,
                "ibge_estado_id" => 31,
                "nome"     => "Bom Jesus do Amparo",
            ],
            [
                "ibge_codigo"       => 3107802,
                "ibge_estado_id" => 31,
                "nome"     => "Bom Jesus do Galho",
            ],
            [
                "ibge_codigo"       => 3107901,
                "ibge_estado_id" => 31,
                "nome"     => "Bom Repouso",
            ],
            [
                "ibge_codigo"       => 3108008,
                "ibge_estado_id" => 31,
                "nome"     => "Bom Sucesso",
            ],
            [
                "ibge_codigo"       => 3108107,
                "ibge_estado_id" => 31,
                "nome"     => "Bonfim",
            ],
            [
                "ibge_codigo"       => 3108206,
                "ibge_estado_id" => 31,
                "nome"     => "Bonfinópolis de Minas",
            ],
            [
                "ibge_codigo"       => 3108255,
                "ibge_estado_id" => 31,
                "nome"     => "Bonito de Minas",
            ],
            [
                "ibge_codigo"       => 3108305,
                "ibge_estado_id" => 31,
                "nome"     => "Borda da Mata",
            ],
            [
                "ibge_codigo"       => 3108404,
                "ibge_estado_id" => 31,
                "nome"     => "Botelhos",
            ],
            [
                "ibge_codigo"       => 3108503,
                "ibge_estado_id" => 31,
                "nome"     => "Botumirim",
            ],
            [
                "ibge_codigo"       => 3108552,
                "ibge_estado_id" => 31,
                "nome"     => "Brasilândia de Minas",
            ],
            [
                "ibge_codigo"       => 3108602,
                "ibge_estado_id" => 31,
                "nome"     => "Brasília de Minas",
            ],
            [
                "ibge_codigo"       => 3108701,
                "ibge_estado_id" => 31,
                "nome"     => "Brás Pires",
            ],
            [
                "ibge_codigo"       => 3108800,
                "ibge_estado_id" => 31,
                "nome"     => "Braúnas",
            ],
            [
                "ibge_codigo"       => 3108909,
                "ibge_estado_id" => 31,
                "nome"     => "Brazópolis",
            ],
            [
                "ibge_codigo"       => 3109006,
                "ibge_estado_id" => 31,
                "nome"     => "Brumadinho",
            ],
            [
                "ibge_codigo"       => 3109105,
                "ibge_estado_id" => 31,
                "nome"     => "Bueno Brandão",
            ],
            [
                "ibge_codigo"       => 3109204,
                "ibge_estado_id" => 31,
                "nome"     => "Buenópolis",
            ],
            [
                "ibge_codigo"       => 3109253,
                "ibge_estado_id" => 31,
                "nome"     => "Bugre",
            ],
            [
                "ibge_codigo"       => 3109303,
                "ibge_estado_id" => 31,
                "nome"     => "Buritis",
            ],
            [
                "ibge_codigo"       => 3109402,
                "ibge_estado_id" => 31,
                "nome"     => "Buritizeiro",
            ],
            [
                "ibge_codigo"       => 3109451,
                "ibge_estado_id" => 31,
                "nome"     => "Cabeceira Grande",
            ],
            [
                "ibge_codigo"       => 3109501,
                "ibge_estado_id" => 31,
                "nome"     => "Cabo Verde",
            ],
            [
                "ibge_codigo"       => 3109600,
                "ibge_estado_id" => 31,
                "nome"     => "Cachoeira da Prata",
            ],
            [
                "ibge_codigo"       => 3109709,
                "ibge_estado_id" => 31,
                "nome"     => "Cachoeira de Minas",
            ],
            [
                "ibge_codigo"       => 3109808,
                "ibge_estado_id" => 31,
                "nome"     => "Cachoeira Dourada",
            ],
            [
                "ibge_codigo"       => 3109907,
                "ibge_estado_id" => 31,
                "nome"     => "Caetanópolis",
            ],
            [
                "ibge_codigo"       => 3110004,
                "ibge_estado_id" => 31,
                "nome"     => "Caeté",
            ],
            [
                "ibge_codigo"       => 3110103,
                "ibge_estado_id" => 31,
                "nome"     => "Caiana",
            ],
            [
                "ibge_codigo"       => 3110202,
                "ibge_estado_id" => 31,
                "nome"     => "Cajuri",
            ],
            [
                "ibge_codigo"       => 3110301,
                "ibge_estado_id" => 31,
                "nome"     => "Caldas",
            ],
            [
                "ibge_codigo"       => 3110400,
                "ibge_estado_id" => 31,
                "nome"     => "Camacho",
            ],
            [
                "ibge_codigo"       => 3110509,
                "ibge_estado_id" => 31,
                "nome"     => "Camanducaia",
            ],
            [
                "ibge_codigo"       => 3110608,
                "ibge_estado_id" => 31,
                "nome"     => "Cambuí",
            ],
            [
                "ibge_codigo"       => 3110707,
                "ibge_estado_id" => 31,
                "nome"     => "Cambuquira",
            ],
            [
                "ibge_codigo"       => 3110806,
                "ibge_estado_id" => 31,
                "nome"     => "Campanário",
            ],
            [
                "ibge_codigo"       => 3110905,
                "ibge_estado_id" => 31,
                "nome"     => "Campanha",
            ],
            [
                "ibge_codigo"       => 3111002,
                "ibge_estado_id" => 31,
                "nome"     => "Campestre",
            ],
            [
                "ibge_codigo"       => 3111101,
                "ibge_estado_id" => 31,
                "nome"     => "Campina Verde",
            ],
            [
                "ibge_codigo"       => 3111150,
                "ibge_estado_id" => 31,
                "nome"     => "Campo Azul",
            ],
            [
                "ibge_codigo"       => 3111200,
                "ibge_estado_id" => 31,
                "nome"     => "Campo Belo",
            ],
            [
                "ibge_codigo"       => 3111309,
                "ibge_estado_id" => 31,
                "nome"     => "Campo do Meio",
            ],
            [
                "ibge_codigo"       => 3111408,
                "ibge_estado_id" => 31,
                "nome"     => "Campo Florido",
            ],
            [
                "ibge_codigo"       => 3111507,
                "ibge_estado_id" => 31,
                "nome"     => "Campos Altos",
            ],
            [
                "ibge_codigo"       => 3111606,
                "ibge_estado_id" => 31,
                "nome"     => "Campos Gerais",
            ],
            [
                "ibge_codigo"       => 3111705,
                "ibge_estado_id" => 31,
                "nome"     => "Canaã",
            ],
            [
                "ibge_codigo"       => 3111804,
                "ibge_estado_id" => 31,
                "nome"     => "Canápolis",
            ],
            [
                "ibge_codigo"       => 3111903,
                "ibge_estado_id" => 31,
                "nome"     => "Cana Verde",
            ],
            [
                "ibge_codigo"       => 3112000,
                "ibge_estado_id" => 31,
                "nome"     => "Candeias",
            ],
            [
                "ibge_codigo"       => 3112059,
                "ibge_estado_id" => 31,
                "nome"     => "Cantagalo",
            ],
            [
                "ibge_codigo"       => 3112109,
                "ibge_estado_id" => 31,
                "nome"     => "Caparaó",
            ],
            [
                "ibge_codigo"       => 3112208,
                "ibge_estado_id" => 31,
                "nome"     => "Capela Nova",
            ],
            [
                "ibge_codigo"       => 3112307,
                "ibge_estado_id" => 31,
                "nome"     => "Capelinha",
            ],
            [
                "ibge_codigo"       => 3112406,
                "ibge_estado_id" => 31,
                "nome"     => "Capetinga",
            ],
            [
                "ibge_codigo"       => 3112505,
                "ibge_estado_id" => 31,
                "nome"     => "Capim Branco",
            ],
            [
                "ibge_codigo"       => 3112604,
                "ibge_estado_id" => 31,
                "nome"     => "Capinópolis",
            ],
            [
                "ibge_codigo"       => 3112653,
                "ibge_estado_id" => 31,
                "nome"     => "Capitão Andrade",
            ],
            [
                "ibge_codigo"       => 3112703,
                "ibge_estado_id" => 31,
                "nome"     => "Capitão Enéas",
            ],
            [
                "ibge_codigo"       => 3112802,
                "ibge_estado_id" => 31,
                "nome"     => "Capitólio",
            ],
            [
                "ibge_codigo"       => 3112901,
                "ibge_estado_id" => 31,
                "nome"     => "Caputira",
            ],
            [
                "ibge_codigo"       => 3113008,
                "ibge_estado_id" => 31,
                "nome"     => "Caraí",
            ],
            [
                "ibge_codigo"       => 3113107,
                "ibge_estado_id" => 31,
                "nome"     => "Caranaíba",
            ],
            [
                "ibge_codigo"       => 3113206,
                "ibge_estado_id" => 31,
                "nome"     => "Carandaí",
            ],
            [
                "ibge_codigo"       => 3113305,
                "ibge_estado_id" => 31,
                "nome"     => "Carangola",
            ],
            [
                "ibge_codigo"       => 3113404,
                "ibge_estado_id" => 31,
                "nome"     => "Caratinga",
            ],
            [
                "ibge_codigo"       => 3113503,
                "ibge_estado_id" => 31,
                "nome"     => "Carbonita",
            ],
            [
                "ibge_codigo"       => 3113602,
                "ibge_estado_id" => 31,
                "nome"     => "Careaçu",
            ],
            [
                "ibge_codigo"       => 3113701,
                "ibge_estado_id" => 31,
                "nome"     => "Carlos Chagas",
            ],
            [
                "ibge_codigo"       => 3113800,
                "ibge_estado_id" => 31,
                "nome"     => "Carmésia",
            ],
            [
                "ibge_codigo"       => 3113909,
                "ibge_estado_id" => 31,
                "nome"     => "Carmo da Cachoeira",
            ],
            [
                "ibge_codigo"       => 3114006,
                "ibge_estado_id" => 31,
                "nome"     => "Carmo da Mata",
            ],
            [
                "ibge_codigo"       => 3114105,
                "ibge_estado_id" => 31,
                "nome"     => "Carmo de Minas",
            ],
            [
                "ibge_codigo"       => 3114204,
                "ibge_estado_id" => 31,
                "nome"     => "Carmo do Cajuru",
            ],
            [
                "ibge_codigo"       => 3114303,
                "ibge_estado_id" => 31,
                "nome"     => "Carmo do Paranaíba",
            ],
            [
                "ibge_codigo"       => 3114402,
                "ibge_estado_id" => 31,
                "nome"     => "Carmo do Rio Claro",
            ],
            [
                "ibge_codigo"       => 3114501,
                "ibge_estado_id" => 31,
                "nome"     => "Carmópolis de Minas",
            ],
            [
                "ibge_codigo"       => 3114550,
                "ibge_estado_id" => 31,
                "nome"     => "Carneirinho",
            ],
            [
                "ibge_codigo"       => 3114600,
                "ibge_estado_id" => 31,
                "nome"     => "Carrancas",
            ],
            [
                "ibge_codigo"       => 3114709,
                "ibge_estado_id" => 31,
                "nome"     => "Carvalhópolis",
            ],
            [
                "ibge_codigo"       => 3114808,
                "ibge_estado_id" => 31,
                "nome"     => "Carvalhos",
            ],
            [
                "ibge_codigo"       => 3114907,
                "ibge_estado_id" => 31,
                "nome"     => "Casa Grande",
            ],
            [
                "ibge_codigo"       => 3115003,
                "ibge_estado_id" => 31,
                "nome"     => "Cascalho Rico",
            ],
            [
                "ibge_codigo"       => 3115102,
                "ibge_estado_id" => 31,
                "nome"     => "Cássia",
            ],
            [
                "ibge_codigo"       => 3115201,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição da Barra de Minas",
            ],
            [
                "ibge_codigo"       => 3115300,
                "ibge_estado_id" => 31,
                "nome"     => "Cataguases",
            ],
            [
                "ibge_codigo"       => 3115359,
                "ibge_estado_id" => 31,
                "nome"     => "Catas Altas",
            ],
            [
                "ibge_codigo"       => 3115409,
                "ibge_estado_id" => 31,
                "nome"     => "Catas Altas da Noruega",
            ],
            [
                "ibge_codigo"       => 3115458,
                "ibge_estado_id" => 31,
                "nome"     => "Catuji",
            ],
            [
                "ibge_codigo"       => 3115474,
                "ibge_estado_id" => 31,
                "nome"     => "Catuti",
            ],
            [
                "ibge_codigo"       => 3115508,
                "ibge_estado_id" => 31,
                "nome"     => "Caxambu",
            ],
            [
                "ibge_codigo"       => 3115607,
                "ibge_estado_id" => 31,
                "nome"     => "Cedro do Abaeté",
            ],
            [
                "ibge_codigo"       => 3115706,
                "ibge_estado_id" => 31,
                "nome"     => "Central de Minas",
            ],
            [
                "ibge_codigo"       => 3115805,
                "ibge_estado_id" => 31,
                "nome"     => "Centralina",
            ],
            [
                "ibge_codigo"       => 3115904,
                "ibge_estado_id" => 31,
                "nome"     => "Chácara",
            ],
            [
                "ibge_codigo"       => 3116001,
                "ibge_estado_id" => 31,
                "nome"     => "Chalé",
            ],
            [
                "ibge_codigo"       => 3116100,
                "ibge_estado_id" => 31,
                "nome"     => "Chapada do Norte",
            ],
            [
                "ibge_codigo"       => 3116159,
                "ibge_estado_id" => 31,
                "nome"     => "Chapada Gaúcha",
            ],
            [
                "ibge_codigo"       => 3116209,
                "ibge_estado_id" => 31,
                "nome"     => "Chiador",
            ],
            [
                "ibge_codigo"       => 3116308,
                "ibge_estado_id" => 31,
                "nome"     => "Cipotânea",
            ],
            [
                "ibge_codigo"       => 3116407,
                "ibge_estado_id" => 31,
                "nome"     => "Claraval",
            ],
            [
                "ibge_codigo"       => 3116506,
                "ibge_estado_id" => 31,
                "nome"     => "Claro dos Poções",
            ],
            [
                "ibge_codigo"       => 3116605,
                "ibge_estado_id" => 31,
                "nome"     => "Cláudio",
            ],
            [
                "ibge_codigo"       => 3116704,
                "ibge_estado_id" => 31,
                "nome"     => "Coimbra",
            ],
            [
                "ibge_codigo"       => 3116803,
                "ibge_estado_id" => 31,
                "nome"     => "Coluna",
            ],
            [
                "ibge_codigo"       => 3116902,
                "ibge_estado_id" => 31,
                "nome"     => "Comendador Gomes",
            ],
            [
                "ibge_codigo"       => 3117009,
                "ibge_estado_id" => 31,
                "nome"     => "Comercinho",
            ],
            [
                "ibge_codigo"       => 3117108,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição da Aparecida",
            ],
            [
                "ibge_codigo"       => 3117207,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição das Pedras",
            ],
            [
                "ibge_codigo"       => 3117306,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição das Alagoas",
            ],
            [
                "ibge_codigo"       => 3117405,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição de Ipanema",
            ],
            [
                "ibge_codigo"       => 3117504,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição do Mato Dentro",
            ],
            [
                "ibge_codigo"       => 3117603,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição do Pará",
            ],
            [
                "ibge_codigo"       => 3117702,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição do Rio Verde",
            ],
            [
                "ibge_codigo"       => 3117801,
                "ibge_estado_id" => 31,
                "nome"     => "Conceição dos Ouros",
            ],
            [
                "ibge_codigo"       => 3117836,
                "ibge_estado_id" => 31,
                "nome"     => "Cônego Marinho",
            ],
            [
                "ibge_codigo"       => 3117876,
                "ibge_estado_id" => 31,
                "nome"     => "Confins",
            ],
            [
                "ibge_codigo"       => 3117900,
                "ibge_estado_id" => 31,
                "nome"     => "Congonhal",
            ],
            [
                "ibge_codigo"       => 3118007,
                "ibge_estado_id" => 31,
                "nome"     => "Congonhas",
            ],
            [
                "ibge_codigo"       => 3118106,
                "ibge_estado_id" => 31,
                "nome"     => "Congonhas do Norte",
            ],
            [
                "ibge_codigo"       => 3118205,
                "ibge_estado_id" => 31,
                "nome"     => "Conquista",
            ],
            [
                "ibge_codigo"       => 3118304,
                "ibge_estado_id" => 31,
                "nome"     => "Conselheiro Lafaiete",
            ],
            [
                "ibge_codigo"       => 3118403,
                "ibge_estado_id" => 31,
                "nome"     => "Conselheiro Pena",
            ],
            [
                "ibge_codigo"       => 3118502,
                "ibge_estado_id" => 31,
                "nome"     => "Consolação",
            ],
            [
                "ibge_codigo"       => 3118601,
                "ibge_estado_id" => 31,
                "nome"     => "Contagem",
            ],
            [
                "ibge_codigo"       => 3118700,
                "ibge_estado_id" => 31,
                "nome"     => "Coqueiral",
            ],
            [
                "ibge_codigo"       => 3118809,
                "ibge_estado_id" => 31,
                "nome"     => "Coração de Jesus",
            ],
            [
                "ibge_codigo"       => 3118908,
                "ibge_estado_id" => 31,
                "nome"     => "Cordisburgo",
            ],
            [
                "ibge_codigo"       => 3119005,
                "ibge_estado_id" => 31,
                "nome"     => "Cordislândia",
            ],
            [
                "ibge_codigo"       => 3119104,
                "ibge_estado_id" => 31,
                "nome"     => "Corinto",
            ],
            [
                "ibge_codigo"       => 3119203,
                "ibge_estado_id" => 31,
                "nome"     => "Coroaci",
            ],
            [
                "ibge_codigo"       => 3119302,
                "ibge_estado_id" => 31,
                "nome"     => "Coromandel",
            ],
            [
                "ibge_codigo"       => 3119401,
                "ibge_estado_id" => 31,
                "nome"     => "Coronel Fabriciano",
            ],
            [
                "ibge_codigo"       => 3119500,
                "ibge_estado_id" => 31,
                "nome"     => "Coronel Murta",
            ],
            [
                "ibge_codigo"       => 3119609,
                "ibge_estado_id" => 31,
                "nome"     => "Coronel Pacheco",
            ],
            [
                "ibge_codigo"       => 3119708,
                "ibge_estado_id" => 31,
                "nome"     => "Coronel Xavier Chaves",
            ],
            [
                "ibge_codigo"       => 3119807,
                "ibge_estado_id" => 31,
                "nome"     => "Córrego Danta",
            ],
            [
                "ibge_codigo"       => 3119906,
                "ibge_estado_id" => 31,
                "nome"     => "Córrego do Bom Jesus",
            ],
            [
                "ibge_codigo"       => 3119955,
                "ibge_estado_id" => 31,
                "nome"     => "Córrego Fundo",
            ],
            [
                "ibge_codigo"       => 3120003,
                "ibge_estado_id" => 31,
                "nome"     => "Córrego Novo",
            ],
            [
                "ibge_codigo"       => 3120102,
                "ibge_estado_id" => 31,
                "nome"     => "Couto de Magalhães de Minas",
            ],
            [
                "ibge_codigo"       => 3120151,
                "ibge_estado_id" => 31,
                "nome"     => "Crisólita",
            ],
            [
                "ibge_codigo"       => 3120201,
                "ibge_estado_id" => 31,
                "nome"     => "Cristais",
            ],
            [
                "ibge_codigo"       => 3120300,
                "ibge_estado_id" => 31,
                "nome"     => "Cristália",
            ],
            [
                "ibge_codigo"       => 3120409,
                "ibge_estado_id" => 31,
                "nome"     => "Cristiano Otoni",
            ],
            [
                "ibge_codigo"       => 3120508,
                "ibge_estado_id" => 31,
                "nome"     => "Cristina",
            ],
            [
                "ibge_codigo"       => 3120607,
                "ibge_estado_id" => 31,
                "nome"     => "Crucilândia",
            ],
            [
                "ibge_codigo"       => 3120706,
                "ibge_estado_id" => 31,
                "nome"     => "Cruzeiro da Fortaleza",
            ],
            [
                "ibge_codigo"       => 3120805,
                "ibge_estado_id" => 31,
                "nome"     => "Cruzília",
            ],
            [
                "ibge_codigo"       => 3120839,
                "ibge_estado_id" => 31,
                "nome"     => "Cuparaque",
            ],
            [
                "ibge_codigo"       => 3120870,
                "ibge_estado_id" => 31,
                "nome"     => "Curral de Dentro",
            ],
            [
                "ibge_codigo"       => 3120904,
                "ibge_estado_id" => 31,
                "nome"     => "Curvelo",
            ],
            [
                "ibge_codigo"       => 3121001,
                "ibge_estado_id" => 31,
                "nome"     => "Datas",
            ],
            [
                "ibge_codigo"       => 3121100,
                "ibge_estado_id" => 31,
                "nome"     => "Delfim Moreira",
            ],
            [
                "ibge_codigo"       => 3121209,
                "ibge_estado_id" => 31,
                "nome"     => "Delfinópolis",
            ],
            [
                "ibge_codigo"       => 3121258,
                "ibge_estado_id" => 31,
                "nome"     => "Delta",
            ],
            [
                "ibge_codigo"       => 3121308,
                "ibge_estado_id" => 31,
                "nome"     => "Descoberto",
            ],
            [
                "ibge_codigo"       => 3121407,
                "ibge_estado_id" => 31,
                "nome"     => "Desterro de Entre Rios",
            ],
            [
                "ibge_codigo"       => 3121506,
                "ibge_estado_id" => 31,
                "nome"     => "Desterro do Melo",
            ],
            [
                "ibge_codigo"       => 3121605,
                "ibge_estado_id" => 31,
                "nome"     => "Diamantina",
            ],
            [
                "ibge_codigo"       => 3121704,
                "ibge_estado_id" => 31,
                "nome"     => "Diogo de Vasconcelos",
            ],
            [
                "ibge_codigo"       => 3121803,
                "ibge_estado_id" => 31,
                "nome"     => "Dionísio",
            ],
            [
                "ibge_codigo"       => 3121902,
                "ibge_estado_id" => 31,
                "nome"     => "Divinésia",
            ],
            [
                "ibge_codigo"       => 3122009,
                "ibge_estado_id" => 31,
                "nome"     => "Divino",
            ],
            [
                "ibge_codigo"       => 3122108,
                "ibge_estado_id" => 31,
                "nome"     => "Divino das Laranjeiras",
            ],
            [
                "ibge_codigo"       => 3122207,
                "ibge_estado_id" => 31,
                "nome"     => "Divinolândia de Minas",
            ],
            [
                "ibge_codigo"       => 3122306,
                "ibge_estado_id" => 31,
                "nome"     => "Divinópolis",
            ],
            [
                "ibge_codigo"       => 3122355,
                "ibge_estado_id" => 31,
                "nome"     => "Divisa Alegre",
            ],
            [
                "ibge_codigo"       => 3122405,
                "ibge_estado_id" => 31,
                "nome"     => "Divisa Nova",
            ],
            [
                "ibge_codigo"       => 3122454,
                "ibge_estado_id" => 31,
                "nome"     => "Divisópolis",
            ],
            [
                "ibge_codigo"       => 3122470,
                "ibge_estado_id" => 31,
                "nome"     => "Dom Bosco",
            ],
            [
                "ibge_codigo"       => 3122504,
                "ibge_estado_id" => 31,
                "nome"     => "Dom Cavati",
            ],
            [
                "ibge_codigo"       => 3122603,
                "ibge_estado_id" => 31,
                "nome"     => "Dom Joaquim",
            ],
            [
                "ibge_codigo"       => 3122702,
                "ibge_estado_id" => 31,
                "nome"     => "Dom Silvério",
            ],
            [
                "ibge_codigo"       => 3122801,
                "ibge_estado_id" => 31,
                "nome"     => "Dom Viçoso",
            ],
            [
                "ibge_codigo"       => 3122900,
                "ibge_estado_id" => 31,
                "nome"     => "Dona Eusébia",
            ],
            [
                "ibge_codigo"       => 3123007,
                "ibge_estado_id" => 31,
                "nome"     => "Dores de Campos",
            ],
            [
                "ibge_codigo"       => 3123106,
                "ibge_estado_id" => 31,
                "nome"     => "Dores de Guanhães",
            ],
            [
                "ibge_codigo"       => 3123205,
                "ibge_estado_id" => 31,
                "nome"     => "Dores do Indaiá",
            ],
            [
                "ibge_codigo"       => 3123304,
                "ibge_estado_id" => 31,
                "nome"     => "Dores do Turvo",
            ],
            [
                "ibge_codigo"       => 3123403,
                "ibge_estado_id" => 31,
                "nome"     => "Doresópolis",
            ],
            [
                "ibge_codigo"       => 3123502,
                "ibge_estado_id" => 31,
                "nome"     => "Douradoquara",
            ],
            [
                "ibge_codigo"       => 3123528,
                "ibge_estado_id" => 31,
                "nome"     => "Durandé",
            ],
            [
                "ibge_codigo"       => 3123601,
                "ibge_estado_id" => 31,
                "nome"     => "Elói Mendes",
            ],
            [
                "ibge_codigo"       => 3123700,
                "ibge_estado_id" => 31,
                "nome"     => "Engenheiro Caldas",
            ],
            [
                "ibge_codigo"       => 3123809,
                "ibge_estado_id" => 31,
                "nome"     => "Engenheiro Navarro",
            ],
            [
                "ibge_codigo"       => 3123858,
                "ibge_estado_id" => 31,
                "nome"     => "Entre Folhas",
            ],
            [
                "ibge_codigo"       => 3123908,
                "ibge_estado_id" => 31,
                "nome"     => "Entre Rios de Minas",
            ],
            [
                "ibge_codigo"       => 3124005,
                "ibge_estado_id" => 31,
                "nome"     => "Ervália",
            ],
            [
                "ibge_codigo"       => 3124104,
                "ibge_estado_id" => 31,
                "nome"     => "Esmeraldas",
            ],
            [
                "ibge_codigo"       => 3124203,
                "ibge_estado_id" => 31,
                "nome"     => "Espera Feliz",
            ],
            [
                "ibge_codigo"       => 3124302,
                "ibge_estado_id" => 31,
                "nome"     => "Espinosa",
            ],
            [
                "ibge_codigo"       => 3124401,
                "ibge_estado_id" => 31,
                "nome"     => "Espírito Santo do Dourado",
            ],
            [
                "ibge_codigo"       => 3124500,
                "ibge_estado_id" => 31,
                "nome"     => "Estiva",
            ],
            [
                "ibge_codigo"       => 3124609,
                "ibge_estado_id" => 31,
                "nome"     => "Estrela Dalva",
            ],
            [
                "ibge_codigo"       => 3124708,
                "ibge_estado_id" => 31,
                "nome"     => "Estrela do Indaiá",
            ],
            [
                "ibge_codigo"       => 3124807,
                "ibge_estado_id" => 31,
                "nome"     => "Estrela do Sul",
            ],
            [
                "ibge_codigo"       => 3124906,
                "ibge_estado_id" => 31,
                "nome"     => "Eugenópolis",
            ],
            [
                "ibge_codigo"       => 3125002,
                "ibge_estado_id" => 31,
                "nome"     => "Ewbank da Câmara",
            ],
            [
                "ibge_codigo"       => 3125101,
                "ibge_estado_id" => 31,
                "nome"     => "Extrema",
            ],
            [
                "ibge_codigo"       => 3125200,
                "ibge_estado_id" => 31,
                "nome"     => "Fama",
            ],
            [
                "ibge_codigo"       => 3125309,
                "ibge_estado_id" => 31,
                "nome"     => "Faria Lemos",
            ],
            [
                "ibge_codigo"       => 3125408,
                "ibge_estado_id" => 31,
                "nome"     => "Felício dos Santos",
            ],
            [
                "ibge_codigo"       => 3125507,
                "ibge_estado_id" => 31,
                "nome"     => "São Gonçalo do Rio Preto",
            ],
            [
                "ibge_codigo"       => 3125606,
                "ibge_estado_id" => 31,
                "nome"     => "Felisburgo",
            ],
            [
                "ibge_codigo"       => 3125705,
                "ibge_estado_id" => 31,
                "nome"     => "Felixlândia",
            ],
            [
                "ibge_codigo"       => 3125804,
                "ibge_estado_id" => 31,
                "nome"     => "Fernandes Tourinho",
            ],
            [
                "ibge_codigo"       => 3125903,
                "ibge_estado_id" => 31,
                "nome"     => "Ferros",
            ],
            [
                "ibge_codigo"       => 3125952,
                "ibge_estado_id" => 31,
                "nome"     => "Fervedouro",
            ],
            [
                "ibge_codigo"       => 3126000,
                "ibge_estado_id" => 31,
                "nome"     => "Florestal",
            ],
            [
                "ibge_codigo"       => 3126109,
                "ibge_estado_id" => 31,
                "nome"     => "Formiga",
            ],
            [
                "ibge_codigo"       => 3126208,
                "ibge_estado_id" => 31,
                "nome"     => "Formoso",
            ],
            [
                "ibge_codigo"       => 3126307,
                "ibge_estado_id" => 31,
                "nome"     => "Fortaleza de Minas",
            ],
            [
                "ibge_codigo"       => 3126406,
                "ibge_estado_id" => 31,
                "nome"     => "Fortuna de Minas",
            ],
            [
                "ibge_codigo"       => 3126505,
                "ibge_estado_id" => 31,
                "nome"     => "Francisco Badaró",
            ],
            [
                "ibge_codigo"       => 3126604,
                "ibge_estado_id" => 31,
                "nome"     => "Francisco Dumont",
            ],
            [
                "ibge_codigo"       => 3126703,
                "ibge_estado_id" => 31,
                "nome"     => "Francisco Sá",
            ],
            [
                "ibge_codigo"       => 3126752,
                "ibge_estado_id" => 31,
                "nome"     => "Franciscópolis",
            ],
            [
                "ibge_codigo"       => 3126802,
                "ibge_estado_id" => 31,
                "nome"     => "Frei Gaspar",
            ],
            [
                "ibge_codigo"       => 3126901,
                "ibge_estado_id" => 31,
                "nome"     => "Frei Inocêncio",
            ],
            [
                "ibge_codigo"       => 3126950,
                "ibge_estado_id" => 31,
                "nome"     => "Frei Lagonegro",
            ],
            [
                "ibge_codigo"       => 3127008,
                "ibge_estado_id" => 31,
                "nome"     => "Fronteira",
            ],
            [
                "ibge_codigo"       => 3127057,
                "ibge_estado_id" => 31,
                "nome"     => "Fronteira dos Vales",
            ],
            [
                "ibge_codigo"       => 3127073,
                "ibge_estado_id" => 31,
                "nome"     => "Fruta de Leite",
            ],
            [
                "ibge_codigo"       => 3127107,
                "ibge_estado_id" => 31,
                "nome"     => "Frutal",
            ],
            [
                "ibge_codigo"       => 3127206,
                "ibge_estado_id" => 31,
                "nome"     => "Funilândia",
            ],
            [
                "ibge_codigo"       => 3127305,
                "ibge_estado_id" => 31,
                "nome"     => "Galiléia",
            ],
            [
                "ibge_codigo"       => 3127339,
                "ibge_estado_id" => 31,
                "nome"     => "Gameleiras",
            ],
            [
                "ibge_codigo"       => 3127354,
                "ibge_estado_id" => 31,
                "nome"     => "Glaucilândia",
            ],
            [
                "ibge_codigo"       => 3127370,
                "ibge_estado_id" => 31,
                "nome"     => "Goiabeira",
            ],
            [
                "ibge_codigo"       => 3127388,
                "ibge_estado_id" => 31,
                "nome"     => "Goianá",
            ],
            [
                "ibge_codigo"       => 3127404,
                "ibge_estado_id" => 31,
                "nome"     => "Gonçalves",
            ],
            [
                "ibge_codigo"       => 3127503,
                "ibge_estado_id" => 31,
                "nome"     => "Gonzaga",
            ],
            [
                "ibge_codigo"       => 3127602,
                "ibge_estado_id" => 31,
                "nome"     => "Gouveia",
            ],
            [
                "ibge_codigo"       => 3127701,
                "ibge_estado_id" => 31,
                "nome"     => "Governador Valadares",
            ],
            [
                "ibge_codigo"       => 3127800,
                "ibge_estado_id" => 31,
                "nome"     => "Grão Mogol",
            ],
            [
                "ibge_codigo"       => 3127909,
                "ibge_estado_id" => 31,
                "nome"     => "Grupiara",
            ],
            [
                "ibge_codigo"       => 3128006,
                "ibge_estado_id" => 31,
                "nome"     => "Guanhães",
            ],
            [
                "ibge_codigo"       => 3128105,
                "ibge_estado_id" => 31,
                "nome"     => "Guapé",
            ],
            [
                "ibge_codigo"       => 3128204,
                "ibge_estado_id" => 31,
                "nome"     => "Guaraciaba",
            ],
            [
                "ibge_codigo"       => 3128253,
                "ibge_estado_id" => 31,
                "nome"     => "Guaraciama",
            ],
            [
                "ibge_codigo"       => 3128303,
                "ibge_estado_id" => 31,
                "nome"     => "Guaranésia",
            ],
            [
                "ibge_codigo"       => 3128402,
                "ibge_estado_id" => 31,
                "nome"     => "Guarani",
            ],
            [
                "ibge_codigo"       => 3128501,
                "ibge_estado_id" => 31,
                "nome"     => "Guarará",
            ],
            [
                "ibge_codigo"       => 3128600,
                "ibge_estado_id" => 31,
                "nome"     => "Guarda-Mor",
            ],
            [
                "ibge_codigo"       => 3128709,
                "ibge_estado_id" => 31,
                "nome"     => "Guaxupé",
            ],
            [
                "ibge_codigo"       => 3128808,
                "ibge_estado_id" => 31,
                "nome"     => "Guidoval",
            ],
            [
                "ibge_codigo"       => 3128907,
                "ibge_estado_id" => 31,
                "nome"     => "Guimarânia",
            ],
            [
                "ibge_codigo"       => 3129004,
                "ibge_estado_id" => 31,
                "nome"     => "Guiricema",
            ],
            [
                "ibge_codigo"       => 3129103,
                "ibge_estado_id" => 31,
                "nome"     => "Gurinhatã",
            ],
            [
                "ibge_codigo"       => 3129202,
                "ibge_estado_id" => 31,
                "nome"     => "Heliodora",
            ],
            [
                "ibge_codigo"       => 3129301,
                "ibge_estado_id" => 31,
                "nome"     => "Iapu",
            ],
            [
                "ibge_codigo"       => 3129400,
                "ibge_estado_id" => 31,
                "nome"     => "Ibertioga",
            ],
            [
                "ibge_codigo"       => 3129509,
                "ibge_estado_id" => 31,
                "nome"     => "Ibiá",
            ],
            [
                "ibge_codigo"       => 3129608,
                "ibge_estado_id" => 31,
                "nome"     => "Ibiaí",
            ],
            [
                "ibge_codigo"       => 3129657,
                "ibge_estado_id" => 31,
                "nome"     => "Ibiracatu",
            ],
            [
                "ibge_codigo"       => 3129707,
                "ibge_estado_id" => 31,
                "nome"     => "Ibiraci",
            ],
            [
                "ibge_codigo"       => 3129806,
                "ibge_estado_id" => 31,
                "nome"     => "Ibirité",
            ],
            [
                "ibge_codigo"       => 3129905,
                "ibge_estado_id" => 31,
                "nome"     => "Ibitiúra de Minas",
            ],
            [
                "ibge_codigo"       => 3130002,
                "ibge_estado_id" => 31,
                "nome"     => "Ibituruna",
            ],
            [
                "ibge_codigo"       => 3130051,
                "ibge_estado_id" => 31,
                "nome"     => "Icaraí de Minas",
            ],
            [
                "ibge_codigo"       => 3130101,
                "ibge_estado_id" => 31,
                "nome"     => "Igarapé",
            ],
            [
                "ibge_codigo"       => 3130200,
                "ibge_estado_id" => 31,
                "nome"     => "Igaratinga",
            ],
            [
                "ibge_codigo"       => 3130309,
                "ibge_estado_id" => 31,
                "nome"     => "Iguatama",
            ],
            [
                "ibge_codigo"       => 3130408,
                "ibge_estado_id" => 31,
                "nome"     => "Ijaci",
            ],
            [
                "ibge_codigo"       => 3130507,
                "ibge_estado_id" => 31,
                "nome"     => "Ilicínea",
            ],
            [
                "ibge_codigo"       => 3130556,
                "ibge_estado_id" => 31,
                "nome"     => "Imbé de Minas",
            ],
            [
                "ibge_codigo"       => 3130606,
                "ibge_estado_id" => 31,
                "nome"     => "Inconfidentes",
            ],
            [
                "ibge_codigo"       => 3130655,
                "ibge_estado_id" => 31,
                "nome"     => "Indaiabira",
            ],
            [
                "ibge_codigo"       => 3130705,
                "ibge_estado_id" => 31,
                "nome"     => "Indianópolis",
            ],
            [
                "ibge_codigo"       => 3130804,
                "ibge_estado_id" => 31,
                "nome"     => "Ingaí",
            ],
            [
                "ibge_codigo"       => 3130903,
                "ibge_estado_id" => 31,
                "nome"     => "Inhapim",
            ],
            [
                "ibge_codigo"       => 3131000,
                "ibge_estado_id" => 31,
                "nome"     => "Inhaúma",
            ],
            [
                "ibge_codigo"       => 3131109,
                "ibge_estado_id" => 31,
                "nome"     => "Inimutaba",
            ],
            [
                "ibge_codigo"       => 3131158,
                "ibge_estado_id" => 31,
                "nome"     => "Ipaba",
            ],
            [
                "ibge_codigo"       => 3131208,
                "ibge_estado_id" => 31,
                "nome"     => "Ipanema",
            ],
            [
                "ibge_codigo"       => 3131307,
                "ibge_estado_id" => 31,
                "nome"     => "Ipatinga",
            ],
            [
                "ibge_codigo"       => 3131406,
                "ibge_estado_id" => 31,
                "nome"     => "Ipiaçu",
            ],
            [
                "ibge_codigo"       => 3131505,
                "ibge_estado_id" => 31,
                "nome"     => "Ipuiúna",
            ],
            [
                "ibge_codigo"       => 3131604,
                "ibge_estado_id" => 31,
                "nome"     => "Iraí de Minas",
            ],
            [
                "ibge_codigo"       => 3131703,
                "ibge_estado_id" => 31,
                "nome"     => "Itabira",
            ],
            [
                "ibge_codigo"       => 3131802,
                "ibge_estado_id" => 31,
                "nome"     => "Itabirinha",
            ],
            [
                "ibge_codigo"       => 3131901,
                "ibge_estado_id" => 31,
                "nome"     => "Itabirito",
            ],
            [
                "ibge_codigo"       => 3132008,
                "ibge_estado_id" => 31,
                "nome"     => "Itacambira",
            ],
            [
                "ibge_codigo"       => 3132107,
                "ibge_estado_id" => 31,
                "nome"     => "Itacarambi",
            ],
            [
                "ibge_codigo"       => 3132206,
                "ibge_estado_id" => 31,
                "nome"     => "Itaguara",
            ],
            [
                "ibge_codigo"       => 3132305,
                "ibge_estado_id" => 31,
                "nome"     => "Itaipé",
            ],
            [
                "ibge_codigo"       => 3132404,
                "ibge_estado_id" => 31,
                "nome"     => "Itajubá",
            ],
            [
                "ibge_codigo"       => 3132503,
                "ibge_estado_id" => 31,
                "nome"     => "Itamarandiba",
            ],
            [
                "ibge_codigo"       => 3132602,
                "ibge_estado_id" => 31,
                "nome"     => "Itamarati de Minas",
            ],
            [
                "ibge_codigo"       => 3132701,
                "ibge_estado_id" => 31,
                "nome"     => "Itambacuri",
            ],
            [
                "ibge_codigo"       => 3132800,
                "ibge_estado_id" => 31,
                "nome"     => "Itambé do Mato Dentro",
            ],
            [
                "ibge_codigo"       => 3132909,
                "ibge_estado_id" => 31,
                "nome"     => "Itamogi",
            ],
            [
                "ibge_codigo"       => 3133006,
                "ibge_estado_id" => 31,
                "nome"     => "Itamonte",
            ],
            [
                "ibge_codigo"       => 3133105,
                "ibge_estado_id" => 31,
                "nome"     => "Itanhandu",
            ],
            [
                "ibge_codigo"       => 3133204,
                "ibge_estado_id" => 31,
                "nome"     => "Itanhomi",
            ],
            [
                "ibge_codigo"       => 3133303,
                "ibge_estado_id" => 31,
                "nome"     => "Itaobim",
            ],
            [
                "ibge_codigo"       => 3133402,
                "ibge_estado_id" => 31,
                "nome"     => "Itapagipe",
            ],
            [
                "ibge_codigo"       => 3133501,
                "ibge_estado_id" => 31,
                "nome"     => "Itapecerica",
            ],
            [
                "ibge_codigo"       => 3133600,
                "ibge_estado_id" => 31,
                "nome"     => "Itapeva",
            ],
            [
                "ibge_codigo"       => 3133709,
                "ibge_estado_id" => 31,
                "nome"     => "Itatiaiuçu",
            ],
            [
                "ibge_codigo"       => 3133758,
                "ibge_estado_id" => 31,
                "nome"     => "Itaú de Minas",
            ],
            [
                "ibge_codigo"       => 3133808,
                "ibge_estado_id" => 31,
                "nome"     => "Itaúna",
            ],
            [
                "ibge_codigo"       => 3133907,
                "ibge_estado_id" => 31,
                "nome"     => "Itaverava",
            ],
            [
                "ibge_codigo"       => 3134004,
                "ibge_estado_id" => 31,
                "nome"     => "Itinga",
            ],
            [
                "ibge_codigo"       => 3134103,
                "ibge_estado_id" => 31,
                "nome"     => "Itueta",
            ],
            [
                "ibge_codigo"       => 3134202,
                "ibge_estado_id" => 31,
                "nome"     => "Ituiutaba",
            ],
            [
                "ibge_codigo"       => 3134301,
                "ibge_estado_id" => 31,
                "nome"     => "Itumirim",
            ],
            [
                "ibge_codigo"       => 3134400,
                "ibge_estado_id" => 31,
                "nome"     => "Iturama",
            ],
            [
                "ibge_codigo"       => 3134509,
                "ibge_estado_id" => 31,
                "nome"     => "Itutinga",
            ],
            [
                "ibge_codigo"       => 3134608,
                "ibge_estado_id" => 31,
                "nome"     => "Jaboticatubas",
            ],
            [
                "ibge_codigo"       => 3134707,
                "ibge_estado_id" => 31,
                "nome"     => "Jacinto",
            ],
            [
                "ibge_codigo"       => 3134806,
                "ibge_estado_id" => 31,
                "nome"     => "Jacuí",
            ],
            [
                "ibge_codigo"       => 3134905,
                "ibge_estado_id" => 31,
                "nome"     => "Jacutinga",
            ],
            [
                "ibge_codigo"       => 3135001,
                "ibge_estado_id" => 31,
                "nome"     => "Jaguaraçu",
            ],
            [
                "ibge_codigo"       => 3135050,
                "ibge_estado_id" => 31,
                "nome"     => "Jaíba",
            ],
            [
                "ibge_codigo"       => 3135076,
                "ibge_estado_id" => 31,
                "nome"     => "Jampruca",
            ],
            [
                "ibge_codigo"       => 3135100,
                "ibge_estado_id" => 31,
                "nome"     => "Janaúba",
            ],
            [
                "ibge_codigo"       => 3135209,
                "ibge_estado_id" => 31,
                "nome"     => "Januária",
            ],
            [
                "ibge_codigo"       => 3135308,
                "ibge_estado_id" => 31,
                "nome"     => "Japaraíba",
            ],
            [
                "ibge_codigo"       => 3135357,
                "ibge_estado_id" => 31,
                "nome"     => "Japonvar",
            ],
            [
                "ibge_codigo"       => 3135407,
                "ibge_estado_id" => 31,
                "nome"     => "Jeceaba",
            ],
            [
                "ibge_codigo"       => 3135456,
                "ibge_estado_id" => 31,
                "nome"     => "Jenipapo de Minas",
            ],
            [
                "ibge_codigo"       => 3135506,
                "ibge_estado_id" => 31,
                "nome"     => "Jequeri",
            ],
            [
                "ibge_codigo"       => 3135605,
                "ibge_estado_id" => 31,
                "nome"     => "Jequitaí",
            ],
            [
                "ibge_codigo"       => 3135704,
                "ibge_estado_id" => 31,
                "nome"     => "Jequitibá",
            ],
            [
                "ibge_codigo"       => 3135803,
                "ibge_estado_id" => 31,
                "nome"     => "Jequitinhonha",
            ],
            [
                "ibge_codigo"       => 3135902,
                "ibge_estado_id" => 31,
                "nome"     => "Jesuânia",
            ],
            [
                "ibge_codigo"       => 3136009,
                "ibge_estado_id" => 31,
                "nome"     => "Joaíma",
            ],
            [
                "ibge_codigo"       => 3136108,
                "ibge_estado_id" => 31,
                "nome"     => "Joanésia",
            ],
            [
                "ibge_codigo"       => 3136207,
                "ibge_estado_id" => 31,
                "nome"     => "João Monlevade",
            ],
            [
                "ibge_codigo"       => 3136306,
                "ibge_estado_id" => 31,
                "nome"     => "João Pinheiro",
            ],
            [
                "ibge_codigo"       => 3136405,
                "ibge_estado_id" => 31,
                "nome"     => "Joaquim Felício",
            ],
            [
                "ibge_codigo"       => 3136504,
                "ibge_estado_id" => 31,
                "nome"     => "Jordânia",
            ],
            [
                "ibge_codigo"       => 3136520,
                "ibge_estado_id" => 31,
                "nome"     => "José Gonçalves de Minas",
            ],
            [
                "ibge_codigo"       => 3136553,
                "ibge_estado_id" => 31,
                "nome"     => "José Raydan",
            ],
            [
                "ibge_codigo"       => 3136579,
                "ibge_estado_id" => 31,
                "nome"     => "Josenópolis",
            ],
            [
                "ibge_codigo"       => 3136603,
                "ibge_estado_id" => 31,
                "nome"     => "Nova União",
            ],
            [
                "ibge_codigo"       => 3136652,
                "ibge_estado_id" => 31,
                "nome"     => "Juatuba",
            ],
            [
                "ibge_codigo"       => 3136702,
                "ibge_estado_id" => 31,
                "nome"     => "Juiz de Fora",
            ],
            [
                "ibge_codigo"       => 3136801,
                "ibge_estado_id" => 31,
                "nome"     => "Juramento",
            ],
            [
                "ibge_codigo"       => 3136900,
                "ibge_estado_id" => 31,
                "nome"     => "Juruaia",
            ],
            [
                "ibge_codigo"       => 3136959,
                "ibge_estado_id" => 31,
                "nome"     => "Juvenília",
            ],
            [
                "ibge_codigo"       => 3137007,
                "ibge_estado_id" => 31,
                "nome"     => "Ladainha",
            ],
            [
                "ibge_codigo"       => 3137106,
                "ibge_estado_id" => 31,
                "nome"     => "Lagamar",
            ],
            [
                "ibge_codigo"       => 3137205,
                "ibge_estado_id" => 31,
                "nome"     => "Lagoa da Prata",
            ],
            [
                "ibge_codigo"       => 3137304,
                "ibge_estado_id" => 31,
                "nome"     => "Lagoa dos Patos",
            ],
            [
                "ibge_codigo"       => 3137403,
                "ibge_estado_id" => 31,
                "nome"     => "Lagoa Dourada",
            ],
            [
                "ibge_codigo"       => 3137502,
                "ibge_estado_id" => 31,
                "nome"     => "Lagoa Formosa",
            ],
            [
                "ibge_codigo"       => 3137536,
                "ibge_estado_id" => 31,
                "nome"     => "Lagoa Grande",
            ],
            [
                "ibge_codigo"       => 3137601,
                "ibge_estado_id" => 31,
                "nome"     => "Lagoa Santa",
            ],
            [
                "ibge_codigo"       => 3137700,
                "ibge_estado_id" => 31,
                "nome"     => "Lajinha",
            ],
            [
                "ibge_codigo"       => 3137809,
                "ibge_estado_id" => 31,
                "nome"     => "Lambari",
            ],
            [
                "ibge_codigo"       => 3137908,
                "ibge_estado_id" => 31,
                "nome"     => "Lamim",
            ],
            [
                "ibge_codigo"       => 3138005,
                "ibge_estado_id" => 31,
                "nome"     => "Laranjal",
            ],
            [
                "ibge_codigo"       => 3138104,
                "ibge_estado_id" => 31,
                "nome"     => "Lassance",
            ],
            [
                "ibge_codigo"       => 3138203,
                "ibge_estado_id" => 31,
                "nome"     => "Lavras",
            ],
            [
                "ibge_codigo"       => 3138302,
                "ibge_estado_id" => 31,
                "nome"     => "Leandro Ferreira",
            ],
            [
                "ibge_codigo"       => 3138351,
                "ibge_estado_id" => 31,
                "nome"     => "Leme do Prado",
            ],
            [
                "ibge_codigo"       => 3138401,
                "ibge_estado_id" => 31,
                "nome"     => "Leopoldina",
            ],
            [
                "ibge_codigo"       => 3138500,
                "ibge_estado_id" => 31,
                "nome"     => "Liberdade",
            ],
            [
                "ibge_codigo"       => 3138609,
                "ibge_estado_id" => 31,
                "nome"     => "Lima Duarte",
            ],
            [
                "ibge_codigo"       => 3138625,
                "ibge_estado_id" => 31,
                "nome"     => "Limeira do Oeste",
            ],
            [
                "ibge_codigo"       => 3138658,
                "ibge_estado_id" => 31,
                "nome"     => "Lontra",
            ],
            [
                "ibge_codigo"       => 3138674,
                "ibge_estado_id" => 31,
                "nome"     => "Luisburgo",
            ],
            [
                "ibge_codigo"       => 3138682,
                "ibge_estado_id" => 31,
                "nome"     => "Luislândia",
            ],
            [
                "ibge_codigo"       => 3138708,
                "ibge_estado_id" => 31,
                "nome"     => "Luminárias",
            ],
            [
                "ibge_codigo"       => 3138807,
                "ibge_estado_id" => 31,
                "nome"     => "Luz",
            ],
            [
                "ibge_codigo"       => 3138906,
                "ibge_estado_id" => 31,
                "nome"     => "Machacalis",
            ],
            [
                "ibge_codigo"       => 3139003,
                "ibge_estado_id" => 31,
                "nome"     => "Machado",
            ],
            [
                "ibge_codigo"       => 3139102,
                "ibge_estado_id" => 31,
                "nome"     => "Madre de Deus de Minas",
            ],
            [
                "ibge_codigo"       => 3139201,
                "ibge_estado_id" => 31,
                "nome"     => "Malacacheta",
            ],
            [
                "ibge_codigo"       => 3139250,
                "ibge_estado_id" => 31,
                "nome"     => "Mamonas",
            ],
            [
                "ibge_codigo"       => 3139300,
                "ibge_estado_id" => 31,
                "nome"     => "Manga",
            ],
            [
                "ibge_codigo"       => 3139409,
                "ibge_estado_id" => 31,
                "nome"     => "Manhuaçu",
            ],
            [
                "ibge_codigo"       => 3139508,
                "ibge_estado_id" => 31,
                "nome"     => "Manhumirim",
            ],
            [
                "ibge_codigo"       => 3139607,
                "ibge_estado_id" => 31,
                "nome"     => "Mantena",
            ],
            [
                "ibge_codigo"       => 3139706,
                "ibge_estado_id" => 31,
                "nome"     => "Maravilhas",
            ],
            [
                "ibge_codigo"       => 3139805,
                "ibge_estado_id" => 31,
                "nome"     => "Mar de Espanha",
            ],
            [
                "ibge_codigo"       => 3139904,
                "ibge_estado_id" => 31,
                "nome"     => "Maria da Fé",
            ],
            [
                "ibge_codigo"       => 3140001,
                "ibge_estado_id" => 31,
                "nome"     => "Mariana",
            ],
            [
                "ibge_codigo"       => 3140100,
                "ibge_estado_id" => 31,
                "nome"     => "Marilac",
            ],
            [
                "ibge_codigo"       => 3140159,
                "ibge_estado_id" => 31,
                "nome"     => "Mário Campos",
            ],
            [
                "ibge_codigo"       => 3140209,
                "ibge_estado_id" => 31,
                "nome"     => "Maripá de Minas",
            ],
            [
                "ibge_codigo"       => 3140308,
                "ibge_estado_id" => 31,
                "nome"     => "Marliéria",
            ],
            [
                "ibge_codigo"       => 3140407,
                "ibge_estado_id" => 31,
                "nome"     => "Marmelópolis",
            ],
            [
                "ibge_codigo"       => 3140506,
                "ibge_estado_id" => 31,
                "nome"     => "Martinho Campos",
            ],
            [
                "ibge_codigo"       => 3140530,
                "ibge_estado_id" => 31,
                "nome"     => "Martins Soares",
            ],
            [
                "ibge_codigo"       => 3140555,
                "ibge_estado_id" => 31,
                "nome"     => "Mata Verde",
            ],
            [
                "ibge_codigo"       => 3140605,
                "ibge_estado_id" => 31,
                "nome"     => "Materlândia",
            ],
            [
                "ibge_codigo"       => 3140704,
                "ibge_estado_id" => 31,
                "nome"     => "Mateus Leme",
            ],
            [
                "ibge_codigo"       => 3140803,
                "ibge_estado_id" => 31,
                "nome"     => "Matias Barbosa",
            ],
            [
                "ibge_codigo"       => 3140852,
                "ibge_estado_id" => 31,
                "nome"     => "Matias Cardoso",
            ],
            [
                "ibge_codigo"       => 3140902,
                "ibge_estado_id" => 31,
                "nome"     => "Matipó",
            ],
            [
                "ibge_codigo"       => 3141009,
                "ibge_estado_id" => 31,
                "nome"     => "Mato Verde",
            ],
            [
                "ibge_codigo"       => 3141108,
                "ibge_estado_id" => 31,
                "nome"     => "Matozinhos",
            ],
            [
                "ibge_codigo"       => 3141207,
                "ibge_estado_id" => 31,
                "nome"     => "Matutina",
            ],
            [
                "ibge_codigo"       => 3141306,
                "ibge_estado_id" => 31,
                "nome"     => "Medeiros",
            ],
            [
                "ibge_codigo"       => 3141405,
                "ibge_estado_id" => 31,
                "nome"     => "Medina",
            ],
            [
                "ibge_codigo"       => 3141504,
                "ibge_estado_id" => 31,
                "nome"     => "Mendes Pimentel",
            ],
            [
                "ibge_codigo"       => 3141603,
                "ibge_estado_id" => 31,
                "nome"     => "Mercês",
            ],
            [
                "ibge_codigo"       => 3141702,
                "ibge_estado_id" => 31,
                "nome"     => "Mesquita",
            ],
            [
                "ibge_codigo"       => 3141801,
                "ibge_estado_id" => 31,
                "nome"     => "Minas Novas",
            ],
            [
                "ibge_codigo"       => 3141900,
                "ibge_estado_id" => 31,
                "nome"     => "Minduri",
            ],
            [
                "ibge_codigo"       => 3142007,
                "ibge_estado_id" => 31,
                "nome"     => "Mirabela",
            ],
            [
                "ibge_codigo"       => 3142106,
                "ibge_estado_id" => 31,
                "nome"     => "Miradouro",
            ],
            [
                "ibge_codigo"       => 3142205,
                "ibge_estado_id" => 31,
                "nome"     => "Miraí",
            ],
            [
                "ibge_codigo"       => 3142254,
                "ibge_estado_id" => 31,
                "nome"     => "Miravânia",
            ],
            [
                "ibge_codigo"       => 3142304,
                "ibge_estado_id" => 31,
                "nome"     => "Moeda",
            ],
            [
                "ibge_codigo"       => 3142403,
                "ibge_estado_id" => 31,
                "nome"     => "Moema",
            ],
            [
                "ibge_codigo"       => 3142502,
                "ibge_estado_id" => 31,
                "nome"     => "Monjolos",
            ],
            [
                "ibge_codigo"       => 3142601,
                "ibge_estado_id" => 31,
                "nome"     => "Monsenhor Paulo",
            ],
            [
                "ibge_codigo"       => 3142700,
                "ibge_estado_id" => 31,
                "nome"     => "Montalvânia",
            ],
            [
                "ibge_codigo"       => 3142809,
                "ibge_estado_id" => 31,
                "nome"     => "Monte Alegre de Minas",
            ],
            [
                "ibge_codigo"       => 3142908,
                "ibge_estado_id" => 31,
                "nome"     => "Monte Azul",
            ],
            [
                "ibge_codigo"       => 3143005,
                "ibge_estado_id" => 31,
                "nome"     => "Monte Belo",
            ],
            [
                "ibge_codigo"       => 3143104,
                "ibge_estado_id" => 31,
                "nome"     => "Monte Carmelo",
            ],
            [
                "ibge_codigo"       => 3143153,
                "ibge_estado_id" => 31,
                "nome"     => "Monte Formoso",
            ],
            [
                "ibge_codigo"       => 3143203,
                "ibge_estado_id" => 31,
                "nome"     => "Monte Santo de Minas",
            ],
            [
                "ibge_codigo"       => 3143302,
                "ibge_estado_id" => 31,
                "nome"     => "Montes Claros",
            ],
            [
                "ibge_codigo"       => 3143401,
                "ibge_estado_id" => 31,
                "nome"     => "Monte Sião",
            ],
            [
                "ibge_codigo"       => 3143450,
                "ibge_estado_id" => 31,
                "nome"     => "Montezuma",
            ],
            [
                "ibge_codigo"       => 3143500,
                "ibge_estado_id" => 31,
                "nome"     => "Morada Nova de Minas",
            ],
            [
                "ibge_codigo"       => 3143609,
                "ibge_estado_id" => 31,
                "nome"     => "Morro da Garça",
            ],
            [
                "ibge_codigo"       => 3143708,
                "ibge_estado_id" => 31,
                "nome"     => "Morro do Pilar",
            ],
            [
                "ibge_codigo"       => 3143807,
                "ibge_estado_id" => 31,
                "nome"     => "Munhoz",
            ],
            [
                "ibge_codigo"       => 3143906,
                "ibge_estado_id" => 31,
                "nome"     => "Muriaé",
            ],
            [
                "ibge_codigo"       => 3144003,
                "ibge_estado_id" => 31,
                "nome"     => "Mutum",
            ],
            [
                "ibge_codigo"       => 3144102,
                "ibge_estado_id" => 31,
                "nome"     => "Muzambinho",
            ],
            [
                "ibge_codigo"       => 3144201,
                "ibge_estado_id" => 31,
                "nome"     => "Nacip Raydan",
            ],
            [
                "ibge_codigo"       => 3144300,
                "ibge_estado_id" => 31,
                "nome"     => "Nanuque",
            ],
            [
                "ibge_codigo"       => 3144359,
                "ibge_estado_id" => 31,
                "nome"     => "Naque",
            ],
            [
                "ibge_codigo"       => 3144375,
                "ibge_estado_id" => 31,
                "nome"     => "Natalândia",
            ],
            [
                "ibge_codigo"       => 3144409,
                "ibge_estado_id" => 31,
                "nome"     => "Natércia",
            ],
            [
                "ibge_codigo"       => 3144508,
                "ibge_estado_id" => 31,
                "nome"     => "Nazareno",
            ],
            [
                "ibge_codigo"       => 3144607,
                "ibge_estado_id" => 31,
                "nome"     => "Nepomuceno",
            ],
            [
                "ibge_codigo"       => 3144656,
                "ibge_estado_id" => 31,
                "nome"     => "Ninheira",
            ],
            [
                "ibge_codigo"       => 3144672,
                "ibge_estado_id" => 31,
                "nome"     => "Nova Belém",
            ],
            [
                "ibge_codigo"       => 3144706,
                "ibge_estado_id" => 31,
                "nome"     => "Nova Era",
            ],
            [
                "ibge_codigo"       => 3144805,
                "ibge_estado_id" => 31,
                "nome"     => "Nova Lima",
            ],
            [
                "ibge_codigo"       => 3144904,
                "ibge_estado_id" => 31,
                "nome"     => "Nova Módica",
            ],
            [
                "ibge_codigo"       => 3145000,
                "ibge_estado_id" => 31,
                "nome"     => "Nova Ponte",
            ],
            [
                "ibge_codigo"       => 3145059,
                "ibge_estado_id" => 31,
                "nome"     => "Nova Porteirinha",
            ],
            [
                "ibge_codigo"       => 3145109,
                "ibge_estado_id" => 31,
                "nome"     => "Nova Resende",
            ],
            [
                "ibge_codigo"       => 3145208,
                "ibge_estado_id" => 31,
                "nome"     => "Nova Serrana",
            ],
            [
                "ibge_codigo"       => 3145307,
                "ibge_estado_id" => 31,
                "nome"     => "Novo Cruzeiro",
            ],
            [
                "ibge_codigo"       => 3145356,
                "ibge_estado_id" => 31,
                "nome"     => "Novo Oriente de Minas",
            ],
            [
                "ibge_codigo"       => 3145372,
                "ibge_estado_id" => 31,
                "nome"     => "Novorizonte",
            ],
            [
                "ibge_codigo"       => 3145406,
                "ibge_estado_id" => 31,
                "nome"     => "Olaria",
            ],
            [
                "ibge_codigo"       => 3145455,
                "ibge_estado_id" => 31,
                "nome"     => "Olhos-d'Água",
            ],
            [
                "ibge_codigo"       => 3145505,
                "ibge_estado_id" => 31,
                "nome"     => "Olímpio Noronha",
            ],
            [
                "ibge_codigo"       => 3145604,
                "ibge_estado_id" => 31,
                "nome"     => "Oliveira",
            ],
            [
                "ibge_codigo"       => 3145703,
                "ibge_estado_id" => 31,
                "nome"     => "Oliveira Fortes",
            ],
            [
                "ibge_codigo"       => 3145802,
                "ibge_estado_id" => 31,
                "nome"     => "Onça de Pitangui",
            ],
            [
                "ibge_codigo"       => 3145851,
                "ibge_estado_id" => 31,
                "nome"     => "Oratórios",
            ],
            [
                "ibge_codigo"       => 3145877,
                "ibge_estado_id" => 31,
                "nome"     => "Orizânia",
            ],
            [
                "ibge_codigo"       => 3145901,
                "ibge_estado_id" => 31,
                "nome"     => "Ouro Branco",
            ],
            [
                "ibge_codigo"       => 3146008,
                "ibge_estado_id" => 31,
                "nome"     => "Ouro Fino",
            ],
            [
                "ibge_codigo"       => 3146107,
                "ibge_estado_id" => 31,
                "nome"     => "Ouro Preto",
            ],
            [
                "ibge_codigo"       => 3146206,
                "ibge_estado_id" => 31,
                "nome"     => "Ouro Verde de Minas",
            ],
            [
                "ibge_codigo"       => 3146255,
                "ibge_estado_id" => 31,
                "nome"     => "Padre Carvalho",
            ],
            [
                "ibge_codigo"       => 3146305,
                "ibge_estado_id" => 31,
                "nome"     => "Padre Paraíso",
            ],
            [
                "ibge_codigo"       => 3146404,
                "ibge_estado_id" => 31,
                "nome"     => "Paineiras",
            ],
            [
                "ibge_codigo"       => 3146503,
                "ibge_estado_id" => 31,
                "nome"     => "Pains",
            ],
            [
                "ibge_codigo"       => 3146552,
                "ibge_estado_id" => 31,
                "nome"     => "Pai Pedro",
            ],
            [
                "ibge_codigo"       => 3146602,
                "ibge_estado_id" => 31,
                "nome"     => "Paiva",
            ],
            [
                "ibge_codigo"       => 3146701,
                "ibge_estado_id" => 31,
                "nome"     => "Palma",
            ],
            [
                "ibge_codigo"       => 3146750,
                "ibge_estado_id" => 31,
                "nome"     => "Palmópolis",
            ],
            [
                "ibge_codigo"       => 3146909,
                "ibge_estado_id" => 31,
                "nome"     => "Papagaios",
            ],
            [
                "ibge_codigo"       => 3147006,
                "ibge_estado_id" => 31,
                "nome"     => "Paracatu",
            ],
            [
                "ibge_codigo"       => 3147105,
                "ibge_estado_id" => 31,
                "nome"     => "Pará de Minas",
            ],
            [
                "ibge_codigo"       => 3147204,
                "ibge_estado_id" => 31,
                "nome"     => "Paraguaçu",
            ],
            [
                "ibge_codigo"       => 3147303,
                "ibge_estado_id" => 31,
                "nome"     => "Paraisópolis",
            ],
            [
                "ibge_codigo"       => 3147402,
                "ibge_estado_id" => 31,
                "nome"     => "Paraopeba",
            ],
            [
                "ibge_codigo"       => 3147501,
                "ibge_estado_id" => 31,
                "nome"     => "Passabém",
            ],
            [
                "ibge_codigo"       => 3147600,
                "ibge_estado_id" => 31,
                "nome"     => "Passa Quatro",
            ],
            [
                "ibge_codigo"       => 3147709,
                "ibge_estado_id" => 31,
                "nome"     => "Passa Tempo",
            ],
            [
                "ibge_codigo"       => 3147808,
                "ibge_estado_id" => 31,
                "nome"     => "Passa-Vinte",
            ],
            [
                "ibge_codigo"       => 3147907,
                "ibge_estado_id" => 31,
                "nome"     => "Passos",
            ],
            [
                "ibge_codigo"       => 3147956,
                "ibge_estado_id" => 31,
                "nome"     => "Patis",
            ],
            [
                "ibge_codigo"       => 3148004,
                "ibge_estado_id" => 31,
                "nome"     => "Patos de Minas",
            ],
            [
                "ibge_codigo"       => 3148103,
                "ibge_estado_id" => 31,
                "nome"     => "Patrocínio",
            ],
            [
                "ibge_codigo"       => 3148202,
                "ibge_estado_id" => 31,
                "nome"     => "Patrocínio do Muriaé",
            ],
            [
                "ibge_codigo"       => 3148301,
                "ibge_estado_id" => 31,
                "nome"     => "Paula Cândido",
            ],
            [
                "ibge_codigo"       => 3148400,
                "ibge_estado_id" => 31,
                "nome"     => "Paulistas",
            ],
            [
                "ibge_codigo"       => 3148509,
                "ibge_estado_id" => 31,
                "nome"     => "Pavão",
            ],
            [
                "ibge_codigo"       => 3148608,
                "ibge_estado_id" => 31,
                "nome"     => "Peçanha",
            ],
            [
                "ibge_codigo"       => 3148707,
                "ibge_estado_id" => 31,
                "nome"     => "Pedra Azul",
            ],
            [
                "ibge_codigo"       => 3148756,
                "ibge_estado_id" => 31,
                "nome"     => "Pedra Bonita",
            ],
            [
                "ibge_codigo"       => 3148806,
                "ibge_estado_id" => 31,
                "nome"     => "Pedra do Anta",
            ],
            [
                "ibge_codigo"       => 3148905,
                "ibge_estado_id" => 31,
                "nome"     => "Pedra do Indaiá",
            ],
            [
                "ibge_codigo"       => 3149002,
                "ibge_estado_id" => 31,
                "nome"     => "Pedra Dourada",
            ],
            [
                "ibge_codigo"       => 3149101,
                "ibge_estado_id" => 31,
                "nome"     => "Pedralva",
            ],
            [
                "ibge_codigo"       => 3149150,
                "ibge_estado_id" => 31,
                "nome"     => "Pedras de Maria da Cruz",
            ],
            [
                "ibge_codigo"       => 3149200,
                "ibge_estado_id" => 31,
                "nome"     => "Pedrinópolis",
            ],
            [
                "ibge_codigo"       => 3149309,
                "ibge_estado_id" => 31,
                "nome"     => "Pedro Leopoldo",
            ],
            [
                "ibge_codigo"       => 3149408,
                "ibge_estado_id" => 31,
                "nome"     => "Pedro Teixeira",
            ],
            [
                "ibge_codigo"       => 3149507,
                "ibge_estado_id" => 31,
                "nome"     => "Pequeri",
            ],
            [
                "ibge_codigo"       => 3149606,
                "ibge_estado_id" => 31,
                "nome"     => "Pequi",
            ],
            [
                "ibge_codigo"       => 3149705,
                "ibge_estado_id" => 31,
                "nome"     => "Perdigão",
            ],
            [
                "ibge_codigo"       => 3149804,
                "ibge_estado_id" => 31,
                "nome"     => "Perdizes",
            ],
            [
                "ibge_codigo"       => 3149903,
                "ibge_estado_id" => 31,
                "nome"     => "Perdões",
            ],
            [
                "ibge_codigo"       => 3149952,
                "ibge_estado_id" => 31,
                "nome"     => "Periquito",
            ],
            [
                "ibge_codigo"       => 3150000,
                "ibge_estado_id" => 31,
                "nome"     => "Pescador",
            ],
            [
                "ibge_codigo"       => 3150109,
                "ibge_estado_id" => 31,
                "nome"     => "Piau",
            ],
            [
                "ibge_codigo"       => 3150158,
                "ibge_estado_id" => 31,
                "nome"     => "Piedade de Caratinga",
            ],
            [
                "ibge_codigo"       => 3150208,
                "ibge_estado_id" => 31,
                "nome"     => "Piedade de Ponte Nova",
            ],
            [
                "ibge_codigo"       => 3150307,
                "ibge_estado_id" => 31,
                "nome"     => "Piedade do Rio Grande",
            ],
            [
                "ibge_codigo"       => 3150406,
                "ibge_estado_id" => 31,
                "nome"     => "Piedade dos Gerais",
            ],
            [
                "ibge_codigo"       => 3150505,
                "ibge_estado_id" => 31,
                "nome"     => "Pimenta",
            ],
            [
                "ibge_codigo"       => 3150539,
                "ibge_estado_id" => 31,
                "nome"     => "Pingo-d'Água",
            ],
            [
                "ibge_codigo"       => 3150570,
                "ibge_estado_id" => 31,
                "nome"     => "Pintópolis",
            ],
            [
                "ibge_codigo"       => 3150604,
                "ibge_estado_id" => 31,
                "nome"     => "Piracema",
            ],
            [
                "ibge_codigo"       => 3150703,
                "ibge_estado_id" => 31,
                "nome"     => "Pirajuba",
            ],
            [
                "ibge_codigo"       => 3150802,
                "ibge_estado_id" => 31,
                "nome"     => "Piranga",
            ],
            [
                "ibge_codigo"       => 3150901,
                "ibge_estado_id" => 31,
                "nome"     => "Piranguçu",
            ],
            [
                "ibge_codigo"       => 3151008,
                "ibge_estado_id" => 31,
                "nome"     => "Piranguinho",
            ],
            [
                "ibge_codigo"       => 3151107,
                "ibge_estado_id" => 31,
                "nome"     => "Pirapetinga",
            ],
            [
                "ibge_codigo"       => 3151206,
                "ibge_estado_id" => 31,
                "nome"     => "Pirapora",
            ],
            [
                "ibge_codigo"       => 3151305,
                "ibge_estado_id" => 31,
                "nome"     => "Piraúba",
            ],
            [
                "ibge_codigo"       => 3151404,
                "ibge_estado_id" => 31,
                "nome"     => "Pitangui",
            ],
            [
                "ibge_codigo"       => 3151503,
                "ibge_estado_id" => 31,
                "nome"     => "Piumhi",
            ],
            [
                "ibge_codigo"       => 3151602,
                "ibge_estado_id" => 31,
                "nome"     => "Planura",
            ],
            [
                "ibge_codigo"       => 3151701,
                "ibge_estado_id" => 31,
                "nome"     => "Poço Fundo",
            ],
            [
                "ibge_codigo"       => 3151800,
                "ibge_estado_id" => 31,
                "nome"     => "Poços de Caldas",
            ],
            [
                "ibge_codigo"       => 3151909,
                "ibge_estado_id" => 31,
                "nome"     => "Pocrane",
            ],
            [
                "ibge_codigo"       => 3152006,
                "ibge_estado_id" => 31,
                "nome"     => "Pompéu",
            ],
            [
                "ibge_codigo"       => 3152105,
                "ibge_estado_id" => 31,
                "nome"     => "Ponte Nova",
            ],
            [
                "ibge_codigo"       => 3152131,
                "ibge_estado_id" => 31,
                "nome"     => "Ponto Chique",
            ],
            [
                "ibge_codigo"       => 3152170,
                "ibge_estado_id" => 31,
                "nome"     => "Ponto dos Volantes",
            ],
            [
                "ibge_codigo"       => 3152204,
                "ibge_estado_id" => 31,
                "nome"     => "Porteirinha",
            ],
            [
                "ibge_codigo"       => 3152303,
                "ibge_estado_id" => 31,
                "nome"     => "Porto Firme",
            ],
            [
                "ibge_codigo"       => 3152402,
                "ibge_estado_id" => 31,
                "nome"     => "Poté",
            ],
            [
                "ibge_codigo"       => 3152501,
                "ibge_estado_id" => 31,
                "nome"     => "Pouso Alegre",
            ],
            [
                "ibge_codigo"       => 3152600,
                "ibge_estado_id" => 31,
                "nome"     => "Pouso Alto",
            ],
            [
                "ibge_codigo"       => 3152709,
                "ibge_estado_id" => 31,
                "nome"     => "Prados",
            ],
            [
                "ibge_codigo"       => 3152808,
                "ibge_estado_id" => 31,
                "nome"     => "Prata",
            ],
            [
                "ibge_codigo"       => 3152907,
                "ibge_estado_id" => 31,
                "nome"     => "Pratápolis",
            ],
            [
                "ibge_codigo"       => 3153004,
                "ibge_estado_id" => 31,
                "nome"     => "Pratinha",
            ],
            [
                "ibge_codigo"       => 3153103,
                "ibge_estado_id" => 31,
                "nome"     => "Presidente Bernardes",
            ],
            [
                "ibge_codigo"       => 3153202,
                "ibge_estado_id" => 31,
                "nome"     => "Presidente Juscelino",
            ],
            [
                "ibge_codigo"       => 3153301,
                "ibge_estado_id" => 31,
                "nome"     => "Presidente Kubitschek",
            ],
            [
                "ibge_codigo"       => 3153400,
                "ibge_estado_id" => 31,
                "nome"     => "Presidente Olegário",
            ],
            [
                "ibge_codigo"       => 3153509,
                "ibge_estado_id" => 31,
                "nome"     => "Alto Jequitibá",
            ],
            [
                "ibge_codigo"       => 3153608,
                "ibge_estado_id" => 31,
                "nome"     => "Prudente de Morais",
            ],
            [
                "ibge_codigo"       => 3153707,
                "ibge_estado_id" => 31,
                "nome"     => "Quartel Geral",
            ],
            [
                "ibge_codigo"       => 3153806,
                "ibge_estado_id" => 31,
                "nome"     => "Queluzito",
            ],
            [
                "ibge_codigo"       => 3153905,
                "ibge_estado_id" => 31,
                "nome"     => "Raposos",
            ],
            [
                "ibge_codigo"       => 3154002,
                "ibge_estado_id" => 31,
                "nome"     => "Raul Soares",
            ],
            [
                "ibge_codigo"       => 3154101,
                "ibge_estado_id" => 31,
                "nome"     => "Recreio",
            ],
            [
                "ibge_codigo"       => 3154150,
                "ibge_estado_id" => 31,
                "nome"     => "Reduto",
            ],
            [
                "ibge_codigo"       => 3154200,
                "ibge_estado_id" => 31,
                "nome"     => "Resende Costa",
            ],
            [
                "ibge_codigo"       => 3154309,
                "ibge_estado_id" => 31,
                "nome"     => "Resplendor",
            ],
            [
                "ibge_codigo"       => 3154408,
                "ibge_estado_id" => 31,
                "nome"     => "Ressaquinha",
            ],
            [
                "ibge_codigo"       => 3154457,
                "ibge_estado_id" => 31,
                "nome"     => "Riachinho",
            ],
            [
                "ibge_codigo"       => 3154507,
                "ibge_estado_id" => 31,
                "nome"     => "Riacho dos Machados",
            ],
            [
                "ibge_codigo"       => 3154606,
                "ibge_estado_id" => 31,
                "nome"     => "Ribeirão das Neves",
            ],
            [
                "ibge_codigo"       => 3154705,
                "ibge_estado_id" => 31,
                "nome"     => "Ribeirão Vermelho",
            ],
            [
                "ibge_codigo"       => 3154804,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Acima",
            ],
            [
                "ibge_codigo"       => 3154903,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Casca",
            ],
            [
                "ibge_codigo"       => 3155009,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Doce",
            ],
            [
                "ibge_codigo"       => 3155108,
                "ibge_estado_id" => 31,
                "nome"     => "Rio do Prado",
            ],
            [
                "ibge_codigo"       => 3155207,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Espera",
            ],
            [
                "ibge_codigo"       => 3155306,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Manso",
            ],
            [
                "ibge_codigo"       => 3155405,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Novo",
            ],
            [
                "ibge_codigo"       => 3155504,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Paranaíba",
            ],
            [
                "ibge_codigo"       => 3155603,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Pardo de Minas",
            ],
            [
                "ibge_codigo"       => 3155702,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Piracicaba",
            ],
            [
                "ibge_codigo"       => 3155801,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Pomba",
            ],
            [
                "ibge_codigo"       => 3155900,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Preto",
            ],
            [
                "ibge_codigo"       => 3156007,
                "ibge_estado_id" => 31,
                "nome"     => "Rio Vermelho",
            ],
            [
                "ibge_codigo"       => 3156106,
                "ibge_estado_id" => 31,
                "nome"     => "Ritápolis",
            ],
            [
                "ibge_codigo"       => 3156205,
                "ibge_estado_id" => 31,
                "nome"     => "Rochedo de Minas",
            ],
            [
                "ibge_codigo"       => 3156304,
                "ibge_estado_id" => 31,
                "nome"     => "Rodeiro",
            ],
            [
                "ibge_codigo"       => 3156403,
                "ibge_estado_id" => 31,
                "nome"     => "Romaria",
            ],
            [
                "ibge_codigo"       => 3156452,
                "ibge_estado_id" => 31,
                "nome"     => "Rosário da Limeira",
            ],
            [
                "ibge_codigo"       => 3156502,
                "ibge_estado_id" => 31,
                "nome"     => "Rubelita",
            ],
            [
                "ibge_codigo"       => 3156601,
                "ibge_estado_id" => 31,
                "nome"     => "Rubim",
            ],
            [
                "ibge_codigo"       => 3156700,
                "ibge_estado_id" => 31,
                "nome"     => "Sabará",
            ],
            [
                "ibge_codigo"       => 3156809,
                "ibge_estado_id" => 31,
                "nome"     => "Sabinópolis",
            ],
            [
                "ibge_codigo"       => 3156908,
                "ibge_estado_id" => 31,
                "nome"     => "Sacramento",
            ],
            [
                "ibge_codigo"       => 3157005,
                "ibge_estado_id" => 31,
                "nome"     => "Salinas",
            ],
            [
                "ibge_codigo"       => 3157104,
                "ibge_estado_id" => 31,
                "nome"     => "Salto da Divisa",
            ],
            [
                "ibge_codigo"       => 3157203,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Bárbara",
            ],
            [
                "ibge_codigo"       => 3157252,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Bárbara do Leste",
            ],
            [
                "ibge_codigo"       => 3157278,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Bárbara do Monte Verde",
            ],
            [
                "ibge_codigo"       => 3157302,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Bárbara do Tugúrio",
            ],
            [
                "ibge_codigo"       => 3157336,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Cruz de Minas",
            ],
            [
                "ibge_codigo"       => 3157377,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Cruz de Salinas",
            ],
            [
                "ibge_codigo"       => 3157401,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Cruz do Escalvado",
            ],
            [
                "ibge_codigo"       => 3157500,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Efigênia de Minas",
            ],
            [
                "ibge_codigo"       => 3157609,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Fé de Minas",
            ],
            [
                "ibge_codigo"       => 3157658,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Helena de Minas",
            ],
            [
                "ibge_codigo"       => 3157708,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Juliana",
            ],
            [
                "ibge_codigo"       => 3157807,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Luzia",
            ],
            [
                "ibge_codigo"       => 3157906,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Margarida",
            ],
            [
                "ibge_codigo"       => 3158003,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Maria de Itabira",
            ],
            [
                "ibge_codigo"       => 3158102,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Maria do Salto",
            ],
            [
                "ibge_codigo"       => 3158201,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Maria do Suaçuí",
            ],
            [
                "ibge_codigo"       => 3158300,
                "ibge_estado_id" => 31,
                "nome"     => "Santana da Vargem",
            ],
            [
                "ibge_codigo"       => 3158409,
                "ibge_estado_id" => 31,
                "nome"     => "Santana de Cataguases",
            ],
            [
                "ibge_codigo"       => 3158508,
                "ibge_estado_id" => 31,
                "nome"     => "Santana de Pirapama",
            ],
            [
                "ibge_codigo"       => 3158607,
                "ibge_estado_id" => 31,
                "nome"     => "Santana do Deserto",
            ],
            [
                "ibge_codigo"       => 3158706,
                "ibge_estado_id" => 31,
                "nome"     => "Santana do Garambéu",
            ],
            [
                "ibge_codigo"       => 3158805,
                "ibge_estado_id" => 31,
                "nome"     => "Santana do Jacaré",
            ],
            [
                "ibge_codigo"       => 3158904,
                "ibge_estado_id" => 31,
                "nome"     => "Santana do Manhuaçu",
            ],
            [
                "ibge_codigo"       => 3158953,
                "ibge_estado_id" => 31,
                "nome"     => "Santana do Paraíso",
            ],
            [
                "ibge_codigo"       => 3159001,
                "ibge_estado_id" => 31,
                "nome"     => "Santana do Riacho",
            ],
            [
                "ibge_codigo"       => 3159100,
                "ibge_estado_id" => 31,
                "nome"     => "Santana dos Montes",
            ],
            [
                "ibge_codigo"       => 3159209,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Rita de Caldas",
            ],
            [
                "ibge_codigo"       => 3159308,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Rita de Jacutinga",
            ],
            [
                "ibge_codigo"       => 3159357,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Rita de Minas",
            ],
            [
                "ibge_codigo"       => 3159407,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Rita de Ibitipoca",
            ],
            [
                "ibge_codigo"       => 3159506,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Rita do Itueto",
            ],
            [
                "ibge_codigo"       => 3159605,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Rita do Sapucaí",
            ],
            [
                "ibge_codigo"       => 3159704,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Rosa da Serra",
            ],
            [
                "ibge_codigo"       => 3159803,
                "ibge_estado_id" => 31,
                "nome"     => "Santa Vitória",
            ],
            [
                "ibge_codigo"       => 3159902,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Antônio do Amparo",
            ],
            [
                "ibge_codigo"       => 3160009,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Antônio do Aventureiro",
            ],
            [
                "ibge_codigo"       => 3160108,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Antônio do Grama",
            ],
            [
                "ibge_codigo"       => 3160207,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Antônio do Itambé",
            ],
            [
                "ibge_codigo"       => 3160306,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Antônio do Jacinto",
            ],
            [
                "ibge_codigo"       => 3160405,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Antônio do Monte",
            ],
            [
                "ibge_codigo"       => 3160454,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Antônio do Retiro",
            ],
            [
                "ibge_codigo"       => 3160504,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Antônio do Rio Abaixo",
            ],
            [
                "ibge_codigo"       => 3160603,
                "ibge_estado_id" => 31,
                "nome"     => "Santo Hipólito",
            ],
            [
                "ibge_codigo"       => 3160702,
                "ibge_estado_id" => 31,
                "nome"     => "Santos Dumont",
            ],
            [
                "ibge_codigo"       => 3160801,
                "ibge_estado_id" => 31,
                "nome"     => "São Bento Abade",
            ],
            [
                "ibge_codigo"       => 3160900,
                "ibge_estado_id" => 31,
                "nome"     => "São Brás do Suaçuí",
            ],
            [
                "ibge_codigo"       => 3160959,
                "ibge_estado_id" => 31,
                "nome"     => "São Domingos das Dores",
            ],
            [
                "ibge_codigo"       => 3161007,
                "ibge_estado_id" => 31,
                "nome"     => "São Domingos do Prata",
            ],
            [
                "ibge_codigo"       => 3161056,
                "ibge_estado_id" => 31,
                "nome"     => "São Félix de Minas",
            ],
            [
                "ibge_codigo"       => 3161106,
                "ibge_estado_id" => 31,
                "nome"     => "São Francisco",
            ],
            [
                "ibge_codigo"       => 3161205,
                "ibge_estado_id" => 31,
                "nome"     => "São Francisco de Paula",
            ],
            [
                "ibge_codigo"       => 3161304,
                "ibge_estado_id" => 31,
                "nome"     => "São Francisco de Sales",
            ],
            [
                "ibge_codigo"       => 3161403,
                "ibge_estado_id" => 31,
                "nome"     => "São Francisco do Glória",
            ],
            [
                "ibge_codigo"       => 3161502,
                "ibge_estado_id" => 31,
                "nome"     => "São Geraldo",
            ],
            [
                "ibge_codigo"       => 3161601,
                "ibge_estado_id" => 31,
                "nome"     => "São Geraldo da Piedade",
            ],
            [
                "ibge_codigo"       => 3161650,
                "ibge_estado_id" => 31,
                "nome"     => "São Geraldo do Baixio",
            ],
            [
                "ibge_codigo"       => 3161700,
                "ibge_estado_id" => 31,
                "nome"     => "São Gonçalo do Abaeté",
            ],
            [
                "ibge_codigo"       => 3161809,
                "ibge_estado_id" => 31,
                "nome"     => "São Gonçalo do Pará",
            ],
            [
                "ibge_codigo"       => 3161908,
                "ibge_estado_id" => 31,
                "nome"     => "São Gonçalo do Rio Abaixo",
            ],
            [
                "ibge_codigo"       => 3162005,
                "ibge_estado_id" => 31,
                "nome"     => "São Gonçalo do Sapucaí",
            ],
            [
                "ibge_codigo"       => 3162104,
                "ibge_estado_id" => 31,
                "nome"     => "São Gotardo",
            ],
            [
                "ibge_codigo"       => 3162203,
                "ibge_estado_id" => 31,
                "nome"     => "São João Batista do Glória",
            ],
            [
                "ibge_codigo"       => 3162252,
                "ibge_estado_id" => 31,
                "nome"     => "São João da Lagoa",
            ],
            [
                "ibge_codigo"       => 3162302,
                "ibge_estado_id" => 31,
                "nome"     => "São João da Mata",
            ],
            [
                "ibge_codigo"       => 3162401,
                "ibge_estado_id" => 31,
                "nome"     => "São João da Ponte",
            ],
            [
                "ibge_codigo"       => 3162450,
                "ibge_estado_id" => 31,
                "nome"     => "São João das Missões",
            ],
            [
                "ibge_codigo"       => 3162500,
                "ibge_estado_id" => 31,
                "nome"     => "São João del Rei",
            ],
            [
                "ibge_codigo"       => 3162559,
                "ibge_estado_id" => 31,
                "nome"     => "São João do Manhuaçu",
            ],
            [
                "ibge_codigo"       => 3162575,
                "ibge_estado_id" => 31,
                "nome"     => "São João do Manteninha",
            ],
            [
                "ibge_codigo"       => 3162609,
                "ibge_estado_id" => 31,
                "nome"     => "São João do Oriente",
            ],
            [
                "ibge_codigo"       => 3162658,
                "ibge_estado_id" => 31,
                "nome"     => "São João do Pacuí",
            ],
            [
                "ibge_codigo"       => 3162708,
                "ibge_estado_id" => 31,
                "nome"     => "São João do Paraíso",
            ],
            [
                "ibge_codigo"       => 3162807,
                "ibge_estado_id" => 31,
                "nome"     => "São João Evangelista",
            ],
            [
                "ibge_codigo"       => 3162906,
                "ibge_estado_id" => 31,
                "nome"     => "São João Nepomuceno",
            ],
            [
                "ibge_codigo"       => 3162922,
                "ibge_estado_id" => 31,
                "nome"     => "São Joaquim de Bicas",
            ],
            [
                "ibge_codigo"       => 3162948,
                "ibge_estado_id" => 31,
                "nome"     => "São José da Barra",
            ],
            [
                "ibge_codigo"       => 3162955,
                "ibge_estado_id" => 31,
                "nome"     => "São José da Lapa",
            ],
            [
                "ibge_codigo"       => 3163003,
                "ibge_estado_id" => 31,
                "nome"     => "São José da Safira",
            ],
            [
                "ibge_codigo"       => 3163102,
                "ibge_estado_id" => 31,
                "nome"     => "São José da Varginha",
            ],
            [
                "ibge_codigo"       => 3163201,
                "ibge_estado_id" => 31,
                "nome"     => "São José do Alegre",
            ],
            [
                "ibge_codigo"       => 3163300,
                "ibge_estado_id" => 31,
                "nome"     => "São José do Divino",
            ],
            [
                "ibge_codigo"       => 3163409,
                "ibge_estado_id" => 31,
                "nome"     => "São José do Goiabal",
            ],
            [
                "ibge_codigo"       => 3163508,
                "ibge_estado_id" => 31,
                "nome"     => "São José do Jacuri",
            ],
            [
                "ibge_codigo"       => 3163607,
                "ibge_estado_id" => 31,
                "nome"     => "São José do Mantimento",
            ],
            [
                "ibge_codigo"       => 3163706,
                "ibge_estado_id" => 31,
                "nome"     => "São Lourenço",
            ],
            [
                "ibge_codigo"       => 3163805,
                "ibge_estado_id" => 31,
                "nome"     => "São Miguel do Anta",
            ],
            [
                "ibge_codigo"       => 3163904,
                "ibge_estado_id" => 31,
                "nome"     => "São Pedro da União",
            ],
            [
                "ibge_codigo"       => 3164001,
                "ibge_estado_id" => 31,
                "nome"     => "São Pedro dos Ferros",
            ],
            [
                "ibge_codigo"       => 3164100,
                "ibge_estado_id" => 31,
                "nome"     => "São Pedro do Suaçuí",
            ],
            [
                "ibge_codigo"       => 3164209,
                "ibge_estado_id" => 31,
                "nome"     => "São Romão",
            ],
            [
                "ibge_codigo"       => 3164308,
                "ibge_estado_id" => 31,
                "nome"     => "São Roque de Minas",
            ],
            [
                "ibge_codigo"       => 3164407,
                "ibge_estado_id" => 31,
                "nome"     => "São Sebastião da Bela Vista",
            ],
            [
                "ibge_codigo"       => 3164431,
                "ibge_estado_id" => 31,
                "nome"     => "São Sebastião da Vargem Alegre",
            ],
            [
                "ibge_codigo"       => 3164472,
                "ibge_estado_id" => 31,
                "nome"     => "São Sebastião do Anta",
            ],
            [
                "ibge_codigo"       => 3164506,
                "ibge_estado_id" => 31,
                "nome"     => "São Sebastião do Maranhão",
            ],
            [
                "ibge_codigo"       => 3164605,
                "ibge_estado_id" => 31,
                "nome"     => "São Sebastião do Oeste",
            ],
            [
                "ibge_codigo"       => 3164704,
                "ibge_estado_id" => 31,
                "nome"     => "São Sebastião do Paraíso",
            ],
            [
                "ibge_codigo"       => 3164803,
                "ibge_estado_id" => 31,
                "nome"     => "São Sebastião do Rio Preto",
            ],
            [
                "ibge_codigo"       => 3164902,
                "ibge_estado_id" => 31,
                "nome"     => "São Sebastião do Rio Verde",
            ],
            [
                "ibge_codigo"       => 3165008,
                "ibge_estado_id" => 31,
                "nome"     => "São Tiago",
            ],
            [
                "ibge_codigo"       => 3165107,
                "ibge_estado_id" => 31,
                "nome"     => "São Tomás de Aquino",
            ],
            [
                "ibge_codigo"       => 3165206,
                "ibge_estado_id" => 31,
                "nome"     => "São Thomé das Letras",
            ],
            [
                "ibge_codigo"       => 3165305,
                "ibge_estado_id" => 31,
                "nome"     => "São Vicente de Minas",
            ],
            [
                "ibge_codigo"       => 3165404,
                "ibge_estado_id" => 31,
                "nome"     => "Sapucaí-Mirim",
            ],
            [
                "ibge_codigo"       => 3165503,
                "ibge_estado_id" => 31,
                "nome"     => "Sardoá",
            ],
            [
                "ibge_codigo"       => 3165537,
                "ibge_estado_id" => 31,
                "nome"     => "Sarzedo",
            ],
            [
                "ibge_codigo"       => 3165552,
                "ibge_estado_id" => 31,
                "nome"     => "Setubinha",
            ],
            [
                "ibge_codigo"       => 3165560,
                "ibge_estado_id" => 31,
                "nome"     => "Sem-Peixe",
            ],
            [
                "ibge_codigo"       => 3165578,
                "ibge_estado_id" => 31,
                "nome"     => "Senador Amaral",
            ],
            [
                "ibge_codigo"       => 3165602,
                "ibge_estado_id" => 31,
                "nome"     => "Senador Cortes",
            ],
            [
                "ibge_codigo"       => 3165701,
                "ibge_estado_id" => 31,
                "nome"     => "Senador Firmino",
            ],
            [
                "ibge_codigo"       => 3165800,
                "ibge_estado_id" => 31,
                "nome"     => "Senador José Bento",
            ],
            [
                "ibge_codigo"       => 3165909,
                "ibge_estado_id" => 31,
                "nome"     => "Senador Modestino Gonçalves",
            ],
            [
                "ibge_codigo"       => 3166006,
                "ibge_estado_id" => 31,
                "nome"     => "Senhora de Oliveira",
            ],
            [
                "ibge_codigo"       => 3166105,
                "ibge_estado_id" => 31,
                "nome"     => "Senhora do Porto",
            ],
            [
                "ibge_codigo"       => 3166204,
                "ibge_estado_id" => 31,
                "nome"     => "Senhora dos Remédios",
            ],
            [
                "ibge_codigo"       => 3166303,
                "ibge_estado_id" => 31,
                "nome"     => "Sericita",
            ],
            [
                "ibge_codigo"       => 3166402,
                "ibge_estado_id" => 31,
                "nome"     => "Seritinga",
            ],
            [
                "ibge_codigo"       => 3166501,
                "ibge_estado_id" => 31,
                "nome"     => "Serra Azul de Minas",
            ],
            [
                "ibge_codigo"       => 3166600,
                "ibge_estado_id" => 31,
                "nome"     => "Serra da Saudade",
            ],
            [
                "ibge_codigo"       => 3166709,
                "ibge_estado_id" => 31,
                "nome"     => "Serra dos Aimorés",
            ],
            [
                "ibge_codigo"       => 3166808,
                "ibge_estado_id" => 31,
                "nome"     => "Serra do Salitre",
            ],
            [
                "ibge_codigo"       => 3166907,
                "ibge_estado_id" => 31,
                "nome"     => "Serrania",
            ],
            [
                "ibge_codigo"       => 3166956,
                "ibge_estado_id" => 31,
                "nome"     => "Serranópolis de Minas",
            ],
            [
                "ibge_codigo"       => 3167004,
                "ibge_estado_id" => 31,
                "nome"     => "Serranos",
            ],
            [
                "ibge_codigo"       => 3167103,
                "ibge_estado_id" => 31,
                "nome"     => "Serro",
            ],
            [
                "ibge_codigo"       => 3167202,
                "ibge_estado_id" => 31,
                "nome"     => "Sete Lagoas",
            ],
            [
                "ibge_codigo"       => 3167301,
                "ibge_estado_id" => 31,
                "nome"     => "Silveirânia",
            ],
            [
                "ibge_codigo"       => 3167400,
                "ibge_estado_id" => 31,
                "nome"     => "Silvianópolis",
            ],
            [
                "ibge_codigo"       => 3167509,
                "ibge_estado_id" => 31,
                "nome"     => "Simão Pereira",
            ],
            [
                "ibge_codigo"       => 3167608,
                "ibge_estado_id" => 31,
                "nome"     => "Simonésia",
            ],
            [
                "ibge_codigo"       => 3167707,
                "ibge_estado_id" => 31,
                "nome"     => "Sobrália",
            ],
            [
                "ibge_codigo"       => 3167806,
                "ibge_estado_id" => 31,
                "nome"     => "Soledade de Minas",
            ],
            [
                "ibge_codigo"       => 3167905,
                "ibge_estado_id" => 31,
                "nome"     => "Tabuleiro",
            ],
            [
                "ibge_codigo"       => 3168002,
                "ibge_estado_id" => 31,
                "nome"     => "Taiobeiras",
            ],
            [
                "ibge_codigo"       => 3168051,
                "ibge_estado_id" => 31,
                "nome"     => "Taparuba",
            ],
            [
                "ibge_codigo"       => 3168101,
                "ibge_estado_id" => 31,
                "nome"     => "Tapira",
            ],
            [
                "ibge_codigo"       => 3168200,
                "ibge_estado_id" => 31,
                "nome"     => "Tapiraí",
            ],
            [
                "ibge_codigo"       => 3168309,
                "ibge_estado_id" => 31,
                "nome"     => "Taquaraçu de Minas",
            ],
            [
                "ibge_codigo"       => 3168408,
                "ibge_estado_id" => 31,
                "nome"     => "Tarumirim",
            ],
            [
                "ibge_codigo"       => 3168507,
                "ibge_estado_id" => 31,
                "nome"     => "Teixeiras",
            ],
            [
                "ibge_codigo"       => 3168606,
                "ibge_estado_id" => 31,
                "nome"     => "Teófilo Otoni",
            ],
            [
                "ibge_codigo"       => 3168705,
                "ibge_estado_id" => 31,
                "nome"     => "Timóteo",
            ],
            [
                "ibge_codigo"       => 3168804,
                "ibge_estado_id" => 31,
                "nome"     => "Tiradentes",
            ],
            [
                "ibge_codigo"       => 3168903,
                "ibge_estado_id" => 31,
                "nome"     => "Tiros",
            ],
            [
                "ibge_codigo"       => 3169000,
                "ibge_estado_id" => 31,
                "nome"     => "Tocantins",
            ],
            [
                "ibge_codigo"       => 3169059,
                "ibge_estado_id" => 31,
                "nome"     => "Tocos do Moji",
            ],
            [
                "ibge_codigo"       => 3169109,
                "ibge_estado_id" => 31,
                "nome"     => "Toledo",
            ],
            [
                "ibge_codigo"       => 3169208,
                "ibge_estado_id" => 31,
                "nome"     => "Tombos",
            ],
            [
                "ibge_codigo"       => 3169307,
                "ibge_estado_id" => 31,
                "nome"     => "Três Corações",
            ],
            [
                "ibge_codigo"       => 3169356,
                "ibge_estado_id" => 31,
                "nome"     => "Três Marias",
            ],
            [
                "ibge_codigo"       => 3169406,
                "ibge_estado_id" => 31,
                "nome"     => "Três Pontas",
            ],
            [
                "ibge_codigo"       => 3169505,
                "ibge_estado_id" => 31,
                "nome"     => "Tumiritinga",
            ],
            [
                "ibge_codigo"       => 3169604,
                "ibge_estado_id" => 31,
                "nome"     => "Tupaciguara",
            ],
            [
                "ibge_codigo"       => 3169703,
                "ibge_estado_id" => 31,
                "nome"     => "Turmalina",
            ],
            [
                "ibge_codigo"       => 3169802,
                "ibge_estado_id" => 31,
                "nome"     => "Turvolândia",
            ],
            [
                "ibge_codigo"       => 3169901,
                "ibge_estado_id" => 31,
                "nome"     => "Ubá",
            ],
            [
                "ibge_codigo"       => 3170008,
                "ibge_estado_id" => 31,
                "nome"     => "Ubaí",
            ],
            [
                "ibge_codigo"       => 3170057,
                "ibge_estado_id" => 31,
                "nome"     => "Ubaporanga",
            ],
            [
                "ibge_codigo"       => 3170107,
                "ibge_estado_id" => 31,
                "nome"     => "Uberaba",
            ],
            [
                "ibge_codigo"       => 3170206,
                "ibge_estado_id" => 31,
                "nome"     => "Uberlândia",
            ],
            [
                "ibge_codigo"       => 3170305,
                "ibge_estado_id" => 31,
                "nome"     => "Umburatiba",
            ],
            [
                "ibge_codigo"       => 3170404,
                "ibge_estado_id" => 31,
                "nome"     => "Unaí",
            ],
            [
                "ibge_codigo"       => 3170438,
                "ibge_estado_id" => 31,
                "nome"     => "União de Minas",
            ],
            [
                "ibge_codigo"       => 3170479,
                "ibge_estado_id" => 31,
                "nome"     => "Uruana de Minas",
            ],
            [
                "ibge_codigo"       => 3170503,
                "ibge_estado_id" => 31,
                "nome"     => "Urucânia",
            ],
            [
                "ibge_codigo"       => 3170529,
                "ibge_estado_id" => 31,
                "nome"     => "Urucuia",
            ],
            [
                "ibge_codigo"       => 3170578,
                "ibge_estado_id" => 31,
                "nome"     => "Vargem Alegre",
            ],
            [
                "ibge_codigo"       => 3170602,
                "ibge_estado_id" => 31,
                "nome"     => "Vargem Bonita",
            ],
            [
                "ibge_codigo"       => 3170651,
                "ibge_estado_id" => 31,
                "nome"     => "Vargem Grande do Rio Pardo",
            ],
            [
                "ibge_codigo"       => 3170701,
                "ibge_estado_id" => 31,
                "nome"     => "Varginha",
            ],
            [
                "ibge_codigo"       => 3170750,
                "ibge_estado_id" => 31,
                "nome"     => "Varjão de Minas",
            ],
            [
                "ibge_codigo"       => 3170800,
                "ibge_estado_id" => 31,
                "nome"     => "Várzea da Palma",
            ],
            [
                "ibge_codigo"       => 3170909,
                "ibge_estado_id" => 31,
                "nome"     => "Varzelândia",
            ],
            [
                "ibge_codigo"       => 3171006,
                "ibge_estado_id" => 31,
                "nome"     => "Vazante",
            ],
            [
                "ibge_codigo"       => 3171030,
                "ibge_estado_id" => 31,
                "nome"     => "Verdelândia",
            ],
            [
                "ibge_codigo"       => 3171071,
                "ibge_estado_id" => 31,
                "nome"     => "Veredinha",
            ],
            [
                "ibge_codigo"       => 3171105,
                "ibge_estado_id" => 31,
                "nome"     => "Veríssimo",
            ],
            [
                "ibge_codigo"       => 3171154,
                "ibge_estado_id" => 31,
                "nome"     => "Vermelho Novo",
            ],
            [
                "ibge_codigo"       => 3171204,
                "ibge_estado_id" => 31,
                "nome"     => "Vespasiano",
            ],
            [
                "ibge_codigo"       => 3171303,
                "ibge_estado_id" => 31,
                "nome"     => "Viçosa",
            ],
            [
                "ibge_codigo"       => 3171402,
                "ibge_estado_id" => 31,
                "nome"     => "Vieiras",
            ],
            [
                "ibge_codigo"       => 3171501,
                "ibge_estado_id" => 31,
                "nome"     => "Mathias Lobato",
            ],
            [
                "ibge_codigo"       => 3171600,
                "ibge_estado_id" => 31,
                "nome"     => "Virgem da Lapa",
            ],
            [
                "ibge_codigo"       => 3171709,
                "ibge_estado_id" => 31,
                "nome"     => "Virgínia",
            ],
            [
                "ibge_codigo"       => 3171808,
                "ibge_estado_id" => 31,
                "nome"     => "Virginópolis",
            ],
            [
                "ibge_codigo"       => 3171907,
                "ibge_estado_id" => 31,
                "nome"     => "Virgolândia",
            ],
            [
                "ibge_codigo"       => 3172004,
                "ibge_estado_id" => 31,
                "nome"     => "Visconde do Rio Branco",
            ],
            [
                "ibge_codigo"       => 3172103,
                "ibge_estado_id" => 31,
                "nome"     => "Volta Grande",
            ],
            [
                "ibge_codigo"       => 3172202,
                "ibge_estado_id" => 31,
                "nome"     => "Wenceslau Braz",
            ],
            [
                "ibge_codigo"       => 3200102,
                "ibge_estado_id" => 32,
                "nome"     => "Afonso Cláudio",
            ],
            [
                "ibge_codigo"       => 3200136,
                "ibge_estado_id" => 32,
                "nome"     => "Águia Branca",
            ],
            [
                "ibge_codigo"       => 3200169,
                "ibge_estado_id" => 32,
                "nome"     => "Água Doce do Norte",
            ],
            [
                "ibge_codigo"       => 3200201,
                "ibge_estado_id" => 32,
                "nome"     => "Alegre",
            ],
            [
                "ibge_codigo"       => 3200300,
                "ibge_estado_id" => 32,
                "nome"     => "Alfredo Chaves",
            ],
            [
                "ibge_codigo"       => 3200359,
                "ibge_estado_id" => 32,
                "nome"     => "Alto Rio Novo",
            ],
            [
                "ibge_codigo"       => 3200409,
                "ibge_estado_id" => 32,
                "nome"     => "Anchieta",
            ],
            [
                "ibge_codigo"       => 3200508,
                "ibge_estado_id" => 32,
                "nome"     => "Apiacá",
            ],
            [
                "ibge_codigo"       => 3200607,
                "ibge_estado_id" => 32,
                "nome"     => "Aracruz",
            ],
            [
                "ibge_codigo"       => 3200706,
                "ibge_estado_id" => 32,
                "nome"     => "Atilio Vivacqua",
            ],
            [
                "ibge_codigo"       => 3200805,
                "ibge_estado_id" => 32,
                "nome"     => "Baixo Guandu",
            ],
            [
                "ibge_codigo"       => 3200904,
                "ibge_estado_id" => 32,
                "nome"     => "Barra de São Francisco",
            ],
            [
                "ibge_codigo"       => 3201001,
                "ibge_estado_id" => 32,
                "nome"     => "Boa Esperança",
            ],
            [
                "ibge_codigo"       => 3201100,
                "ibge_estado_id" => 32,
                "nome"     => "Bom Jesus do Norte",
            ],
            [
                "ibge_codigo"       => 3201159,
                "ibge_estado_id" => 32,
                "nome"     => "Brejetuba",
            ],
            [
                "ibge_codigo"       => 3201209,
                "ibge_estado_id" => 32,
                "nome"     => "Cachoeiro de Itapemirim",
            ],
            [
                "ibge_codigo"       => 3201308,
                "ibge_estado_id" => 32,
                "nome"     => "Cariacica",
            ],
            [
                "ibge_codigo"       => 3201407,
                "ibge_estado_id" => 32,
                "nome"     => "Castelo",
            ],
            [
                "ibge_codigo"       => 3201506,
                "ibge_estado_id" => 32,
                "nome"     => "Colatina",
            ],
            [
                "ibge_codigo"       => 3201605,
                "ibge_estado_id" => 32,
                "nome"     => "Conceição da Barra",
            ],
            [
                "ibge_codigo"       => 3201704,
                "ibge_estado_id" => 32,
                "nome"     => "Conceição do Castelo",
            ],
            [
                "ibge_codigo"       => 3201803,
                "ibge_estado_id" => 32,
                "nome"     => "Divino de São Lourenço",
            ],
            [
                "ibge_codigo"       => 3201902,
                "ibge_estado_id" => 32,
                "nome"     => "Domingos Martins",
            ],
            [
                "ibge_codigo"       => 3202009,
                "ibge_estado_id" => 32,
                "nome"     => "Dores do Rio Preto",
            ],
            [
                "ibge_codigo"       => 3202108,
                "ibge_estado_id" => 32,
                "nome"     => "Ecoporanga",
            ],
            [
                "ibge_codigo"       => 3202207,
                "ibge_estado_id" => 32,
                "nome"     => "Fundão",
            ],
            [
                "ibge_codigo"       => 3202256,
                "ibge_estado_id" => 32,
                "nome"     => "Governador Lindenberg",
            ],
            [
                "ibge_codigo"       => 3202306,
                "ibge_estado_id" => 32,
                "nome"     => "Guaçuí",
            ],
            [
                "ibge_codigo"       => 3202405,
                "ibge_estado_id" => 32,
                "nome"     => "Guarapari",
            ],
            [
                "ibge_codigo"       => 3202454,
                "ibge_estado_id" => 32,
                "nome"     => "Ibatiba",
            ],
            [
                "ibge_codigo"       => 3202504,
                "ibge_estado_id" => 32,
                "nome"     => "Ibiraçu",
            ],
            [
                "ibge_codigo"       => 3202553,
                "ibge_estado_id" => 32,
                "nome"     => "Ibitirama",
            ],
            [
                "ibge_codigo"       => 3202603,
                "ibge_estado_id" => 32,
                "nome"     => "Iconha",
            ],
            [
                "ibge_codigo"       => 3202652,
                "ibge_estado_id" => 32,
                "nome"     => "Irupi",
            ],
            [
                "ibge_codigo"       => 3202702,
                "ibge_estado_id" => 32,
                "nome"     => "Itaguaçu",
            ],
            [
                "ibge_codigo"       => 3202801,
                "ibge_estado_id" => 32,
                "nome"     => "Itapemirim",
            ],
            [
                "ibge_codigo"       => 3202900,
                "ibge_estado_id" => 32,
                "nome"     => "Itarana",
            ],
            [
                "ibge_codigo"       => 3203007,
                "ibge_estado_id" => 32,
                "nome"     => "Iúna",
            ],
            [
                "ibge_codigo"       => 3203056,
                "ibge_estado_id" => 32,
                "nome"     => "Jaguaré",
            ],
            [
                "ibge_codigo"       => 3203106,
                "ibge_estado_id" => 32,
                "nome"     => "Jerônimo Monteiro",
            ],
            [
                "ibge_codigo"       => 3203130,
                "ibge_estado_id" => 32,
                "nome"     => "João Neiva",
            ],
            [
                "ibge_codigo"       => 3203163,
                "ibge_estado_id" => 32,
                "nome"     => "Laranja da Terra",
            ],
            [
                "ibge_codigo"       => 3203205,
                "ibge_estado_id" => 32,
                "nome"     => "Linhares",
            ],
            [
                "ibge_codigo"       => 3203304,
                "ibge_estado_id" => 32,
                "nome"     => "Mantenópolis",
            ],
            [
                "ibge_codigo"       => 3203320,
                "ibge_estado_id" => 32,
                "nome"     => "Marataízes",
            ],
            [
                "ibge_codigo"       => 3203346,
                "ibge_estado_id" => 32,
                "nome"     => "Marechal Floriano",
            ],
            [
                "ibge_codigo"       => 3203353,
                "ibge_estado_id" => 32,
                "nome"     => "Marilândia",
            ],
            [
                "ibge_codigo"       => 3203403,
                "ibge_estado_id" => 32,
                "nome"     => "Mimoso do Sul",
            ],
            [
                "ibge_codigo"       => 3203502,
                "ibge_estado_id" => 32,
                "nome"     => "Montanha",
            ],
            [
                "ibge_codigo"       => 3203601,
                "ibge_estado_id" => 32,
                "nome"     => "Mucurici",
            ],
            [
                "ibge_codigo"       => 3203700,
                "ibge_estado_id" => 32,
                "nome"     => "Muniz Freire",
            ],
            [
                "ibge_codigo"       => 3203809,
                "ibge_estado_id" => 32,
                "nome"     => "Muqui",
            ],
            [
                "ibge_codigo"       => 3203908,
                "ibge_estado_id" => 32,
                "nome"     => "Nova Venécia",
            ],
            [
                "ibge_codigo"       => 3204005,
                "ibge_estado_id" => 32,
                "nome"     => "Pancas",
            ],
            [
                "ibge_codigo"       => 3204054,
                "ibge_estado_id" => 32,
                "nome"     => "Pedro Canário",
            ],
            [
                "ibge_codigo"       => 3204104,
                "ibge_estado_id" => 32,
                "nome"     => "Pinheiros",
            ],
            [
                "ibge_codigo"       => 3204203,
                "ibge_estado_id" => 32,
                "nome"     => "Piúma",
            ],
            [
                "ibge_codigo"       => 3204252,
                "ibge_estado_id" => 32,
                "nome"     => "Ponto Belo",
            ],
            [
                "ibge_codigo"       => 3204302,
                "ibge_estado_id" => 32,
                "nome"     => "Presidente Kennedy",
            ],
            [
                "ibge_codigo"       => 3204351,
                "ibge_estado_id" => 32,
                "nome"     => "Rio Bananal",
            ],
            [
                "ibge_codigo"       => 3204401,
                "ibge_estado_id" => 32,
                "nome"     => "Rio Novo do Sul",
            ],
            [
                "ibge_codigo"       => 3204500,
                "ibge_estado_id" => 32,
                "nome"     => "Santa Leopoldina",
            ],
            [
                "ibge_codigo"       => 3204559,
                "ibge_estado_id" => 32,
                "nome"     => "Santa Maria de Jetibá",
            ],
            [
                "ibge_codigo"       => 3204609,
                "ibge_estado_id" => 32,
                "nome"     => "Santa Teresa",
            ],
            [
                "ibge_codigo"       => 3204658,
                "ibge_estado_id" => 32,
                "nome"     => "São Domingos do Norte",
            ],
            [
                "ibge_codigo"       => 3204708,
                "ibge_estado_id" => 32,
                "nome"     => "São Gabriel da Palha",
            ],
            [
                "ibge_codigo"       => 3204807,
                "ibge_estado_id" => 32,
                "nome"     => "São José do Calçado",
            ],
            [
                "ibge_codigo"       => 3204906,
                "ibge_estado_id" => 32,
                "nome"     => "São Mateus",
            ],
            [
                "ibge_codigo"       => 3204955,
                "ibge_estado_id" => 32,
                "nome"     => "São Roque do Canaã",
            ],
            [
                "ibge_codigo"       => 3205002,
                "ibge_estado_id" => 32,
                "nome"     => "Serra",
            ],
            [
                "ibge_codigo"       => 3205010,
                "ibge_estado_id" => 32,
                "nome"     => "Sooretama",
            ],
            [
                "ibge_codigo"       => 3205036,
                "ibge_estado_id" => 32,
                "nome"     => "Vargem Alta",
            ],
            [
                "ibge_codigo"       => 3205069,
                "ibge_estado_id" => 32,
                "nome"     => "Venda Nova do Imigrante",
            ],
            [
                "ibge_codigo"       => 3205101,
                "ibge_estado_id" => 32,
                "nome"     => "Viana",
            ],
            [
                "ibge_codigo"       => 3205150,
                "ibge_estado_id" => 32,
                "nome"     => "Vila Pavão",
            ],
            [
                "ibge_codigo"       => 3205176,
                "ibge_estado_id" => 32,
                "nome"     => "Vila Valério",
            ],
            [
                "ibge_codigo"       => 3205200,
                "ibge_estado_id" => 32,
                "nome"     => "Vila Velha",
            ],
            [
                "ibge_codigo"       => 3205309,
                "ibge_estado_id" => 32,
                "nome"     => "Vitória",
            ],
            [
                "ibge_codigo"       => 3300100,
                "ibge_estado_id" => 33,
                "nome"     => "Angra dos Reis",
            ],
            [
                "ibge_codigo"       => 3300159,
                "ibge_estado_id" => 33,
                "nome"     => "Aperibé",
            ],
            [
                "ibge_codigo"       => 3300209,
                "ibge_estado_id" => 33,
                "nome"     => "Araruama",
            ],
            [
                "ibge_codigo"       => 3300225,
                "ibge_estado_id" => 33,
                "nome"     => "Areal",
            ],
            [
                "ibge_codigo"       => 3300233,
                "ibge_estado_id" => 33,
                "nome"     => "Armação dos Búzios",
            ],
            [
                "ibge_codigo"       => 3300258,
                "ibge_estado_id" => 33,
                "nome"     => "Arraial do Cabo",
            ],
            [
                "ibge_codigo"       => 3300308,
                "ibge_estado_id" => 33,
                "nome"     => "Barra do Piraí",
            ],
            [
                "ibge_codigo"       => 3300407,
                "ibge_estado_id" => 33,
                "nome"     => "Barra Mansa",
            ],
            [
                "ibge_codigo"       => 3300456,
                "ibge_estado_id" => 33,
                "nome"     => "Belford Roxo",
            ],
            [
                "ibge_codigo"       => 3300506,
                "ibge_estado_id" => 33,
                "nome"     => "Bom Jardim",
            ],
            [
                "ibge_codigo"       => 3300605,
                "ibge_estado_id" => 33,
                "nome"     => "Bom Jesus do Itabapoana",
            ],
            [
                "ibge_codigo"       => 3300704,
                "ibge_estado_id" => 33,
                "nome"     => "Cabo Frio",
            ],
            [
                "ibge_codigo"       => 3300803,
                "ibge_estado_id" => 33,
                "nome"     => "Cachoeiras de Macacu",
            ],
            [
                "ibge_codigo"       => 3300902,
                "ibge_estado_id" => 33,
                "nome"     => "Cambuci",
            ],
            [
                "ibge_codigo"       => 3300936,
                "ibge_estado_id" => 33,
                "nome"     => "Carapebus",
            ],
            [
                "ibge_codigo"       => 3300951,
                "ibge_estado_id" => 33,
                "nome"     => "Comendador Levy Gasparian",
            ],
            [
                "ibge_codigo"       => 3301009,
                "ibge_estado_id" => 33,
                "nome"     => "Campos dos Goytacazes",
            ],
            [
                "ibge_codigo"       => 3301108,
                "ibge_estado_id" => 33,
                "nome"     => "Cantagalo",
            ],
            [
                "ibge_codigo"       => 3301157,
                "ibge_estado_id" => 33,
                "nome"     => "Cardoso Moreira",
            ],
            [
                "ibge_codigo"       => 3301207,
                "ibge_estado_id" => 33,
                "nome"     => "Carmo",
            ],
            [
                "ibge_codigo"       => 3301306,
                "ibge_estado_id" => 33,
                "nome"     => "Casimiro de Abreu",
            ],
            [
                "ibge_codigo"       => 3301405,
                "ibge_estado_id" => 33,
                "nome"     => "Conceição de Macabu",
            ],
            [
                "ibge_codigo"       => 3301504,
                "ibge_estado_id" => 33,
                "nome"     => "Cordeiro",
            ],
            [
                "ibge_codigo"       => 3301603,
                "ibge_estado_id" => 33,
                "nome"     => "Duas Barras",
            ],
            [
                "ibge_codigo"       => 3301702,
                "ibge_estado_id" => 33,
                "nome"     => "Duque de Caxias",
            ],
            [
                "ibge_codigo"       => 3301801,
                "ibge_estado_id" => 33,
                "nome"     => "Engenheiro Paulo de Frontin",
            ],
            [
                "ibge_codigo"       => 3301850,
                "ibge_estado_id" => 33,
                "nome"     => "Guapimirim",
            ],
            [
                "ibge_codigo"       => 3301876,
                "ibge_estado_id" => 33,
                "nome"     => "Iguaba Grande",
            ],
            [
                "ibge_codigo"       => 3301900,
                "ibge_estado_id" => 33,
                "nome"     => "Itaboraí",
            ],
            [
                "ibge_codigo"       => 3302007,
                "ibge_estado_id" => 33,
                "nome"     => "Itaguaí",
            ],
            [
                "ibge_codigo"       => 3302056,
                "ibge_estado_id" => 33,
                "nome"     => "Italva",
            ],
            [
                "ibge_codigo"       => 3302106,
                "ibge_estado_id" => 33,
                "nome"     => "Itaocara",
            ],
            [
                "ibge_codigo"       => 3302205,
                "ibge_estado_id" => 33,
                "nome"     => "Itaperuna",
            ],
            [
                "ibge_codigo"       => 3302254,
                "ibge_estado_id" => 33,
                "nome"     => "Itatiaia",
            ],
            [
                "ibge_codigo"       => 3302270,
                "ibge_estado_id" => 33,
                "nome"     => "Japeri",
            ],
            [
                "ibge_codigo"       => 3302304,
                "ibge_estado_id" => 33,
                "nome"     => "Laje do Muriaé",
            ],
            [
                "ibge_codigo"       => 3302403,
                "ibge_estado_id" => 33,
                "nome"     => "Macaé",
            ],
            [
                "ibge_codigo"       => 3302452,
                "ibge_estado_id" => 33,
                "nome"     => "Macuco",
            ],
            [
                "ibge_codigo"       => 3302502,
                "ibge_estado_id" => 33,
                "nome"     => "Magé",
            ],
            [
                "ibge_codigo"       => 3302601,
                "ibge_estado_id" => 33,
                "nome"     => "Mangaratiba",
            ],
            [
                "ibge_codigo"       => 3302700,
                "ibge_estado_id" => 33,
                "nome"     => "Maricá",
            ],
            [
                "ibge_codigo"       => 3302809,
                "ibge_estado_id" => 33,
                "nome"     => "Mendes",
            ],
            [
                "ibge_codigo"       => 3302858,
                "ibge_estado_id" => 33,
                "nome"     => "Mesquita",
            ],
            [
                "ibge_codigo"       => 3302908,
                "ibge_estado_id" => 33,
                "nome"     => "Miguel Pereira",
            ],
            [
                "ibge_codigo"       => 3303005,
                "ibge_estado_id" => 33,
                "nome"     => "Miracema",
            ],
            [
                "ibge_codigo"       => 3303104,
                "ibge_estado_id" => 33,
                "nome"     => "Natividade",
            ],
            [
                "ibge_codigo"       => 3303203,
                "ibge_estado_id" => 33,
                "nome"     => "Nilópolis",
            ],
            [
                "ibge_codigo"       => 3303302,
                "ibge_estado_id" => 33,
                "nome"     => "Niterói",
            ],
            [
                "ibge_codigo"       => 3303401,
                "ibge_estado_id" => 33,
                "nome"     => "Nova Friburgo",
            ],
            [
                "ibge_codigo"       => 3303500,
                "ibge_estado_id" => 33,
                "nome"     => "Nova Iguaçu",
            ],
            [
                "ibge_codigo"       => 3303609,
                "ibge_estado_id" => 33,
                "nome"     => "Paracambi",
            ],
            [
                "ibge_codigo"       => 3303708,
                "ibge_estado_id" => 33,
                "nome"     => "Paraíba do Sul",
            ],
            [
                "ibge_codigo"       => 3303807,
                "ibge_estado_id" => 33,
                "nome"     => "Paraty",
            ],
            [
                "ibge_codigo"       => 3303856,
                "ibge_estado_id" => 33,
                "nome"     => "Paty do Alferes",
            ],
            [
                "ibge_codigo"       => 3303906,
                "ibge_estado_id" => 33,
                "nome"     => "Petrópolis",
            ],
            [
                "ibge_codigo"       => 3303955,
                "ibge_estado_id" => 33,
                "nome"     => "Pinheiral",
            ],
            [
                "ibge_codigo"       => 3304003,
                "ibge_estado_id" => 33,
                "nome"     => "Piraí",
            ],
            [
                "ibge_codigo"       => 3304102,
                "ibge_estado_id" => 33,
                "nome"     => "Porciúncula",
            ],
            [
                "ibge_codigo"       => 3304110,
                "ibge_estado_id" => 33,
                "nome"     => "Porto Real",
            ],
            [
                "ibge_codigo"       => 3304128,
                "ibge_estado_id" => 33,
                "nome"     => "Quatis",
            ],
            [
                "ibge_codigo"       => 3304144,
                "ibge_estado_id" => 33,
                "nome"     => "Queimados",
            ],
            [
                "ibge_codigo"       => 3304151,
                "ibge_estado_id" => 33,
                "nome"     => "Quissamã",
            ],
            [
                "ibge_codigo"       => 3304201,
                "ibge_estado_id" => 33,
                "nome"     => "Resende",
            ],
            [
                "ibge_codigo"       => 3304300,
                "ibge_estado_id" => 33,
                "nome"     => "Rio Bonito",
            ],
            [
                "ibge_codigo"       => 3304409,
                "ibge_estado_id" => 33,
                "nome"     => "Rio Claro",
            ],
            [
                "ibge_codigo"       => 3304508,
                "ibge_estado_id" => 33,
                "nome"     => "Rio das Flores",
            ],
            [
                "ibge_codigo"       => 3304524,
                "ibge_estado_id" => 33,
                "nome"     => "Rio das Ostras",
            ],
            [
                "ibge_codigo"       => 3304557,
                "ibge_estado_id" => 33,
                "nome"     => "Rio de Janeiro",
            ],
            [
                "ibge_codigo"       => 3304607,
                "ibge_estado_id" => 33,
                "nome"     => "Santa Maria Madalena",
            ],
            [
                "ibge_codigo"       => 3304706,
                "ibge_estado_id" => 33,
                "nome"     => "Santo Antônio de Pádua",
            ],
            [
                "ibge_codigo"       => 3304755,
                "ibge_estado_id" => 33,
                "nome"     => "São Francisco de Itabapoana",
            ],
            [
                "ibge_codigo"       => 3304805,
                "ibge_estado_id" => 33,
                "nome"     => "São Fidélis",
            ],
            [
                "ibge_codigo"       => 3304904,
                "ibge_estado_id" => 33,
                "nome"     => "São Gonçalo",
            ],
            [
                "ibge_codigo"       => 3305000,
                "ibge_estado_id" => 33,
                "nome"     => "São João da Barra",
            ],
            [
                "ibge_codigo"       => 3305109,
                "ibge_estado_id" => 33,
                "nome"     => "São João de Meriti",
            ],
            [
                "ibge_codigo"       => 3305133,
                "ibge_estado_id" => 33,
                "nome"     => "São José de Ubá",
            ],
            [
                "ibge_codigo"       => 3305158,
                "ibge_estado_id" => 33,
                "nome"     => "São José do Vale do Rio Preto",
            ],
            [
                "ibge_codigo"       => 3305208,
                "ibge_estado_id" => 33,
                "nome"     => "São Pedro da Aldeia",
            ],
            [
                "ibge_codigo"       => 3305307,
                "ibge_estado_id" => 33,
                "nome"     => "São Sebastião do Alto",
            ],
            [
                "ibge_codigo"       => 3305406,
                "ibge_estado_id" => 33,
                "nome"     => "Sapucaia",
            ],
            [
                "ibge_codigo"       => 3305505,
                "ibge_estado_id" => 33,
                "nome"     => "Saquarema",
            ],
            [
                "ibge_codigo"       => 3305554,
                "ibge_estado_id" => 33,
                "nome"     => "Seropédica",
            ],
            [
                "ibge_codigo"       => 3305604,
                "ibge_estado_id" => 33,
                "nome"     => "Silva Jardim",
            ],
            [
                "ibge_codigo"       => 3305703,
                "ibge_estado_id" => 33,
                "nome"     => "Sumidouro",
            ],
            [
                "ibge_codigo"       => 3305752,
                "ibge_estado_id" => 33,
                "nome"     => "Tanguá",
            ],
            [
                "ibge_codigo"       => 3305802,
                "ibge_estado_id" => 33,
                "nome"     => "Teresópolis",
            ],
            [
                "ibge_codigo"       => 3305901,
                "ibge_estado_id" => 33,
                "nome"     => "Trajano de Moraes",
            ],
            [
                "ibge_codigo"       => 3306008,
                "ibge_estado_id" => 33,
                "nome"     => "Três Rios",
            ],
            [
                "ibge_codigo"       => 3306107,
                "ibge_estado_id" => 33,
                "nome"     => "Valença",
            ],
            [
                "ibge_codigo"       => 3306156,
                "ibge_estado_id" => 33,
                "nome"     => "Varre-Sai",
            ],
            [
                "ibge_codigo"       => 3306206,
                "ibge_estado_id" => 33,
                "nome"     => "Vassouras",
            ],
            [
                "ibge_codigo"       => 3306305,
                "ibge_estado_id" => 33,
                "nome"     => "Volta Redonda",
            ],
            [
                "ibge_codigo"       => 3500105,
                "ibge_estado_id" => 35,
                "nome"     => "Adamantina",
            ],
            [
                "ibge_codigo"       => 3500204,
                "ibge_estado_id" => 35,
                "nome"     => "Adolfo",
            ],
            [
                "ibge_codigo"       => 3500303,
                "ibge_estado_id" => 35,
                "nome"     => "Aguaí",
            ],
            [
                "ibge_codigo"       => 3500402,
                "ibge_estado_id" => 35,
                "nome"     => "Águas da Prata",
            ],
            [
                "ibge_codigo"       => 3500501,
                "ibge_estado_id" => 35,
                "nome"     => "Águas de Lindóia",
            ],
            [
                "ibge_codigo"       => 3500550,
                "ibge_estado_id" => 35,
                "nome"     => "Águas de Santa Bárbara",
            ],
            [
                "ibge_codigo"       => 3500600,
                "ibge_estado_id" => 35,
                "nome"     => "Águas de São Pedro",
            ],
            [
                "ibge_codigo"       => 3500709,
                "ibge_estado_id" => 35,
                "nome"     => "Agudos",
            ],
            [
                "ibge_codigo"       => 3500758,
                "ibge_estado_id" => 35,
                "nome"     => "Alambari",
            ],
            [
                "ibge_codigo"       => 3500808,
                "ibge_estado_id" => 35,
                "nome"     => "Alfredo Marcondes",
            ],
            [
                "ibge_codigo"       => 3500907,
                "ibge_estado_id" => 35,
                "nome"     => "Altair",
            ],
            [
                "ibge_codigo"       => 3501004,
                "ibge_estado_id" => 35,
                "nome"     => "Altinópolis",
            ],
            [
                "ibge_codigo"       => 3501103,
                "ibge_estado_id" => 35,
                "nome"     => "Alto Alegre",
            ],
            [
                "ibge_codigo"       => 3501152,
                "ibge_estado_id" => 35,
                "nome"     => "Alumínio",
            ],
            [
                "ibge_codigo"       => 3501202,
                "ibge_estado_id" => 35,
                "nome"     => "Álvares Florence",
            ],
            [
                "ibge_codigo"       => 3501301,
                "ibge_estado_id" => 35,
                "nome"     => "Álvares Machado",
            ],
            [
                "ibge_codigo"       => 3501400,
                "ibge_estado_id" => 35,
                "nome"     => "Álvaro de Carvalho",
            ],
            [
                "ibge_codigo"       => 3501509,
                "ibge_estado_id" => 35,
                "nome"     => "Alvinlândia",
            ],
            [
                "ibge_codigo"       => 3501608,
                "ibge_estado_id" => 35,
                "nome"     => "Americana",
            ],
            [
                "ibge_codigo"       => 3501707,
                "ibge_estado_id" => 35,
                "nome"     => "Américo Brasiliense",
            ],
            [
                "ibge_codigo"       => 3501806,
                "ibge_estado_id" => 35,
                "nome"     => "Américo de Campos",
            ],
            [
                "ibge_codigo"       => 3501905,
                "ibge_estado_id" => 35,
                "nome"     => "Amparo",
            ],
            [
                "ibge_codigo"       => 3502002,
                "ibge_estado_id" => 35,
                "nome"     => "Analândia",
            ],
            [
                "ibge_codigo"       => 3502101,
                "ibge_estado_id" => 35,
                "nome"     => "Andradina",
            ],
            [
                "ibge_codigo"       => 3502200,
                "ibge_estado_id" => 35,
                "nome"     => "Angatuba",
            ],
            [
                "ibge_codigo"       => 3502309,
                "ibge_estado_id" => 35,
                "nome"     => "Anhembi",
            ],
            [
                "ibge_codigo"       => 3502408,
                "ibge_estado_id" => 35,
                "nome"     => "Anhumas",
            ],
            [
                "ibge_codigo"       => 3502507,
                "ibge_estado_id" => 35,
                "nome"     => "Aparecida",
            ],
            [
                "ibge_codigo"       => 3502606,
                "ibge_estado_id" => 35,
                "nome"     => "Aparecida d'Oeste",
            ],
            [
                "ibge_codigo"       => 3502705,
                "ibge_estado_id" => 35,
                "nome"     => "Apiaí",
            ],
            [
                "ibge_codigo"       => 3502754,
                "ibge_estado_id" => 35,
                "nome"     => "Araçariguama",
            ],
            [
                "ibge_codigo"       => 3502804,
                "ibge_estado_id" => 35,
                "nome"     => "Araçatuba",
            ],
            [
                "ibge_codigo"       => 3502903,
                "ibge_estado_id" => 35,
                "nome"     => "Araçoiaba da Serra",
            ],
            [
                "ibge_codigo"       => 3503000,
                "ibge_estado_id" => 35,
                "nome"     => "Aramina",
            ],
            [
                "ibge_codigo"       => 3503109,
                "ibge_estado_id" => 35,
                "nome"     => "Arandu",
            ],
            [
                "ibge_codigo"       => 3503158,
                "ibge_estado_id" => 35,
                "nome"     => "Arapeí",
            ],
            [
                "ibge_codigo"       => 3503208,
                "ibge_estado_id" => 35,
                "nome"     => "Araraquara",
            ],
            [
                "ibge_codigo"       => 3503307,
                "ibge_estado_id" => 35,
                "nome"     => "Araras",
            ],
            [
                "ibge_codigo"       => 3503356,
                "ibge_estado_id" => 35,
                "nome"     => "Arco-Íris",
            ],
            [
                "ibge_codigo"       => 3503406,
                "ibge_estado_id" => 35,
                "nome"     => "Arealva",
            ],
            [
                "ibge_codigo"       => 3503505,
                "ibge_estado_id" => 35,
                "nome"     => "Areias",
            ],
            [
                "ibge_codigo"       => 3503604,
                "ibge_estado_id" => 35,
                "nome"     => "Areiópolis",
            ],
            [
                "ibge_codigo"       => 3503703,
                "ibge_estado_id" => 35,
                "nome"     => "Ariranha",
            ],
            [
                "ibge_codigo"       => 3503802,
                "ibge_estado_id" => 35,
                "nome"     => "Artur Nogueira",
            ],
            [
                "ibge_codigo"       => 3503901,
                "ibge_estado_id" => 35,
                "nome"     => "Arujá",
            ],
            [
                "ibge_codigo"       => 3503950,
                "ibge_estado_id" => 35,
                "nome"     => "Aspásia",
            ],
            [
                "ibge_codigo"       => 3504008,
                "ibge_estado_id" => 35,
                "nome"     => "Assis",
            ],
            [
                "ibge_codigo"       => 3504107,
                "ibge_estado_id" => 35,
                "nome"     => "Atibaia",
            ],
            [
                "ibge_codigo"       => 3504206,
                "ibge_estado_id" => 35,
                "nome"     => "Auriflama",
            ],
            [
                "ibge_codigo"       => 3504305,
                "ibge_estado_id" => 35,
                "nome"     => "Avaí",
            ],
            [
                "ibge_codigo"       => 3504404,
                "ibge_estado_id" => 35,
                "nome"     => "Avanhandava",
            ],
            [
                "ibge_codigo"       => 3504503,
                "ibge_estado_id" => 35,
                "nome"     => "Avaré",
            ],
            [
                "ibge_codigo"       => 3504602,
                "ibge_estado_id" => 35,
                "nome"     => "Bady Bassitt",
            ],
            [
                "ibge_codigo"       => 3504701,
                "ibge_estado_id" => 35,
                "nome"     => "Balbinos",
            ],
            [
                "ibge_codigo"       => 3504800,
                "ibge_estado_id" => 35,
                "nome"     => "Bálsamo",
            ],
            [
                "ibge_codigo"       => 3504909,
                "ibge_estado_id" => 35,
                "nome"     => "Bananal",
            ],
            [
                "ibge_codigo"       => 3505005,
                "ibge_estado_id" => 35,
                "nome"     => "Barão de Antonina",
            ],
            [
                "ibge_codigo"       => 3505104,
                "ibge_estado_id" => 35,
                "nome"     => "Barbosa",
            ],
            [
                "ibge_codigo"       => 3505203,
                "ibge_estado_id" => 35,
                "nome"     => "Bariri",
            ],
            [
                "ibge_codigo"       => 3505302,
                "ibge_estado_id" => 35,
                "nome"     => "Barra Bonita",
            ],
            [
                "ibge_codigo"       => 3505351,
                "ibge_estado_id" => 35,
                "nome"     => "Barra do Chapéu",
            ],
            [
                "ibge_codigo"       => 3505401,
                "ibge_estado_id" => 35,
                "nome"     => "Barra do Turvo",
            ],
            [
                "ibge_codigo"       => 3505500,
                "ibge_estado_id" => 35,
                "nome"     => "Barretos",
            ],
            [
                "ibge_codigo"       => 3505609,
                "ibge_estado_id" => 35,
                "nome"     => "Barrinha",
            ],
            [
                "ibge_codigo"       => 3505708,
                "ibge_estado_id" => 35,
                "nome"     => "Barueri",
            ],
            [
                "ibge_codigo"       => 3505807,
                "ibge_estado_id" => 35,
                "nome"     => "Bastos",
            ],
            [
                "ibge_codigo"       => 3505906,
                "ibge_estado_id" => 35,
                "nome"     => "Batatais",
            ],
            [
                "ibge_codigo"       => 3506003,
                "ibge_estado_id" => 35,
                "nome"     => "Bauru",
            ],
            [
                "ibge_codigo"       => 3506102,
                "ibge_estado_id" => 35,
                "nome"     => "Bebedouro",
            ],
            [
                "ibge_codigo"       => 3506201,
                "ibge_estado_id" => 35,
                "nome"     => "Bento de Abreu",
            ],
            [
                "ibge_codigo"       => 3506300,
                "ibge_estado_id" => 35,
                "nome"     => "Bernardino de Campos",
            ],
            [
                "ibge_codigo"       => 3506359,
                "ibge_estado_id" => 35,
                "nome"     => "Bertioga",
            ],
            [
                "ibge_codigo"       => 3506409,
                "ibge_estado_id" => 35,
                "nome"     => "Bilac",
            ],
            [
                "ibge_codigo"       => 3506508,
                "ibge_estado_id" => 35,
                "nome"     => "Birigui",
            ],
            [
                "ibge_codigo"       => 3506607,
                "ibge_estado_id" => 35,
                "nome"     => "Biritiba-Mirim",
            ],
            [
                "ibge_codigo"       => 3506706,
                "ibge_estado_id" => 35,
                "nome"     => "Boa Esperança do Sul",
            ],
            [
                "ibge_codigo"       => 3506805,
                "ibge_estado_id" => 35,
                "nome"     => "Bocaina",
            ],
            [
                "ibge_codigo"       => 3506904,
                "ibge_estado_id" => 35,
                "nome"     => "Bofete",
            ],
            [
                "ibge_codigo"       => 3507001,
                "ibge_estado_id" => 35,
                "nome"     => "Boituva",
            ],
            [
                "ibge_codigo"       => 3507100,
                "ibge_estado_id" => 35,
                "nome"     => "Bom Jesus dos Perdões",
            ],
            [
                "ibge_codigo"       => 3507159,
                "ibge_estado_id" => 35,
                "nome"     => "Bom Sucesso de Itararé",
            ],
            [
                "ibge_codigo"       => 3507209,
                "ibge_estado_id" => 35,
                "nome"     => "Borá",
            ],
            [
                "ibge_codigo"       => 3507308,
                "ibge_estado_id" => 35,
                "nome"     => "Boracéia",
            ],
            [
                "ibge_codigo"       => 3507407,
                "ibge_estado_id" => 35,
                "nome"     => "Borborema",
            ],
            [
                "ibge_codigo"       => 3507456,
                "ibge_estado_id" => 35,
                "nome"     => "Borebi",
            ],
            [
                "ibge_codigo"       => 3507506,
                "ibge_estado_id" => 35,
                "nome"     => "Botucatu",
            ],
            [
                "ibge_codigo"       => 3507605,
                "ibge_estado_id" => 35,
                "nome"     => "Bragança Paulista",
            ],
            [
                "ibge_codigo"       => 3507704,
                "ibge_estado_id" => 35,
                "nome"     => "Braúna",
            ],
            [
                "ibge_codigo"       => 3507753,
                "ibge_estado_id" => 35,
                "nome"     => "Brejo Alegre",
            ],
            [
                "ibge_codigo"       => 3507803,
                "ibge_estado_id" => 35,
                "nome"     => "Brodowski",
            ],
            [
                "ibge_codigo"       => 3507902,
                "ibge_estado_id" => 35,
                "nome"     => "Brotas",
            ],
            [
                "ibge_codigo"       => 3508009,
                "ibge_estado_id" => 35,
                "nome"     => "Buri",
            ],
            [
                "ibge_codigo"       => 3508108,
                "ibge_estado_id" => 35,
                "nome"     => "Buritama",
            ],
            [
                "ibge_codigo"       => 3508207,
                "ibge_estado_id" => 35,
                "nome"     => "Buritizal",
            ],
            [
                "ibge_codigo"       => 3508306,
                "ibge_estado_id" => 35,
                "nome"     => "Cabrália Paulista",
            ],
            [
                "ibge_codigo"       => 3508405,
                "ibge_estado_id" => 35,
                "nome"     => "Cabreúva",
            ],
            [
                "ibge_codigo"       => 3508504,
                "ibge_estado_id" => 35,
                "nome"     => "Caçapava",
            ],
            [
                "ibge_codigo"       => 3508603,
                "ibge_estado_id" => 35,
                "nome"     => "Cachoeira Paulista",
            ],
            [
                "ibge_codigo"       => 3508702,
                "ibge_estado_id" => 35,
                "nome"     => "Caconde",
            ],
            [
                "ibge_codigo"       => 3508801,
                "ibge_estado_id" => 35,
                "nome"     => "Cafelândia",
            ],
            [
                "ibge_codigo"       => 3508900,
                "ibge_estado_id" => 35,
                "nome"     => "Caiabu",
            ],
            [
                "ibge_codigo"       => 3509007,
                "ibge_estado_id" => 35,
                "nome"     => "Caieiras",
            ],
            [
                "ibge_codigo"       => 3509106,
                "ibge_estado_id" => 35,
                "nome"     => "Caiuá",
            ],
            [
                "ibge_codigo"       => 3509205,
                "ibge_estado_id" => 35,
                "nome"     => "Cajamar",
            ],
            [
                "ibge_codigo"       => 3509254,
                "ibge_estado_id" => 35,
                "nome"     => "Cajati",
            ],
            [
                "ibge_codigo"       => 3509304,
                "ibge_estado_id" => 35,
                "nome"     => "Cajobi",
            ],
            [
                "ibge_codigo"       => 3509403,
                "ibge_estado_id" => 35,
                "nome"     => "Cajuru",
            ],
            [
                "ibge_codigo"       => 3509452,
                "ibge_estado_id" => 35,
                "nome"     => "Campina do Monte Alegre",
            ],
            [
                "ibge_codigo"       => 3509502,
                "ibge_estado_id" => 35,
                "nome"     => "Campinas",
            ],
            [
                "ibge_codigo"       => 3509601,
                "ibge_estado_id" => 35,
                "nome"     => "Campo Limpo Paulista",
            ],
            [
                "ibge_codigo"       => 3509700,
                "ibge_estado_id" => 35,
                "nome"     => "Campos do Jordão",
            ],
            [
                "ibge_codigo"       => 3509809,
                "ibge_estado_id" => 35,
                "nome"     => "Campos Novos Paulista",
            ],
            [
                "ibge_codigo"       => 3509908,
                "ibge_estado_id" => 35,
                "nome"     => "Cananéia",
            ],
            [
                "ibge_codigo"       => 3509957,
                "ibge_estado_id" => 35,
                "nome"     => "Canas",
            ],
            [
                "ibge_codigo"       => 3510005,
                "ibge_estado_id" => 35,
                "nome"     => "Cândido Mota",
            ],
            [
                "ibge_codigo"       => 3510104,
                "ibge_estado_id" => 35,
                "nome"     => "Cândido Rodrigues",
            ],
            [
                "ibge_codigo"       => 3510153,
                "ibge_estado_id" => 35,
                "nome"     => "Canitar",
            ],
            [
                "ibge_codigo"       => 3510203,
                "ibge_estado_id" => 35,
                "nome"     => "Capão Bonito",
            ],
            [
                "ibge_codigo"       => 3510302,
                "ibge_estado_id" => 35,
                "nome"     => "Capela do Alto",
            ],
            [
                "ibge_codigo"       => 3510401,
                "ibge_estado_id" => 35,
                "nome"     => "Capivari",
            ],
            [
                "ibge_codigo"       => 3510500,
                "ibge_estado_id" => 35,
                "nome"     => "Caraguatatuba",
            ],
            [
                "ibge_codigo"       => 3510609,
                "ibge_estado_id" => 35,
                "nome"     => "Carapicuíba",
            ],
            [
                "ibge_codigo"       => 3510708,
                "ibge_estado_id" => 35,
                "nome"     => "Cardoso",
            ],
            [
                "ibge_codigo"       => 3510807,
                "ibge_estado_id" => 35,
                "nome"     => "Casa Branca",
            ],
            [
                "ibge_codigo"       => 3510906,
                "ibge_estado_id" => 35,
                "nome"     => "Cássia dos Coqueiros",
            ],
            [
                "ibge_codigo"       => 3511003,
                "ibge_estado_id" => 35,
                "nome"     => "Castilho",
            ],
            [
                "ibge_codigo"       => 3511102,
                "ibge_estado_id" => 35,
                "nome"     => "Catanduva",
            ],
            [
                "ibge_codigo"       => 3511201,
                "ibge_estado_id" => 35,
                "nome"     => "Catiguá",
            ],
            [
                "ibge_codigo"       => 3511300,
                "ibge_estado_id" => 35,
                "nome"     => "Cedral",
            ],
            [
                "ibge_codigo"       => 3511409,
                "ibge_estado_id" => 35,
                "nome"     => "Cerqueira César",
            ],
            [
                "ibge_codigo"       => 3511508,
                "ibge_estado_id" => 35,
                "nome"     => "Cerquilho",
            ],
            [
                "ibge_codigo"       => 3511607,
                "ibge_estado_id" => 35,
                "nome"     => "Cesário Lange",
            ],
            [
                "ibge_codigo"       => 3511706,
                "ibge_estado_id" => 35,
                "nome"     => "Charqueada",
            ],
            [
                "ibge_codigo"       => 3511904,
                "ibge_estado_id" => 35,
                "nome"     => "Clementina",
            ],
            [
                "ibge_codigo"       => 3512001,
                "ibge_estado_id" => 35,
                "nome"     => "Colina",
            ],
            [
                "ibge_codigo"       => 3512100,
                "ibge_estado_id" => 35,
                "nome"     => "Colômbia",
            ],
            [
                "ibge_codigo"       => 3512209,
                "ibge_estado_id" => 35,
                "nome"     => "Conchal",
            ],
            [
                "ibge_codigo"       => 3512308,
                "ibge_estado_id" => 35,
                "nome"     => "Conchas",
            ],
            [
                "ibge_codigo"       => 3512407,
                "ibge_estado_id" => 35,
                "nome"     => "Cordeirópolis",
            ],
            [
                "ibge_codigo"       => 3512506,
                "ibge_estado_id" => 35,
                "nome"     => "Coroados",
            ],
            [
                "ibge_codigo"       => 3512605,
                "ibge_estado_id" => 35,
                "nome"     => "Coronel Macedo",
            ],
            [
                "ibge_codigo"       => 3512704,
                "ibge_estado_id" => 35,
                "nome"     => "Corumbataí",
            ],
            [
                "ibge_codigo"       => 3512803,
                "ibge_estado_id" => 35,
                "nome"     => "Cosmópolis",
            ],
            [
                "ibge_codigo"       => 3512902,
                "ibge_estado_id" => 35,
                "nome"     => "Cosmorama",
            ],
            [
                "ibge_codigo"       => 3513009,
                "ibge_estado_id" => 35,
                "nome"     => "Cotia",
            ],
            [
                "ibge_codigo"       => 3513108,
                "ibge_estado_id" => 35,
                "nome"     => "Cravinhos",
            ],
            [
                "ibge_codigo"       => 3513207,
                "ibge_estado_id" => 35,
                "nome"     => "Cristais Paulista",
            ],
            [
                "ibge_codigo"       => 3513306,
                "ibge_estado_id" => 35,
                "nome"     => "Cruzália",
            ],
            [
                "ibge_codigo"       => 3513405,
                "ibge_estado_id" => 35,
                "nome"     => "Cruzeiro",
            ],
            [
                "ibge_codigo"       => 3513504,
                "ibge_estado_id" => 35,
                "nome"     => "Cubatão",
            ],
            [
                "ibge_codigo"       => 3513603,
                "ibge_estado_id" => 35,
                "nome"     => "Cunha",
            ],
            [
                "ibge_codigo"       => 3513702,
                "ibge_estado_id" => 35,
                "nome"     => "Descalvado",
            ],
            [
                "ibge_codigo"       => 3513801,
                "ibge_estado_id" => 35,
                "nome"     => "Diadema",
            ],
            [
                "ibge_codigo"       => 3513850,
                "ibge_estado_id" => 35,
                "nome"     => "Dirce Reis",
            ],
            [
                "ibge_codigo"       => 3513900,
                "ibge_estado_id" => 35,
                "nome"     => "Divinolândia",
            ],
            [
                "ibge_codigo"       => 3514007,
                "ibge_estado_id" => 35,
                "nome"     => "Dobrada",
            ],
            [
                "ibge_codigo"       => 3514106,
                "ibge_estado_id" => 35,
                "nome"     => "Dois Córregos",
            ],
            [
                "ibge_codigo"       => 3514205,
                "ibge_estado_id" => 35,
                "nome"     => "Dolcinópolis",
            ],
            [
                "ibge_codigo"       => 3514304,
                "ibge_estado_id" => 35,
                "nome"     => "Dourado",
            ],
            [
                "ibge_codigo"       => 3514403,
                "ibge_estado_id" => 35,
                "nome"     => "Dracena",
            ],
            [
                "ibge_codigo"       => 3514502,
                "ibge_estado_id" => 35,
                "nome"     => "Duartina",
            ],
            [
                "ibge_codigo"       => 3514601,
                "ibge_estado_id" => 35,
                "nome"     => "Dumont",
            ],
            [
                "ibge_codigo"       => 3514700,
                "ibge_estado_id" => 35,
                "nome"     => "Echaporã",
            ],
            [
                "ibge_codigo"       => 3514809,
                "ibge_estado_id" => 35,
                "nome"     => "Eldorado",
            ],
            [
                "ibge_codigo"       => 3514908,
                "ibge_estado_id" => 35,
                "nome"     => "Elias Fausto",
            ],
            [
                "ibge_codigo"       => 3514924,
                "ibge_estado_id" => 35,
                "nome"     => "Elisiário",
            ],
            [
                "ibge_codigo"       => 3514957,
                "ibge_estado_id" => 35,
                "nome"     => "Embaúba",
            ],
            [
                "ibge_codigo"       => 3515004,
                "ibge_estado_id" => 35,
                "nome"     => "Embu das Artes",
            ],
            [
                "ibge_codigo"       => 3515103,
                "ibge_estado_id" => 35,
                "nome"     => "Embu-Guaçu",
            ],
            [
                "ibge_codigo"       => 3515129,
                "ibge_estado_id" => 35,
                "nome"     => "Emilianópolis",
            ],
            [
                "ibge_codigo"       => 3515152,
                "ibge_estado_id" => 35,
                "nome"     => "Engenheiro Coelho",
            ],
            [
                "ibge_codigo"       => 3515186,
                "ibge_estado_id" => 35,
                "nome"     => "Espírito Santo do Pinhal",
            ],
            [
                "ibge_codigo"       => 3515194,
                "ibge_estado_id" => 35,
                "nome"     => "Espírito Santo do Turvo",
            ],
            [
                "ibge_codigo"       => 3515202,
                "ibge_estado_id" => 35,
                "nome"     => "Estrela d'Oeste",
            ],
            [
                "ibge_codigo"       => 3515301,
                "ibge_estado_id" => 35,
                "nome"     => "Estrela do Norte",
            ],
            [
                "ibge_codigo"       => 3515350,
                "ibge_estado_id" => 35,
                "nome"     => "Euclides da Cunha Paulista",
            ],
            [
                "ibge_codigo"       => 3515400,
                "ibge_estado_id" => 35,
                "nome"     => "Fartura",
            ],
            [
                "ibge_codigo"       => 3515509,
                "ibge_estado_id" => 35,
                "nome"     => "Fernandópolis",
            ],
            [
                "ibge_codigo"       => 3515608,
                "ibge_estado_id" => 35,
                "nome"     => "Fernando Prestes",
            ],
            [
                "ibge_codigo"       => 3515657,
                "ibge_estado_id" => 35,
                "nome"     => "Fernão",
            ],
            [
                "ibge_codigo"       => 3515707,
                "ibge_estado_id" => 35,
                "nome"     => "Ferraz de Vasconcelos",
            ],
            [
                "ibge_codigo"       => 3515806,
                "ibge_estado_id" => 35,
                "nome"     => "Flora Rica",
            ],
            [
                "ibge_codigo"       => 3515905,
                "ibge_estado_id" => 35,
                "nome"     => "Floreal",
            ],
            [
                "ibge_codigo"       => 3516002,
                "ibge_estado_id" => 35,
                "nome"     => "Flórida Paulista",
            ],
            [
                "ibge_codigo"       => 3516101,
                "ibge_estado_id" => 35,
                "nome"     => "Florínia",
            ],
            [
                "ibge_codigo"       => 3516200,
                "ibge_estado_id" => 35,
                "nome"     => "Franca",
            ],
            [
                "ibge_codigo"       => 3516309,
                "ibge_estado_id" => 35,
                "nome"     => "Francisco Morato",
            ],
            [
                "ibge_codigo"       => 3516408,
                "ibge_estado_id" => 35,
                "nome"     => "Franco da Rocha",
            ],
            [
                "ibge_codigo"       => 3516507,
                "ibge_estado_id" => 35,
                "nome"     => "Gabriel Monteiro",
            ],
            [
                "ibge_codigo"       => 3516606,
                "ibge_estado_id" => 35,
                "nome"     => "Gália",
            ],
            [
                "ibge_codigo"       => 3516705,
                "ibge_estado_id" => 35,
                "nome"     => "Garça",
            ],
            [
                "ibge_codigo"       => 3516804,
                "ibge_estado_id" => 35,
                "nome"     => "Gastão Vidigal",
            ],
            [
                "ibge_codigo"       => 3516853,
                "ibge_estado_id" => 35,
                "nome"     => "Gavião Peixoto",
            ],
            [
                "ibge_codigo"       => 3516903,
                "ibge_estado_id" => 35,
                "nome"     => "General Salgado",
            ],
            [
                "ibge_codigo"       => 3517000,
                "ibge_estado_id" => 35,
                "nome"     => "Getulina",
            ],
            [
                "ibge_codigo"       => 3517109,
                "ibge_estado_id" => 35,
                "nome"     => "Glicério",
            ],
            [
                "ibge_codigo"       => 3517208,
                "ibge_estado_id" => 35,
                "nome"     => "Guaiçara",
            ],
            [
                "ibge_codigo"       => 3517307,
                "ibge_estado_id" => 35,
                "nome"     => "Guaimbê",
            ],
            [
                "ibge_codigo"       => 3517406,
                "ibge_estado_id" => 35,
                "nome"     => "Guaíra",
            ],
            [
                "ibge_codigo"       => 3517505,
                "ibge_estado_id" => 35,
                "nome"     => "Guapiaçu",
            ],
            [
                "ibge_codigo"       => 3517604,
                "ibge_estado_id" => 35,
                "nome"     => "Guapiara",
            ],
            [
                "ibge_codigo"       => 3517703,
                "ibge_estado_id" => 35,
                "nome"     => "Guará",
            ],
            [
                "ibge_codigo"       => 3517802,
                "ibge_estado_id" => 35,
                "nome"     => "Guaraçaí",
            ],
            [
                "ibge_codigo"       => 3517901,
                "ibge_estado_id" => 35,
                "nome"     => "Guaraci",
            ],
            [
                "ibge_codigo"       => 3518008,
                "ibge_estado_id" => 35,
                "nome"     => "Guarani d'Oeste",
            ],
            [
                "ibge_codigo"       => 3518107,
                "ibge_estado_id" => 35,
                "nome"     => "Guarantã",
            ],
            [
                "ibge_codigo"       => 3518206,
                "ibge_estado_id" => 35,
                "nome"     => "Guararapes",
            ],
            [
                "ibge_codigo"       => 3518305,
                "ibge_estado_id" => 35,
                "nome"     => "Guararema",
            ],
            [
                "ibge_codigo"       => 3518404,
                "ibge_estado_id" => 35,
                "nome"     => "Guaratinguetá",
            ],
            [
                "ibge_codigo"       => 3518503,
                "ibge_estado_id" => 35,
                "nome"     => "Guareí",
            ],
            [
                "ibge_codigo"       => 3518602,
                "ibge_estado_id" => 35,
                "nome"     => "Guariba",
            ],
            [
                "ibge_codigo"       => 3518701,
                "ibge_estado_id" => 35,
                "nome"     => "Guarujá",
            ],
            [
                "ibge_codigo"       => 3518800,
                "ibge_estado_id" => 35,
                "nome"     => "Guarulhos",
            ],
            [
                "ibge_codigo"       => 3518859,
                "ibge_estado_id" => 35,
                "nome"     => "Guatapará",
            ],
            [
                "ibge_codigo"       => 3518909,
                "ibge_estado_id" => 35,
                "nome"     => "Guzolândia",
            ],
            [
                "ibge_codigo"       => 3519006,
                "ibge_estado_id" => 35,
                "nome"     => "Herculândia",
            ],
            [
                "ibge_codigo"       => 3519055,
                "ibge_estado_id" => 35,
                "nome"     => "Holambra",
            ],
            [
                "ibge_codigo"       => 3519071,
                "ibge_estado_id" => 35,
                "nome"     => "Hortolândia",
            ],
            [
                "ibge_codigo"       => 3519105,
                "ibge_estado_id" => 35,
                "nome"     => "Iacanga",
            ],
            [
                "ibge_codigo"       => 3519204,
                "ibge_estado_id" => 35,
                "nome"     => "Iacri",
            ],
            [
                "ibge_codigo"       => 3519253,
                "ibge_estado_id" => 35,
                "nome"     => "Iaras",
            ],
            [
                "ibge_codigo"       => 3519303,
                "ibge_estado_id" => 35,
                "nome"     => "Ibaté",
            ],
            [
                "ibge_codigo"       => 3519402,
                "ibge_estado_id" => 35,
                "nome"     => "Ibirá",
            ],
            [
                "ibge_codigo"       => 3519501,
                "ibge_estado_id" => 35,
                "nome"     => "Ibirarema",
            ],
            [
                "ibge_codigo"       => 3519600,
                "ibge_estado_id" => 35,
                "nome"     => "Ibitinga",
            ],
            [
                "ibge_codigo"       => 3519709,
                "ibge_estado_id" => 35,
                "nome"     => "Ibiúna",
            ],
            [
                "ibge_codigo"       => 3519808,
                "ibge_estado_id" => 35,
                "nome"     => "Icém",
            ],
            [
                "ibge_codigo"       => 3519907,
                "ibge_estado_id" => 35,
                "nome"     => "Iepê",
            ],
            [
                "ibge_codigo"       => 3520004,
                "ibge_estado_id" => 35,
                "nome"     => "Igaraçu do Tietê",
            ],
            [
                "ibge_codigo"       => 3520103,
                "ibge_estado_id" => 35,
                "nome"     => "Igarapava",
            ],
            [
                "ibge_codigo"       => 3520202,
                "ibge_estado_id" => 35,
                "nome"     => "Igaratá",
            ],
            [
                "ibge_codigo"       => 3520301,
                "ibge_estado_id" => 35,
                "nome"     => "Iguape",
            ],
            [
                "ibge_codigo"       => 3520400,
                "ibge_estado_id" => 35,
                "nome"     => "Ilhabela",
            ],
            [
                "ibge_codigo"       => 3520426,
                "ibge_estado_id" => 35,
                "nome"     => "Ilha Comprida",
            ],
            [
                "ibge_codigo"       => 3520442,
                "ibge_estado_id" => 35,
                "nome"     => "Ilha Solteira",
            ],
            [
                "ibge_codigo"       => 3520509,
                "ibge_estado_id" => 35,
                "nome"     => "Indaiatuba",
            ],
            [
                "ibge_codigo"       => 3520608,
                "ibge_estado_id" => 35,
                "nome"     => "Indiana",
            ],
            [
                "ibge_codigo"       => 3520707,
                "ibge_estado_id" => 35,
                "nome"     => "Indiaporã",
            ],
            [
                "ibge_codigo"       => 3520806,
                "ibge_estado_id" => 35,
                "nome"     => "Inúbia Paulista",
            ],
            [
                "ibge_codigo"       => 3520905,
                "ibge_estado_id" => 35,
                "nome"     => "Ipaussu",
            ],
            [
                "ibge_codigo"       => 3521002,
                "ibge_estado_id" => 35,
                "nome"     => "Iperó",
            ],
            [
                "ibge_codigo"       => 3521101,
                "ibge_estado_id" => 35,
                "nome"     => "Ipeúna",
            ],
            [
                "ibge_codigo"       => 3521150,
                "ibge_estado_id" => 35,
                "nome"     => "Ipiguá",
            ],
            [
                "ibge_codigo"       => 3521200,
                "ibge_estado_id" => 35,
                "nome"     => "Iporanga",
            ],
            [
                "ibge_codigo"       => 3521309,
                "ibge_estado_id" => 35,
                "nome"     => "Ipuã",
            ],
            [
                "ibge_codigo"       => 3521408,
                "ibge_estado_id" => 35,
                "nome"     => "Iracemápolis",
            ],
            [
                "ibge_codigo"       => 3521507,
                "ibge_estado_id" => 35,
                "nome"     => "Irapuã",
            ],
            [
                "ibge_codigo"       => 3521606,
                "ibge_estado_id" => 35,
                "nome"     => "Irapuru",
            ],
            [
                "ibge_codigo"       => 3521705,
                "ibge_estado_id" => 35,
                "nome"     => "Itaberá",
            ],
            [
                "ibge_codigo"       => 3521804,
                "ibge_estado_id" => 35,
                "nome"     => "Itaí",
            ],
            [
                "ibge_codigo"       => 3521903,
                "ibge_estado_id" => 35,
                "nome"     => "Itajobi",
            ],
            [
                "ibge_codigo"       => 3522000,
                "ibge_estado_id" => 35,
                "nome"     => "Itaju",
            ],
            [
                "ibge_codigo"       => 3522109,
                "ibge_estado_id" => 35,
                "nome"     => "Itanhaém",
            ],
            [
                "ibge_codigo"       => 3522158,
                "ibge_estado_id" => 35,
                "nome"     => "Itaóca",
            ],
            [
                "ibge_codigo"       => 3522208,
                "ibge_estado_id" => 35,
                "nome"     => "Itapecerica da Serra",
            ],
            [
                "ibge_codigo"       => 3522307,
                "ibge_estado_id" => 35,
                "nome"     => "Itapetininga",
            ],
            [
                "ibge_codigo"       => 3522406,
                "ibge_estado_id" => 35,
                "nome"     => "Itapeva",
            ],
            [
                "ibge_codigo"       => 3522505,
                "ibge_estado_id" => 35,
                "nome"     => "Itapevi",
            ],
            [
                "ibge_codigo"       => 3522604,
                "ibge_estado_id" => 35,
                "nome"     => "Itapira",
            ],
            [
                "ibge_codigo"       => 3522653,
                "ibge_estado_id" => 35,
                "nome"     => "Itapirapuã Paulista",
            ],
            [
                "ibge_codigo"       => 3522703,
                "ibge_estado_id" => 35,
                "nome"     => "Itápolis",
            ],
            [
                "ibge_codigo"       => 3522802,
                "ibge_estado_id" => 35,
                "nome"     => "Itaporanga",
            ],
            [
                "ibge_codigo"       => 3522901,
                "ibge_estado_id" => 35,
                "nome"     => "Itapuí",
            ],
            [
                "ibge_codigo"       => 3523008,
                "ibge_estado_id" => 35,
                "nome"     => "Itapura",
            ],
            [
                "ibge_codigo"       => 3523107,
                "ibge_estado_id" => 35,
                "nome"     => "Itaquaquecetuba",
            ],
            [
                "ibge_codigo"       => 3523206,
                "ibge_estado_id" => 35,
                "nome"     => "Itararé",
            ],
            [
                "ibge_codigo"       => 3523305,
                "ibge_estado_id" => 35,
                "nome"     => "Itariri",
            ],
            [
                "ibge_codigo"       => 3523404,
                "ibge_estado_id" => 35,
                "nome"     => "Itatiba",
            ],
            [
                "ibge_codigo"       => 3523503,
                "ibge_estado_id" => 35,
                "nome"     => "Itatinga",
            ],
            [
                "ibge_codigo"       => 3523602,
                "ibge_estado_id" => 35,
                "nome"     => "Itirapina",
            ],
            [
                "ibge_codigo"       => 3523701,
                "ibge_estado_id" => 35,
                "nome"     => "Itirapuã",
            ],
            [
                "ibge_codigo"       => 3523800,
                "ibge_estado_id" => 35,
                "nome"     => "Itobi",
            ],
            [
                "ibge_codigo"       => 3523909,
                "ibge_estado_id" => 35,
                "nome"     => "Itu",
            ],
            [
                "ibge_codigo"       => 3524006,
                "ibge_estado_id" => 35,
                "nome"     => "Itupeva",
            ],
            [
                "ibge_codigo"       => 3524105,
                "ibge_estado_id" => 35,
                "nome"     => "Ituverava",
            ],
            [
                "ibge_codigo"       => 3524204,
                "ibge_estado_id" => 35,
                "nome"     => "Jaborandi",
            ],
            [
                "ibge_codigo"       => 3524303,
                "ibge_estado_id" => 35,
                "nome"     => "Jaboticabal",
            ],
            [
                "ibge_codigo"       => 3524402,
                "ibge_estado_id" => 35,
                "nome"     => "Jacareí",
            ],
            [
                "ibge_codigo"       => 3524501,
                "ibge_estado_id" => 35,
                "nome"     => "Jaci",
            ],
            [
                "ibge_codigo"       => 3524600,
                "ibge_estado_id" => 35,
                "nome"     => "Jacupiranga",
            ],
            [
                "ibge_codigo"       => 3524709,
                "ibge_estado_id" => 35,
                "nome"     => "Jaguariúna",
            ],
            [
                "ibge_codigo"       => 3524808,
                "ibge_estado_id" => 35,
                "nome"     => "Jales",
            ],
            [
                "ibge_codigo"       => 3524907,
                "ibge_estado_id" => 35,
                "nome"     => "Jambeiro",
            ],
            [
                "ibge_codigo"       => 3525003,
                "ibge_estado_id" => 35,
                "nome"     => "Jandira",
            ],
            [
                "ibge_codigo"       => 3525102,
                "ibge_estado_id" => 35,
                "nome"     => "Jardinópolis",
            ],
            [
                "ibge_codigo"       => 3525201,
                "ibge_estado_id" => 35,
                "nome"     => "Jarinu",
            ],
            [
                "ibge_codigo"       => 3525300,
                "ibge_estado_id" => 35,
                "nome"     => "Jaú",
            ],
            [
                "ibge_codigo"       => 3525409,
                "ibge_estado_id" => 35,
                "nome"     => "Jeriquara",
            ],
            [
                "ibge_codigo"       => 3525508,
                "ibge_estado_id" => 35,
                "nome"     => "Joanópolis",
            ],
            [
                "ibge_codigo"       => 3525607,
                "ibge_estado_id" => 35,
                "nome"     => "João Ramalho",
            ],
            [
                "ibge_codigo"       => 3525706,
                "ibge_estado_id" => 35,
                "nome"     => "José Bonifácio",
            ],
            [
                "ibge_codigo"       => 3525805,
                "ibge_estado_id" => 35,
                "nome"     => "Júlio Mesquita",
            ],
            [
                "ibge_codigo"       => 3525854,
                "ibge_estado_id" => 35,
                "nome"     => "Jumirim",
            ],
            [
                "ibge_codigo"       => 3525904,
                "ibge_estado_id" => 35,
                "nome"     => "Jundiaí",
            ],
            [
                "ibge_codigo"       => 3526001,
                "ibge_estado_id" => 35,
                "nome"     => "Junqueirópolis",
            ],
            [
                "ibge_codigo"       => 3526100,
                "ibge_estado_id" => 35,
                "nome"     => "Juquiá",
            ],
            [
                "ibge_codigo"       => 3526209,
                "ibge_estado_id" => 35,
                "nome"     => "Juquitiba",
            ],
            [
                "ibge_codigo"       => 3526308,
                "ibge_estado_id" => 35,
                "nome"     => "Lagoinha",
            ],
            [
                "ibge_codigo"       => 3526407,
                "ibge_estado_id" => 35,
                "nome"     => "Laranjal Paulista",
            ],
            [
                "ibge_codigo"       => 3526506,
                "ibge_estado_id" => 35,
                "nome"     => "Lavínia",
            ],
            [
                "ibge_codigo"       => 3526605,
                "ibge_estado_id" => 35,
                "nome"     => "Lavrinhas",
            ],
            [
                "ibge_codigo"       => 3526704,
                "ibge_estado_id" => 35,
                "nome"     => "Leme",
            ],
            [
                "ibge_codigo"       => 3526803,
                "ibge_estado_id" => 35,
                "nome"     => "Lençóis Paulista",
            ],
            [
                "ibge_codigo"       => 3526902,
                "ibge_estado_id" => 35,
                "nome"     => "Limeira",
            ],
            [
                "ibge_codigo"       => 3527009,
                "ibge_estado_id" => 35,
                "nome"     => "Lindóia",
            ],
            [
                "ibge_codigo"       => 3527108,
                "ibge_estado_id" => 35,
                "nome"     => "Lins",
            ],
            [
                "ibge_codigo"       => 3527207,
                "ibge_estado_id" => 35,
                "nome"     => "Lorena",
            ],
            [
                "ibge_codigo"       => 3527256,
                "ibge_estado_id" => 35,
                "nome"     => "Lourdes",
            ],
            [
                "ibge_codigo"       => 3527306,
                "ibge_estado_id" => 35,
                "nome"     => "Louveira",
            ],
            [
                "ibge_codigo"       => 3527405,
                "ibge_estado_id" => 35,
                "nome"     => "Lucélia",
            ],
            [
                "ibge_codigo"       => 3527504,
                "ibge_estado_id" => 35,
                "nome"     => "Lucianópolis",
            ],
            [
                "ibge_codigo"       => 3527603,
                "ibge_estado_id" => 35,
                "nome"     => "Luís Antônio",
            ],
            [
                "ibge_codigo"       => 3527702,
                "ibge_estado_id" => 35,
                "nome"     => "Luiziânia",
            ],
            [
                "ibge_codigo"       => 3527801,
                "ibge_estado_id" => 35,
                "nome"     => "Lupércio",
            ],
            [
                "ibge_codigo"       => 3527900,
                "ibge_estado_id" => 35,
                "nome"     => "Lutécia",
            ],
            [
                "ibge_codigo"       => 3528007,
                "ibge_estado_id" => 35,
                "nome"     => "Macatuba",
            ],
            [
                "ibge_codigo"       => 3528106,
                "ibge_estado_id" => 35,
                "nome"     => "Macaubal",
            ],
            [
                "ibge_codigo"       => 3528205,
                "ibge_estado_id" => 35,
                "nome"     => "Macedônia",
            ],
            [
                "ibge_codigo"       => 3528304,
                "ibge_estado_id" => 35,
                "nome"     => "Magda",
            ],
            [
                "ibge_codigo"       => 3528403,
                "ibge_estado_id" => 35,
                "nome"     => "Mairinque",
            ],
            [
                "ibge_codigo"       => 3528502,
                "ibge_estado_id" => 35,
                "nome"     => "Mairiporã",
            ],
            [
                "ibge_codigo"       => 3528601,
                "ibge_estado_id" => 35,
                "nome"     => "Manduri",
            ],
            [
                "ibge_codigo"       => 3528700,
                "ibge_estado_id" => 35,
                "nome"     => "Marabá Paulista",
            ],
            [
                "ibge_codigo"       => 3528809,
                "ibge_estado_id" => 35,
                "nome"     => "Maracaí",
            ],
            [
                "ibge_codigo"       => 3528858,
                "ibge_estado_id" => 35,
                "nome"     => "Marapoama",
            ],
            [
                "ibge_codigo"       => 3528908,
                "ibge_estado_id" => 35,
                "nome"     => "Mariápolis",
            ],
            [
                "ibge_codigo"       => 3529005,
                "ibge_estado_id" => 35,
                "nome"     => "Marília",
            ],
            [
                "ibge_codigo"       => 3529104,
                "ibge_estado_id" => 35,
                "nome"     => "Marinópolis",
            ],
            [
                "ibge_codigo"       => 3529203,
                "ibge_estado_id" => 35,
                "nome"     => "Martinópolis",
            ],
            [
                "ibge_codigo"       => 3529302,
                "ibge_estado_id" => 35,
                "nome"     => "Matão",
            ],
            [
                "ibge_codigo"       => 3529401,
                "ibge_estado_id" => 35,
                "nome"     => "Mauá",
            ],
            [
                "ibge_codigo"       => 3529500,
                "ibge_estado_id" => 35,
                "nome"     => "Mendonça",
            ],
            [
                "ibge_codigo"       => 3529609,
                "ibge_estado_id" => 35,
                "nome"     => "Meridiano",
            ],
            [
                "ibge_codigo"       => 3529658,
                "ibge_estado_id" => 35,
                "nome"     => "Mesópolis",
            ],
            [
                "ibge_codigo"       => 3529708,
                "ibge_estado_id" => 35,
                "nome"     => "Miguelópolis",
            ],
            [
                "ibge_codigo"       => 3529807,
                "ibge_estado_id" => 35,
                "nome"     => "Mineiros do Tietê",
            ],
            [
                "ibge_codigo"       => 3529906,
                "ibge_estado_id" => 35,
                "nome"     => "Miracatu",
            ],
            [
                "ibge_codigo"       => 3530003,
                "ibge_estado_id" => 35,
                "nome"     => "Mira Estrela",
            ],
            [
                "ibge_codigo"       => 3530102,
                "ibge_estado_id" => 35,
                "nome"     => "Mirandópolis",
            ],
            [
                "ibge_codigo"       => 3530201,
                "ibge_estado_id" => 35,
                "nome"     => "Mirante do Paranapanema",
            ],
            [
                "ibge_codigo"       => 3530300,
                "ibge_estado_id" => 35,
                "nome"     => "Mirassol",
            ],
            [
                "ibge_codigo"       => 3530409,
                "ibge_estado_id" => 35,
                "nome"     => "Mirassolândia",
            ],
            [
                "ibge_codigo"       => 3530508,
                "ibge_estado_id" => 35,
                "nome"     => "Mococa",
            ],
            [
                "ibge_codigo"       => 3530607,
                "ibge_estado_id" => 35,
                "nome"     => "Mogi das Cruzes",
            ],
            [
                "ibge_codigo"       => 3530706,
                "ibge_estado_id" => 35,
                "nome"     => "Mogi Guaçu",
            ],
            [
                "ibge_codigo"       => 3530805,
                "ibge_estado_id" => 35,
                "nome"     => "Moji Mirim",
            ],
            [
                "ibge_codigo"       => 3530904,
                "ibge_estado_id" => 35,
                "nome"     => "Mombuca",
            ],
            [
                "ibge_codigo"       => 3531001,
                "ibge_estado_id" => 35,
                "nome"     => "Monções",
            ],
            [
                "ibge_codigo"       => 3531100,
                "ibge_estado_id" => 35,
                "nome"     => "Mongaguá",
            ],
            [
                "ibge_codigo"       => 3531209,
                "ibge_estado_id" => 35,
                "nome"     => "Monte Alegre do Sul",
            ],
            [
                "ibge_codigo"       => 3531308,
                "ibge_estado_id" => 35,
                "nome"     => "Monte Alto",
            ],
            [
                "ibge_codigo"       => 3531407,
                "ibge_estado_id" => 35,
                "nome"     => "Monte Aprazível",
            ],
            [
                "ibge_codigo"       => 3531506,
                "ibge_estado_id" => 35,
                "nome"     => "Monte Azul Paulista",
            ],
            [
                "ibge_codigo"       => 3531605,
                "ibge_estado_id" => 35,
                "nome"     => "Monte Castelo",
            ],
            [
                "ibge_codigo"       => 3531704,
                "ibge_estado_id" => 35,
                "nome"     => "Monteiro Lobato",
            ],
            [
                "ibge_codigo"       => 3531803,
                "ibge_estado_id" => 35,
                "nome"     => "Monte Mor",
            ],
            [
                "ibge_codigo"       => 3531902,
                "ibge_estado_id" => 35,
                "nome"     => "Morro Agudo",
            ],
            [
                "ibge_codigo"       => 3532009,
                "ibge_estado_id" => 35,
                "nome"     => "Morungaba",
            ],
            [
                "ibge_codigo"       => 3532058,
                "ibge_estado_id" => 35,
                "nome"     => "Motuca",
            ],
            [
                "ibge_codigo"       => 3532108,
                "ibge_estado_id" => 35,
                "nome"     => "Murutinga do Sul",
            ],
            [
                "ibge_codigo"       => 3532157,
                "ibge_estado_id" => 35,
                "nome"     => "Nantes",
            ],
            [
                "ibge_codigo"       => 3532207,
                "ibge_estado_id" => 35,
                "nome"     => "Narandiba",
            ],
            [
                "ibge_codigo"       => 3532306,
                "ibge_estado_id" => 35,
                "nome"     => "Natividade da Serra",
            ],
            [
                "ibge_codigo"       => 3532405,
                "ibge_estado_id" => 35,
                "nome"     => "Nazaré Paulista",
            ],
            [
                "ibge_codigo"       => 3532504,
                "ibge_estado_id" => 35,
                "nome"     => "Neves Paulista",
            ],
            [
                "ibge_codigo"       => 3532603,
                "ibge_estado_id" => 35,
                "nome"     => "Nhandeara",
            ],
            [
                "ibge_codigo"       => 3532702,
                "ibge_estado_id" => 35,
                "nome"     => "Nipoã",
            ],
            [
                "ibge_codigo"       => 3532801,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Aliança",
            ],
            [
                "ibge_codigo"       => 3532827,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Campina",
            ],
            [
                "ibge_codigo"       => 3532843,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Canaã Paulista",
            ],
            [
                "ibge_codigo"       => 3532868,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Castilho",
            ],
            [
                "ibge_codigo"       => 3532900,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Europa",
            ],
            [
                "ibge_codigo"       => 3533007,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Granada",
            ],
            [
                "ibge_codigo"       => 3533106,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Guataporanga",
            ],
            [
                "ibge_codigo"       => 3533205,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Independência",
            ],
            [
                "ibge_codigo"       => 3533254,
                "ibge_estado_id" => 35,
                "nome"     => "Novais",
            ],
            [
                "ibge_codigo"       => 3533304,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Luzitânia",
            ],
            [
                "ibge_codigo"       => 3533403,
                "ibge_estado_id" => 35,
                "nome"     => "Nova Odessa",
            ],
            [
                "ibge_codigo"       => 3533502,
                "ibge_estado_id" => 35,
                "nome"     => "Novo Horizonte",
            ],
            [
                "ibge_codigo"       => 3533601,
                "ibge_estado_id" => 35,
                "nome"     => "Nuporanga",
            ],
            [
                "ibge_codigo"       => 3533700,
                "ibge_estado_id" => 35,
                "nome"     => "Ocauçu",
            ],
            [
                "ibge_codigo"       => 3533809,
                "ibge_estado_id" => 35,
                "nome"     => "Óleo",
            ],
            [
                "ibge_codigo"       => 3533908,
                "ibge_estado_id" => 35,
                "nome"     => "Olímpia",
            ],
            [
                "ibge_codigo"       => 3534005,
                "ibge_estado_id" => 35,
                "nome"     => "Onda Verde",
            ],
            [
                "ibge_codigo"       => 3534104,
                "ibge_estado_id" => 35,
                "nome"     => "Oriente",
            ],
            [
                "ibge_codigo"       => 3534203,
                "ibge_estado_id" => 35,
                "nome"     => "Orindiúva",
            ],
            [
                "ibge_codigo"       => 3534302,
                "ibge_estado_id" => 35,
                "nome"     => "Orlândia",
            ],
            [
                "ibge_codigo"       => 3534401,
                "ibge_estado_id" => 35,
                "nome"     => "Osasco",
            ],
            [
                "ibge_codigo"       => 3534500,
                "ibge_estado_id" => 35,
                "nome"     => "Oscar Bressane",
            ],
            [
                "ibge_codigo"       => 3534609,
                "ibge_estado_id" => 35,
                "nome"     => "Osvaldo Cruz",
            ],
            [
                "ibge_codigo"       => 3534708,
                "ibge_estado_id" => 35,
                "nome"     => "Ourinhos",
            ],
            [
                "ibge_codigo"       => 3534757,
                "ibge_estado_id" => 35,
                "nome"     => "Ouroeste",
            ],
            [
                "ibge_codigo"       => 3534807,
                "ibge_estado_id" => 35,
                "nome"     => "Ouro Verde",
            ],
            [
                "ibge_codigo"       => 3534906,
                "ibge_estado_id" => 35,
                "nome"     => "Pacaembu",
            ],
            [
                "ibge_codigo"       => 3535002,
                "ibge_estado_id" => 35,
                "nome"     => "Palestina",
            ],
            [
                "ibge_codigo"       => 3535101,
                "ibge_estado_id" => 35,
                "nome"     => "Palmares Paulista",
            ],
            [
                "ibge_codigo"       => 3535200,
                "ibge_estado_id" => 35,
                "nome"     => "Palmeira d'Oeste",
            ],
            [
                "ibge_codigo"       => 3535309,
                "ibge_estado_id" => 35,
                "nome"     => "Palmital",
            ],
            [
                "ibge_codigo"       => 3535408,
                "ibge_estado_id" => 35,
                "nome"     => "Panorama",
            ],
            [
                "ibge_codigo"       => 3535507,
                "ibge_estado_id" => 35,
                "nome"     => "Paraguaçu Paulista",
            ],
            [
                "ibge_codigo"       => 3535606,
                "ibge_estado_id" => 35,
                "nome"     => "Paraibuna",
            ],
            [
                "ibge_codigo"       => 3535705,
                "ibge_estado_id" => 35,
                "nome"     => "Paraíso",
            ],
            [
                "ibge_codigo"       => 3535804,
                "ibge_estado_id" => 35,
                "nome"     => "Paranapanema",
            ],
            [
                "ibge_codigo"       => 3535903,
                "ibge_estado_id" => 35,
                "nome"     => "Paranapuã",
            ],
            [
                "ibge_codigo"       => 3536000,
                "ibge_estado_id" => 35,
                "nome"     => "Parapuã",
            ],
            [
                "ibge_codigo"       => 3536109,
                "ibge_estado_id" => 35,
                "nome"     => "Pardinho",
            ],
            [
                "ibge_codigo"       => 3536208,
                "ibge_estado_id" => 35,
                "nome"     => "Pariquera-Açu",
            ],
            [
                "ibge_codigo"       => 3536257,
                "ibge_estado_id" => 35,
                "nome"     => "Parisi",
            ],
            [
                "ibge_codigo"       => 3536307,
                "ibge_estado_id" => 35,
                "nome"     => "Patrocínio Paulista",
            ],
            [
                "ibge_codigo"       => 3536406,
                "ibge_estado_id" => 35,
                "nome"     => "Paulicéia",
            ],
            [
                "ibge_codigo"       => 3536505,
                "ibge_estado_id" => 35,
                "nome"     => "Paulínia",
            ],
            [
                "ibge_codigo"       => 3536570,
                "ibge_estado_id" => 35,
                "nome"     => "Paulistânia",
            ],
            [
                "ibge_codigo"       => 3536604,
                "ibge_estado_id" => 35,
                "nome"     => "Paulo de Faria",
            ],
            [
                "ibge_codigo"       => 3536703,
                "ibge_estado_id" => 35,
                "nome"     => "Pederneiras",
            ],
            [
                "ibge_codigo"       => 3536802,
                "ibge_estado_id" => 35,
                "nome"     => "Pedra Bela",
            ],
            [
                "ibge_codigo"       => 3536901,
                "ibge_estado_id" => 35,
                "nome"     => "Pedranópolis",
            ],
            [
                "ibge_codigo"       => 3537008,
                "ibge_estado_id" => 35,
                "nome"     => "Pedregulho",
            ],
            [
                "ibge_codigo"       => 3537107,
                "ibge_estado_id" => 35,
                "nome"     => "Pedreira",
            ],
            [
                "ibge_codigo"       => 3537156,
                "ibge_estado_id" => 35,
                "nome"     => "Pedrinhas Paulista",
            ],
            [
                "ibge_codigo"       => 3537206,
                "ibge_estado_id" => 35,
                "nome"     => "Pedro de Toledo",
            ],
            [
                "ibge_codigo"       => 3537305,
                "ibge_estado_id" => 35,
                "nome"     => "Penápolis",
            ],
            [
                "ibge_codigo"       => 3537404,
                "ibge_estado_id" => 35,
                "nome"     => "Pereira Barreto",
            ],
            [
                "ibge_codigo"       => 3537503,
                "ibge_estado_id" => 35,
                "nome"     => "Pereiras",
            ],
            [
                "ibge_codigo"       => 3537602,
                "ibge_estado_id" => 35,
                "nome"     => "Peruíbe",
            ],
            [
                "ibge_codigo"       => 3537701,
                "ibge_estado_id" => 35,
                "nome"     => "Piacatu",
            ],
            [
                "ibge_codigo"       => 3537800,
                "ibge_estado_id" => 35,
                "nome"     => "Piedade",
            ],
            [
                "ibge_codigo"       => 3537909,
                "ibge_estado_id" => 35,
                "nome"     => "Pilar do Sul",
            ],
            [
                "ibge_codigo"       => 3538006,
                "ibge_estado_id" => 35,
                "nome"     => "Pindamonhangaba",
            ],
            [
                "ibge_codigo"       => 3538105,
                "ibge_estado_id" => 35,
                "nome"     => "Pindorama",
            ],
            [
                "ibge_codigo"       => 3538204,
                "ibge_estado_id" => 35,
                "nome"     => "Pinhalzinho",
            ],
            [
                "ibge_codigo"       => 3538303,
                "ibge_estado_id" => 35,
                "nome"     => "Piquerobi",
            ],
            [
                "ibge_codigo"       => 3538501,
                "ibge_estado_id" => 35,
                "nome"     => "Piquete",
            ],
            [
                "ibge_codigo"       => 3538600,
                "ibge_estado_id" => 35,
                "nome"     => "Piracaia",
            ],
            [
                "ibge_codigo"       => 3538709,
                "ibge_estado_id" => 35,
                "nome"     => "Piracicaba",
            ],
            [
                "ibge_codigo"       => 3538808,
                "ibge_estado_id" => 35,
                "nome"     => "Piraju",
            ],
            [
                "ibge_codigo"       => 3538907,
                "ibge_estado_id" => 35,
                "nome"     => "Pirajuí",
            ],
            [
                "ibge_codigo"       => 3539004,
                "ibge_estado_id" => 35,
                "nome"     => "Pirangi",
            ],
            [
                "ibge_codigo"       => 3539103,
                "ibge_estado_id" => 35,
                "nome"     => "Pirapora do Bom Jesus",
            ],
            [
                "ibge_codigo"       => 3539202,
                "ibge_estado_id" => 35,
                "nome"     => "Pirapozinho",
            ],
            [
                "ibge_codigo"       => 3539301,
                "ibge_estado_id" => 35,
                "nome"     => "Pirassununga",
            ],
            [
                "ibge_codigo"       => 3539400,
                "ibge_estado_id" => 35,
                "nome"     => "Piratininga",
            ],
            [
                "ibge_codigo"       => 3539509,
                "ibge_estado_id" => 35,
                "nome"     => "Pitangueiras",
            ],
            [
                "ibge_codigo"       => 3539608,
                "ibge_estado_id" => 35,
                "nome"     => "Planalto",
            ],
            [
                "ibge_codigo"       => 3539707,
                "ibge_estado_id" => 35,
                "nome"     => "Platina",
            ],
            [
                "ibge_codigo"       => 3539806,
                "ibge_estado_id" => 35,
                "nome"     => "Poá",
            ],
            [
                "ibge_codigo"       => 3539905,
                "ibge_estado_id" => 35,
                "nome"     => "Poloni",
            ],
            [
                "ibge_codigo"       => 3540002,
                "ibge_estado_id" => 35,
                "nome"     => "Pompéia",
            ],
            [
                "ibge_codigo"       => 3540101,
                "ibge_estado_id" => 35,
                "nome"     => "Pongaí",
            ],
            [
                "ibge_codigo"       => 3540200,
                "ibge_estado_id" => 35,
                "nome"     => "Pontal",
            ],
            [
                "ibge_codigo"       => 3540259,
                "ibge_estado_id" => 35,
                "nome"     => "Pontalinda",
            ],
            [
                "ibge_codigo"       => 3540309,
                "ibge_estado_id" => 35,
                "nome"     => "Pontes Gestal",
            ],
            [
                "ibge_codigo"       => 3540408,
                "ibge_estado_id" => 35,
                "nome"     => "Populina",
            ],
            [
                "ibge_codigo"       => 3540507,
                "ibge_estado_id" => 35,
                "nome"     => "Porangaba",
            ],
            [
                "ibge_codigo"       => 3540606,
                "ibge_estado_id" => 35,
                "nome"     => "Porto Feliz",
            ],
            [
                "ibge_codigo"       => 3540705,
                "ibge_estado_id" => 35,
                "nome"     => "Porto Ferreira",
            ],
            [
                "ibge_codigo"       => 3540754,
                "ibge_estado_id" => 35,
                "nome"     => "Potim",
            ],
            [
                "ibge_codigo"       => 3540804,
                "ibge_estado_id" => 35,
                "nome"     => "Potirendaba",
            ],
            [
                "ibge_codigo"       => 3540853,
                "ibge_estado_id" => 35,
                "nome"     => "Pracinha",
            ],
            [
                "ibge_codigo"       => 3540903,
                "ibge_estado_id" => 35,
                "nome"     => "Pradópolis",
            ],
            [
                "ibge_codigo"       => 3541000,
                "ibge_estado_id" => 35,
                "nome"     => "Praia Grande",
            ],
            [
                "ibge_codigo"       => 3541059,
                "ibge_estado_id" => 35,
                "nome"     => "Pratânia",
            ],
            [
                "ibge_codigo"       => 3541109,
                "ibge_estado_id" => 35,
                "nome"     => "Presidente Alves",
            ],
            [
                "ibge_codigo"       => 3541208,
                "ibge_estado_id" => 35,
                "nome"     => "Presidente Bernardes",
            ],
            [
                "ibge_codigo"       => 3541307,
                "ibge_estado_id" => 35,
                "nome"     => "Presidente Epitácio",
            ],
            [
                "ibge_codigo"       => 3541406,
                "ibge_estado_id" => 35,
                "nome"     => "Presidente Prudente",
            ],
            [
                "ibge_codigo"       => 3541505,
                "ibge_estado_id" => 35,
                "nome"     => "Presidente Venceslau",
            ],
            [
                "ibge_codigo"       => 3541604,
                "ibge_estado_id" => 35,
                "nome"     => "Promissão",
            ],
            [
                "ibge_codigo"       => 3541653,
                "ibge_estado_id" => 35,
                "nome"     => "Quadra",
            ],
            [
                "ibge_codigo"       => 3541703,
                "ibge_estado_id" => 35,
                "nome"     => "Quatá",
            ],
            [
                "ibge_codigo"       => 3541802,
                "ibge_estado_id" => 35,
                "nome"     => "Queiroz",
            ],
            [
                "ibge_codigo"       => 3541901,
                "ibge_estado_id" => 35,
                "nome"     => "Queluz",
            ],
            [
                "ibge_codigo"       => 3542008,
                "ibge_estado_id" => 35,
                "nome"     => "Quintana",
            ],
            [
                "ibge_codigo"       => 3542107,
                "ibge_estado_id" => 35,
                "nome"     => "Rafard",
            ],
            [
                "ibge_codigo"       => 3542206,
                "ibge_estado_id" => 35,
                "nome"     => "Rancharia",
            ],
            [
                "ibge_codigo"       => 3542305,
                "ibge_estado_id" => 35,
                "nome"     => "Redenção da Serra",
            ],
            [
                "ibge_codigo"       => 3542404,
                "ibge_estado_id" => 35,
                "nome"     => "Regente Feijó",
            ],
            [
                "ibge_codigo"       => 3542503,
                "ibge_estado_id" => 35,
                "nome"     => "Reginópolis",
            ],
            [
                "ibge_codigo"       => 3542602,
                "ibge_estado_id" => 35,
                "nome"     => "Registro",
            ],
            [
                "ibge_codigo"       => 3542701,
                "ibge_estado_id" => 35,
                "nome"     => "Restinga",
            ],
            [
                "ibge_codigo"       => 3542800,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeira",
            ],
            [
                "ibge_codigo"       => 3542909,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeirão Bonito",
            ],
            [
                "ibge_codigo"       => 3543006,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeirão Branco",
            ],
            [
                "ibge_codigo"       => 3543105,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeirão Corrente",
            ],
            [
                "ibge_codigo"       => 3543204,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeirão do Sul",
            ],
            [
                "ibge_codigo"       => 3543238,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeirão dos Índios",
            ],
            [
                "ibge_codigo"       => 3543253,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeirão Grande",
            ],
            [
                "ibge_codigo"       => 3543303,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeirão Pires",
            ],
            [
                "ibge_codigo"       => 3543402,
                "ibge_estado_id" => 35,
                "nome"     => "Ribeirão Preto",
            ],
            [
                "ibge_codigo"       => 3543501,
                "ibge_estado_id" => 35,
                "nome"     => "Riversul",
            ],
            [
                "ibge_codigo"       => 3543600,
                "ibge_estado_id" => 35,
                "nome"     => "Rifaina",
            ],
            [
                "ibge_codigo"       => 3543709,
                "ibge_estado_id" => 35,
                "nome"     => "Rincão",
            ],
            [
                "ibge_codigo"       => 3543808,
                "ibge_estado_id" => 35,
                "nome"     => "Rinópolis",
            ],
            [
                "ibge_codigo"       => 3543907,
                "ibge_estado_id" => 35,
                "nome"     => "Rio Claro",
            ],
            [
                "ibge_codigo"       => 3544004,
                "ibge_estado_id" => 35,
                "nome"     => "Rio das Pedras",
            ],
            [
                "ibge_codigo"       => 3544103,
                "ibge_estado_id" => 35,
                "nome"     => "Rio Grande da Serra",
            ],
            [
                "ibge_codigo"       => 3544202,
                "ibge_estado_id" => 35,
                "nome"     => "Riolândia",
            ],
            [
                "ibge_codigo"       => 3544251,
                "ibge_estado_id" => 35,
                "nome"     => "Rosana",
            ],
            [
                "ibge_codigo"       => 3544301,
                "ibge_estado_id" => 35,
                "nome"     => "Roseira",
            ],
            [
                "ibge_codigo"       => 3544400,
                "ibge_estado_id" => 35,
                "nome"     => "Rubiácea",
            ],
            [
                "ibge_codigo"       => 3544509,
                "ibge_estado_id" => 35,
                "nome"     => "Rubinéia",
            ],
            [
                "ibge_codigo"       => 3544608,
                "ibge_estado_id" => 35,
                "nome"     => "Sabino",
            ],
            [
                "ibge_codigo"       => 3544707,
                "ibge_estado_id" => 35,
                "nome"     => "Sagres",
            ],
            [
                "ibge_codigo"       => 3544806,
                "ibge_estado_id" => 35,
                "nome"     => "Sales",
            ],
            [
                "ibge_codigo"       => 3544905,
                "ibge_estado_id" => 35,
                "nome"     => "Sales Oliveira",
            ],
            [
                "ibge_codigo"       => 3545001,
                "ibge_estado_id" => 35,
                "nome"     => "Salesópolis",
            ],
            [
                "ibge_codigo"       => 3545100,
                "ibge_estado_id" => 35,
                "nome"     => "Salmourão",
            ],
            [
                "ibge_codigo"       => 3545159,
                "ibge_estado_id" => 35,
                "nome"     => "Saltinho",
            ],
            [
                "ibge_codigo"       => 3545209,
                "ibge_estado_id" => 35,
                "nome"     => "Salto",
            ],
            [
                "ibge_codigo"       => 3545308,
                "ibge_estado_id" => 35,
                "nome"     => "Salto de Pirapora",
            ],
            [
                "ibge_codigo"       => 3545407,
                "ibge_estado_id" => 35,
                "nome"     => "Salto Grande",
            ],
            [
                "ibge_codigo"       => 3545506,
                "ibge_estado_id" => 35,
                "nome"     => "Sandovalina",
            ],
            [
                "ibge_codigo"       => 3545605,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Adélia",
            ],
            [
                "ibge_codigo"       => 3545704,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Albertina",
            ],
            [
                "ibge_codigo"       => 3545803,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Bárbara d'Oeste",
            ],
            [
                "ibge_codigo"       => 3546009,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Branca",
            ],
            [
                "ibge_codigo"       => 3546108,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Clara d'Oeste",
            ],
            [
                "ibge_codigo"       => 3546207,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Cruz da Conceição",
            ],
            [
                "ibge_codigo"       => 3546256,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Cruz da Esperança",
            ],
            [
                "ibge_codigo"       => 3546306,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Cruz das Palmeiras",
            ],
            [
                "ibge_codigo"       => 3546405,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Cruz do Rio Pardo",
            ],
            [
                "ibge_codigo"       => 3546504,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Ernestina",
            ],
            [
                "ibge_codigo"       => 3546603,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Fé do Sul",
            ],
            [
                "ibge_codigo"       => 3546702,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Gertrudes",
            ],
            [
                "ibge_codigo"       => 3546801,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Isabel",
            ],
            [
                "ibge_codigo"       => 3546900,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Lúcia",
            ],
            [
                "ibge_codigo"       => 3547007,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Maria da Serra",
            ],
            [
                "ibge_codigo"       => 3547106,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Mercedes",
            ],
            [
                "ibge_codigo"       => 3547205,
                "ibge_estado_id" => 35,
                "nome"     => "Santana da Ponte Pensa",
            ],
            [
                "ibge_codigo"       => 3547304,
                "ibge_estado_id" => 35,
                "nome"     => "Santana de Parnaíba",
            ],
            [
                "ibge_codigo"       => 3547403,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Rita d'Oeste",
            ],
            [
                "ibge_codigo"       => 3547502,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Rita do Passa Quatro",
            ],
            [
                "ibge_codigo"       => 3547601,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Rosa de Viterbo",
            ],
            [
                "ibge_codigo"       => 3547650,
                "ibge_estado_id" => 35,
                "nome"     => "Santa Salete",
            ],
            [
                "ibge_codigo"       => 3547700,
                "ibge_estado_id" => 35,
                "nome"     => "Santo Anastácio",
            ],
            [
                "ibge_codigo"       => 3547809,
                "ibge_estado_id" => 35,
                "nome"     => "Santo André",
            ],
            [
                "ibge_codigo"       => 3547908,
                "ibge_estado_id" => 35,
                "nome"     => "Santo Antônio da Alegria",
            ],
            [
                "ibge_codigo"       => 3548005,
                "ibge_estado_id" => 35,
                "nome"     => "Santo Antônio de Posse",
            ],
            [
                "ibge_codigo"       => 3548054,
                "ibge_estado_id" => 35,
                "nome"     => "Santo Antônio do Aracanguá",
            ],
            [
                "ibge_codigo"       => 3548104,
                "ibge_estado_id" => 35,
                "nome"     => "Santo Antônio do Jardim",
            ],
            [
                "ibge_codigo"       => 3548203,
                "ibge_estado_id" => 35,
                "nome"     => "Santo Antônio do Pinhal",
            ],
            [
                "ibge_codigo"       => 3548302,
                "ibge_estado_id" => 35,
                "nome"     => "Santo Expedito",
            ],
            [
                "ibge_codigo"       => 3548401,
                "ibge_estado_id" => 35,
                "nome"     => "Santópolis do Aguapeí",
            ],
            [
                "ibge_codigo"       => 3548500,
                "ibge_estado_id" => 35,
                "nome"     => "Santos",
            ],
            [
                "ibge_codigo"       => 3548609,
                "ibge_estado_id" => 35,
                "nome"     => "São Bento do Sapucaí",
            ],
            [
                "ibge_codigo"       => 3548708,
                "ibge_estado_id" => 35,
                "nome"     => "São Bernardo do Campo",
            ],
            [
                "ibge_codigo"       => 3548807,
                "ibge_estado_id" => 35,
                "nome"     => "São Caetano do Sul",
            ],
            [
                "ibge_codigo"       => 3548906,
                "ibge_estado_id" => 35,
                "nome"     => "São Carlos",
            ],
            [
                "ibge_codigo"       => 3549003,
                "ibge_estado_id" => 35,
                "nome"     => "São Francisco",
            ],
            [
                "ibge_codigo"       => 3549102,
                "ibge_estado_id" => 35,
                "nome"     => "São João da Boa Vista",
            ],
            [
                "ibge_codigo"       => 3549201,
                "ibge_estado_id" => 35,
                "nome"     => "São João das Duas Pontes",
            ],
            [
                "ibge_codigo"       => 3549250,
                "ibge_estado_id" => 35,
                "nome"     => "São João de Iracema",
            ],
            [
                "ibge_codigo"       => 3549300,
                "ibge_estado_id" => 35,
                "nome"     => "São João do Pau d'Alho",
            ],
            [
                "ibge_codigo"       => 3549409,
                "ibge_estado_id" => 35,
                "nome"     => "São Joaquim da Barra",
            ],
            [
                "ibge_codigo"       => 3549508,
                "ibge_estado_id" => 35,
                "nome"     => "São José da Bela Vista",
            ],
            [
                "ibge_codigo"       => 3549607,
                "ibge_estado_id" => 35,
                "nome"     => "São José do Barreiro",
            ],
            [
                "ibge_codigo"       => 3549706,
                "ibge_estado_id" => 35,
                "nome"     => "São José do Rio Pardo",
            ],
            [
                "ibge_codigo"       => 3549805,
                "ibge_estado_id" => 35,
                "nome"     => "São José do Rio Preto",
            ],
            [
                "ibge_codigo"       => 3549904,
                "ibge_estado_id" => 35,
                "nome"     => "São José dos Campos",
            ],
            [
                "ibge_codigo"       => 3549953,
                "ibge_estado_id" => 35,
                "nome"     => "São Lourenço da Serra",
            ],
            [
                "ibge_codigo"       => 3550001,
                "ibge_estado_id" => 35,
                "nome"     => "São Luís do Paraitinga",
            ],
            [
                "ibge_codigo"       => 3550100,
                "ibge_estado_id" => 35,
                "nome"     => "São Manuel",
            ],
            [
                "ibge_codigo"       => 3550209,
                "ibge_estado_id" => 35,
                "nome"     => "São Miguel Arcanjo",
            ],
            [
                "ibge_codigo"       => 3550308,
                "ibge_estado_id" => 35,
                "nome"     => "São Paulo",
            ],
            [
                "ibge_codigo"       => 3550407,
                "ibge_estado_id" => 35,
                "nome"     => "São Pedro",
            ],
            [
                "ibge_codigo"       => 3550506,
                "ibge_estado_id" => 35,
                "nome"     => "São Pedro do Turvo",
            ],
            [
                "ibge_codigo"       => 3550605,
                "ibge_estado_id" => 35,
                "nome"     => "São Roque",
            ],
            [
                "ibge_codigo"       => 3550704,
                "ibge_estado_id" => 35,
                "nome"     => "São Sebastião",
            ],
            [
                "ibge_codigo"       => 3550803,
                "ibge_estado_id" => 35,
                "nome"     => "São Sebastião da Grama",
            ],
            [
                "ibge_codigo"       => 3550902,
                "ibge_estado_id" => 35,
                "nome"     => "São Simão",
            ],
            [
                "ibge_codigo"       => 3551009,
                "ibge_estado_id" => 35,
                "nome"     => "São Vicente",
            ],
            [
                "ibge_codigo"       => 3551108,
                "ibge_estado_id" => 35,
                "nome"     => "Sarapuí",
            ],
            [
                "ibge_codigo"       => 3551207,
                "ibge_estado_id" => 35,
                "nome"     => "Sarutaiá",
            ],
            [
                "ibge_codigo"       => 3551306,
                "ibge_estado_id" => 35,
                "nome"     => "Sebastianópolis do Sul",
            ],
            [
                "ibge_codigo"       => 3551405,
                "ibge_estado_id" => 35,
                "nome"     => "Serra Azul",
            ],
            [
                "ibge_codigo"       => 3551504,
                "ibge_estado_id" => 35,
                "nome"     => "Serrana",
            ],
            [
                "ibge_codigo"       => 3551603,
                "ibge_estado_id" => 35,
                "nome"     => "Serra Negra",
            ],
            [
                "ibge_codigo"       => 3551702,
                "ibge_estado_id" => 35,
                "nome"     => "Sertãozinho",
            ],
            [
                "ibge_codigo"       => 3551801,
                "ibge_estado_id" => 35,
                "nome"     => "Sete Barras",
            ],
            [
                "ibge_codigo"       => 3551900,
                "ibge_estado_id" => 35,
                "nome"     => "Severínia",
            ],
            [
                "ibge_codigo"       => 3552007,
                "ibge_estado_id" => 35,
                "nome"     => "Silveiras",
            ],
            [
                "ibge_codigo"       => 3552106,
                "ibge_estado_id" => 35,
                "nome"     => "Socorro",
            ],
            [
                "ibge_codigo"       => 3552205,
                "ibge_estado_id" => 35,
                "nome"     => "Sorocaba",
            ],
            [
                "ibge_codigo"       => 3552304,
                "ibge_estado_id" => 35,
                "nome"     => "Sud Mennucci",
            ],
            [
                "ibge_codigo"       => 3552403,
                "ibge_estado_id" => 35,
                "nome"     => "Sumaré",
            ],
            [
                "ibge_codigo"       => 3552502,
                "ibge_estado_id" => 35,
                "nome"     => "Suzano",
            ],
            [
                "ibge_codigo"       => 3552551,
                "ibge_estado_id" => 35,
                "nome"     => "Suzanápolis",
            ],
            [
                "ibge_codigo"       => 3552601,
                "ibge_estado_id" => 35,
                "nome"     => "Tabapuã",
            ],
            [
                "ibge_codigo"       => 3552700,
                "ibge_estado_id" => 35,
                "nome"     => "Tabatinga",
            ],
            [
                "ibge_codigo"       => 3552809,
                "ibge_estado_id" => 35,
                "nome"     => "Taboão da Serra",
            ],
            [
                "ibge_codigo"       => 3552908,
                "ibge_estado_id" => 35,
                "nome"     => "Taciba",
            ],
            [
                "ibge_codigo"       => 3553005,
                "ibge_estado_id" => 35,
                "nome"     => "Taguaí",
            ],
            [
                "ibge_codigo"       => 3553104,
                "ibge_estado_id" => 35,
                "nome"     => "Taiaçu",
            ],
            [
                "ibge_codigo"       => 3553203,
                "ibge_estado_id" => 35,
                "nome"     => "Taiúva",
            ],
            [
                "ibge_codigo"       => 3553302,
                "ibge_estado_id" => 35,
                "nome"     => "Tambaú",
            ],
            [
                "ibge_codigo"       => 3553401,
                "ibge_estado_id" => 35,
                "nome"     => "Tanabi",
            ],
            [
                "ibge_codigo"       => 3553500,
                "ibge_estado_id" => 35,
                "nome"     => "Tapiraí",
            ],
            [
                "ibge_codigo"       => 3553609,
                "ibge_estado_id" => 35,
                "nome"     => "Tapiratiba",
            ],
            [
                "ibge_codigo"       => 3553658,
                "ibge_estado_id" => 35,
                "nome"     => "Taquaral",
            ],
            [
                "ibge_codigo"       => 3553708,
                "ibge_estado_id" => 35,
                "nome"     => "Taquaritinga",
            ],
            [
                "ibge_codigo"       => 3553807,
                "ibge_estado_id" => 35,
                "nome"     => "Taquarituba",
            ],
            [
                "ibge_codigo"       => 3553856,
                "ibge_estado_id" => 35,
                "nome"     => "Taquarivaí",
            ],
            [
                "ibge_codigo"       => 3553906,
                "ibge_estado_id" => 35,
                "nome"     => "Tarabai",
            ],
            [
                "ibge_codigo"       => 3553955,
                "ibge_estado_id" => 35,
                "nome"     => "Tarumã",
            ],
            [
                "ibge_codigo"       => 3554003,
                "ibge_estado_id" => 35,
                "nome"     => "Tatuí",
            ],
            [
                "ibge_codigo"       => 3554102,
                "ibge_estado_id" => 35,
                "nome"     => "Taubaté",
            ],
            [
                "ibge_codigo"       => 3554201,
                "ibge_estado_id" => 35,
                "nome"     => "Tejupá",
            ],
            [
                "ibge_codigo"       => 3554300,
                "ibge_estado_id" => 35,
                "nome"     => "Teodoro Sampaio",
            ],
            [
                "ibge_codigo"       => 3554409,
                "ibge_estado_id" => 35,
                "nome"     => "Terra Roxa",
            ],
            [
                "ibge_codigo"       => 3554508,
                "ibge_estado_id" => 35,
                "nome"     => "Tietê",
            ],
            [
                "ibge_codigo"       => 3554607,
                "ibge_estado_id" => 35,
                "nome"     => "Timburi",
            ],
            [
                "ibge_codigo"       => 3554656,
                "ibge_estado_id" => 35,
                "nome"     => "Torre de Pedra",
            ],
            [
                "ibge_codigo"       => 3554706,
                "ibge_estado_id" => 35,
                "nome"     => "Torrinha",
            ],
            [
                "ibge_codigo"       => 3554755,
                "ibge_estado_id" => 35,
                "nome"     => "Trabiju",
            ],
            [
                "ibge_codigo"       => 3554805,
                "ibge_estado_id" => 35,
                "nome"     => "Tremembé",
            ],
            [
                "ibge_codigo"       => 3554904,
                "ibge_estado_id" => 35,
                "nome"     => "Três Fronteiras",
            ],
            [
                "ibge_codigo"       => 3554953,
                "ibge_estado_id" => 35,
                "nome"     => "Tuiuti",
            ],
            [
                "ibge_codigo"       => 3555000,
                "ibge_estado_id" => 35,
                "nome"     => "Tupã",
            ],
            [
                "ibge_codigo"       => 3555109,
                "ibge_estado_id" => 35,
                "nome"     => "Tupi Paulista",
            ],
            [
                "ibge_codigo"       => 3555208,
                "ibge_estado_id" => 35,
                "nome"     => "Turiúba",
            ],
            [
                "ibge_codigo"       => 3555307,
                "ibge_estado_id" => 35,
                "nome"     => "Turmalina",
            ],
            [
                "ibge_codigo"       => 3555356,
                "ibge_estado_id" => 35,
                "nome"     => "Ubarana",
            ],
            [
                "ibge_codigo"       => 3555406,
                "ibge_estado_id" => 35,
                "nome"     => "Ubatuba",
            ],
            [
                "ibge_codigo"       => 3555505,
                "ibge_estado_id" => 35,
                "nome"     => "Ubirajara",
            ],
            [
                "ibge_codigo"       => 3555604,
                "ibge_estado_id" => 35,
                "nome"     => "Uchoa",
            ],
            [
                "ibge_codigo"       => 3555703,
                "ibge_estado_id" => 35,
                "nome"     => "União Paulista",
            ],
            [
                "ibge_codigo"       => 3555802,
                "ibge_estado_id" => 35,
                "nome"     => "Urânia",
            ],
            [
                "ibge_codigo"       => 3555901,
                "ibge_estado_id" => 35,
                "nome"     => "Uru",
            ],
            [
                "ibge_codigo"       => 3556008,
                "ibge_estado_id" => 35,
                "nome"     => "Urupês",
            ],
            [
                "ibge_codigo"       => 3556107,
                "ibge_estado_id" => 35,
                "nome"     => "Valentim Gentil",
            ],
            [
                "ibge_codigo"       => 3556206,
                "ibge_estado_id" => 35,
                "nome"     => "Valinhos",
            ],
            [
                "ibge_codigo"       => 3556305,
                "ibge_estado_id" => 35,
                "nome"     => "Valparaíso",
            ],
            [
                "ibge_codigo"       => 3556354,
                "ibge_estado_id" => 35,
                "nome"     => "Vargem",
            ],
            [
                "ibge_codigo"       => 3556404,
                "ibge_estado_id" => 35,
                "nome"     => "Vargem Grande do Sul",
            ],
            [
                "ibge_codigo"       => 3556453,
                "ibge_estado_id" => 35,
                "nome"     => "Vargem Grande Paulista",
            ],
            [
                "ibge_codigo"       => 3556503,
                "ibge_estado_id" => 35,
                "nome"     => "Várzea Paulista",
            ],
            [
                "ibge_codigo"       => 3556602,
                "ibge_estado_id" => 35,
                "nome"     => "Vera Cruz",
            ],
            [
                "ibge_codigo"       => 3556701,
                "ibge_estado_id" => 35,
                "nome"     => "Vinhedo",
            ],
            [
                "ibge_codigo"       => 3556800,
                "ibge_estado_id" => 35,
                "nome"     => "Viradouro",
            ],
            [
                "ibge_codigo"       => 3556909,
                "ibge_estado_id" => 35,
                "nome"     => "Vista Alegre do Alto",
            ],
            [
                "ibge_codigo"       => 3556958,
                "ibge_estado_id" => 35,
                "nome"     => "Vitória Brasil",
            ],
            [
                "ibge_codigo"       => 3557006,
                "ibge_estado_id" => 35,
                "nome"     => "Votorantim",
            ],
            [
                "ibge_codigo"       => 3557105,
                "ibge_estado_id" => 35,
                "nome"     => "Votuporanga",
            ],
            [
                "ibge_codigo"       => 3557154,
                "ibge_estado_id" => 35,
                "nome"     => "Zacarias",
            ],
            [
                "ibge_codigo"       => 3557204,
                "ibge_estado_id" => 35,
                "nome"     => "Chavantes",
            ],
            [
                "ibge_codigo"       => 3557303,
                "ibge_estado_id" => 35,
                "nome"     => "Estiva Gerbi",
            ],
            [
                "ibge_codigo"       => 4100103,
                "ibge_estado_id" => 41,
                "nome"     => "Abatiá",
            ],
            [
                "ibge_codigo"       => 4100202,
                "ibge_estado_id" => 41,
                "nome"     => "Adrianópolis",
            ],
            [
                "ibge_codigo"       => 4100301,
                "ibge_estado_id" => 41,
                "nome"     => "Agudos do Sul",
            ],
            [
                "ibge_codigo"       => 4100400,
                "ibge_estado_id" => 41,
                "nome"     => "Almirante Tamandaré",
            ],
            [
                "ibge_codigo"       => 4100459,
                "ibge_estado_id" => 41,
                "nome"     => "Altamira do Paraná",
            ],
            [
                "ibge_codigo"       => 4100509,
                "ibge_estado_id" => 41,
                "nome"     => "Altônia",
            ],
            [
                "ibge_codigo"       => 4100608,
                "ibge_estado_id" => 41,
                "nome"     => "Alto Paraná",
            ],
            [
                "ibge_codigo"       => 4100707,
                "ibge_estado_id" => 41,
                "nome"     => "Alto Piquiri",
            ],
            [
                "ibge_codigo"       => 4100806,
                "ibge_estado_id" => 41,
                "nome"     => "Alvorada do Sul",
            ],
            [
                "ibge_codigo"       => 4100905,
                "ibge_estado_id" => 41,
                "nome"     => "Amaporã",
            ],
            [
                "ibge_codigo"       => 4101002,
                "ibge_estado_id" => 41,
                "nome"     => "Ampére",
            ],
            [
                "ibge_codigo"       => 4101051,
                "ibge_estado_id" => 41,
                "nome"     => "Anahy",
            ],
            [
                "ibge_codigo"       => 4101101,
                "ibge_estado_id" => 41,
                "nome"     => "Andirá",
            ],
            [
                "ibge_codigo"       => 4101150,
                "ibge_estado_id" => 41,
                "nome"     => "Ângulo",
            ],
            [
                "ibge_codigo"       => 4101200,
                "ibge_estado_id" => 41,
                "nome"     => "Antonina",
            ],
            [
                "ibge_codigo"       => 4101309,
                "ibge_estado_id" => 41,
                "nome"     => "Antônio Olinto",
            ],
            [
                "ibge_codigo"       => 4101408,
                "ibge_estado_id" => 41,
                "nome"     => "Apucarana",
            ],
            [
                "ibge_codigo"       => 4101507,
                "ibge_estado_id" => 41,
                "nome"     => "Arapongas",
            ],
            [
                "ibge_codigo"       => 4101606,
                "ibge_estado_id" => 41,
                "nome"     => "Arapoti",
            ],
            [
                "ibge_codigo"       => 4101655,
                "ibge_estado_id" => 41,
                "nome"     => "Arapuã",
            ],
            [
                "ibge_codigo"       => 4101705,
                "ibge_estado_id" => 41,
                "nome"     => "Araruna",
            ],
            [
                "ibge_codigo"       => 4101804,
                "ibge_estado_id" => 41,
                "nome"     => "Araucária",
            ],
            [
                "ibge_codigo"       => 4101853,
                "ibge_estado_id" => 41,
                "nome"     => "Ariranha do Ivaí",
            ],
            [
                "ibge_codigo"       => 4101903,
                "ibge_estado_id" => 41,
                "nome"     => "Assaí",
            ],
            [
                "ibge_codigo"       => 4102000,
                "ibge_estado_id" => 41,
                "nome"     => "Assis Chateaubriand",
            ],
            [
                "ibge_codigo"       => 4102109,
                "ibge_estado_id" => 41,
                "nome"     => "Astorga",
            ],
            [
                "ibge_codigo"       => 4102208,
                "ibge_estado_id" => 41,
                "nome"     => "Atalaia",
            ],
            [
                "ibge_codigo"       => 4102307,
                "ibge_estado_id" => 41,
                "nome"     => "Balsa Nova",
            ],
            [
                "ibge_codigo"       => 4102406,
                "ibge_estado_id" => 41,
                "nome"     => "Bandeirantes",
            ],
            [
                "ibge_codigo"       => 4102505,
                "ibge_estado_id" => 41,
                "nome"     => "Barbosa Ferraz",
            ],
            [
                "ibge_codigo"       => 4102604,
                "ibge_estado_id" => 41,
                "nome"     => "Barracão",
            ],
            [
                "ibge_codigo"       => 4102703,
                "ibge_estado_id" => 41,
                "nome"     => "Barra do Jacaré",
            ],
            [
                "ibge_codigo"       => 4102752,
                "ibge_estado_id" => 41,
                "nome"     => "Bela Vista da Caroba",
            ],
            [
                "ibge_codigo"       => 4102802,
                "ibge_estado_id" => 41,
                "nome"     => "Bela Vista do Paraíso",
            ],
            [
                "ibge_codigo"       => 4102901,
                "ibge_estado_id" => 41,
                "nome"     => "Bituruna",
            ],
            [
                "ibge_codigo"       => 4103008,
                "ibge_estado_id" => 41,
                "nome"     => "Boa Esperança",
            ],
            [
                "ibge_codigo"       => 4103024,
                "ibge_estado_id" => 41,
                "nome"     => "Boa Esperança do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4103040,
                "ibge_estado_id" => 41,
                "nome"     => "Boa Ventura de São Roque",
            ],
            [
                "ibge_codigo"       => 4103057,
                "ibge_estado_id" => 41,
                "nome"     => "Boa Vista da Aparecida",
            ],
            [
                "ibge_codigo"       => 4103107,
                "ibge_estado_id" => 41,
                "nome"     => "Bocaiúva do Sul",
            ],
            [
                "ibge_codigo"       => 4103156,
                "ibge_estado_id" => 41,
                "nome"     => "Bom Jesus do Sul",
            ],
            [
                "ibge_codigo"       => 4103206,
                "ibge_estado_id" => 41,
                "nome"     => "Bom Sucesso",
            ],
            [
                "ibge_codigo"       => 4103222,
                "ibge_estado_id" => 41,
                "nome"     => "Bom Sucesso do Sul",
            ],
            [
                "ibge_codigo"       => 4103305,
                "ibge_estado_id" => 41,
                "nome"     => "Borrazópolis",
            ],
            [
                "ibge_codigo"       => 4103354,
                "ibge_estado_id" => 41,
                "nome"     => "Braganey",
            ],
            [
                "ibge_codigo"       => 4103370,
                "ibge_estado_id" => 41,
                "nome"     => "Brasilândia do Sul",
            ],
            [
                "ibge_codigo"       => 4103404,
                "ibge_estado_id" => 41,
                "nome"     => "Cafeara",
            ],
            [
                "ibge_codigo"       => 4103453,
                "ibge_estado_id" => 41,
                "nome"     => "Cafelândia",
            ],
            [
                "ibge_codigo"       => 4103479,
                "ibge_estado_id" => 41,
                "nome"     => "Cafezal do Sul",
            ],
            [
                "ibge_codigo"       => 4103503,
                "ibge_estado_id" => 41,
                "nome"     => "Califórnia",
            ],
            [
                "ibge_codigo"       => 4103602,
                "ibge_estado_id" => 41,
                "nome"     => "Cambará",
            ],
            [
                "ibge_codigo"       => 4103701,
                "ibge_estado_id" => 41,
                "nome"     => "Cambé",
            ],
            [
                "ibge_codigo"       => 4103800,
                "ibge_estado_id" => 41,
                "nome"     => "Cambira",
            ],
            [
                "ibge_codigo"       => 4103909,
                "ibge_estado_id" => 41,
                "nome"     => "Campina da Lagoa",
            ],
            [
                "ibge_codigo"       => 4103958,
                "ibge_estado_id" => 41,
                "nome"     => "Campina do Simão",
            ],
            [
                "ibge_codigo"       => 4104006,
                "ibge_estado_id" => 41,
                "nome"     => "Campina Grande do Sul",
            ],
            [
                "ibge_codigo"       => 4104055,
                "ibge_estado_id" => 41,
                "nome"     => "Campo Bonito",
            ],
            [
                "ibge_codigo"       => 4104105,
                "ibge_estado_id" => 41,
                "nome"     => "Campo do Tenente",
            ],
            [
                "ibge_codigo"       => 4104204,
                "ibge_estado_id" => 41,
                "nome"     => "Campo Largo",
            ],
            [
                "ibge_codigo"       => 4104253,
                "ibge_estado_id" => 41,
                "nome"     => "Campo Magro",
            ],
            [
                "ibge_codigo"       => 4104303,
                "ibge_estado_id" => 41,
                "nome"     => "Campo Mourão",
            ],
            [
                "ibge_codigo"       => 4104402,
                "ibge_estado_id" => 41,
                "nome"     => "Cândido de Abreu",
            ],
            [
                "ibge_codigo"       => 4104428,
                "ibge_estado_id" => 41,
                "nome"     => "Candói",
            ],
            [
                "ibge_codigo"       => 4104451,
                "ibge_estado_id" => 41,
                "nome"     => "Cantagalo",
            ],
            [
                "ibge_codigo"       => 4104501,
                "ibge_estado_id" => 41,
                "nome"     => "Capanema",
            ],
            [
                "ibge_codigo"       => 4104600,
                "ibge_estado_id" => 41,
                "nome"     => "Capitão Leônidas Marques",
            ],
            [
                "ibge_codigo"       => 4104659,
                "ibge_estado_id" => 41,
                "nome"     => "Carambeí",
            ],
            [
                "ibge_codigo"       => 4104709,
                "ibge_estado_id" => 41,
                "nome"     => "Carlópolis",
            ],
            [
                "ibge_codigo"       => 4104808,
                "ibge_estado_id" => 41,
                "nome"     => "Cascavel",
            ],
            [
                "ibge_codigo"       => 4104907,
                "ibge_estado_id" => 41,
                "nome"     => "Castro",
            ],
            [
                "ibge_codigo"       => 4105003,
                "ibge_estado_id" => 41,
                "nome"     => "Catanduvas",
            ],
            [
                "ibge_codigo"       => 4105102,
                "ibge_estado_id" => 41,
                "nome"     => "Centenário do Sul",
            ],
            [
                "ibge_codigo"       => 4105201,
                "ibge_estado_id" => 41,
                "nome"     => "Cerro Azul",
            ],
            [
                "ibge_codigo"       => 4105300,
                "ibge_estado_id" => 41,
                "nome"     => "Céu Azul",
            ],
            [
                "ibge_codigo"       => 4105409,
                "ibge_estado_id" => 41,
                "nome"     => "Chopinzinho",
            ],
            [
                "ibge_codigo"       => 4105508,
                "ibge_estado_id" => 41,
                "nome"     => "Cianorte",
            ],
            [
                "ibge_codigo"       => 4105607,
                "ibge_estado_id" => 41,
                "nome"     => "Cidade Gaúcha",
            ],
            [
                "ibge_codigo"       => 4105706,
                "ibge_estado_id" => 41,
                "nome"     => "Clevelândia",
            ],
            [
                "ibge_codigo"       => 4105805,
                "ibge_estado_id" => 41,
                "nome"     => "Colombo",
            ],
            [
                "ibge_codigo"       => 4105904,
                "ibge_estado_id" => 41,
                "nome"     => "Colorado",
            ],
            [
                "ibge_codigo"       => 4106001,
                "ibge_estado_id" => 41,
                "nome"     => "Congonhinhas",
            ],
            [
                "ibge_codigo"       => 4106100,
                "ibge_estado_id" => 41,
                "nome"     => "Conselheiro Mairinck",
            ],
            [
                "ibge_codigo"       => 4106209,
                "ibge_estado_id" => 41,
                "nome"     => "Contenda",
            ],
            [
                "ibge_codigo"       => 4106308,
                "ibge_estado_id" => 41,
                "nome"     => "Corbélia",
            ],
            [
                "ibge_codigo"       => 4106407,
                "ibge_estado_id" => 41,
                "nome"     => "Cornélio Procópio",
            ],
            [
                "ibge_codigo"       => 4106456,
                "ibge_estado_id" => 41,
                "nome"     => "Coronel Domingos Soares",
            ],
            [
                "ibge_codigo"       => 4106506,
                "ibge_estado_id" => 41,
                "nome"     => "Coronel Vivida",
            ],
            [
                "ibge_codigo"       => 4106555,
                "ibge_estado_id" => 41,
                "nome"     => "Corumbataí do Sul",
            ],
            [
                "ibge_codigo"       => 4106571,
                "ibge_estado_id" => 41,
                "nome"     => "Cruzeiro do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4106605,
                "ibge_estado_id" => 41,
                "nome"     => "Cruzeiro do Oeste",
            ],
            [
                "ibge_codigo"       => 4106704,
                "ibge_estado_id" => 41,
                "nome"     => "Cruzeiro do Sul",
            ],
            [
                "ibge_codigo"       => 4106803,
                "ibge_estado_id" => 41,
                "nome"     => "Cruz Machado",
            ],
            [
                "ibge_codigo"       => 4106852,
                "ibge_estado_id" => 41,
                "nome"     => "Cruzmaltina",
            ],
            [
                "ibge_codigo"       => 4106902,
                "ibge_estado_id" => 41,
                "nome"     => "Curitiba",
            ],
            [
                "ibge_codigo"       => 4107009,
                "ibge_estado_id" => 41,
                "nome"     => "Curiúva",
            ],
            [
                "ibge_codigo"       => 4107108,
                "ibge_estado_id" => 41,
                "nome"     => "Diamante do Norte",
            ],
            [
                "ibge_codigo"       => 4107124,
                "ibge_estado_id" => 41,
                "nome"     => "Diamante do Sul",
            ],
            [
                "ibge_codigo"       => 4107157,
                "ibge_estado_id" => 41,
                "nome"     => "Diamante d'Oeste",
            ],
            [
                "ibge_codigo"       => 4107207,
                "ibge_estado_id" => 41,
                "nome"     => "Dois Vizinhos",
            ],
            [
                "ibge_codigo"       => 4107256,
                "ibge_estado_id" => 41,
                "nome"     => "Douradina",
            ],
            [
                "ibge_codigo"       => 4107306,
                "ibge_estado_id" => 41,
                "nome"     => "Doutor Camargo",
            ],
            [
                "ibge_codigo"       => 4107405,
                "ibge_estado_id" => 41,
                "nome"     => "Enéas Marques",
            ],
            [
                "ibge_codigo"       => 4107504,
                "ibge_estado_id" => 41,
                "nome"     => "Engenheiro Beltrão",
            ],
            [
                "ibge_codigo"       => 4107520,
                "ibge_estado_id" => 41,
                "nome"     => "Esperança Nova",
            ],
            [
                "ibge_codigo"       => 4107538,
                "ibge_estado_id" => 41,
                "nome"     => "Entre Rios do Oeste",
            ],
            [
                "ibge_codigo"       => 4107546,
                "ibge_estado_id" => 41,
                "nome"     => "Espigão Alto do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4107553,
                "ibge_estado_id" => 41,
                "nome"     => "Farol",
            ],
            [
                "ibge_codigo"       => 4107603,
                "ibge_estado_id" => 41,
                "nome"     => "Faxinal",
            ],
            [
                "ibge_codigo"       => 4107652,
                "ibge_estado_id" => 41,
                "nome"     => "Fazenda Rio Grande",
            ],
            [
                "ibge_codigo"       => 4107702,
                "ibge_estado_id" => 41,
                "nome"     => "Fênix",
            ],
            [
                "ibge_codigo"       => 4107736,
                "ibge_estado_id" => 41,
                "nome"     => "Fernandes Pinheiro",
            ],
            [
                "ibge_codigo"       => 4107751,
                "ibge_estado_id" => 41,
                "nome"     => "Figueira",
            ],
            [
                "ibge_codigo"       => 4107801,
                "ibge_estado_id" => 41,
                "nome"     => "Floraí",
            ],
            [
                "ibge_codigo"       => 4107850,
                "ibge_estado_id" => 41,
                "nome"     => "Flor da Serra do Sul",
            ],
            [
                "ibge_codigo"       => 4107900,
                "ibge_estado_id" => 41,
                "nome"     => "Floresta",
            ],
            [
                "ibge_codigo"       => 4108007,
                "ibge_estado_id" => 41,
                "nome"     => "Florestópolis",
            ],
            [
                "ibge_codigo"       => 4108106,
                "ibge_estado_id" => 41,
                "nome"     => "Flórida",
            ],
            [
                "ibge_codigo"       => 4108205,
                "ibge_estado_id" => 41,
                "nome"     => "Formosa do Oeste",
            ],
            [
                "ibge_codigo"       => 4108304,
                "ibge_estado_id" => 41,
                "nome"     => "Foz do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4108320,
                "ibge_estado_id" => 41,
                "nome"     => "Francisco Alves",
            ],
            [
                "ibge_codigo"       => 4108403,
                "ibge_estado_id" => 41,
                "nome"     => "Francisco Beltrão",
            ],
            [
                "ibge_codigo"       => 4108452,
                "ibge_estado_id" => 41,
                "nome"     => "Foz do Jordão",
            ],
            [
                "ibge_codigo"       => 4108502,
                "ibge_estado_id" => 41,
                "nome"     => "General Carneiro",
            ],
            [
                "ibge_codigo"       => 4108551,
                "ibge_estado_id" => 41,
                "nome"     => "Godoy Moreira",
            ],
            [
                "ibge_codigo"       => 4108601,
                "ibge_estado_id" => 41,
                "nome"     => "Goioerê",
            ],
            [
                "ibge_codigo"       => 4108650,
                "ibge_estado_id" => 41,
                "nome"     => "Goioxim",
            ],
            [
                "ibge_codigo"       => 4108700,
                "ibge_estado_id" => 41,
                "nome"     => "Grandes Rios",
            ],
            [
                "ibge_codigo"       => 4108809,
                "ibge_estado_id" => 41,
                "nome"     => "Guaíra",
            ],
            [
                "ibge_codigo"       => 4108908,
                "ibge_estado_id" => 41,
                "nome"     => "Guairaçá",
            ],
            [
                "ibge_codigo"       => 4108957,
                "ibge_estado_id" => 41,
                "nome"     => "Guamiranga",
            ],
            [
                "ibge_codigo"       => 4109005,
                "ibge_estado_id" => 41,
                "nome"     => "Guapirama",
            ],
            [
                "ibge_codigo"       => 4109104,
                "ibge_estado_id" => 41,
                "nome"     => "Guaporema",
            ],
            [
                "ibge_codigo"       => 4109203,
                "ibge_estado_id" => 41,
                "nome"     => "Guaraci",
            ],
            [
                "ibge_codigo"       => 4109302,
                "ibge_estado_id" => 41,
                "nome"     => "Guaraniaçu",
            ],
            [
                "ibge_codigo"       => 4109401,
                "ibge_estado_id" => 41,
                "nome"     => "Guarapuava",
            ],
            [
                "ibge_codigo"       => 4109500,
                "ibge_estado_id" => 41,
                "nome"     => "Guaraqueçaba",
            ],
            [
                "ibge_codigo"       => 4109609,
                "ibge_estado_id" => 41,
                "nome"     => "Guaratuba",
            ],
            [
                "ibge_codigo"       => 4109658,
                "ibge_estado_id" => 41,
                "nome"     => "Honório Serpa",
            ],
            [
                "ibge_codigo"       => 4109708,
                "ibge_estado_id" => 41,
                "nome"     => "Ibaiti",
            ],
            [
                "ibge_codigo"       => 4109757,
                "ibge_estado_id" => 41,
                "nome"     => "Ibema",
            ],
            [
                "ibge_codigo"       => 4109807,
                "ibge_estado_id" => 41,
                "nome"     => "Ibiporã",
            ],
            [
                "ibge_codigo"       => 4109906,
                "ibge_estado_id" => 41,
                "nome"     => "Icaraíma",
            ],
            [
                "ibge_codigo"       => 4110003,
                "ibge_estado_id" => 41,
                "nome"     => "Iguaraçu",
            ],
            [
                "ibge_codigo"       => 4110052,
                "ibge_estado_id" => 41,
                "nome"     => "Iguatu",
            ],
            [
                "ibge_codigo"       => 4110078,
                "ibge_estado_id" => 41,
                "nome"     => "Imbaú",
            ],
            [
                "ibge_codigo"       => 4110102,
                "ibge_estado_id" => 41,
                "nome"     => "Imbituva",
            ],
            [
                "ibge_codigo"       => 4110201,
                "ibge_estado_id" => 41,
                "nome"     => "Inácio Martins",
            ],
            [
                "ibge_codigo"       => 4110300,
                "ibge_estado_id" => 41,
                "nome"     => "Inajá",
            ],
            [
                "ibge_codigo"       => 4110409,
                "ibge_estado_id" => 41,
                "nome"     => "Indianópolis",
            ],
            [
                "ibge_codigo"       => 4110508,
                "ibge_estado_id" => 41,
                "nome"     => "Ipiranga",
            ],
            [
                "ibge_codigo"       => 4110607,
                "ibge_estado_id" => 41,
                "nome"     => "Iporã",
            ],
            [
                "ibge_codigo"       => 4110656,
                "ibge_estado_id" => 41,
                "nome"     => "Iracema do Oeste",
            ],
            [
                "ibge_codigo"       => 4110706,
                "ibge_estado_id" => 41,
                "nome"     => "Irati",
            ],
            [
                "ibge_codigo"       => 4110805,
                "ibge_estado_id" => 41,
                "nome"     => "Iretama",
            ],
            [
                "ibge_codigo"       => 4110904,
                "ibge_estado_id" => 41,
                "nome"     => "Itaguajé",
            ],
            [
                "ibge_codigo"       => 4110953,
                "ibge_estado_id" => 41,
                "nome"     => "Itaipulândia",
            ],
            [
                "ibge_codigo"       => 4111001,
                "ibge_estado_id" => 41,
                "nome"     => "Itambaracá",
            ],
            [
                "ibge_codigo"       => 4111100,
                "ibge_estado_id" => 41,
                "nome"     => "Itambé",
            ],
            [
                "ibge_codigo"       => 4111209,
                "ibge_estado_id" => 41,
                "nome"     => "Itapejara d'Oeste",
            ],
            [
                "ibge_codigo"       => 4111258,
                "ibge_estado_id" => 41,
                "nome"     => "Itaperuçu",
            ],
            [
                "ibge_codigo"       => 4111308,
                "ibge_estado_id" => 41,
                "nome"     => "Itaúna do Sul",
            ],
            [
                "ibge_codigo"       => 4111407,
                "ibge_estado_id" => 41,
                "nome"     => "Ivaí",
            ],
            [
                "ibge_codigo"       => 4111506,
                "ibge_estado_id" => 41,
                "nome"     => "Ivaiporã",
            ],
            [
                "ibge_codigo"       => 4111555,
                "ibge_estado_id" => 41,
                "nome"     => "Ivaté",
            ],
            [
                "ibge_codigo"       => 4111605,
                "ibge_estado_id" => 41,
                "nome"     => "Ivatuba",
            ],
            [
                "ibge_codigo"       => 4111704,
                "ibge_estado_id" => 41,
                "nome"     => "Jaboti",
            ],
            [
                "ibge_codigo"       => 4111803,
                "ibge_estado_id" => 41,
                "nome"     => "Jacarezinho",
            ],
            [
                "ibge_codigo"       => 4111902,
                "ibge_estado_id" => 41,
                "nome"     => "Jaguapitã",
            ],
            [
                "ibge_codigo"       => 4112009,
                "ibge_estado_id" => 41,
                "nome"     => "Jaguariaíva",
            ],
            [
                "ibge_codigo"       => 4112108,
                "ibge_estado_id" => 41,
                "nome"     => "Jandaia do Sul",
            ],
            [
                "ibge_codigo"       => 4112207,
                "ibge_estado_id" => 41,
                "nome"     => "Janiópolis",
            ],
            [
                "ibge_codigo"       => 4112306,
                "ibge_estado_id" => 41,
                "nome"     => "Japira",
            ],
            [
                "ibge_codigo"       => 4112405,
                "ibge_estado_id" => 41,
                "nome"     => "Japurá",
            ],
            [
                "ibge_codigo"       => 4112504,
                "ibge_estado_id" => 41,
                "nome"     => "Jardim Alegre",
            ],
            [
                "ibge_codigo"       => 4112603,
                "ibge_estado_id" => 41,
                "nome"     => "Jardim Olinda",
            ],
            [
                "ibge_codigo"       => 4112702,
                "ibge_estado_id" => 41,
                "nome"     => "Jataizinho",
            ],
            [
                "ibge_codigo"       => 4112751,
                "ibge_estado_id" => 41,
                "nome"     => "Jesuítas",
            ],
            [
                "ibge_codigo"       => 4112801,
                "ibge_estado_id" => 41,
                "nome"     => "Joaquim Távora",
            ],
            [
                "ibge_codigo"       => 4112900,
                "ibge_estado_id" => 41,
                "nome"     => "Jundiaí do Sul",
            ],
            [
                "ibge_codigo"       => 4112959,
                "ibge_estado_id" => 41,
                "nome"     => "Juranda",
            ],
            [
                "ibge_codigo"       => 4113007,
                "ibge_estado_id" => 41,
                "nome"     => "Jussara",
            ],
            [
                "ibge_codigo"       => 4113106,
                "ibge_estado_id" => 41,
                "nome"     => "Kaloré",
            ],
            [
                "ibge_codigo"       => 4113205,
                "ibge_estado_id" => 41,
                "nome"     => "Lapa",
            ],
            [
                "ibge_codigo"       => 4113254,
                "ibge_estado_id" => 41,
                "nome"     => "Laranjal",
            ],
            [
                "ibge_codigo"       => 4113304,
                "ibge_estado_id" => 41,
                "nome"     => "Laranjeiras do Sul",
            ],
            [
                "ibge_codigo"       => 4113403,
                "ibge_estado_id" => 41,
                "nome"     => "Leópolis",
            ],
            [
                "ibge_codigo"       => 4113429,
                "ibge_estado_id" => 41,
                "nome"     => "Lidianópolis",
            ],
            [
                "ibge_codigo"       => 4113452,
                "ibge_estado_id" => 41,
                "nome"     => "Lindoeste",
            ],
            [
                "ibge_codigo"       => 4113502,
                "ibge_estado_id" => 41,
                "nome"     => "Loanda",
            ],
            [
                "ibge_codigo"       => 4113601,
                "ibge_estado_id" => 41,
                "nome"     => "Lobato",
            ],
            [
                "ibge_codigo"       => 4113700,
                "ibge_estado_id" => 41,
                "nome"     => "Londrina",
            ],
            [
                "ibge_codigo"       => 4113734,
                "ibge_estado_id" => 41,
                "nome"     => "Luiziana",
            ],
            [
                "ibge_codigo"       => 4113759,
                "ibge_estado_id" => 41,
                "nome"     => "Lunardelli",
            ],
            [
                "ibge_codigo"       => 4113809,
                "ibge_estado_id" => 41,
                "nome"     => "Lupionópolis",
            ],
            [
                "ibge_codigo"       => 4113908,
                "ibge_estado_id" => 41,
                "nome"     => "Mallet",
            ],
            [
                "ibge_codigo"       => 4114005,
                "ibge_estado_id" => 41,
                "nome"     => "Mamborê",
            ],
            [
                "ibge_codigo"       => 4114104,
                "ibge_estado_id" => 41,
                "nome"     => "Mandaguaçu",
            ],
            [
                "ibge_codigo"       => 4114203,
                "ibge_estado_id" => 41,
                "nome"     => "Mandaguari",
            ],
            [
                "ibge_codigo"       => 4114302,
                "ibge_estado_id" => 41,
                "nome"     => "Mandirituba",
            ],
            [
                "ibge_codigo"       => 4114351,
                "ibge_estado_id" => 41,
                "nome"     => "Manfrinópolis",
            ],
            [
                "ibge_codigo"       => 4114401,
                "ibge_estado_id" => 41,
                "nome"     => "Mangueirinha",
            ],
            [
                "ibge_codigo"       => 4114500,
                "ibge_estado_id" => 41,
                "nome"     => "Manoel Ribas",
            ],
            [
                "ibge_codigo"       => 4114609,
                "ibge_estado_id" => 41,
                "nome"     => "Marechal Cândido Rondon",
            ],
            [
                "ibge_codigo"       => 4114708,
                "ibge_estado_id" => 41,
                "nome"     => "Maria Helena",
            ],
            [
                "ibge_codigo"       => 4114807,
                "ibge_estado_id" => 41,
                "nome"     => "Marialva",
            ],
            [
                "ibge_codigo"       => 4114906,
                "ibge_estado_id" => 41,
                "nome"     => "Marilândia do Sul",
            ],
            [
                "ibge_codigo"       => 4115002,
                "ibge_estado_id" => 41,
                "nome"     => "Marilena",
            ],
            [
                "ibge_codigo"       => 4115101,
                "ibge_estado_id" => 41,
                "nome"     => "Mariluz",
            ],
            [
                "ibge_codigo"       => 4115200,
                "ibge_estado_id" => 41,
                "nome"     => "Maringá",
            ],
            [
                "ibge_codigo"       => 4115309,
                "ibge_estado_id" => 41,
                "nome"     => "Mariópolis",
            ],
            [
                "ibge_codigo"       => 4115358,
                "ibge_estado_id" => 41,
                "nome"     => "Maripá",
            ],
            [
                "ibge_codigo"       => 4115408,
                "ibge_estado_id" => 41,
                "nome"     => "Marmeleiro",
            ],
            [
                "ibge_codigo"       => 4115457,
                "ibge_estado_id" => 41,
                "nome"     => "Marquinho",
            ],
            [
                "ibge_codigo"       => 4115507,
                "ibge_estado_id" => 41,
                "nome"     => "Marumbi",
            ],
            [
                "ibge_codigo"       => 4115606,
                "ibge_estado_id" => 41,
                "nome"     => "Matelândia",
            ],
            [
                "ibge_codigo"       => 4115705,
                "ibge_estado_id" => 41,
                "nome"     => "Matinhos",
            ],
            [
                "ibge_codigo"       => 4115739,
                "ibge_estado_id" => 41,
                "nome"     => "Mato Rico",
            ],
            [
                "ibge_codigo"       => 4115754,
                "ibge_estado_id" => 41,
                "nome"     => "Mauá da Serra",
            ],
            [
                "ibge_codigo"       => 4115804,
                "ibge_estado_id" => 41,
                "nome"     => "Medianeira",
            ],
            [
                "ibge_codigo"       => 4115853,
                "ibge_estado_id" => 41,
                "nome"     => "Mercedes",
            ],
            [
                "ibge_codigo"       => 4115903,
                "ibge_estado_id" => 41,
                "nome"     => "Mirador",
            ],
            [
                "ibge_codigo"       => 4116000,
                "ibge_estado_id" => 41,
                "nome"     => "Miraselva",
            ],
            [
                "ibge_codigo"       => 4116059,
                "ibge_estado_id" => 41,
                "nome"     => "Missal",
            ],
            [
                "ibge_codigo"       => 4116109,
                "ibge_estado_id" => 41,
                "nome"     => "Moreira Sales",
            ],
            [
                "ibge_codigo"       => 4116208,
                "ibge_estado_id" => 41,
                "nome"     => "Morretes",
            ],
            [
                "ibge_codigo"       => 4116307,
                "ibge_estado_id" => 41,
                "nome"     => "Munhoz de Melo",
            ],
            [
                "ibge_codigo"       => 4116406,
                "ibge_estado_id" => 41,
                "nome"     => "Nossa Senhora das Graças",
            ],
            [
                "ibge_codigo"       => 4116505,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Aliança do Ivaí",
            ],
            [
                "ibge_codigo"       => 4116604,
                "ibge_estado_id" => 41,
                "nome"     => "Nova América da Colina",
            ],
            [
                "ibge_codigo"       => 4116703,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Aurora",
            ],
            [
                "ibge_codigo"       => 4116802,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Cantu",
            ],
            [
                "ibge_codigo"       => 4116901,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Esperança",
            ],
            [
                "ibge_codigo"       => 4116950,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Esperança do Sudoeste",
            ],
            [
                "ibge_codigo"       => 4117008,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Fátima",
            ],
            [
                "ibge_codigo"       => 4117057,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Laranjeiras",
            ],
            [
                "ibge_codigo"       => 4117107,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Londrina",
            ],
            [
                "ibge_codigo"       => 4117206,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Olímpia",
            ],
            [
                "ibge_codigo"       => 4117214,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Santa Bárbara",
            ],
            [
                "ibge_codigo"       => 4117222,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Santa Rosa",
            ],
            [
                "ibge_codigo"       => 4117255,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Prata do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4117271,
                "ibge_estado_id" => 41,
                "nome"     => "Nova Tebas",
            ],
            [
                "ibge_codigo"       => 4117297,
                "ibge_estado_id" => 41,
                "nome"     => "Novo Itacolomi",
            ],
            [
                "ibge_codigo"       => 4117305,
                "ibge_estado_id" => 41,
                "nome"     => "Ortigueira",
            ],
            [
                "ibge_codigo"       => 4117404,
                "ibge_estado_id" => 41,
                "nome"     => "Ourizona",
            ],
            [
                "ibge_codigo"       => 4117453,
                "ibge_estado_id" => 41,
                "nome"     => "Ouro Verde do Oeste",
            ],
            [
                "ibge_codigo"       => 4117503,
                "ibge_estado_id" => 41,
                "nome"     => "Paiçandu",
            ],
            [
                "ibge_codigo"       => 4117602,
                "ibge_estado_id" => 41,
                "nome"     => "Palmas",
            ],
            [
                "ibge_codigo"       => 4117701,
                "ibge_estado_id" => 41,
                "nome"     => "Palmeira",
            ],
            [
                "ibge_codigo"       => 4117800,
                "ibge_estado_id" => 41,
                "nome"     => "Palmital",
            ],
            [
                "ibge_codigo"       => 4117909,
                "ibge_estado_id" => 41,
                "nome"     => "Palotina",
            ],
            [
                "ibge_codigo"       => 4118006,
                "ibge_estado_id" => 41,
                "nome"     => "Paraíso do Norte",
            ],
            [
                "ibge_codigo"       => 4118105,
                "ibge_estado_id" => 41,
                "nome"     => "Paranacity",
            ],
            [
                "ibge_codigo"       => 4118204,
                "ibge_estado_id" => 41,
                "nome"     => "Paranaguá",
            ],
            [
                "ibge_codigo"       => 4118303,
                "ibge_estado_id" => 41,
                "nome"     => "Paranapoema",
            ],
            [
                "ibge_codigo"       => 4118402,
                "ibge_estado_id" => 41,
                "nome"     => "Paranavaí",
            ],
            [
                "ibge_codigo"       => 4118451,
                "ibge_estado_id" => 41,
                "nome"     => "Pato Bragado",
            ],
            [
                "ibge_codigo"       => 4118501,
                "ibge_estado_id" => 41,
                "nome"     => "Pato Branco",
            ],
            [
                "ibge_codigo"       => 4118600,
                "ibge_estado_id" => 41,
                "nome"     => "Paula Freitas",
            ],
            [
                "ibge_codigo"       => 4118709,
                "ibge_estado_id" => 41,
                "nome"     => "Paulo Frontin",
            ],
            [
                "ibge_codigo"       => 4118808,
                "ibge_estado_id" => 41,
                "nome"     => "Peabiru",
            ],
            [
                "ibge_codigo"       => 4118857,
                "ibge_estado_id" => 41,
                "nome"     => "Perobal",
            ],
            [
                "ibge_codigo"       => 4118907,
                "ibge_estado_id" => 41,
                "nome"     => "Pérola",
            ],
            [
                "ibge_codigo"       => 4119004,
                "ibge_estado_id" => 41,
                "nome"     => "Pérola d'Oeste",
            ],
            [
                "ibge_codigo"       => 4119103,
                "ibge_estado_id" => 41,
                "nome"     => "Piên",
            ],
            [
                "ibge_codigo"       => 4119152,
                "ibge_estado_id" => 41,
                "nome"     => "Pinhais",
            ],
            [
                "ibge_codigo"       => 4119202,
                "ibge_estado_id" => 41,
                "nome"     => "Pinhalão",
            ],
            [
                "ibge_codigo"       => 4119251,
                "ibge_estado_id" => 41,
                "nome"     => "Pinhal de São Bento",
            ],
            [
                "ibge_codigo"       => 4119301,
                "ibge_estado_id" => 41,
                "nome"     => "Pinhão",
            ],
            [
                "ibge_codigo"       => 4119400,
                "ibge_estado_id" => 41,
                "nome"     => "Piraí do Sul",
            ],
            [
                "ibge_codigo"       => 4119509,
                "ibge_estado_id" => 41,
                "nome"     => "Piraquara",
            ],
            [
                "ibge_codigo"       => 4119608,
                "ibge_estado_id" => 41,
                "nome"     => "Pitanga",
            ],
            [
                "ibge_codigo"       => 4119657,
                "ibge_estado_id" => 41,
                "nome"     => "Pitangueiras",
            ],
            [
                "ibge_codigo"       => 4119707,
                "ibge_estado_id" => 41,
                "nome"     => "Planaltina do Paraná",
            ],
            [
                "ibge_codigo"       => 4119806,
                "ibge_estado_id" => 41,
                "nome"     => "Planalto",
            ],
            [
                "ibge_codigo"       => 4119905,
                "ibge_estado_id" => 41,
                "nome"     => "Ponta Grossa",
            ],
            [
                "ibge_codigo"       => 4119954,
                "ibge_estado_id" => 41,
                "nome"     => "Pontal do Paraná",
            ],
            [
                "ibge_codigo"       => 4120002,
                "ibge_estado_id" => 41,
                "nome"     => "Porecatu",
            ],
            [
                "ibge_codigo"       => 4120101,
                "ibge_estado_id" => 41,
                "nome"     => "Porto Amazonas",
            ],
            [
                "ibge_codigo"       => 4120150,
                "ibge_estado_id" => 41,
                "nome"     => "Porto Barreiro",
            ],
            [
                "ibge_codigo"       => 4120200,
                "ibge_estado_id" => 41,
                "nome"     => "Porto Rico",
            ],
            [
                "ibge_codigo"       => 4120309,
                "ibge_estado_id" => 41,
                "nome"     => "Porto Vitória",
            ],
            [
                "ibge_codigo"       => 4120333,
                "ibge_estado_id" => 41,
                "nome"     => "Prado Ferreira",
            ],
            [
                "ibge_codigo"       => 4120358,
                "ibge_estado_id" => 41,
                "nome"     => "Pranchita",
            ],
            [
                "ibge_codigo"       => 4120408,
                "ibge_estado_id" => 41,
                "nome"     => "Presidente Castelo Branco",
            ],
            [
                "ibge_codigo"       => 4120507,
                "ibge_estado_id" => 41,
                "nome"     => "Primeiro de Maio",
            ],
            [
                "ibge_codigo"       => 4120606,
                "ibge_estado_id" => 41,
                "nome"     => "Prudentópolis",
            ],
            [
                "ibge_codigo"       => 4120655,
                "ibge_estado_id" => 41,
                "nome"     => "Quarto Centenário",
            ],
            [
                "ibge_codigo"       => 4120705,
                "ibge_estado_id" => 41,
                "nome"     => "Quatiguá",
            ],
            [
                "ibge_codigo"       => 4120804,
                "ibge_estado_id" => 41,
                "nome"     => "Quatro Barras",
            ],
            [
                "ibge_codigo"       => 4120853,
                "ibge_estado_id" => 41,
                "nome"     => "Quatro Pontes",
            ],
            [
                "ibge_codigo"       => 4120903,
                "ibge_estado_id" => 41,
                "nome"     => "Quedas do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4121000,
                "ibge_estado_id" => 41,
                "nome"     => "Querência do Norte",
            ],
            [
                "ibge_codigo"       => 4121109,
                "ibge_estado_id" => 41,
                "nome"     => "Quinta do Sol",
            ],
            [
                "ibge_codigo"       => 4121208,
                "ibge_estado_id" => 41,
                "nome"     => "Quitandinha",
            ],
            [
                "ibge_codigo"       => 4121257,
                "ibge_estado_id" => 41,
                "nome"     => "Ramilândia",
            ],
            [
                "ibge_codigo"       => 4121307,
                "ibge_estado_id" => 41,
                "nome"     => "Rancho Alegre",
            ],
            [
                "ibge_codigo"       => 4121356,
                "ibge_estado_id" => 41,
                "nome"     => "Rancho Alegre d'Oeste",
            ],
            [
                "ibge_codigo"       => 4121406,
                "ibge_estado_id" => 41,
                "nome"     => "Realeza",
            ],
            [
                "ibge_codigo"       => 4121505,
                "ibge_estado_id" => 41,
                "nome"     => "Rebouças",
            ],
            [
                "ibge_codigo"       => 4121604,
                "ibge_estado_id" => 41,
                "nome"     => "Renascença",
            ],
            [
                "ibge_codigo"       => 4121703,
                "ibge_estado_id" => 41,
                "nome"     => "Reserva",
            ],
            [
                "ibge_codigo"       => 4121752,
                "ibge_estado_id" => 41,
                "nome"     => "Reserva do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4121802,
                "ibge_estado_id" => 41,
                "nome"     => "Ribeirão Claro",
            ],
            [
                "ibge_codigo"       => 4121901,
                "ibge_estado_id" => 41,
                "nome"     => "Ribeirão do Pinhal",
            ],
            [
                "ibge_codigo"       => 4122008,
                "ibge_estado_id" => 41,
                "nome"     => "Rio Azul",
            ],
            [
                "ibge_codigo"       => 4122107,
                "ibge_estado_id" => 41,
                "nome"     => "Rio Bom",
            ],
            [
                "ibge_codigo"       => 4122156,
                "ibge_estado_id" => 41,
                "nome"     => "Rio Bonito do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4122172,
                "ibge_estado_id" => 41,
                "nome"     => "Rio Branco do Ivaí",
            ],
            [
                "ibge_codigo"       => 4122206,
                "ibge_estado_id" => 41,
                "nome"     => "Rio Branco do Sul",
            ],
            [
                "ibge_codigo"       => 4122305,
                "ibge_estado_id" => 41,
                "nome"     => "Rio Negro",
            ],
            [
                "ibge_codigo"       => 4122404,
                "ibge_estado_id" => 41,
                "nome"     => "Rolândia",
            ],
            [
                "ibge_codigo"       => 4122503,
                "ibge_estado_id" => 41,
                "nome"     => "Roncador",
            ],
            [
                "ibge_codigo"       => 4122602,
                "ibge_estado_id" => 41,
                "nome"     => "Rondon",
            ],
            [
                "ibge_codigo"       => 4122651,
                "ibge_estado_id" => 41,
                "nome"     => "Rosário do Ivaí",
            ],
            [
                "ibge_codigo"       => 4122701,
                "ibge_estado_id" => 41,
                "nome"     => "Sabáudia",
            ],
            [
                "ibge_codigo"       => 4122800,
                "ibge_estado_id" => 41,
                "nome"     => "Salgado Filho",
            ],
            [
                "ibge_codigo"       => 4122909,
                "ibge_estado_id" => 41,
                "nome"     => "Salto do Itararé",
            ],
            [
                "ibge_codigo"       => 4123006,
                "ibge_estado_id" => 41,
                "nome"     => "Salto do Lontra",
            ],
            [
                "ibge_codigo"       => 4123105,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Amélia",
            ],
            [
                "ibge_codigo"       => 4123204,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Cecília do Pavão",
            ],
            [
                "ibge_codigo"       => 4123303,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Cruz de Monte Castelo",
            ],
            [
                "ibge_codigo"       => 4123402,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Fé",
            ],
            [
                "ibge_codigo"       => 4123501,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Helena",
            ],
            [
                "ibge_codigo"       => 4123600,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Inês",
            ],
            [
                "ibge_codigo"       => 4123709,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Isabel do Ivaí",
            ],
            [
                "ibge_codigo"       => 4123808,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Izabel do Oeste",
            ],
            [
                "ibge_codigo"       => 4123824,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Lúcia",
            ],
            [
                "ibge_codigo"       => 4123857,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Maria do Oeste",
            ],
            [
                "ibge_codigo"       => 4123907,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Mariana",
            ],
            [
                "ibge_codigo"       => 4123956,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Mônica",
            ],
            [
                "ibge_codigo"       => 4124004,
                "ibge_estado_id" => 41,
                "nome"     => "Santana do Itararé",
            ],
            [
                "ibge_codigo"       => 4124020,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Tereza do Oeste",
            ],
            [
                "ibge_codigo"       => 4124053,
                "ibge_estado_id" => 41,
                "nome"     => "Santa Terezinha de Itaipu",
            ],
            [
                "ibge_codigo"       => 4124103,
                "ibge_estado_id" => 41,
                "nome"     => "Santo Antônio da Platina",
            ],
            [
                "ibge_codigo"       => 4124202,
                "ibge_estado_id" => 41,
                "nome"     => "Santo Antônio do Caiuá",
            ],
            [
                "ibge_codigo"       => 4124301,
                "ibge_estado_id" => 41,
                "nome"     => "Santo Antônio do Paraíso",
            ],
            [
                "ibge_codigo"       => 4124400,
                "ibge_estado_id" => 41,
                "nome"     => "Santo Antônio do Sudoeste",
            ],
            [
                "ibge_codigo"       => 4124509,
                "ibge_estado_id" => 41,
                "nome"     => "Santo Inácio",
            ],
            [
                "ibge_codigo"       => 4124608,
                "ibge_estado_id" => 41,
                "nome"     => "São Carlos do Ivaí",
            ],
            [
                "ibge_codigo"       => 4124707,
                "ibge_estado_id" => 41,
                "nome"     => "São Jerônimo da Serra",
            ],
            [
                "ibge_codigo"       => 4124806,
                "ibge_estado_id" => 41,
                "nome"     => "São João",
            ],
            [
                "ibge_codigo"       => 4124905,
                "ibge_estado_id" => 41,
                "nome"     => "São João do Caiuá",
            ],
            [
                "ibge_codigo"       => 4125001,
                "ibge_estado_id" => 41,
                "nome"     => "São João do Ivaí",
            ],
            [
                "ibge_codigo"       => 4125100,
                "ibge_estado_id" => 41,
                "nome"     => "São João do Triunfo",
            ],
            [
                "ibge_codigo"       => 4125209,
                "ibge_estado_id" => 41,
                "nome"     => "São Jorge d'Oeste",
            ],
            [
                "ibge_codigo"       => 4125308,
                "ibge_estado_id" => 41,
                "nome"     => "São Jorge do Ivaí",
            ],
            [
                "ibge_codigo"       => 4125357,
                "ibge_estado_id" => 41,
                "nome"     => "São Jorge do Patrocínio",
            ],
            [
                "ibge_codigo"       => 4125407,
                "ibge_estado_id" => 41,
                "nome"     => "São José da Boa Vista",
            ],
            [
                "ibge_codigo"       => 4125456,
                "ibge_estado_id" => 41,
                "nome"     => "São José das Palmeiras",
            ],
            [
                "ibge_codigo"       => 4125506,
                "ibge_estado_id" => 41,
                "nome"     => "São José dos Pinhais",
            ],
            [
                "ibge_codigo"       => 4125555,
                "ibge_estado_id" => 41,
                "nome"     => "São Manoel do Paraná",
            ],
            [
                "ibge_codigo"       => 4125605,
                "ibge_estado_id" => 41,
                "nome"     => "São Mateus do Sul",
            ],
            [
                "ibge_codigo"       => 4125704,
                "ibge_estado_id" => 41,
                "nome"     => "São Miguel do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4125753,
                "ibge_estado_id" => 41,
                "nome"     => "São Pedro do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4125803,
                "ibge_estado_id" => 41,
                "nome"     => "São Pedro do Ivaí",
            ],
            [
                "ibge_codigo"       => 4125902,
                "ibge_estado_id" => 41,
                "nome"     => "São Pedro do Paraná",
            ],
            [
                "ibge_codigo"       => 4126009,
                "ibge_estado_id" => 41,
                "nome"     => "São Sebastião da Amoreira",
            ],
            [
                "ibge_codigo"       => 4126108,
                "ibge_estado_id" => 41,
                "nome"     => "São Tomé",
            ],
            [
                "ibge_codigo"       => 4126207,
                "ibge_estado_id" => 41,
                "nome"     => "Sapopema",
            ],
            [
                "ibge_codigo"       => 4126256,
                "ibge_estado_id" => 41,
                "nome"     => "Sarandi",
            ],
            [
                "ibge_codigo"       => 4126272,
                "ibge_estado_id" => 41,
                "nome"     => "Saudade do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4126306,
                "ibge_estado_id" => 41,
                "nome"     => "Sengés",
            ],
            [
                "ibge_codigo"       => 4126355,
                "ibge_estado_id" => 41,
                "nome"     => "Serranópolis do Iguaçu",
            ],
            [
                "ibge_codigo"       => 4126405,
                "ibge_estado_id" => 41,
                "nome"     => "Sertaneja",
            ],
            [
                "ibge_codigo"       => 4126504,
                "ibge_estado_id" => 41,
                "nome"     => "Sertanópolis",
            ],
            [
                "ibge_codigo"       => 4126603,
                "ibge_estado_id" => 41,
                "nome"     => "Siqueira Campos",
            ],
            [
                "ibge_codigo"       => 4126652,
                "ibge_estado_id" => 41,
                "nome"     => "Sulina",
            ],
            [
                "ibge_codigo"       => 4126678,
                "ibge_estado_id" => 41,
                "nome"     => "Tamarana",
            ],
            [
                "ibge_codigo"       => 4126702,
                "ibge_estado_id" => 41,
                "nome"     => "Tamboara",
            ],
            [
                "ibge_codigo"       => 4126801,
                "ibge_estado_id" => 41,
                "nome"     => "Tapejara",
            ],
            [
                "ibge_codigo"       => 4126900,
                "ibge_estado_id" => 41,
                "nome"     => "Tapira",
            ],
            [
                "ibge_codigo"       => 4127007,
                "ibge_estado_id" => 41,
                "nome"     => "Teixeira Soares",
            ],
            [
                "ibge_codigo"       => 4127106,
                "ibge_estado_id" => 41,
                "nome"     => "Telêmaco Borba",
            ],
            [
                "ibge_codigo"       => 4127205,
                "ibge_estado_id" => 41,
                "nome"     => "Terra Boa",
            ],
            [
                "ibge_codigo"       => 4127304,
                "ibge_estado_id" => 41,
                "nome"     => "Terra Rica",
            ],
            [
                "ibge_codigo"       => 4127403,
                "ibge_estado_id" => 41,
                "nome"     => "Terra Roxa",
            ],
            [
                "ibge_codigo"       => 4127502,
                "ibge_estado_id" => 41,
                "nome"     => "Tibagi",
            ],
            [
                "ibge_codigo"       => 4127601,
                "ibge_estado_id" => 41,
                "nome"     => "Tijucas do Sul",
            ],
            [
                "ibge_codigo"       => 4127700,
                "ibge_estado_id" => 41,
                "nome"     => "Toledo",
            ],
            [
                "ibge_codigo"       => 4127809,
                "ibge_estado_id" => 41,
                "nome"     => "Tomazina",
            ],
            [
                "ibge_codigo"       => 4127858,
                "ibge_estado_id" => 41,
                "nome"     => "Três Barras do Paraná",
            ],
            [
                "ibge_codigo"       => 4127882,
                "ibge_estado_id" => 41,
                "nome"     => "Tunas do Paraná",
            ],
            [
                "ibge_codigo"       => 4127908,
                "ibge_estado_id" => 41,
                "nome"     => "Tuneiras do Oeste",
            ],
            [
                "ibge_codigo"       => 4127957,
                "ibge_estado_id" => 41,
                "nome"     => "Tupãssi",
            ],
            [
                "ibge_codigo"       => 4127965,
                "ibge_estado_id" => 41,
                "nome"     => "Turvo",
            ],
            [
                "ibge_codigo"       => 4128005,
                "ibge_estado_id" => 41,
                "nome"     => "Ubiratã",
            ],
            [
                "ibge_codigo"       => 4128104,
                "ibge_estado_id" => 41,
                "nome"     => "Umuarama",
            ],
            [
                "ibge_codigo"       => 4128203,
                "ibge_estado_id" => 41,
                "nome"     => "União da Vitória",
            ],
            [
                "ibge_codigo"       => 4128302,
                "ibge_estado_id" => 41,
                "nome"     => "Uniflor",
            ],
            [
                "ibge_codigo"       => 4128401,
                "ibge_estado_id" => 41,
                "nome"     => "Uraí",
            ],
            [
                "ibge_codigo"       => 4128500,
                "ibge_estado_id" => 41,
                "nome"     => "Wenceslau Braz",
            ],
            [
                "ibge_codigo"       => 4128534,
                "ibge_estado_id" => 41,
                "nome"     => "Ventania",
            ],
            [
                "ibge_codigo"       => 4128559,
                "ibge_estado_id" => 41,
                "nome"     => "Vera Cruz do Oeste",
            ],
            [
                "ibge_codigo"       => 4128609,
                "ibge_estado_id" => 41,
                "nome"     => "Verê",
            ],
            [
                "ibge_codigo"       => 4128625,
                "ibge_estado_id" => 41,
                "nome"     => "Alto Paraíso",
            ],
            [
                "ibge_codigo"       => 4128633,
                "ibge_estado_id" => 41,
                "nome"     => "Doutor Ulysses",
            ],
            [
                "ibge_codigo"       => 4128658,
                "ibge_estado_id" => 41,
                "nome"     => "Virmond",
            ],
            [
                "ibge_codigo"       => 4128708,
                "ibge_estado_id" => 41,
                "nome"     => "Vitorino",
            ],
            [
                "ibge_codigo"       => 4128807,
                "ibge_estado_id" => 41,
                "nome"     => "Xambrê",
            ],
            [
                "ibge_codigo"       => 4200051,
                "ibge_estado_id" => 42,
                "nome"     => "Abdon Batista",
            ],
            [
                "ibge_codigo"       => 4200101,
                "ibge_estado_id" => 42,
                "nome"     => "Abelardo Luz",
            ],
            [
                "ibge_codigo"       => 4200200,
                "ibge_estado_id" => 42,
                "nome"     => "Agrolândia",
            ],
            [
                "ibge_codigo"       => 4200309,
                "ibge_estado_id" => 42,
                "nome"     => "Agronômica",
            ],
            [
                "ibge_codigo"       => 4200408,
                "ibge_estado_id" => 42,
                "nome"     => "Água Doce",
            ],
            [
                "ibge_codigo"       => 4200507,
                "ibge_estado_id" => 42,
                "nome"     => "Águas de Chapecó",
            ],
            [
                "ibge_codigo"       => 4200556,
                "ibge_estado_id" => 42,
                "nome"     => "Águas Frias",
            ],
            [
                "ibge_codigo"       => 4200606,
                "ibge_estado_id" => 42,
                "nome"     => "Águas Mornas",
            ],
            [
                "ibge_codigo"       => 4200705,
                "ibge_estado_id" => 42,
                "nome"     => "Alfredo Wagner",
            ],
            [
                "ibge_codigo"       => 4200754,
                "ibge_estado_id" => 42,
                "nome"     => "Alto Bela Vista",
            ],
            [
                "ibge_codigo"       => 4200804,
                "ibge_estado_id" => 42,
                "nome"     => "Anchieta",
            ],
            [
                "ibge_codigo"       => 4200903,
                "ibge_estado_id" => 42,
                "nome"     => "Angelina",
            ],
            [
                "ibge_codigo"       => 4201000,
                "ibge_estado_id" => 42,
                "nome"     => "Anita Garibaldi",
            ],
            [
                "ibge_codigo"       => 4201109,
                "ibge_estado_id" => 42,
                "nome"     => "Anitápolis",
            ],
            [
                "ibge_codigo"       => 4201208,
                "ibge_estado_id" => 42,
                "nome"     => "Antônio Carlos",
            ],
            [
                "ibge_codigo"       => 4201257,
                "ibge_estado_id" => 42,
                "nome"     => "Apiúna",
            ],
            [
                "ibge_codigo"       => 4201273,
                "ibge_estado_id" => 42,
                "nome"     => "Arabutã",
            ],
            [
                "ibge_codigo"       => 4201307,
                "ibge_estado_id" => 42,
                "nome"     => "Araquari",
            ],
            [
                "ibge_codigo"       => 4201406,
                "ibge_estado_id" => 42,
                "nome"     => "Araranguá",
            ],
            [
                "ibge_codigo"       => 4201505,
                "ibge_estado_id" => 42,
                "nome"     => "Armazém",
            ],
            [
                "ibge_codigo"       => 4201604,
                "ibge_estado_id" => 42,
                "nome"     => "Arroio Trinta",
            ],
            [
                "ibge_codigo"       => 4201653,
                "ibge_estado_id" => 42,
                "nome"     => "Arvoredo",
            ],
            [
                "ibge_codigo"       => 4201703,
                "ibge_estado_id" => 42,
                "nome"     => "Ascurra",
            ],
            [
                "ibge_codigo"       => 4201802,
                "ibge_estado_id" => 42,
                "nome"     => "Atalanta",
            ],
            [
                "ibge_codigo"       => 4201901,
                "ibge_estado_id" => 42,
                "nome"     => "Aurora",
            ],
            [
                "ibge_codigo"       => 4201950,
                "ibge_estado_id" => 42,
                "nome"     => "Balneário Arroio do Silva",
            ],
            [
                "ibge_codigo"       => 4202008,
                "ibge_estado_id" => 42,
                "nome"     => "Balneário Camboriú",
            ],
            [
                "ibge_codigo"       => 4202057,
                "ibge_estado_id" => 42,
                "nome"     => "Balneário Barra do Sul",
            ],
            [
                "ibge_codigo"       => 4202073,
                "ibge_estado_id" => 42,
                "nome"     => "Balneário Gaivota",
            ],
            [
                "ibge_codigo"       => 4202081,
                "ibge_estado_id" => 42,
                "nome"     => "Bandeirante",
            ],
            [
                "ibge_codigo"       => 4202099,
                "ibge_estado_id" => 42,
                "nome"     => "Barra Bonita",
            ],
            [
                "ibge_codigo"       => 4202107,
                "ibge_estado_id" => 42,
                "nome"     => "Barra Velha",
            ],
            [
                "ibge_codigo"       => 4202131,
                "ibge_estado_id" => 42,
                "nome"     => "Bela Vista do Toldo",
            ],
            [
                "ibge_codigo"       => 4202156,
                "ibge_estado_id" => 42,
                "nome"     => "Belmonte",
            ],
            [
                "ibge_codigo"       => 4202206,
                "ibge_estado_id" => 42,
                "nome"     => "Benedito Novo",
            ],
            [
                "ibge_codigo"       => 4202305,
                "ibge_estado_id" => 42,
                "nome"     => "Biguaçu",
            ],
            [
                "ibge_codigo"       => 4202404,
                "ibge_estado_id" => 42,
                "nome"     => "Blumenau",
            ],
            [
                "ibge_codigo"       => 4202438,
                "ibge_estado_id" => 42,
                "nome"     => "Bocaina do Sul",
            ],
            [
                "ibge_codigo"       => 4202453,
                "ibge_estado_id" => 42,
                "nome"     => "Bombinhas",
            ],
            [
                "ibge_codigo"       => 4202503,
                "ibge_estado_id" => 42,
                "nome"     => "Bom Jardim da Serra",
            ],
            [
                "ibge_codigo"       => 4202537,
                "ibge_estado_id" => 42,
                "nome"     => "Bom Jesus",
            ],
            [
                "ibge_codigo"       => 4202578,
                "ibge_estado_id" => 42,
                "nome"     => "Bom Jesus do Oeste",
            ],
            [
                "ibge_codigo"       => 4202602,
                "ibge_estado_id" => 42,
                "nome"     => "Bom Retiro",
            ],
            [
                "ibge_codigo"       => 4202701,
                "ibge_estado_id" => 42,
                "nome"     => "Botuverá",
            ],
            [
                "ibge_codigo"       => 4202800,
                "ibge_estado_id" => 42,
                "nome"     => "Braço do Norte",
            ],
            [
                "ibge_codigo"       => 4202859,
                "ibge_estado_id" => 42,
                "nome"     => "Braço do Trombudo",
            ],
            [
                "ibge_codigo"       => 4202875,
                "ibge_estado_id" => 42,
                "nome"     => "Brunópolis",
            ],
            [
                "ibge_codigo"       => 4202909,
                "ibge_estado_id" => 42,
                "nome"     => "Brusque",
            ],
            [
                "ibge_codigo"       => 4203006,
                "ibge_estado_id" => 42,
                "nome"     => "Caçador",
            ],
            [
                "ibge_codigo"       => 4203105,
                "ibge_estado_id" => 42,
                "nome"     => "Caibi",
            ],
            [
                "ibge_codigo"       => 4203154,
                "ibge_estado_id" => 42,
                "nome"     => "Calmon",
            ],
            [
                "ibge_codigo"       => 4203204,
                "ibge_estado_id" => 42,
                "nome"     => "Camboriú",
            ],
            [
                "ibge_codigo"       => 4203253,
                "ibge_estado_id" => 42,
                "nome"     => "Capão Alto",
            ],
            [
                "ibge_codigo"       => 4203303,
                "ibge_estado_id" => 42,
                "nome"     => "Campo Alegre",
            ],
            [
                "ibge_codigo"       => 4203402,
                "ibge_estado_id" => 42,
                "nome"     => "Campo Belo do Sul",
            ],
            [
                "ibge_codigo"       => 4203501,
                "ibge_estado_id" => 42,
                "nome"     => "Campo Erê",
            ],
            [
                "ibge_codigo"       => 4203600,
                "ibge_estado_id" => 42,
                "nome"     => "Campos Novos",
            ],
            [
                "ibge_codigo"       => 4203709,
                "ibge_estado_id" => 42,
                "nome"     => "Canelinha",
            ],
            [
                "ibge_codigo"       => 4203808,
                "ibge_estado_id" => 42,
                "nome"     => "Canoinhas",
            ],
            [
                "ibge_codigo"       => 4203907,
                "ibge_estado_id" => 42,
                "nome"     => "Capinzal",
            ],
            [
                "ibge_codigo"       => 4203956,
                "ibge_estado_id" => 42,
                "nome"     => "Capivari de Baixo",
            ],
            [
                "ibge_codigo"       => 4204004,
                "ibge_estado_id" => 42,
                "nome"     => "Catanduvas",
            ],
            [
                "ibge_codigo"       => 4204103,
                "ibge_estado_id" => 42,
                "nome"     => "Caxambu do Sul",
            ],
            [
                "ibge_codigo"       => 4204152,
                "ibge_estado_id" => 42,
                "nome"     => "Celso Ramos",
            ],
            [
                "ibge_codigo"       => 4204178,
                "ibge_estado_id" => 42,
                "nome"     => "Cerro Negro",
            ],
            [
                "ibge_codigo"       => 4204194,
                "ibge_estado_id" => 42,
                "nome"     => "Chapadão do Lageado",
            ],
            [
                "ibge_codigo"       => 4204202,
                "ibge_estado_id" => 42,
                "nome"     => "Chapecó",
            ],
            [
                "ibge_codigo"       => 4204251,
                "ibge_estado_id" => 42,
                "nome"     => "Cocal do Sul",
            ],
            [
                "ibge_codigo"       => 4204301,
                "ibge_estado_id" => 42,
                "nome"     => "Concórdia",
            ],
            [
                "ibge_codigo"       => 4204350,
                "ibge_estado_id" => 42,
                "nome"     => "Cordilheira Alta",
            ],
            [
                "ibge_codigo"       => 4204400,
                "ibge_estado_id" => 42,
                "nome"     => "Coronel Freitas",
            ],
            [
                "ibge_codigo"       => 4204459,
                "ibge_estado_id" => 42,
                "nome"     => "Coronel Martins",
            ],
            [
                "ibge_codigo"       => 4204509,
                "ibge_estado_id" => 42,
                "nome"     => "Corupá",
            ],
            [
                "ibge_codigo"       => 4204558,
                "ibge_estado_id" => 42,
                "nome"     => "Correia Pinto",
            ],
            [
                "ibge_codigo"       => 4204608,
                "ibge_estado_id" => 42,
                "nome"     => "Criciúma",
            ],
            [
                "ibge_codigo"       => 4204707,
                "ibge_estado_id" => 42,
                "nome"     => "Cunha Porã",
            ],
            [
                "ibge_codigo"       => 4204756,
                "ibge_estado_id" => 42,
                "nome"     => "Cunhataí",
            ],
            [
                "ibge_codigo"       => 4204806,
                "ibge_estado_id" => 42,
                "nome"     => "Curitibanos",
            ],
            [
                "ibge_codigo"       => 4204905,
                "ibge_estado_id" => 42,
                "nome"     => "Descanso",
            ],
            [
                "ibge_codigo"       => 4205001,
                "ibge_estado_id" => 42,
                "nome"     => "Dionísio Cerqueira",
            ],
            [
                "ibge_codigo"       => 4205100,
                "ibge_estado_id" => 42,
                "nome"     => "Dona Emma",
            ],
            [
                "ibge_codigo"       => 4205159,
                "ibge_estado_id" => 42,
                "nome"     => "Doutor Pedrinho",
            ],
            [
                "ibge_codigo"       => 4205175,
                "ibge_estado_id" => 42,
                "nome"     => "Entre Rios",
            ],
            [
                "ibge_codigo"       => 4205191,
                "ibge_estado_id" => 42,
                "nome"     => "Ermo",
            ],
            [
                "ibge_codigo"       => 4205209,
                "ibge_estado_id" => 42,
                "nome"     => "Erval Velho",
            ],
            [
                "ibge_codigo"       => 4205308,
                "ibge_estado_id" => 42,
                "nome"     => "Faxinal dos Guedes",
            ],
            [
                "ibge_codigo"       => 4205357,
                "ibge_estado_id" => 42,
                "nome"     => "Flor do Sertão",
            ],
            [
                "ibge_codigo"       => 4205407,
                "ibge_estado_id" => 42,
                "nome"     => "Florianópolis",
            ],
            [
                "ibge_codigo"       => 4205431,
                "ibge_estado_id" => 42,
                "nome"     => "Formosa do Sul",
            ],
            [
                "ibge_codigo"       => 4205456,
                "ibge_estado_id" => 42,
                "nome"     => "Forquilhinha",
            ],
            [
                "ibge_codigo"       => 4205506,
                "ibge_estado_id" => 42,
                "nome"     => "Fraiburgo",
            ],
            [
                "ibge_codigo"       => 4205555,
                "ibge_estado_id" => 42,
                "nome"     => "Frei Rogério",
            ],
            [
                "ibge_codigo"       => 4205605,
                "ibge_estado_id" => 42,
                "nome"     => "Galvão",
            ],
            [
                "ibge_codigo"       => 4205704,
                "ibge_estado_id" => 42,
                "nome"     => "Garopaba",
            ],
            [
                "ibge_codigo"       => 4205803,
                "ibge_estado_id" => 42,
                "nome"     => "Garuva",
            ],
            [
                "ibge_codigo"       => 4205902,
                "ibge_estado_id" => 42,
                "nome"     => "Gaspar",
            ],
            [
                "ibge_codigo"       => 4206009,
                "ibge_estado_id" => 42,
                "nome"     => "Governador Celso Ramos",
            ],
            [
                "ibge_codigo"       => 4206108,
                "ibge_estado_id" => 42,
                "nome"     => "Grão Pará",
            ],
            [
                "ibge_codigo"       => 4206207,
                "ibge_estado_id" => 42,
                "nome"     => "Gravatal",
            ],
            [
                "ibge_codigo"       => 4206306,
                "ibge_estado_id" => 42,
                "nome"     => "Guabiruba",
            ],
            [
                "ibge_codigo"       => 4206405,
                "ibge_estado_id" => 42,
                "nome"     => "Guaraciaba",
            ],
            [
                "ibge_codigo"       => 4206504,
                "ibge_estado_id" => 42,
                "nome"     => "Guaramirim",
            ],
            [
                "ibge_codigo"       => 4206603,
                "ibge_estado_id" => 42,
                "nome"     => "Guarujá do Sul",
            ],
            [
                "ibge_codigo"       => 4206652,
                "ibge_estado_id" => 42,
                "nome"     => "Guatambú",
            ],
            [
                "ibge_codigo"       => 4206702,
                "ibge_estado_id" => 42,
                "nome"     => "Herval d'Oeste",
            ],
            [
                "ibge_codigo"       => 4206751,
                "ibge_estado_id" => 42,
                "nome"     => "Ibiam",
            ],
            [
                "ibge_codigo"       => 4206801,
                "ibge_estado_id" => 42,
                "nome"     => "Ibicaré",
            ],
            [
                "ibge_codigo"       => 4206900,
                "ibge_estado_id" => 42,
                "nome"     => "Ibirama",
            ],
            [
                "ibge_codigo"       => 4207007,
                "ibge_estado_id" => 42,
                "nome"     => "Içara",
            ],
            [
                "ibge_codigo"       => 4207106,
                "ibge_estado_id" => 42,
                "nome"     => "Ilhota",
            ],
            [
                "ibge_codigo"       => 4207205,
                "ibge_estado_id" => 42,
                "nome"     => "Imaruí",
            ],
            [
                "ibge_codigo"       => 4207304,
                "ibge_estado_id" => 42,
                "nome"     => "Imbituba",
            ],
            [
                "ibge_codigo"       => 4207403,
                "ibge_estado_id" => 42,
                "nome"     => "Imbuia",
            ],
            [
                "ibge_codigo"       => 4207502,
                "ibge_estado_id" => 42,
                "nome"     => "Indaial",
            ],
            [
                "ibge_codigo"       => 4207577,
                "ibge_estado_id" => 42,
                "nome"     => "Iomerê",
            ],
            [
                "ibge_codigo"       => 4207601,
                "ibge_estado_id" => 42,
                "nome"     => "Ipira",
            ],
            [
                "ibge_codigo"       => 4207650,
                "ibge_estado_id" => 42,
                "nome"     => "Iporã do Oeste",
            ],
            [
                "ibge_codigo"       => 4207684,
                "ibge_estado_id" => 42,
                "nome"     => "Ipuaçu",
            ],
            [
                "ibge_codigo"       => 4207700,
                "ibge_estado_id" => 42,
                "nome"     => "Ipumirim",
            ],
            [
                "ibge_codigo"       => 4207759,
                "ibge_estado_id" => 42,
                "nome"     => "Iraceminha",
            ],
            [
                "ibge_codigo"       => 4207809,
                "ibge_estado_id" => 42,
                "nome"     => "Irani",
            ],
            [
                "ibge_codigo"       => 4207858,
                "ibge_estado_id" => 42,
                "nome"     => "Irati",
            ],
            [
                "ibge_codigo"       => 4207908,
                "ibge_estado_id" => 42,
                "nome"     => "Irineópolis",
            ],
            [
                "ibge_codigo"       => 4208005,
                "ibge_estado_id" => 42,
                "nome"     => "Itá",
            ],
            [
                "ibge_codigo"       => 4208104,
                "ibge_estado_id" => 42,
                "nome"     => "Itaiópolis",
            ],
            [
                "ibge_codigo"       => 4208203,
                "ibge_estado_id" => 42,
                "nome"     => "Itajaí",
            ],
            [
                "ibge_codigo"       => 4208302,
                "ibge_estado_id" => 42,
                "nome"     => "Itapema",
            ],
            [
                "ibge_codigo"       => 4208401,
                "ibge_estado_id" => 42,
                "nome"     => "Itapiranga",
            ],
            [
                "ibge_codigo"       => 4208450,
                "ibge_estado_id" => 42,
                "nome"     => "Itapoá",
            ],
            [
                "ibge_codigo"       => 4208500,
                "ibge_estado_id" => 42,
                "nome"     => "Ituporanga",
            ],
            [
                "ibge_codigo"       => 4208609,
                "ibge_estado_id" => 42,
                "nome"     => "Jaborá",
            ],
            [
                "ibge_codigo"       => 4208708,
                "ibge_estado_id" => 42,
                "nome"     => "Jacinto Machado",
            ],
            [
                "ibge_codigo"       => 4208807,
                "ibge_estado_id" => 42,
                "nome"     => "Jaguaruna",
            ],
            [
                "ibge_codigo"       => 4208906,
                "ibge_estado_id" => 42,
                "nome"     => "Jaraguá do Sul",
            ],
            [
                "ibge_codigo"       => 4208955,
                "ibge_estado_id" => 42,
                "nome"     => "Jardinópolis",
            ],
            [
                "ibge_codigo"       => 4209003,
                "ibge_estado_id" => 42,
                "nome"     => "Joaçaba",
            ],
            [
                "ibge_codigo"       => 4209102,
                "ibge_estado_id" => 42,
                "nome"     => "Joinville",
            ],
            [
                "ibge_codigo"       => 4209151,
                "ibge_estado_id" => 42,
                "nome"     => "José Boiteux",
            ],
            [
                "ibge_codigo"       => 4209177,
                "ibge_estado_id" => 42,
                "nome"     => "Jupiá",
            ],
            [
                "ibge_codigo"       => 4209201,
                "ibge_estado_id" => 42,
                "nome"     => "Lacerdópolis",
            ],
            [
                "ibge_codigo"       => 4209300,
                "ibge_estado_id" => 42,
                "nome"     => "Lages",
            ],
            [
                "ibge_codigo"       => 4209409,
                "ibge_estado_id" => 42,
                "nome"     => "Laguna",
            ],
            [
                "ibge_codigo"       => 4209458,
                "ibge_estado_id" => 42,
                "nome"     => "Lajeado Grande",
            ],
            [
                "ibge_codigo"       => 4209508,
                "ibge_estado_id" => 42,
                "nome"     => "Laurentino",
            ],
            [
                "ibge_codigo"       => 4209607,
                "ibge_estado_id" => 42,
                "nome"     => "Lauro Muller",
            ],
            [
                "ibge_codigo"       => 4209706,
                "ibge_estado_id" => 42,
                "nome"     => "Lebon Régis",
            ],
            [
                "ibge_codigo"       => 4209805,
                "ibge_estado_id" => 42,
                "nome"     => "Leoberto Leal",
            ],
            [
                "ibge_codigo"       => 4209854,
                "ibge_estado_id" => 42,
                "nome"     => "Lindóia do Sul",
            ],
            [
                "ibge_codigo"       => 4209904,
                "ibge_estado_id" => 42,
                "nome"     => "Lontras",
            ],
            [
                "ibge_codigo"       => 4210001,
                "ibge_estado_id" => 42,
                "nome"     => "Luiz Alves",
            ],
            [
                "ibge_codigo"       => 4210035,
                "ibge_estado_id" => 42,
                "nome"     => "Luzerna",
            ],
            [
                "ibge_codigo"       => 4210050,
                "ibge_estado_id" => 42,
                "nome"     => "Macieira",
            ],
            [
                "ibge_codigo"       => 4210100,
                "ibge_estado_id" => 42,
                "nome"     => "Mafra",
            ],
            [
                "ibge_codigo"       => 4210209,
                "ibge_estado_id" => 42,
                "nome"     => "Major Gercino",
            ],
            [
                "ibge_codigo"       => 4210308,
                "ibge_estado_id" => 42,
                "nome"     => "Major Vieira",
            ],
            [
                "ibge_codigo"       => 4210407,
                "ibge_estado_id" => 42,
                "nome"     => "Maracajá",
            ],
            [
                "ibge_codigo"       => 4210506,
                "ibge_estado_id" => 42,
                "nome"     => "Maravilha",
            ],
            [
                "ibge_codigo"       => 4210555,
                "ibge_estado_id" => 42,
                "nome"     => "Marema",
            ],
            [
                "ibge_codigo"       => 4210605,
                "ibge_estado_id" => 42,
                "nome"     => "Massaranduba",
            ],
            [
                "ibge_codigo"       => 4210704,
                "ibge_estado_id" => 42,
                "nome"     => "Matos Costa",
            ],
            [
                "ibge_codigo"       => 4210803,
                "ibge_estado_id" => 42,
                "nome"     => "Meleiro",
            ],
            [
                "ibge_codigo"       => 4210852,
                "ibge_estado_id" => 42,
                "nome"     => "Mirim Doce",
            ],
            [
                "ibge_codigo"       => 4210902,
                "ibge_estado_id" => 42,
                "nome"     => "Modelo",
            ],
            [
                "ibge_codigo"       => 4211009,
                "ibge_estado_id" => 42,
                "nome"     => "Mondaí",
            ],
            [
                "ibge_codigo"       => 4211058,
                "ibge_estado_id" => 42,
                "nome"     => "Monte Carlo",
            ],
            [
                "ibge_codigo"       => 4211108,
                "ibge_estado_id" => 42,
                "nome"     => "Monte Castelo",
            ],
            [
                "ibge_codigo"       => 4211207,
                "ibge_estado_id" => 42,
                "nome"     => "Morro da Fumaça",
            ],
            [
                "ibge_codigo"       => 4211256,
                "ibge_estado_id" => 42,
                "nome"     => "Morro Grande",
            ],
            [
                "ibge_codigo"       => 4211306,
                "ibge_estado_id" => 42,
                "nome"     => "Navegantes",
            ],
            [
                "ibge_codigo"       => 4211405,
                "ibge_estado_id" => 42,
                "nome"     => "Nova Erechim",
            ],
            [
                "ibge_codigo"       => 4211454,
                "ibge_estado_id" => 42,
                "nome"     => "Nova Itaberaba",
            ],
            [
                "ibge_codigo"       => 4211504,
                "ibge_estado_id" => 42,
                "nome"     => "Nova Trento",
            ],
            [
                "ibge_codigo"       => 4211603,
                "ibge_estado_id" => 42,
                "nome"     => "Nova Veneza",
            ],
            [
                "ibge_codigo"       => 4211652,
                "ibge_estado_id" => 42,
                "nome"     => "Novo Horizonte",
            ],
            [
                "ibge_codigo"       => 4211702,
                "ibge_estado_id" => 42,
                "nome"     => "Orleans",
            ],
            [
                "ibge_codigo"       => 4211751,
                "ibge_estado_id" => 42,
                "nome"     => "Otacílio Costa",
            ],
            [
                "ibge_codigo"       => 4211801,
                "ibge_estado_id" => 42,
                "nome"     => "Ouro",
            ],
            [
                "ibge_codigo"       => 4211850,
                "ibge_estado_id" => 42,
                "nome"     => "Ouro Verde",
            ],
            [
                "ibge_codigo"       => 4211876,
                "ibge_estado_id" => 42,
                "nome"     => "Paial",
            ],
            [
                "ibge_codigo"       => 4211892,
                "ibge_estado_id" => 42,
                "nome"     => "Painel",
            ],
            [
                "ibge_codigo"       => 4211900,
                "ibge_estado_id" => 42,
                "nome"     => "Palhoça",
            ],
            [
                "ibge_codigo"       => 4212007,
                "ibge_estado_id" => 42,
                "nome"     => "Palma Sola",
            ],
            [
                "ibge_codigo"       => 4212056,
                "ibge_estado_id" => 42,
                "nome"     => "Palmeira",
            ],
            [
                "ibge_codigo"       => 4212106,
                "ibge_estado_id" => 42,
                "nome"     => "Palmitos",
            ],
            [
                "ibge_codigo"       => 4212205,
                "ibge_estado_id" => 42,
                "nome"     => "Papanduva",
            ],
            [
                "ibge_codigo"       => 4212239,
                "ibge_estado_id" => 42,
                "nome"     => "Paraíso",
            ],
            [
                "ibge_codigo"       => 4212254,
                "ibge_estado_id" => 42,
                "nome"     => "Passo de Torres",
            ],
            [
                "ibge_codigo"       => 4212270,
                "ibge_estado_id" => 42,
                "nome"     => "Passos Maia",
            ],
            [
                "ibge_codigo"       => 4212304,
                "ibge_estado_id" => 42,
                "nome"     => "Paulo Lopes",
            ],
            [
                "ibge_codigo"       => 4212403,
                "ibge_estado_id" => 42,
                "nome"     => "Pedras Grandes",
            ],
            [
                "ibge_codigo"       => 4212502,
                "ibge_estado_id" => 42,
                "nome"     => "Penha",
            ],
            [
                "ibge_codigo"       => 4212601,
                "ibge_estado_id" => 42,
                "nome"     => "Peritiba",
            ],
            [
                "ibge_codigo"       => 4212650,
                "ibge_estado_id" => 42,
                "nome"     => "Pescaria Brava",
            ],
            [
                "ibge_codigo"       => 4212700,
                "ibge_estado_id" => 42,
                "nome"     => "Petrolândia",
            ],
            [
                "ibge_codigo"       => 4212809,
                "ibge_estado_id" => 42,
                "nome"     => "Balneário Piçarras",
            ],
            [
                "ibge_codigo"       => 4212908,
                "ibge_estado_id" => 42,
                "nome"     => "Pinhalzinho",
            ],
            [
                "ibge_codigo"       => 4213005,
                "ibge_estado_id" => 42,
                "nome"     => "Pinheiro Preto",
            ],
            [
                "ibge_codigo"       => 4213104,
                "ibge_estado_id" => 42,
                "nome"     => "Piratuba",
            ],
            [
                "ibge_codigo"       => 4213153,
                "ibge_estado_id" => 42,
                "nome"     => "Planalto Alegre",
            ],
            [
                "ibge_codigo"       => 4213203,
                "ibge_estado_id" => 42,
                "nome"     => "Pomerode",
            ],
            [
                "ibge_codigo"       => 4213302,
                "ibge_estado_id" => 42,
                "nome"     => "Ponte Alta",
            ],
            [
                "ibge_codigo"       => 4213351,
                "ibge_estado_id" => 42,
                "nome"     => "Ponte Alta do Norte",
            ],
            [
                "ibge_codigo"       => 4213401,
                "ibge_estado_id" => 42,
                "nome"     => "Ponte Serrada",
            ],
            [
                "ibge_codigo"       => 4213500,
                "ibge_estado_id" => 42,
                "nome"     => "Porto Belo",
            ],
            [
                "ibge_codigo"       => 4213609,
                "ibge_estado_id" => 42,
                "nome"     => "Porto União",
            ],
            [
                "ibge_codigo"       => 4213708,
                "ibge_estado_id" => 42,
                "nome"     => "Pouso Redondo",
            ],
            [
                "ibge_codigo"       => 4213807,
                "ibge_estado_id" => 42,
                "nome"     => "Praia Grande",
            ],
            [
                "ibge_codigo"       => 4213906,
                "ibge_estado_id" => 42,
                "nome"     => "Presidente Castello Branco",
            ],
            [
                "ibge_codigo"       => 4214003,
                "ibge_estado_id" => 42,
                "nome"     => "Presidente Getúlio",
            ],
            [
                "ibge_codigo"       => 4214102,
                "ibge_estado_id" => 42,
                "nome"     => "Presidente Nereu",
            ],
            [
                "ibge_codigo"       => 4214151,
                "ibge_estado_id" => 42,
                "nome"     => "Princesa",
            ],
            [
                "ibge_codigo"       => 4214201,
                "ibge_estado_id" => 42,
                "nome"     => "Quilombo",
            ],
            [
                "ibge_codigo"       => 4214300,
                "ibge_estado_id" => 42,
                "nome"     => "Rancho Queimado",
            ],
            [
                "ibge_codigo"       => 4214409,
                "ibge_estado_id" => 42,
                "nome"     => "Rio das Antas",
            ],
            [
                "ibge_codigo"       => 4214508,
                "ibge_estado_id" => 42,
                "nome"     => "Rio do Campo",
            ],
            [
                "ibge_codigo"       => 4214607,
                "ibge_estado_id" => 42,
                "nome"     => "Rio do Oeste",
            ],
            [
                "ibge_codigo"       => 4214706,
                "ibge_estado_id" => 42,
                "nome"     => "Rio dos Cedros",
            ],
            [
                "ibge_codigo"       => 4214805,
                "ibge_estado_id" => 42,
                "nome"     => "Rio do Sul",
            ],
            [
                "ibge_codigo"       => 4214904,
                "ibge_estado_id" => 42,
                "nome"     => "Rio Fortuna",
            ],
            [
                "ibge_codigo"       => 4215000,
                "ibge_estado_id" => 42,
                "nome"     => "Rio Negrinho",
            ],
            [
                "ibge_codigo"       => 4215059,
                "ibge_estado_id" => 42,
                "nome"     => "Rio Rufino",
            ],
            [
                "ibge_codigo"       => 4215075,
                "ibge_estado_id" => 42,
                "nome"     => "Riqueza",
            ],
            [
                "ibge_codigo"       => 4215109,
                "ibge_estado_id" => 42,
                "nome"     => "Rodeio",
            ],
            [
                "ibge_codigo"       => 4215208,
                "ibge_estado_id" => 42,
                "nome"     => "Romelândia",
            ],
            [
                "ibge_codigo"       => 4215307,
                "ibge_estado_id" => 42,
                "nome"     => "Salete",
            ],
            [
                "ibge_codigo"       => 4215356,
                "ibge_estado_id" => 42,
                "nome"     => "Saltinho",
            ],
            [
                "ibge_codigo"       => 4215406,
                "ibge_estado_id" => 42,
                "nome"     => "Salto Veloso",
            ],
            [
                "ibge_codigo"       => 4215455,
                "ibge_estado_id" => 42,
                "nome"     => "Sangão",
            ],
            [
                "ibge_codigo"       => 4215505,
                "ibge_estado_id" => 42,
                "nome"     => "Santa Cecília",
            ],
            [
                "ibge_codigo"       => 4215554,
                "ibge_estado_id" => 42,
                "nome"     => "Santa Helena",
            ],
            [
                "ibge_codigo"       => 4215604,
                "ibge_estado_id" => 42,
                "nome"     => "Santa Rosa de Lima",
            ],
            [
                "ibge_codigo"       => 4215653,
                "ibge_estado_id" => 42,
                "nome"     => "Santa Rosa do Sul",
            ],
            [
                "ibge_codigo"       => 4215679,
                "ibge_estado_id" => 42,
                "nome"     => "Santa Terezinha",
            ],
            [
                "ibge_codigo"       => 4215687,
                "ibge_estado_id" => 42,
                "nome"     => "Santa Terezinha do Progresso",
            ],
            [
                "ibge_codigo"       => 4215695,
                "ibge_estado_id" => 42,
                "nome"     => "Santiago do Sul",
            ],
            [
                "ibge_codigo"       => 4215703,
                "ibge_estado_id" => 42,
                "nome"     => "Santo Amaro da Imperatriz",
            ],
            [
                "ibge_codigo"       => 4215752,
                "ibge_estado_id" => 42,
                "nome"     => "São Bernardino",
            ],
            [
                "ibge_codigo"       => 4215802,
                "ibge_estado_id" => 42,
                "nome"     => "São Bento do Sul",
            ],
            [
                "ibge_codigo"       => 4215901,
                "ibge_estado_id" => 42,
                "nome"     => "São Bonifácio",
            ],
            [
                "ibge_codigo"       => 4216008,
                "ibge_estado_id" => 42,
                "nome"     => "São Carlos",
            ],
            [
                "ibge_codigo"       => 4216057,
                "ibge_estado_id" => 42,
                "nome"     => "São Cristovão do Sul",
            ],
            [
                "ibge_codigo"       => 4216107,
                "ibge_estado_id" => 42,
                "nome"     => "São Domingos",
            ],
            [
                "ibge_codigo"       => 4216206,
                "ibge_estado_id" => 42,
                "nome"     => "São Francisco do Sul",
            ],
            [
                "ibge_codigo"       => 4216255,
                "ibge_estado_id" => 42,
                "nome"     => "São João do Oeste",
            ],
            [
                "ibge_codigo"       => 4216305,
                "ibge_estado_id" => 42,
                "nome"     => "São João Batista",
            ],
            [
                "ibge_codigo"       => 4216354,
                "ibge_estado_id" => 42,
                "nome"     => "São João do Itaperiú",
            ],
            [
                "ibge_codigo"       => 4216404,
                "ibge_estado_id" => 42,
                "nome"     => "São João do Sul",
            ],
            [
                "ibge_codigo"       => 4216503,
                "ibge_estado_id" => 42,
                "nome"     => "São Joaquim",
            ],
            [
                "ibge_codigo"       => 4216602,
                "ibge_estado_id" => 42,
                "nome"     => "São José",
            ],
            [
                "ibge_codigo"       => 4216701,
                "ibge_estado_id" => 42,
                "nome"     => "São José do Cedro",
            ],
            [
                "ibge_codigo"       => 4216800,
                "ibge_estado_id" => 42,
                "nome"     => "São José do Cerrito",
            ],
            [
                "ibge_codigo"       => 4216909,
                "ibge_estado_id" => 42,
                "nome"     => "São Lourenço do Oeste",
            ],
            [
                "ibge_codigo"       => 4217006,
                "ibge_estado_id" => 42,
                "nome"     => "São Ludgero",
            ],
            [
                "ibge_codigo"       => 4217105,
                "ibge_estado_id" => 42,
                "nome"     => "São Martinho",
            ],
            [
                "ibge_codigo"       => 4217154,
                "ibge_estado_id" => 42,
                "nome"     => "São Miguel da Boa Vista",
            ],
            [
                "ibge_codigo"       => 4217204,
                "ibge_estado_id" => 42,
                "nome"     => "São Miguel do Oeste",
            ],
            [
                "ibge_codigo"       => 4217253,
                "ibge_estado_id" => 42,
                "nome"     => "São Pedro de Alcântara",
            ],
            [
                "ibge_codigo"       => 4217303,
                "ibge_estado_id" => 42,
                "nome"     => "Saudades",
            ],
            [
                "ibge_codigo"       => 4217402,
                "ibge_estado_id" => 42,
                "nome"     => "Schroeder",
            ],
            [
                "ibge_codigo"       => 4217501,
                "ibge_estado_id" => 42,
                "nome"     => "Seara",
            ],
            [
                "ibge_codigo"       => 4217550,
                "ibge_estado_id" => 42,
                "nome"     => "Serra Alta",
            ],
            [
                "ibge_codigo"       => 4217600,
                "ibge_estado_id" => 42,
                "nome"     => "Siderópolis",
            ],
            [
                "ibge_codigo"       => 4217709,
                "ibge_estado_id" => 42,
                "nome"     => "Sombrio",
            ],
            [
                "ibge_codigo"       => 4217758,
                "ibge_estado_id" => 42,
                "nome"     => "Sul Brasil",
            ],
            [
                "ibge_codigo"       => 4217808,
                "ibge_estado_id" => 42,
                "nome"     => "Taió",
            ],
            [
                "ibge_codigo"       => 4217907,
                "ibge_estado_id" => 42,
                "nome"     => "Tangará",
            ],
            [
                "ibge_codigo"       => 4217956,
                "ibge_estado_id" => 42,
                "nome"     => "Tigrinhos",
            ],
            [
                "ibge_codigo"       => 4218004,
                "ibge_estado_id" => 42,
                "nome"     => "Tijucas",
            ],
            [
                "ibge_codigo"       => 4218103,
                "ibge_estado_id" => 42,
                "nome"     => "Timbé do Sul",
            ],
            [
                "ibge_codigo"       => 4218202,
                "ibge_estado_id" => 42,
                "nome"     => "Timbó",
            ],
            [
                "ibge_codigo"       => 4218251,
                "ibge_estado_id" => 42,
                "nome"     => "Timbó Grande",
            ],
            [
                "ibge_codigo"       => 4218301,
                "ibge_estado_id" => 42,
                "nome"     => "Três Barras",
            ],
            [
                "ibge_codigo"       => 4218350,
                "ibge_estado_id" => 42,
                "nome"     => "Treviso",
            ],
            [
                "ibge_codigo"       => 4218400,
                "ibge_estado_id" => 42,
                "nome"     => "Treze de Maio",
            ],
            [
                "ibge_codigo"       => 4218509,
                "ibge_estado_id" => 42,
                "nome"     => "Treze Tílias",
            ],
            [
                "ibge_codigo"       => 4218608,
                "ibge_estado_id" => 42,
                "nome"     => "Trombudo Central",
            ],
            [
                "ibge_codigo"       => 4218707,
                "ibge_estado_id" => 42,
                "nome"     => "Tubarão",
            ],
            [
                "ibge_codigo"       => 4218756,
                "ibge_estado_id" => 42,
                "nome"     => "Tunápolis",
            ],
            [
                "ibge_codigo"       => 4218806,
                "ibge_estado_id" => 42,
                "nome"     => "Turvo",
            ],
            [
                "ibge_codigo"       => 4218855,
                "ibge_estado_id" => 42,
                "nome"     => "União do Oeste",
            ],
            [
                "ibge_codigo"       => 4218905,
                "ibge_estado_id" => 42,
                "nome"     => "Urubici",
            ],
            [
                "ibge_codigo"       => 4218954,
                "ibge_estado_id" => 42,
                "nome"     => "Urupema",
            ],
            [
                "ibge_codigo"       => 4219002,
                "ibge_estado_id" => 42,
                "nome"     => "Urussanga",
            ],
            [
                "ibge_codigo"       => 4219101,
                "ibge_estado_id" => 42,
                "nome"     => "Vargeão",
            ],
            [
                "ibge_codigo"       => 4219150,
                "ibge_estado_id" => 42,
                "nome"     => "Vargem",
            ],
            [
                "ibge_codigo"       => 4219176,
                "ibge_estado_id" => 42,
                "nome"     => "Vargem Bonita",
            ],
            [
                "ibge_codigo"       => 4219200,
                "ibge_estado_id" => 42,
                "nome"     => "Vidal Ramos",
            ],
            [
                "ibge_codigo"       => 4219309,
                "ibge_estado_id" => 42,
                "nome"     => "Videira",
            ],
            [
                "ibge_codigo"       => 4219358,
                "ibge_estado_id" => 42,
                "nome"     => "Vitor Meireles",
            ],
            [
                "ibge_codigo"       => 4219408,
                "ibge_estado_id" => 42,
                "nome"     => "Witmarsum",
            ],
            [
                "ibge_codigo"       => 4219507,
                "ibge_estado_id" => 42,
                "nome"     => "Xanxerê",
            ],
            [
                "ibge_codigo"       => 4219606,
                "ibge_estado_id" => 42,
                "nome"     => "Xavantina",
            ],
            [
                "ibge_codigo"       => 4219705,
                "ibge_estado_id" => 42,
                "nome"     => "Xaxim",
            ],
            [
                "ibge_codigo"       => 4219853,
                "ibge_estado_id" => 42,
                "nome"     => "Zortéa",
            ],
            [
                "ibge_codigo"       => 4220000,
                "ibge_estado_id" => 42,
                "nome"     => "Balneário Rincão",
            ],
            [
                "ibge_codigo"       => 4300034,
                "ibge_estado_id" => 43,
                "nome"     => "Aceguá",
            ],
            [
                "ibge_codigo"       => 4300059,
                "ibge_estado_id" => 43,
                "nome"     => "Água Santa",
            ],
            [
                "ibge_codigo"       => 4300109,
                "ibge_estado_id" => 43,
                "nome"     => "Agudo",
            ],
            [
                "ibge_codigo"       => 4300208,
                "ibge_estado_id" => 43,
                "nome"     => "Ajuricaba",
            ],
            [
                "ibge_codigo"       => 4300307,
                "ibge_estado_id" => 43,
                "nome"     => "Alecrim",
            ],
            [
                "ibge_codigo"       => 4300406,
                "ibge_estado_id" => 43,
                "nome"     => "Alegrete",
            ],
            [
                "ibge_codigo"       => 4300455,
                "ibge_estado_id" => 43,
                "nome"     => "Alegria",
            ],
            [
                "ibge_codigo"       => 4300471,
                "ibge_estado_id" => 43,
                "nome"     => "Almirante Tamandaré do Sul",
            ],
            [
                "ibge_codigo"       => 4300505,
                "ibge_estado_id" => 43,
                "nome"     => "Alpestre",
            ],
            [
                "ibge_codigo"       => 4300554,
                "ibge_estado_id" => 43,
                "nome"     => "Alto Alegre",
            ],
            [
                "ibge_codigo"       => 4300570,
                "ibge_estado_id" => 43,
                "nome"     => "Alto Feliz",
            ],
            [
                "ibge_codigo"       => 4300604,
                "ibge_estado_id" => 43,
                "nome"     => "Alvorada",
            ],
            [
                "ibge_codigo"       => 4300638,
                "ibge_estado_id" => 43,
                "nome"     => "Amaral Ferrador",
            ],
            [
                "ibge_codigo"       => 4300646,
                "ibge_estado_id" => 43,
                "nome"     => "Ametista do Sul",
            ],
            [
                "ibge_codigo"       => 4300661,
                "ibge_estado_id" => 43,
                "nome"     => "André da Rocha",
            ],
            [
                "ibge_codigo"       => 4300703,
                "ibge_estado_id" => 43,
                "nome"     => "Anta Gorda",
            ],
            [
                "ibge_codigo"       => 4300802,
                "ibge_estado_id" => 43,
                "nome"     => "Antônio Prado",
            ],
            [
                "ibge_codigo"       => 4300851,
                "ibge_estado_id" => 43,
                "nome"     => "Arambaré",
            ],
            [
                "ibge_codigo"       => 4300877,
                "ibge_estado_id" => 43,
                "nome"     => "Araricá",
            ],
            [
                "ibge_codigo"       => 4300901,
                "ibge_estado_id" => 43,
                "nome"     => "Aratiba",
            ],
            [
                "ibge_codigo"       => 4301008,
                "ibge_estado_id" => 43,
                "nome"     => "Arroio do Meio",
            ],
            [
                "ibge_codigo"       => 4301057,
                "ibge_estado_id" => 43,
                "nome"     => "Arroio do Sal",
            ],
            [
                "ibge_codigo"       => 4301073,
                "ibge_estado_id" => 43,
                "nome"     => "Arroio do Padre",
            ],
            [
                "ibge_codigo"       => 4301107,
                "ibge_estado_id" => 43,
                "nome"     => "Arroio dos Ratos",
            ],
            [
                "ibge_codigo"       => 4301206,
                "ibge_estado_id" => 43,
                "nome"     => "Arroio do Tigre",
            ],
            [
                "ibge_codigo"       => 4301305,
                "ibge_estado_id" => 43,
                "nome"     => "Arroio Grande",
            ],
            [
                "ibge_codigo"       => 4301404,
                "ibge_estado_id" => 43,
                "nome"     => "Arvorezinha",
            ],
            [
                "ibge_codigo"       => 4301503,
                "ibge_estado_id" => 43,
                "nome"     => "Augusto Pestana",
            ],
            [
                "ibge_codigo"       => 4301552,
                "ibge_estado_id" => 43,
                "nome"     => "Áurea",
            ],
            [
                "ibge_codigo"       => 4301602,
                "ibge_estado_id" => 43,
                "nome"     => "Bagé",
            ],
            [
                "ibge_codigo"       => 4301636,
                "ibge_estado_id" => 43,
                "nome"     => "Balneário Pinhal",
            ],
            [
                "ibge_codigo"       => 4301651,
                "ibge_estado_id" => 43,
                "nome"     => "Barão",
            ],
            [
                "ibge_codigo"       => 4301701,
                "ibge_estado_id" => 43,
                "nome"     => "Barão de Cotegipe",
            ],
            [
                "ibge_codigo"       => 4301750,
                "ibge_estado_id" => 43,
                "nome"     => "Barão do Triunfo",
            ],
            [
                "ibge_codigo"       => 4301800,
                "ibge_estado_id" => 43,
                "nome"     => "Barracão",
            ],
            [
                "ibge_codigo"       => 4301859,
                "ibge_estado_id" => 43,
                "nome"     => "Barra do Guarita",
            ],
            [
                "ibge_codigo"       => 4301875,
                "ibge_estado_id" => 43,
                "nome"     => "Barra do Quaraí",
            ],
            [
                "ibge_codigo"       => 4301909,
                "ibge_estado_id" => 43,
                "nome"     => "Barra do Ribeiro",
            ],
            [
                "ibge_codigo"       => 4301925,
                "ibge_estado_id" => 43,
                "nome"     => "Barra do Rio Azul",
            ],
            [
                "ibge_codigo"       => 4301958,
                "ibge_estado_id" => 43,
                "nome"     => "Barra Funda",
            ],
            [
                "ibge_codigo"       => 4302006,
                "ibge_estado_id" => 43,
                "nome"     => "Barros Cassal",
            ],
            [
                "ibge_codigo"       => 4302055,
                "ibge_estado_id" => 43,
                "nome"     => "Benjamin Constant do Sul",
            ],
            [
                "ibge_codigo"       => 4302105,
                "ibge_estado_id" => 43,
                "nome"     => "Bento Gonçalves",
            ],
            [
                "ibge_codigo"       => 4302154,
                "ibge_estado_id" => 43,
                "nome"     => "Boa Vista das Missões",
            ],
            [
                "ibge_codigo"       => 4302204,
                "ibge_estado_id" => 43,
                "nome"     => "Boa Vista do Buricá",
            ],
            [
                "ibge_codigo"       => 4302220,
                "ibge_estado_id" => 43,
                "nome"     => "Boa Vista do Cadeado",
            ],
            [
                "ibge_codigo"       => 4302238,
                "ibge_estado_id" => 43,
                "nome"     => "Boa Vista do Incra",
            ],
            [
                "ibge_codigo"       => 4302253,
                "ibge_estado_id" => 43,
                "nome"     => "Boa Vista do Sul",
            ],
            [
                "ibge_codigo"       => 4302303,
                "ibge_estado_id" => 43,
                "nome"     => "Bom Jesus",
            ],
            [
                "ibge_codigo"       => 4302352,
                "ibge_estado_id" => 43,
                "nome"     => "Bom Princípio",
            ],
            [
                "ibge_codigo"       => 4302378,
                "ibge_estado_id" => 43,
                "nome"     => "Bom Progresso",
            ],
            [
                "ibge_codigo"       => 4302402,
                "ibge_estado_id" => 43,
                "nome"     => "Bom Retiro do Sul",
            ],
            [
                "ibge_codigo"       => 4302451,
                "ibge_estado_id" => 43,
                "nome"     => "Boqueirão do Leão",
            ],
            [
                "ibge_codigo"       => 4302501,
                "ibge_estado_id" => 43,
                "nome"     => "Bossoroca",
            ],
            [
                "ibge_codigo"       => 4302584,
                "ibge_estado_id" => 43,
                "nome"     => "Bozano",
            ],
            [
                "ibge_codigo"       => 4302600,
                "ibge_estado_id" => 43,
                "nome"     => "Braga",
            ],
            [
                "ibge_codigo"       => 4302659,
                "ibge_estado_id" => 43,
                "nome"     => "Brochier",
            ],
            [
                "ibge_codigo"       => 4302709,
                "ibge_estado_id" => 43,
                "nome"     => "Butiá",
            ],
            [
                "ibge_codigo"       => 4302808,
                "ibge_estado_id" => 43,
                "nome"     => "Caçapava do Sul",
            ],
            [
                "ibge_codigo"       => 4302907,
                "ibge_estado_id" => 43,
                "nome"     => "Cacequi",
            ],
            [
                "ibge_codigo"       => 4303004,
                "ibge_estado_id" => 43,
                "nome"     => "Cachoeira do Sul",
            ],
            [
                "ibge_codigo"       => 4303103,
                "ibge_estado_id" => 43,
                "nome"     => "Cachoeirinha",
            ],
            [
                "ibge_codigo"       => 4303202,
                "ibge_estado_id" => 43,
                "nome"     => "Cacique Doble",
            ],
            [
                "ibge_codigo"       => 4303301,
                "ibge_estado_id" => 43,
                "nome"     => "Caibaté",
            ],
            [
                "ibge_codigo"       => 4303400,
                "ibge_estado_id" => 43,
                "nome"     => "Caiçara",
            ],
            [
                "ibge_codigo"       => 4303509,
                "ibge_estado_id" => 43,
                "nome"     => "Camaquã",
            ],
            [
                "ibge_codigo"       => 4303558,
                "ibge_estado_id" => 43,
                "nome"     => "Camargo",
            ],
            [
                "ibge_codigo"       => 4303608,
                "ibge_estado_id" => 43,
                "nome"     => "Cambará do Sul",
            ],
            [
                "ibge_codigo"       => 4303673,
                "ibge_estado_id" => 43,
                "nome"     => "Campestre da Serra",
            ],
            [
                "ibge_codigo"       => 4303707,
                "ibge_estado_id" => 43,
                "nome"     => "Campina das Missões",
            ],
            [
                "ibge_codigo"       => 4303806,
                "ibge_estado_id" => 43,
                "nome"     => "Campinas do Sul",
            ],
            [
                "ibge_codigo"       => 4303905,
                "ibge_estado_id" => 43,
                "nome"     => "Campo Bom",
            ],
            [
                "ibge_codigo"       => 4304002,
                "ibge_estado_id" => 43,
                "nome"     => "Campo Novo",
            ],
            [
                "ibge_codigo"       => 4304101,
                "ibge_estado_id" => 43,
                "nome"     => "Campos Borges",
            ],
            [
                "ibge_codigo"       => 4304200,
                "ibge_estado_id" => 43,
                "nome"     => "Candelária",
            ],
            [
                "ibge_codigo"       => 4304309,
                "ibge_estado_id" => 43,
                "nome"     => "Cândido Godói",
            ],
            [
                "ibge_codigo"       => 4304358,
                "ibge_estado_id" => 43,
                "nome"     => "Candiota",
            ],
            [
                "ibge_codigo"       => 4304408,
                "ibge_estado_id" => 43,
                "nome"     => "Canela",
            ],
            [
                "ibge_codigo"       => 4304507,
                "ibge_estado_id" => 43,
                "nome"     => "Canguçu",
            ],
            [
                "ibge_codigo"       => 4304606,
                "ibge_estado_id" => 43,
                "nome"     => "Canoas",
            ],
            [
                "ibge_codigo"       => 4304614,
                "ibge_estado_id" => 43,
                "nome"     => "Canudos do Vale",
            ],
            [
                "ibge_codigo"       => 4304622,
                "ibge_estado_id" => 43,
                "nome"     => "Capão Bonito do Sul",
            ],
            [
                "ibge_codigo"       => 4304630,
                "ibge_estado_id" => 43,
                "nome"     => "Capão da Canoa",
            ],
            [
                "ibge_codigo"       => 4304655,
                "ibge_estado_id" => 43,
                "nome"     => "Capão do Cipó",
            ],
            [
                "ibge_codigo"       => 4304663,
                "ibge_estado_id" => 43,
                "nome"     => "Capão do Leão",
            ],
            [
                "ibge_codigo"       => 4304671,
                "ibge_estado_id" => 43,
                "nome"     => "Capivari do Sul",
            ],
            [
                "ibge_codigo"       => 4304689,
                "ibge_estado_id" => 43,
                "nome"     => "Capela de Santana",
            ],
            [
                "ibge_codigo"       => 4304697,
                "ibge_estado_id" => 43,
                "nome"     => "Capitão",
            ],
            [
                "ibge_codigo"       => 4304705,
                "ibge_estado_id" => 43,
                "nome"     => "Carazinho",
            ],
            [
                "ibge_codigo"       => 4304713,
                "ibge_estado_id" => 43,
                "nome"     => "Caraá",
            ],
            [
                "ibge_codigo"       => 4304804,
                "ibge_estado_id" => 43,
                "nome"     => "Carlos Barbosa",
            ],
            [
                "ibge_codigo"       => 4304853,
                "ibge_estado_id" => 43,
                "nome"     => "Carlos Gomes",
            ],
            [
                "ibge_codigo"       => 4304903,
                "ibge_estado_id" => 43,
                "nome"     => "Casca",
            ],
            [
                "ibge_codigo"       => 4304952,
                "ibge_estado_id" => 43,
                "nome"     => "Caseiros",
            ],
            [
                "ibge_codigo"       => 4305009,
                "ibge_estado_id" => 43,
                "nome"     => "Catuípe",
            ],
            [
                "ibge_codigo"       => 4305108,
                "ibge_estado_id" => 43,
                "nome"     => "Caxias do Sul",
            ],
            [
                "ibge_codigo"       => 4305116,
                "ibge_estado_id" => 43,
                "nome"     => "Centenário",
            ],
            [
                "ibge_codigo"       => 4305124,
                "ibge_estado_id" => 43,
                "nome"     => "Cerrito",
            ],
            [
                "ibge_codigo"       => 4305132,
                "ibge_estado_id" => 43,
                "nome"     => "Cerro Branco",
            ],
            [
                "ibge_codigo"       => 4305157,
                "ibge_estado_id" => 43,
                "nome"     => "Cerro Grande",
            ],
            [
                "ibge_codigo"       => 4305173,
                "ibge_estado_id" => 43,
                "nome"     => "Cerro Grande do Sul",
            ],
            [
                "ibge_codigo"       => 4305207,
                "ibge_estado_id" => 43,
                "nome"     => "Cerro Largo",
            ],
            [
                "ibge_codigo"       => 4305306,
                "ibge_estado_id" => 43,
                "nome"     => "Chapada",
            ],
            [
                "ibge_codigo"       => 4305355,
                "ibge_estado_id" => 43,
                "nome"     => "Charqueadas",
            ],
            [
                "ibge_codigo"       => 4305371,
                "ibge_estado_id" => 43,
                "nome"     => "Charrua",
            ],
            [
                "ibge_codigo"       => 4305405,
                "ibge_estado_id" => 43,
                "nome"     => "Chiapetta",
            ],
            [
                "ibge_codigo"       => 4305439,
                "ibge_estado_id" => 43,
                "nome"     => "Chuí",
            ],
            [
                "ibge_codigo"       => 4305447,
                "ibge_estado_id" => 43,
                "nome"     => "Chuvisca",
            ],
            [
                "ibge_codigo"       => 4305454,
                "ibge_estado_id" => 43,
                "nome"     => "Cidreira",
            ],
            [
                "ibge_codigo"       => 4305504,
                "ibge_estado_id" => 43,
                "nome"     => "Ciríaco",
            ],
            [
                "ibge_codigo"       => 4305587,
                "ibge_estado_id" => 43,
                "nome"     => "Colinas",
            ],
            [
                "ibge_codigo"       => 4305603,
                "ibge_estado_id" => 43,
                "nome"     => "Colorado",
            ],
            [
                "ibge_codigo"       => 4305702,
                "ibge_estado_id" => 43,
                "nome"     => "Condor",
            ],
            [
                "ibge_codigo"       => 4305801,
                "ibge_estado_id" => 43,
                "nome"     => "Constantina",
            ],
            [
                "ibge_codigo"       => 4305835,
                "ibge_estado_id" => 43,
                "nome"     => "Coqueiro Baixo",
            ],
            [
                "ibge_codigo"       => 4305850,
                "ibge_estado_id" => 43,
                "nome"     => "Coqueiros do Sul",
            ],
            [
                "ibge_codigo"       => 4305871,
                "ibge_estado_id" => 43,
                "nome"     => "Coronel Barros",
            ],
            [
                "ibge_codigo"       => 4305900,
                "ibge_estado_id" => 43,
                "nome"     => "Coronel Bicaco",
            ],
            [
                "ibge_codigo"       => 4305934,
                "ibge_estado_id" => 43,
                "nome"     => "Coronel Pilar",
            ],
            [
                "ibge_codigo"       => 4305959,
                "ibge_estado_id" => 43,
                "nome"     => "Cotiporã",
            ],
            [
                "ibge_codigo"       => 4305975,
                "ibge_estado_id" => 43,
                "nome"     => "Coxilha",
            ],
            [
                "ibge_codigo"       => 4306007,
                "ibge_estado_id" => 43,
                "nome"     => "Crissiumal",
            ],
            [
                "ibge_codigo"       => 4306056,
                "ibge_estado_id" => 43,
                "nome"     => "Cristal",
            ],
            [
                "ibge_codigo"       => 4306072,
                "ibge_estado_id" => 43,
                "nome"     => "Cristal do Sul",
            ],
            [
                "ibge_codigo"       => 4306106,
                "ibge_estado_id" => 43,
                "nome"     => "Cruz Alta",
            ],
            [
                "ibge_codigo"       => 4306130,
                "ibge_estado_id" => 43,
                "nome"     => "Cruzaltense",
            ],
            [
                "ibge_codigo"       => 4306205,
                "ibge_estado_id" => 43,
                "nome"     => "Cruzeiro do Sul",
            ],
            [
                "ibge_codigo"       => 4306304,
                "ibge_estado_id" => 43,
                "nome"     => "David Canabarro",
            ],
            [
                "ibge_codigo"       => 4306320,
                "ibge_estado_id" => 43,
                "nome"     => "Derrubadas",
            ],
            [
                "ibge_codigo"       => 4306353,
                "ibge_estado_id" => 43,
                "nome"     => "Dezesseis de Novembro",
            ],
            [
                "ibge_codigo"       => 4306379,
                "ibge_estado_id" => 43,
                "nome"     => "Dilermando de Aguiar",
            ],
            [
                "ibge_codigo"       => 4306403,
                "ibge_estado_id" => 43,
                "nome"     => "Dois Irmãos",
            ],
            [
                "ibge_codigo"       => 4306429,
                "ibge_estado_id" => 43,
                "nome"     => "Dois Irmãos das Missões",
            ],
            [
                "ibge_codigo"       => 4306452,
                "ibge_estado_id" => 43,
                "nome"     => "Dois Lajeados",
            ],
            [
                "ibge_codigo"       => 4306502,
                "ibge_estado_id" => 43,
                "nome"     => "Dom Feliciano",
            ],
            [
                "ibge_codigo"       => 4306551,
                "ibge_estado_id" => 43,
                "nome"     => "Dom Pedro de Alcântara",
            ],
            [
                "ibge_codigo"       => 4306601,
                "ibge_estado_id" => 43,
                "nome"     => "Dom Pedrito",
            ],
            [
                "ibge_codigo"       => 4306700,
                "ibge_estado_id" => 43,
                "nome"     => "Dona Francisca",
            ],
            [
                "ibge_codigo"       => 4306734,
                "ibge_estado_id" => 43,
                "nome"     => "Doutor Maurício Cardoso",
            ],
            [
                "ibge_codigo"       => 4306759,
                "ibge_estado_id" => 43,
                "nome"     => "Doutor Ricardo",
            ],
            [
                "ibge_codigo"       => 4306767,
                "ibge_estado_id" => 43,
                "nome"     => "Eldorado do Sul",
            ],
            [
                "ibge_codigo"       => 4306809,
                "ibge_estado_id" => 43,
                "nome"     => "Encantado",
            ],
            [
                "ibge_codigo"       => 4306908,
                "ibge_estado_id" => 43,
                "nome"     => "Encruzilhada do Sul",
            ],
            [
                "ibge_codigo"       => 4306924,
                "ibge_estado_id" => 43,
                "nome"     => "Engenho Velho",
            ],
            [
                "ibge_codigo"       => 4306932,
                "ibge_estado_id" => 43,
                "nome"     => "Entre-Ijuís",
            ],
            [
                "ibge_codigo"       => 4306957,
                "ibge_estado_id" => 43,
                "nome"     => "Entre Rios do Sul",
            ],
            [
                "ibge_codigo"       => 4306973,
                "ibge_estado_id" => 43,
                "nome"     => "Erebango",
            ],
            [
                "ibge_codigo"       => 4307005,
                "ibge_estado_id" => 43,
                "nome"     => "Erechim",
            ],
            [
                "ibge_codigo"       => 4307054,
                "ibge_estado_id" => 43,
                "nome"     => "Ernestina",
            ],
            [
                "ibge_codigo"       => 4307104,
                "ibge_estado_id" => 43,
                "nome"     => "Herval",
            ],
            [
                "ibge_codigo"       => 4307203,
                "ibge_estado_id" => 43,
                "nome"     => "Erval Grande",
            ],
            [
                "ibge_codigo"       => 4307302,
                "ibge_estado_id" => 43,
                "nome"     => "Erval Seco",
            ],
            [
                "ibge_codigo"       => 4307401,
                "ibge_estado_id" => 43,
                "nome"     => "Esmeralda",
            ],
            [
                "ibge_codigo"       => 4307450,
                "ibge_estado_id" => 43,
                "nome"     => "Esperança do Sul",
            ],
            [
                "ibge_codigo"       => 4307500,
                "ibge_estado_id" => 43,
                "nome"     => "Espumoso",
            ],
            [
                "ibge_codigo"       => 4307559,
                "ibge_estado_id" => 43,
                "nome"     => "Estação",
            ],
            [
                "ibge_codigo"       => 4307609,
                "ibge_estado_id" => 43,
                "nome"     => "Estância Velha",
            ],
            [
                "ibge_codigo"       => 4307708,
                "ibge_estado_id" => 43,
                "nome"     => "Esteio",
            ],
            [
                "ibge_codigo"       => 4307807,
                "ibge_estado_id" => 43,
                "nome"     => "Estrela",
            ],
            [
                "ibge_codigo"       => 4307815,
                "ibge_estado_id" => 43,
                "nome"     => "Estrela Velha",
            ],
            [
                "ibge_codigo"       => 4307831,
                "ibge_estado_id" => 43,
                "nome"     => "Eugênio de Castro",
            ],
            [
                "ibge_codigo"       => 4307864,
                "ibge_estado_id" => 43,
                "nome"     => "Fagundes Varela",
            ],
            [
                "ibge_codigo"       => 4307906,
                "ibge_estado_id" => 43,
                "nome"     => "Farroupilha",
            ],
            [
                "ibge_codigo"       => 4308003,
                "ibge_estado_id" => 43,
                "nome"     => "Faxinal do Soturno",
            ],
            [
                "ibge_codigo"       => 4308052,
                "ibge_estado_id" => 43,
                "nome"     => "Faxinalzinho",
            ],
            [
                "ibge_codigo"       => 4308078,
                "ibge_estado_id" => 43,
                "nome"     => "Fazenda Vilanova",
            ],
            [
                "ibge_codigo"       => 4308102,
                "ibge_estado_id" => 43,
                "nome"     => "Feliz",
            ],
            [
                "ibge_codigo"       => 4308201,
                "ibge_estado_id" => 43,
                "nome"     => "Flores da Cunha",
            ],
            [
                "ibge_codigo"       => 4308250,
                "ibge_estado_id" => 43,
                "nome"     => "Floriano Peixoto",
            ],
            [
                "ibge_codigo"       => 4308300,
                "ibge_estado_id" => 43,
                "nome"     => "Fontoura Xavier",
            ],
            [
                "ibge_codigo"       => 4308409,
                "ibge_estado_id" => 43,
                "nome"     => "Formigueiro",
            ],
            [
                "ibge_codigo"       => 4308433,
                "ibge_estado_id" => 43,
                "nome"     => "Forquetinha",
            ],
            [
                "ibge_codigo"       => 4308458,
                "ibge_estado_id" => 43,
                "nome"     => "Fortaleza dos Valos",
            ],
            [
                "ibge_codigo"       => 4308508,
                "ibge_estado_id" => 43,
                "nome"     => "Frederico Westphalen",
            ],
            [
                "ibge_codigo"       => 4308607,
                "ibge_estado_id" => 43,
                "nome"     => "Garibaldi",
            ],
            [
                "ibge_codigo"       => 4308656,
                "ibge_estado_id" => 43,
                "nome"     => "Garruchos",
            ],
            [
                "ibge_codigo"       => 4308706,
                "ibge_estado_id" => 43,
                "nome"     => "Gaurama",
            ],
            [
                "ibge_codigo"       => 4308805,
                "ibge_estado_id" => 43,
                "nome"     => "General Câmara",
            ],
            [
                "ibge_codigo"       => 4308854,
                "ibge_estado_id" => 43,
                "nome"     => "Gentil",
            ],
            [
                "ibge_codigo"       => 4308904,
                "ibge_estado_id" => 43,
                "nome"     => "Getúlio Vargas",
            ],
            [
                "ibge_codigo"       => 4309001,
                "ibge_estado_id" => 43,
                "nome"     => "Giruá",
            ],
            [
                "ibge_codigo"       => 4309050,
                "ibge_estado_id" => 43,
                "nome"     => "Glorinha",
            ],
            [
                "ibge_codigo"       => 4309100,
                "ibge_estado_id" => 43,
                "nome"     => "Gramado",
            ],
            [
                "ibge_codigo"       => 4309126,
                "ibge_estado_id" => 43,
                "nome"     => "Gramado dos Loureiros",
            ],
            [
                "ibge_codigo"       => 4309159,
                "ibge_estado_id" => 43,
                "nome"     => "Gramado Xavier",
            ],
            [
                "ibge_codigo"       => 4309209,
                "ibge_estado_id" => 43,
                "nome"     => "Gravataí",
            ],
            [
                "ibge_codigo"       => 4309258,
                "ibge_estado_id" => 43,
                "nome"     => "Guabiju",
            ],
            [
                "ibge_codigo"       => 4309308,
                "ibge_estado_id" => 43,
                "nome"     => "Guaíba",
            ],
            [
                "ibge_codigo"       => 4309407,
                "ibge_estado_id" => 43,
                "nome"     => "Guaporé",
            ],
            [
                "ibge_codigo"       => 4309506,
                "ibge_estado_id" => 43,
                "nome"     => "Guarani das Missões",
            ],
            [
                "ibge_codigo"       => 4309555,
                "ibge_estado_id" => 43,
                "nome"     => "Harmonia",
            ],
            [
                "ibge_codigo"       => 4309571,
                "ibge_estado_id" => 43,
                "nome"     => "Herveiras",
            ],
            [
                "ibge_codigo"       => 4309605,
                "ibge_estado_id" => 43,
                "nome"     => "Horizontina",
            ],
            [
                "ibge_codigo"       => 4309654,
                "ibge_estado_id" => 43,
                "nome"     => "Hulha Negra",
            ],
            [
                "ibge_codigo"       => 4309704,
                "ibge_estado_id" => 43,
                "nome"     => "Humaitá",
            ],
            [
                "ibge_codigo"       => 4309753,
                "ibge_estado_id" => 43,
                "nome"     => "Ibarama",
            ],
            [
                "ibge_codigo"       => 4309803,
                "ibge_estado_id" => 43,
                "nome"     => "Ibiaçá",
            ],
            [
                "ibge_codigo"       => 4309902,
                "ibge_estado_id" => 43,
                "nome"     => "Ibiraiaras",
            ],
            [
                "ibge_codigo"       => 4309951,
                "ibge_estado_id" => 43,
                "nome"     => "Ibirapuitã",
            ],
            [
                "ibge_codigo"       => 4310009,
                "ibge_estado_id" => 43,
                "nome"     => "Ibirubá",
            ],
            [
                "ibge_codigo"       => 4310108,
                "ibge_estado_id" => 43,
                "nome"     => "Igrejinha",
            ],
            [
                "ibge_codigo"       => 4310207,
                "ibge_estado_id" => 43,
                "nome"     => "Ijuí",
            ],
            [
                "ibge_codigo"       => 4310306,
                "ibge_estado_id" => 43,
                "nome"     => "Ilópolis",
            ],
            [
                "ibge_codigo"       => 4310330,
                "ibge_estado_id" => 43,
                "nome"     => "Imbé",
            ],
            [
                "ibge_codigo"       => 4310363,
                "ibge_estado_id" => 43,
                "nome"     => "Imigrante",
            ],
            [
                "ibge_codigo"       => 4310405,
                "ibge_estado_id" => 43,
                "nome"     => "Independência",
            ],
            [
                "ibge_codigo"       => 4310413,
                "ibge_estado_id" => 43,
                "nome"     => "Inhacorá",
            ],
            [
                "ibge_codigo"       => 4310439,
                "ibge_estado_id" => 43,
                "nome"     => "Ipê",
            ],
            [
                "ibge_codigo"       => 4310462,
                "ibge_estado_id" => 43,
                "nome"     => "Ipiranga do Sul",
            ],
            [
                "ibge_codigo"       => 4310504,
                "ibge_estado_id" => 43,
                "nome"     => "Iraí",
            ],
            [
                "ibge_codigo"       => 4310538,
                "ibge_estado_id" => 43,
                "nome"     => "Itaara",
            ],
            [
                "ibge_codigo"       => 4310553,
                "ibge_estado_id" => 43,
                "nome"     => "Itacurubi",
            ],
            [
                "ibge_codigo"       => 4310579,
                "ibge_estado_id" => 43,
                "nome"     => "Itapuca",
            ],
            [
                "ibge_codigo"       => 4310603,
                "ibge_estado_id" => 43,
                "nome"     => "Itaqui",
            ],
            [
                "ibge_codigo"       => 4310652,
                "ibge_estado_id" => 43,
                "nome"     => "Itati",
            ],
            [
                "ibge_codigo"       => 4310702,
                "ibge_estado_id" => 43,
                "nome"     => "Itatiba do Sul",
            ],
            [
                "ibge_codigo"       => 4310751,
                "ibge_estado_id" => 43,
                "nome"     => "Ivorá",
            ],
            [
                "ibge_codigo"       => 4310801,
                "ibge_estado_id" => 43,
                "nome"     => "Ivoti",
            ],
            [
                "ibge_codigo"       => 4310850,
                "ibge_estado_id" => 43,
                "nome"     => "Jaboticaba",
            ],
            [
                "ibge_codigo"       => 4310876,
                "ibge_estado_id" => 43,
                "nome"     => "Jacuizinho",
            ],
            [
                "ibge_codigo"       => 4310900,
                "ibge_estado_id" => 43,
                "nome"     => "Jacutinga",
            ],
            [
                "ibge_codigo"       => 4311007,
                "ibge_estado_id" => 43,
                "nome"     => "Jaguarão",
            ],
            [
                "ibge_codigo"       => 4311106,
                "ibge_estado_id" => 43,
                "nome"     => "Jaguari",
            ],
            [
                "ibge_codigo"       => 4311122,
                "ibge_estado_id" => 43,
                "nome"     => "Jaquirana",
            ],
            [
                "ibge_codigo"       => 4311130,
                "ibge_estado_id" => 43,
                "nome"     => "Jari",
            ],
            [
                "ibge_codigo"       => 4311155,
                "ibge_estado_id" => 43,
                "nome"     => "Jóia",
            ],
            [
                "ibge_codigo"       => 4311205,
                "ibge_estado_id" => 43,
                "nome"     => "Júlio de Castilhos",
            ],
            [
                "ibge_codigo"       => 4311239,
                "ibge_estado_id" => 43,
                "nome"     => "Lagoa Bonita do Sul",
            ],
            [
                "ibge_codigo"       => 4311254,
                "ibge_estado_id" => 43,
                "nome"     => "Lagoão",
            ],
            [
                "ibge_codigo"       => 4311270,
                "ibge_estado_id" => 43,
                "nome"     => "Lagoa dos Três Cantos",
            ],
            [
                "ibge_codigo"       => 4311304,
                "ibge_estado_id" => 43,
                "nome"     => "Lagoa Vermelha",
            ],
            [
                "ibge_codigo"       => 4311403,
                "ibge_estado_id" => 43,
                "nome"     => "Lajeado",
            ],
            [
                "ibge_codigo"       => 4311429,
                "ibge_estado_id" => 43,
                "nome"     => "Lajeado do Bugre",
            ],
            [
                "ibge_codigo"       => 4311502,
                "ibge_estado_id" => 43,
                "nome"     => "Lavras do Sul",
            ],
            [
                "ibge_codigo"       => 4311601,
                "ibge_estado_id" => 43,
                "nome"     => "Liberato Salzano",
            ],
            [
                "ibge_codigo"       => 4311627,
                "ibge_estado_id" => 43,
                "nome"     => "Lindolfo Collor",
            ],
            [
                "ibge_codigo"       => 4311643,
                "ibge_estado_id" => 43,
                "nome"     => "Linha Nova",
            ],
            [
                "ibge_codigo"       => 4311700,
                "ibge_estado_id" => 43,
                "nome"     => "Machadinho",
            ],
            [
                "ibge_codigo"       => 4311718,
                "ibge_estado_id" => 43,
                "nome"     => "Maçambara",
            ],
            [
                "ibge_codigo"       => 4311734,
                "ibge_estado_id" => 43,
                "nome"     => "Mampituba",
            ],
            [
                "ibge_codigo"       => 4311759,
                "ibge_estado_id" => 43,
                "nome"     => "Manoel Viana",
            ],
            [
                "ibge_codigo"       => 4311775,
                "ibge_estado_id" => 43,
                "nome"     => "Maquiné",
            ],
            [
                "ibge_codigo"       => 4311791,
                "ibge_estado_id" => 43,
                "nome"     => "Maratá",
            ],
            [
                "ibge_codigo"       => 4311809,
                "ibge_estado_id" => 43,
                "nome"     => "Marau",
            ],
            [
                "ibge_codigo"       => 4311908,
                "ibge_estado_id" => 43,
                "nome"     => "Marcelino Ramos",
            ],
            [
                "ibge_codigo"       => 4311981,
                "ibge_estado_id" => 43,
                "nome"     => "Mariana Pimentel",
            ],
            [
                "ibge_codigo"       => 4312005,
                "ibge_estado_id" => 43,
                "nome"     => "Mariano Moro",
            ],
            [
                "ibge_codigo"       => 4312054,
                "ibge_estado_id" => 43,
                "nome"     => "Marques de Souza",
            ],
            [
                "ibge_codigo"       => 4312104,
                "ibge_estado_id" => 43,
                "nome"     => "Mata",
            ],
            [
                "ibge_codigo"       => 4312138,
                "ibge_estado_id" => 43,
                "nome"     => "Mato Castelhano",
            ],
            [
                "ibge_codigo"       => 4312153,
                "ibge_estado_id" => 43,
                "nome"     => "Mato Leitão",
            ],
            [
                "ibge_codigo"       => 4312179,
                "ibge_estado_id" => 43,
                "nome"     => "Mato Queimado",
            ],
            [
                "ibge_codigo"       => 4312203,
                "ibge_estado_id" => 43,
                "nome"     => "Maximiliano de Almeida",
            ],
            [
                "ibge_codigo"       => 4312252,
                "ibge_estado_id" => 43,
                "nome"     => "Minas do Leão",
            ],
            [
                "ibge_codigo"       => 4312302,
                "ibge_estado_id" => 43,
                "nome"     => "Miraguaí",
            ],
            [
                "ibge_codigo"       => 4312351,
                "ibge_estado_id" => 43,
                "nome"     => "Montauri",
            ],
            [
                "ibge_codigo"       => 4312377,
                "ibge_estado_id" => 43,
                "nome"     => "Monte Alegre dos Campos",
            ],
            [
                "ibge_codigo"       => 4312385,
                "ibge_estado_id" => 43,
                "nome"     => "Monte Belo do Sul",
            ],
            [
                "ibge_codigo"       => 4312401,
                "ibge_estado_id" => 43,
                "nome"     => "Montenegro",
            ],
            [
                "ibge_codigo"       => 4312427,
                "ibge_estado_id" => 43,
                "nome"     => "Mormaço",
            ],
            [
                "ibge_codigo"       => 4312443,
                "ibge_estado_id" => 43,
                "nome"     => "Morrinhos do Sul",
            ],
            [
                "ibge_codigo"       => 4312450,
                "ibge_estado_id" => 43,
                "nome"     => "Morro Redondo",
            ],
            [
                "ibge_codigo"       => 4312476,
                "ibge_estado_id" => 43,
                "nome"     => "Morro Reuter",
            ],
            [
                "ibge_codigo"       => 4312500,
                "ibge_estado_id" => 43,
                "nome"     => "Mostardas",
            ],
            [
                "ibge_codigo"       => 4312609,
                "ibge_estado_id" => 43,
                "nome"     => "Muçum",
            ],
            [
                "ibge_codigo"       => 4312617,
                "ibge_estado_id" => 43,
                "nome"     => "Muitos Capões",
            ],
            [
                "ibge_codigo"       => 4312625,
                "ibge_estado_id" => 43,
                "nome"     => "Muliterno",
            ],
            [
                "ibge_codigo"       => 4312658,
                "ibge_estado_id" => 43,
                "nome"     => "Não-Me-Toque",
            ],
            [
                "ibge_codigo"       => 4312674,
                "ibge_estado_id" => 43,
                "nome"     => "Nicolau Vergueiro",
            ],
            [
                "ibge_codigo"       => 4312708,
                "ibge_estado_id" => 43,
                "nome"     => "Nonoai",
            ],
            [
                "ibge_codigo"       => 4312757,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Alvorada",
            ],
            [
                "ibge_codigo"       => 4312807,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Araçá",
            ],
            [
                "ibge_codigo"       => 4312906,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Bassano",
            ],
            [
                "ibge_codigo"       => 4312955,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Boa Vista",
            ],
            [
                "ibge_codigo"       => 4313003,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Bréscia",
            ],
            [
                "ibge_codigo"       => 4313011,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Candelária",
            ],
            [
                "ibge_codigo"       => 4313037,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Esperança do Sul",
            ],
            [
                "ibge_codigo"       => 4313060,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Hartz",
            ],
            [
                "ibge_codigo"       => 4313086,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Pádua",
            ],
            [
                "ibge_codigo"       => 4313102,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Palma",
            ],
            [
                "ibge_codigo"       => 4313201,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Petrópolis",
            ],
            [
                "ibge_codigo"       => 4313300,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Prata",
            ],
            [
                "ibge_codigo"       => 4313334,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Ramada",
            ],
            [
                "ibge_codigo"       => 4313359,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Roma do Sul",
            ],
            [
                "ibge_codigo"       => 4313375,
                "ibge_estado_id" => 43,
                "nome"     => "Nova Santa Rita",
            ],
            [
                "ibge_codigo"       => 4313391,
                "ibge_estado_id" => 43,
                "nome"     => "Novo Cabrais",
            ],
            [
                "ibge_codigo"       => 4313409,
                "ibge_estado_id" => 43,
                "nome"     => "Novo Hamburgo",
            ],
            [
                "ibge_codigo"       => 4313425,
                "ibge_estado_id" => 43,
                "nome"     => "Novo Machado",
            ],
            [
                "ibge_codigo"       => 4313441,
                "ibge_estado_id" => 43,
                "nome"     => "Novo Tiradentes",
            ],
            [
                "ibge_codigo"       => 4313466,
                "ibge_estado_id" => 43,
                "nome"     => "Novo Xingu",
            ],
            [
                "ibge_codigo"       => 4313490,
                "ibge_estado_id" => 43,
                "nome"     => "Novo Barreiro",
            ],
            [
                "ibge_codigo"       => 4313508,
                "ibge_estado_id" => 43,
                "nome"     => "Osório",
            ],
            [
                "ibge_codigo"       => 4313607,
                "ibge_estado_id" => 43,
                "nome"     => "Paim Filho",
            ],
            [
                "ibge_codigo"       => 4313656,
                "ibge_estado_id" => 43,
                "nome"     => "Palmares do Sul",
            ],
            [
                "ibge_codigo"       => 4313706,
                "ibge_estado_id" => 43,
                "nome"     => "Palmeira das Missões",
            ],
            [
                "ibge_codigo"       => 4313805,
                "ibge_estado_id" => 43,
                "nome"     => "Palmitinho",
            ],
            [
                "ibge_codigo"       => 4313904,
                "ibge_estado_id" => 43,
                "nome"     => "Panambi",
            ],
            [
                "ibge_codigo"       => 4313953,
                "ibge_estado_id" => 43,
                "nome"     => "Pantano Grande",
            ],
            [
                "ibge_codigo"       => 4314001,
                "ibge_estado_id" => 43,
                "nome"     => "Paraí",
            ],
            [
                "ibge_codigo"       => 4314027,
                "ibge_estado_id" => 43,
                "nome"     => "Paraíso do Sul",
            ],
            [
                "ibge_codigo"       => 4314035,
                "ibge_estado_id" => 43,
                "nome"     => "Pareci Novo",
            ],
            [
                "ibge_codigo"       => 4314050,
                "ibge_estado_id" => 43,
                "nome"     => "Parobé",
            ],
            [
                "ibge_codigo"       => 4314068,
                "ibge_estado_id" => 43,
                "nome"     => "Passa Sete",
            ],
            [
                "ibge_codigo"       => 4314076,
                "ibge_estado_id" => 43,
                "nome"     => "Passo do Sobrado",
            ],
            [
                "ibge_codigo"       => 4314100,
                "ibge_estado_id" => 43,
                "nome"     => "Passo Fundo",
            ],
            [
                "ibge_codigo"       => 4314134,
                "ibge_estado_id" => 43,
                "nome"     => "Paulo Bento",
            ],
            [
                "ibge_codigo"       => 4314159,
                "ibge_estado_id" => 43,
                "nome"     => "Paverama",
            ],
            [
                "ibge_codigo"       => 4314175,
                "ibge_estado_id" => 43,
                "nome"     => "Pedras Altas",
            ],
            [
                "ibge_codigo"       => 4314209,
                "ibge_estado_id" => 43,
                "nome"     => "Pedro Osório",
            ],
            [
                "ibge_codigo"       => 4314308,
                "ibge_estado_id" => 43,
                "nome"     => "Pejuçara",
            ],
            [
                "ibge_codigo"       => 4314407,
                "ibge_estado_id" => 43,
                "nome"     => "Pelotas",
            ],
            [
                "ibge_codigo"       => 4314423,
                "ibge_estado_id" => 43,
                "nome"     => "Picada Café",
            ],
            [
                "ibge_codigo"       => 4314456,
                "ibge_estado_id" => 43,
                "nome"     => "Pinhal",
            ],
            [
                "ibge_codigo"       => 4314464,
                "ibge_estado_id" => 43,
                "nome"     => "Pinhal da Serra",
            ],
            [
                "ibge_codigo"       => 4314472,
                "ibge_estado_id" => 43,
                "nome"     => "Pinhal Grande",
            ],
            [
                "ibge_codigo"       => 4314498,
                "ibge_estado_id" => 43,
                "nome"     => "Pinheirinho do Vale",
            ],
            [
                "ibge_codigo"       => 4314506,
                "ibge_estado_id" => 43,
                "nome"     => "Pinheiro Machado",
            ],
            [
                "ibge_codigo"       => 4314548,
                "ibge_estado_id" => 43,
                "nome"     => "Pinto Bandeira",
            ],
            [
                "ibge_codigo"       => 4314555,
                "ibge_estado_id" => 43,
                "nome"     => "Pirapó",
            ],
            [
                "ibge_codigo"       => 4314605,
                "ibge_estado_id" => 43,
                "nome"     => "Piratini",
            ],
            [
                "ibge_codigo"       => 4314704,
                "ibge_estado_id" => 43,
                "nome"     => "Planalto",
            ],
            [
                "ibge_codigo"       => 4314753,
                "ibge_estado_id" => 43,
                "nome"     => "Poço das Antas",
            ],
            [
                "ibge_codigo"       => 4314779,
                "ibge_estado_id" => 43,
                "nome"     => "Pontão",
            ],
            [
                "ibge_codigo"       => 4314787,
                "ibge_estado_id" => 43,
                "nome"     => "Ponte Preta",
            ],
            [
                "ibge_codigo"       => 4314803,
                "ibge_estado_id" => 43,
                "nome"     => "Portão",
            ],
            [
                "ibge_codigo"       => 4314902,
                "ibge_estado_id" => 43,
                "nome"     => "Porto Alegre",
            ],
            [
                "ibge_codigo"       => 4315008,
                "ibge_estado_id" => 43,
                "nome"     => "Porto Lucena",
            ],
            [
                "ibge_codigo"       => 4315057,
                "ibge_estado_id" => 43,
                "nome"     => "Porto Mauá",
            ],
            [
                "ibge_codigo"       => 4315073,
                "ibge_estado_id" => 43,
                "nome"     => "Porto Vera Cruz",
            ],
            [
                "ibge_codigo"       => 4315107,
                "ibge_estado_id" => 43,
                "nome"     => "Porto Xavier",
            ],
            [
                "ibge_codigo"       => 4315131,
                "ibge_estado_id" => 43,
                "nome"     => "Pouso Novo",
            ],
            [
                "ibge_codigo"       => 4315149,
                "ibge_estado_id" => 43,
                "nome"     => "Presidente Lucena",
            ],
            [
                "ibge_codigo"       => 4315156,
                "ibge_estado_id" => 43,
                "nome"     => "Progresso",
            ],
            [
                "ibge_codigo"       => 4315172,
                "ibge_estado_id" => 43,
                "nome"     => "Protásio Alves",
            ],
            [
                "ibge_codigo"       => 4315206,
                "ibge_estado_id" => 43,
                "nome"     => "Putinga",
            ],
            [
                "ibge_codigo"       => 4315305,
                "ibge_estado_id" => 43,
                "nome"     => "Quaraí",
            ],
            [
                "ibge_codigo"       => 4315313,
                "ibge_estado_id" => 43,
                "nome"     => "Quatro Irmãos",
            ],
            [
                "ibge_codigo"       => 4315321,
                "ibge_estado_id" => 43,
                "nome"     => "Quevedos",
            ],
            [
                "ibge_codigo"       => 4315354,
                "ibge_estado_id" => 43,
                "nome"     => "Quinze de Novembro",
            ],
            [
                "ibge_codigo"       => 4315404,
                "ibge_estado_id" => 43,
                "nome"     => "Redentora",
            ],
            [
                "ibge_codigo"       => 4315453,
                "ibge_estado_id" => 43,
                "nome"     => "Relvado",
            ],
            [
                "ibge_codigo"       => 4315503,
                "ibge_estado_id" => 43,
                "nome"     => "Restinga Seca",
            ],
            [
                "ibge_codigo"       => 4315552,
                "ibge_estado_id" => 43,
                "nome"     => "Rio dos Índios",
            ],
            [
                "ibge_codigo"       => 4315602,
                "ibge_estado_id" => 43,
                "nome"     => "Rio Grande",
            ],
            [
                "ibge_codigo"       => 4315701,
                "ibge_estado_id" => 43,
                "nome"     => "Rio Pardo",
            ],
            [
                "ibge_codigo"       => 4315750,
                "ibge_estado_id" => 43,
                "nome"     => "Riozinho",
            ],
            [
                "ibge_codigo"       => 4315800,
                "ibge_estado_id" => 43,
                "nome"     => "Roca Sales",
            ],
            [
                "ibge_codigo"       => 4315909,
                "ibge_estado_id" => 43,
                "nome"     => "Rodeio Bonito",
            ],
            [
                "ibge_codigo"       => 4315958,
                "ibge_estado_id" => 43,
                "nome"     => "Rolador",
            ],
            [
                "ibge_codigo"       => 4316006,
                "ibge_estado_id" => 43,
                "nome"     => "Rolante",
            ],
            [
                "ibge_codigo"       => 4316105,
                "ibge_estado_id" => 43,
                "nome"     => "Ronda Alta",
            ],
            [
                "ibge_codigo"       => 4316204,
                "ibge_estado_id" => 43,
                "nome"     => "Rondinha",
            ],
            [
                "ibge_codigo"       => 4316303,
                "ibge_estado_id" => 43,
                "nome"     => "Roque Gonzales",
            ],
            [
                "ibge_codigo"       => 4316402,
                "ibge_estado_id" => 43,
                "nome"     => "Rosário do Sul",
            ],
            [
                "ibge_codigo"       => 4316428,
                "ibge_estado_id" => 43,
                "nome"     => "Sagrada Família",
            ],
            [
                "ibge_codigo"       => 4316436,
                "ibge_estado_id" => 43,
                "nome"     => "Saldanha Marinho",
            ],
            [
                "ibge_codigo"       => 4316451,
                "ibge_estado_id" => 43,
                "nome"     => "Salto do Jacuí",
            ],
            [
                "ibge_codigo"       => 4316477,
                "ibge_estado_id" => 43,
                "nome"     => "Salvador das Missões",
            ],
            [
                "ibge_codigo"       => 4316501,
                "ibge_estado_id" => 43,
                "nome"     => "Salvador do Sul",
            ],
            [
                "ibge_codigo"       => 4316600,
                "ibge_estado_id" => 43,
                "nome"     => "Sananduva",
            ],
            [
                "ibge_codigo"       => 4316709,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Bárbara do Sul",
            ],
            [
                "ibge_codigo"       => 4316733,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Cecília do Sul",
            ],
            [
                "ibge_codigo"       => 4316758,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Clara do Sul",
            ],
            [
                "ibge_codigo"       => 4316808,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Cruz do Sul",
            ],
            [
                "ibge_codigo"       => 4316907,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Maria",
            ],
            [
                "ibge_codigo"       => 4316956,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Maria do Herval",
            ],
            [
                "ibge_codigo"       => 4316972,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Margarida do Sul",
            ],
            [
                "ibge_codigo"       => 4317004,
                "ibge_estado_id" => 43,
                "nome"     => "Santana da Boa Vista",
            ],
            [
                "ibge_codigo"       => 4317103,
                "ibge_estado_id" => 43,
                "nome"     => "Santana do Livramento",
            ],
            [
                "ibge_codigo"       => 4317202,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Rosa",
            ],
            [
                "ibge_codigo"       => 4317251,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Tereza",
            ],
            [
                "ibge_codigo"       => 4317301,
                "ibge_estado_id" => 43,
                "nome"     => "Santa Vitória do Palmar",
            ],
            [
                "ibge_codigo"       => 4317400,
                "ibge_estado_id" => 43,
                "nome"     => "Santiago",
            ],
            [
                "ibge_codigo"       => 4317509,
                "ibge_estado_id" => 43,
                "nome"     => "Santo Ângelo",
            ],
            [
                "ibge_codigo"       => 4317558,
                "ibge_estado_id" => 43,
                "nome"     => "Santo Antônio do Palma",
            ],
            [
                "ibge_codigo"       => 4317608,
                "ibge_estado_id" => 43,
                "nome"     => "Santo Antônio da Patrulha",
            ],
            [
                "ibge_codigo"       => 4317707,
                "ibge_estado_id" => 43,
                "nome"     => "Santo Antônio das Missões",
            ],
            [
                "ibge_codigo"       => 4317756,
                "ibge_estado_id" => 43,
                "nome"     => "Santo Antônio do Planalto",
            ],
            [
                "ibge_codigo"       => 4317806,
                "ibge_estado_id" => 43,
                "nome"     => "Santo Augusto",
            ],
            [
                "ibge_codigo"       => 4317905,
                "ibge_estado_id" => 43,
                "nome"     => "Santo Cristo",
            ],
            [
                "ibge_codigo"       => 4317954,
                "ibge_estado_id" => 43,
                "nome"     => "Santo Expedito do Sul",
            ],
            [
                "ibge_codigo"       => 4318002,
                "ibge_estado_id" => 43,
                "nome"     => "São Borja",
            ],
            [
                "ibge_codigo"       => 4318051,
                "ibge_estado_id" => 43,
                "nome"     => "São Domingos do Sul",
            ],
            [
                "ibge_codigo"       => 4318101,
                "ibge_estado_id" => 43,
                "nome"     => "São Francisco de Assis",
            ],
            [
                "ibge_codigo"       => 4318200,
                "ibge_estado_id" => 43,
                "nome"     => "São Francisco de Paula",
            ],
            [
                "ibge_codigo"       => 4318309,
                "ibge_estado_id" => 43,
                "nome"     => "São Gabriel",
            ],
            [
                "ibge_codigo"       => 4318408,
                "ibge_estado_id" => 43,
                "nome"     => "São Jerônimo",
            ],
            [
                "ibge_codigo"       => 4318424,
                "ibge_estado_id" => 43,
                "nome"     => "São João da Urtiga",
            ],
            [
                "ibge_codigo"       => 4318432,
                "ibge_estado_id" => 43,
                "nome"     => "São João do Polêsine",
            ],
            [
                "ibge_codigo"       => 4318440,
                "ibge_estado_id" => 43,
                "nome"     => "São Jorge",
            ],
            [
                "ibge_codigo"       => 4318457,
                "ibge_estado_id" => 43,
                "nome"     => "São José das Missões",
            ],
            [
                "ibge_codigo"       => 4318465,
                "ibge_estado_id" => 43,
                "nome"     => "São José do Herval",
            ],
            [
                "ibge_codigo"       => 4318481,
                "ibge_estado_id" => 43,
                "nome"     => "São José do Hortêncio",
            ],
            [
                "ibge_codigo"       => 4318499,
                "ibge_estado_id" => 43,
                "nome"     => "São José do Inhacorá",
            ],
            [
                "ibge_codigo"       => 4318507,
                "ibge_estado_id" => 43,
                "nome"     => "São José do Norte",
            ],
            [
                "ibge_codigo"       => 4318606,
                "ibge_estado_id" => 43,
                "nome"     => "São José do Ouro",
            ],
            [
                "ibge_codigo"       => 4318614,
                "ibge_estado_id" => 43,
                "nome"     => "São José do Sul",
            ],
            [
                "ibge_codigo"       => 4318622,
                "ibge_estado_id" => 43,
                "nome"     => "São José dos Ausentes",
            ],
            [
                "ibge_codigo"       => 4318705,
                "ibge_estado_id" => 43,
                "nome"     => "São Leopoldo",
            ],
            [
                "ibge_codigo"       => 4318804,
                "ibge_estado_id" => 43,
                "nome"     => "São Lourenço do Sul",
            ],
            [
                "ibge_codigo"       => 4318903,
                "ibge_estado_id" => 43,
                "nome"     => "São Luiz Gonzaga",
            ],
            [
                "ibge_codigo"       => 4319000,
                "ibge_estado_id" => 43,
                "nome"     => "São Marcos",
            ],
            [
                "ibge_codigo"       => 4319109,
                "ibge_estado_id" => 43,
                "nome"     => "São Martinho",
            ],
            [
                "ibge_codigo"       => 4319125,
                "ibge_estado_id" => 43,
                "nome"     => "São Martinho da Serra",
            ],
            [
                "ibge_codigo"       => 4319158,
                "ibge_estado_id" => 43,
                "nome"     => "São Miguel das Missões",
            ],
            [
                "ibge_codigo"       => 4319208,
                "ibge_estado_id" => 43,
                "nome"     => "São Nicolau",
            ],
            [
                "ibge_codigo"       => 4319307,
                "ibge_estado_id" => 43,
                "nome"     => "São Paulo das Missões",
            ],
            [
                "ibge_codigo"       => 4319356,
                "ibge_estado_id" => 43,
                "nome"     => "São Pedro da Serra",
            ],
            [
                "ibge_codigo"       => 4319364,
                "ibge_estado_id" => 43,
                "nome"     => "São Pedro das Missões",
            ],
            [
                "ibge_codigo"       => 4319372,
                "ibge_estado_id" => 43,
                "nome"     => "São Pedro do Butiá",
            ],
            [
                "ibge_codigo"       => 4319406,
                "ibge_estado_id" => 43,
                "nome"     => "São Pedro do Sul",
            ],
            [
                "ibge_codigo"       => 4319505,
                "ibge_estado_id" => 43,
                "nome"     => "São Sebastião do Caí",
            ],
            [
                "ibge_codigo"       => 4319604,
                "ibge_estado_id" => 43,
                "nome"     => "São Sepé",
            ],
            [
                "ibge_codigo"       => 4319703,
                "ibge_estado_id" => 43,
                "nome"     => "São Valentim",
            ],
            [
                "ibge_codigo"       => 4319711,
                "ibge_estado_id" => 43,
                "nome"     => "São Valentim do Sul",
            ],
            [
                "ibge_codigo"       => 4319737,
                "ibge_estado_id" => 43,
                "nome"     => "São Valério do Sul",
            ],
            [
                "ibge_codigo"       => 4319752,
                "ibge_estado_id" => 43,
                "nome"     => "São Vendelino",
            ],
            [
                "ibge_codigo"       => 4319802,
                "ibge_estado_id" => 43,
                "nome"     => "São Vicente do Sul",
            ],
            [
                "ibge_codigo"       => 4319901,
                "ibge_estado_id" => 43,
                "nome"     => "Sapiranga",
            ],
            [
                "ibge_codigo"       => 4320008,
                "ibge_estado_id" => 43,
                "nome"     => "Sapucaia do Sul",
            ],
            [
                "ibge_codigo"       => 4320107,
                "ibge_estado_id" => 43,
                "nome"     => "Sarandi",
            ],
            [
                "ibge_codigo"       => 4320206,
                "ibge_estado_id" => 43,
                "nome"     => "Seberi",
            ],
            [
                "ibge_codigo"       => 4320230,
                "ibge_estado_id" => 43,
                "nome"     => "Sede Nova",
            ],
            [
                "ibge_codigo"       => 4320263,
                "ibge_estado_id" => 43,
                "nome"     => "Segredo",
            ],
            [
                "ibge_codigo"       => 4320305,
                "ibge_estado_id" => 43,
                "nome"     => "Selbach",
            ],
            [
                "ibge_codigo"       => 4320321,
                "ibge_estado_id" => 43,
                "nome"     => "Senador Salgado Filho",
            ],
            [
                "ibge_codigo"       => 4320354,
                "ibge_estado_id" => 43,
                "nome"     => "Sentinela do Sul",
            ],
            [
                "ibge_codigo"       => 4320404,
                "ibge_estado_id" => 43,
                "nome"     => "Serafina Corrêa",
            ],
            [
                "ibge_codigo"       => 4320453,
                "ibge_estado_id" => 43,
                "nome"     => "Sério",
            ],
            [
                "ibge_codigo"       => 4320503,
                "ibge_estado_id" => 43,
                "nome"     => "Sertão",
            ],
            [
                "ibge_codigo"       => 4320552,
                "ibge_estado_id" => 43,
                "nome"     => "Sertão Santana",
            ],
            [
                "ibge_codigo"       => 4320578,
                "ibge_estado_id" => 43,
                "nome"     => "Sete de Setembro",
            ],
            [
                "ibge_codigo"       => 4320602,
                "ibge_estado_id" => 43,
                "nome"     => "Severiano de Almeida",
            ],
            [
                "ibge_codigo"       => 4320651,
                "ibge_estado_id" => 43,
                "nome"     => "Silveira Martins",
            ],
            [
                "ibge_codigo"       => 4320677,
                "ibge_estado_id" => 43,
                "nome"     => "Sinimbu",
            ],
            [
                "ibge_codigo"       => 4320701,
                "ibge_estado_id" => 43,
                "nome"     => "Sobradinho",
            ],
            [
                "ibge_codigo"       => 4320800,
                "ibge_estado_id" => 43,
                "nome"     => "Soledade",
            ],
            [
                "ibge_codigo"       => 4320859,
                "ibge_estado_id" => 43,
                "nome"     => "Tabaí",
            ],
            [
                "ibge_codigo"       => 4320909,
                "ibge_estado_id" => 43,
                "nome"     => "Tapejara",
            ],
            [
                "ibge_codigo"       => 4321006,
                "ibge_estado_id" => 43,
                "nome"     => "Tapera",
            ],
            [
                "ibge_codigo"       => 4321105,
                "ibge_estado_id" => 43,
                "nome"     => "Tapes",
            ],
            [
                "ibge_codigo"       => 4321204,
                "ibge_estado_id" => 43,
                "nome"     => "Taquara",
            ],
            [
                "ibge_codigo"       => 4321303,
                "ibge_estado_id" => 43,
                "nome"     => "Taquari",
            ],
            [
                "ibge_codigo"       => 4321329,
                "ibge_estado_id" => 43,
                "nome"     => "Taquaruçu do Sul",
            ],
            [
                "ibge_codigo"       => 4321352,
                "ibge_estado_id" => 43,
                "nome"     => "Tavares",
            ],
            [
                "ibge_codigo"       => 4321402,
                "ibge_estado_id" => 43,
                "nome"     => "Tenente Portela",
            ],
            [
                "ibge_codigo"       => 4321436,
                "ibge_estado_id" => 43,
                "nome"     => "Terra de Areia",
            ],
            [
                "ibge_codigo"       => 4321451,
                "ibge_estado_id" => 43,
                "nome"     => "Teutônia",
            ],
            [
                "ibge_codigo"       => 4321469,
                "ibge_estado_id" => 43,
                "nome"     => "Tio Hugo",
            ],
            [
                "ibge_codigo"       => 4321477,
                "ibge_estado_id" => 43,
                "nome"     => "Tiradentes do Sul",
            ],
            [
                "ibge_codigo"       => 4321493,
                "ibge_estado_id" => 43,
                "nome"     => "Toropi",
            ],
            [
                "ibge_codigo"       => 4321501,
                "ibge_estado_id" => 43,
                "nome"     => "Torres",
            ],
            [
                "ibge_codigo"       => 4321600,
                "ibge_estado_id" => 43,
                "nome"     => "Tramandaí",
            ],
            [
                "ibge_codigo"       => 4321626,
                "ibge_estado_id" => 43,
                "nome"     => "Travesseiro",
            ],
            [
                "ibge_codigo"       => 4321634,
                "ibge_estado_id" => 43,
                "nome"     => "Três Arroios",
            ],
            [
                "ibge_codigo"       => 4321667,
                "ibge_estado_id" => 43,
                "nome"     => "Três Cachoeiras",
            ],
            [
                "ibge_codigo"       => 4321709,
                "ibge_estado_id" => 43,
                "nome"     => "Três Coroas",
            ],
            [
                "ibge_codigo"       => 4321808,
                "ibge_estado_id" => 43,
                "nome"     => "Três de Maio",
            ],
            [
                "ibge_codigo"       => 4321832,
                "ibge_estado_id" => 43,
                "nome"     => "Três Forquilhas",
            ],
            [
                "ibge_codigo"       => 4321857,
                "ibge_estado_id" => 43,
                "nome"     => "Três Palmeiras",
            ],
            [
                "ibge_codigo"       => 4321907,
                "ibge_estado_id" => 43,
                "nome"     => "Três Passos",
            ],
            [
                "ibge_codigo"       => 4321956,
                "ibge_estado_id" => 43,
                "nome"     => "Trindade do Sul",
            ],
            [
                "ibge_codigo"       => 4322004,
                "ibge_estado_id" => 43,
                "nome"     => "Triunfo",
            ],
            [
                "ibge_codigo"       => 4322103,
                "ibge_estado_id" => 43,
                "nome"     => "Tucunduva",
            ],
            [
                "ibge_codigo"       => 4322152,
                "ibge_estado_id" => 43,
                "nome"     => "Tunas",
            ],
            [
                "ibge_codigo"       => 4322186,
                "ibge_estado_id" => 43,
                "nome"     => "Tupanci do Sul",
            ],
            [
                "ibge_codigo"       => 4322202,
                "ibge_estado_id" => 43,
                "nome"     => "Tupanciretã",
            ],
            [
                "ibge_codigo"       => 4322251,
                "ibge_estado_id" => 43,
                "nome"     => "Tupandi",
            ],
            [
                "ibge_codigo"       => 4322301,
                "ibge_estado_id" => 43,
                "nome"     => "Tuparendi",
            ],
            [
                "ibge_codigo"       => 4322327,
                "ibge_estado_id" => 43,
                "nome"     => "Turuçu",
            ],
            [
                "ibge_codigo"       => 4322343,
                "ibge_estado_id" => 43,
                "nome"     => "Ubiretama",
            ],
            [
                "ibge_codigo"       => 4322350,
                "ibge_estado_id" => 43,
                "nome"     => "União da Serra",
            ],
            [
                "ibge_codigo"       => 4322376,
                "ibge_estado_id" => 43,
                "nome"     => "Unistalda",
            ],
            [
                "ibge_codigo"       => 4322400,
                "ibge_estado_id" => 43,
                "nome"     => "Uruguaiana",
            ],
            [
                "ibge_codigo"       => 4322509,
                "ibge_estado_id" => 43,
                "nome"     => "Vacaria",
            ],
            [
                "ibge_codigo"       => 4322525,
                "ibge_estado_id" => 43,
                "nome"     => "Vale Verde",
            ],
            [
                "ibge_codigo"       => 4322533,
                "ibge_estado_id" => 43,
                "nome"     => "Vale do Sol",
            ],
            [
                "ibge_codigo"       => 4322541,
                "ibge_estado_id" => 43,
                "nome"     => "Vale Real",
            ],
            [
                "ibge_codigo"       => 4322558,
                "ibge_estado_id" => 43,
                "nome"     => "Vanini",
            ],
            [
                "ibge_codigo"       => 4322608,
                "ibge_estado_id" => 43,
                "nome"     => "Venâncio Aires",
            ],
            [
                "ibge_codigo"       => 4322707,
                "ibge_estado_id" => 43,
                "nome"     => "Vera Cruz",
            ],
            [
                "ibge_codigo"       => 4322806,
                "ibge_estado_id" => 43,
                "nome"     => "Veranópolis",
            ],
            [
                "ibge_codigo"       => 4322855,
                "ibge_estado_id" => 43,
                "nome"     => "Vespasiano Correa",
            ],
            [
                "ibge_codigo"       => 4322905,
                "ibge_estado_id" => 43,
                "nome"     => "Viadutos",
            ],
            [
                "ibge_codigo"       => 4323002,
                "ibge_estado_id" => 43,
                "nome"     => "Viamão",
            ],
            [
                "ibge_codigo"       => 4323101,
                "ibge_estado_id" => 43,
                "nome"     => "Vicente Dutra",
            ],
            [
                "ibge_codigo"       => 4323200,
                "ibge_estado_id" => 43,
                "nome"     => "Victor Graeff",
            ],
            [
                "ibge_codigo"       => 4323309,
                "ibge_estado_id" => 43,
                "nome"     => "Vila Flores",
            ],
            [
                "ibge_codigo"       => 4323358,
                "ibge_estado_id" => 43,
                "nome"     => "Vila Lângaro",
            ],
            [
                "ibge_codigo"       => 4323408,
                "ibge_estado_id" => 43,
                "nome"     => "Vila Maria",
            ],
            [
                "ibge_codigo"       => 4323457,
                "ibge_estado_id" => 43,
                "nome"     => "Vila Nova do Sul",
            ],
            [
                "ibge_codigo"       => 4323507,
                "ibge_estado_id" => 43,
                "nome"     => "Vista Alegre",
            ],
            [
                "ibge_codigo"       => 4323606,
                "ibge_estado_id" => 43,
                "nome"     => "Vista Alegre do Prata",
            ],
            [
                "ibge_codigo"       => 4323705,
                "ibge_estado_id" => 43,
                "nome"     => "Vista Gaúcha",
            ],
            [
                "ibge_codigo"       => 4323754,
                "ibge_estado_id" => 43,
                "nome"     => "Vitória das Missões",
            ],
            [
                "ibge_codigo"       => 4323770,
                "ibge_estado_id" => 43,
                "nome"     => "Westfália",
            ],
            [
                "ibge_codigo"       => 4323804,
                "ibge_estado_id" => 43,
                "nome"     => "Xangri-lá",
            ],
            [
                "ibge_codigo"       => 5000203,
                "ibge_estado_id" => 50,
                "nome"     => "Água Clara",
            ],
            [
                "ibge_codigo"       => 5000252,
                "ibge_estado_id" => 50,
                "nome"     => "Alcinópolis",
            ],
            [
                "ibge_codigo"       => 5000609,
                "ibge_estado_id" => 50,
                "nome"     => "Amambai",
            ],
            [
                "ibge_codigo"       => 5000708,
                "ibge_estado_id" => 50,
                "nome"     => "Anastácio",
            ],
            [
                "ibge_codigo"       => 5000807,
                "ibge_estado_id" => 50,
                "nome"     => "Anaurilândia",
            ],
            [
                "ibge_codigo"       => 5000856,
                "ibge_estado_id" => 50,
                "nome"     => "Angélica",
            ],
            [
                "ibge_codigo"       => 5000906,
                "ibge_estado_id" => 50,
                "nome"     => "Antônio João",
            ],
            [
                "ibge_codigo"       => 5001003,
                "ibge_estado_id" => 50,
                "nome"     => "Aparecida do Taboado",
            ],
            [
                "ibge_codigo"       => 5001102,
                "ibge_estado_id" => 50,
                "nome"     => "Aquidauana",
            ],
            [
                "ibge_codigo"       => 5001243,
                "ibge_estado_id" => 50,
                "nome"     => "Aral Moreira",
            ],
            [
                "ibge_codigo"       => 5001508,
                "ibge_estado_id" => 50,
                "nome"     => "Bandeirantes",
            ],
            [
                "ibge_codigo"       => 5001904,
                "ibge_estado_id" => 50,
                "nome"     => "Bataguassu",
            ],
            [
                "ibge_codigo"       => 5002001,
                "ibge_estado_id" => 50,
                "nome"     => "Batayporã",
            ],
            [
                "ibge_codigo"       => 5002100,
                "ibge_estado_id" => 50,
                "nome"     => "Bela Vista",
            ],
            [
                "ibge_codigo"       => 5002159,
                "ibge_estado_id" => 50,
                "nome"     => "Bodoquena",
            ],
            [
                "ibge_codigo"       => 5002209,
                "ibge_estado_id" => 50,
                "nome"     => "Bonito",
            ],
            [
                "ibge_codigo"       => 5002308,
                "ibge_estado_id" => 50,
                "nome"     => "Brasilândia",
            ],
            [
                "ibge_codigo"       => 5002407,
                "ibge_estado_id" => 50,
                "nome"     => "Caarapó",
            ],
            [
                "ibge_codigo"       => 5002605,
                "ibge_estado_id" => 50,
                "nome"     => "Camapuã",
            ],
            [
                "ibge_codigo"       => 5002704,
                "ibge_estado_id" => 50,
                "nome"     => "Campo Grande",
            ],
            [
                "ibge_codigo"       => 5002803,
                "ibge_estado_id" => 50,
                "nome"     => "Caracol",
            ],
            [
                "ibge_codigo"       => 5002902,
                "ibge_estado_id" => 50,
                "nome"     => "Cassilândia",
            ],
            [
                "ibge_codigo"       => 5002951,
                "ibge_estado_id" => 50,
                "nome"     => "Chapadão do Sul",
            ],
            [
                "ibge_codigo"       => 5003108,
                "ibge_estado_id" => 50,
                "nome"     => "Corguinho",
            ],
            [
                "ibge_codigo"       => 5003157,
                "ibge_estado_id" => 50,
                "nome"     => "Coronel Sapucaia",
            ],
            [
                "ibge_codigo"       => 5003207,
                "ibge_estado_id" => 50,
                "nome"     => "Corumbá",
            ],
            [
                "ibge_codigo"       => 5003256,
                "ibge_estado_id" => 50,
                "nome"     => "Costa Rica",
            ],
            [
                "ibge_codigo"       => 5003306,
                "ibge_estado_id" => 50,
                "nome"     => "Coxim",
            ],
            [
                "ibge_codigo"       => 5003454,
                "ibge_estado_id" => 50,
                "nome"     => "Deodápolis",
            ],
            [
                "ibge_codigo"       => 5003488,
                "ibge_estado_id" => 50,
                "nome"     => "Dois Irmãos do Buriti",
            ],
            [
                "ibge_codigo"       => 5003504,
                "ibge_estado_id" => 50,
                "nome"     => "Douradina",
            ],
            [
                "ibge_codigo"       => 5003702,
                "ibge_estado_id" => 50,
                "nome"     => "Dourados",
            ],
            [
                "ibge_codigo"       => 5003751,
                "ibge_estado_id" => 50,
                "nome"     => "Eldorado",
            ],
            [
                "ibge_codigo"       => 5003801,
                "ibge_estado_id" => 50,
                "nome"     => "Fátima do Sul",
            ],
            [
                "ibge_codigo"       => 5003900,
                "ibge_estado_id" => 50,
                "nome"     => "Figueirão",
            ],
            [
                "ibge_codigo"       => 5004007,
                "ibge_estado_id" => 50,
                "nome"     => "Glória de Dourados",
            ],
            [
                "ibge_codigo"       => 5004106,
                "ibge_estado_id" => 50,
                "nome"     => "Guia Lopes da Laguna",
            ],
            [
                "ibge_codigo"       => 5004304,
                "ibge_estado_id" => 50,
                "nome"     => "Iguatemi",
            ],
            [
                "ibge_codigo"       => 5004403,
                "ibge_estado_id" => 50,
                "nome"     => "Inocência",
            ],
            [
                "ibge_codigo"       => 5004502,
                "ibge_estado_id" => 50,
                "nome"     => "Itaporã",
            ],
            [
                "ibge_codigo"       => 5004601,
                "ibge_estado_id" => 50,
                "nome"     => "Itaquiraí",
            ],
            [
                "ibge_codigo"       => 5004700,
                "ibge_estado_id" => 50,
                "nome"     => "Ivinhema",
            ],
            [
                "ibge_codigo"       => 5004809,
                "ibge_estado_id" => 50,
                "nome"     => "Japorã",
            ],
            [
                "ibge_codigo"       => 5004908,
                "ibge_estado_id" => 50,
                "nome"     => "Jaraguari",
            ],
            [
                "ibge_codigo"       => 5005004,
                "ibge_estado_id" => 50,
                "nome"     => "Jardim",
            ],
            [
                "ibge_codigo"       => 5005103,
                "ibge_estado_id" => 50,
                "nome"     => "Jateí",
            ],
            [
                "ibge_codigo"       => 5005152,
                "ibge_estado_id" => 50,
                "nome"     => "Juti",
            ],
            [
                "ibge_codigo"       => 5005202,
                "ibge_estado_id" => 50,
                "nome"     => "Ladário",
            ],
            [
                "ibge_codigo"       => 5005251,
                "ibge_estado_id" => 50,
                "nome"     => "Laguna Carapã",
            ],
            [
                "ibge_codigo"       => 5005400,
                "ibge_estado_id" => 50,
                "nome"     => "Maracaju",
            ],
            [
                "ibge_codigo"       => 5005608,
                "ibge_estado_id" => 50,
                "nome"     => "Miranda",
            ],
            [
                "ibge_codigo"       => 5005681,
                "ibge_estado_id" => 50,
                "nome"     => "Mundo Novo",
            ],
            [
                "ibge_codigo"       => 5005707,
                "ibge_estado_id" => 50,
                "nome"     => "Naviraí",
            ],
            [
                "ibge_codigo"       => 5005806,
                "ibge_estado_id" => 50,
                "nome"     => "Nioaque",
            ],
            [
                "ibge_codigo"       => 5006002,
                "ibge_estado_id" => 50,
                "nome"     => "Nova Alvorada do Sul",
            ],
            [
                "ibge_codigo"       => 5006200,
                "ibge_estado_id" => 50,
                "nome"     => "Nova Andradina",
            ],
            [
                "ibge_codigo"       => 5006259,
                "ibge_estado_id" => 50,
                "nome"     => "Novo Horizonte do Sul",
            ],
            [
                "ibge_codigo"       => 5006275,
                "ibge_estado_id" => 50,
                "nome"     => "Paraíso das Águas",
            ],
            [
                "ibge_codigo"       => 5006309,
                "ibge_estado_id" => 50,
                "nome"     => "Paranaíba",
            ],
            [
                "ibge_codigo"       => 5006358,
                "ibge_estado_id" => 50,
                "nome"     => "Paranhos",
            ],
            [
                "ibge_codigo"       => 5006408,
                "ibge_estado_id" => 50,
                "nome"     => "Pedro Gomes",
            ],
            [
                "ibge_codigo"       => 5006606,
                "ibge_estado_id" => 50,
                "nome"     => "Ponta Porã",
            ],
            [
                "ibge_codigo"       => 5006903,
                "ibge_estado_id" => 50,
                "nome"     => "Porto Murtinho",
            ],
            [
                "ibge_codigo"       => 5007109,
                "ibge_estado_id" => 50,
                "nome"     => "Ribas do Rio Pardo",
            ],
            [
                "ibge_codigo"       => 5007208,
                "ibge_estado_id" => 50,
                "nome"     => "Rio Brilhante",
            ],
            [
                "ibge_codigo"       => 5007307,
                "ibge_estado_id" => 50,
                "nome"     => "Rio Negro",
            ],
            [
                "ibge_codigo"       => 5007406,
                "ibge_estado_id" => 50,
                "nome"     => "Rio Verde de Mato Grosso",
            ],
            [
                "ibge_codigo"       => 5007505,
                "ibge_estado_id" => 50,
                "nome"     => "Rochedo",
            ],
            [
                "ibge_codigo"       => 5007554,
                "ibge_estado_id" => 50,
                "nome"     => "Santa Rita do Pardo",
            ],
            [
                "ibge_codigo"       => 5007695,
                "ibge_estado_id" => 50,
                "nome"     => "São Gabriel do Oeste",
            ],
            [
                "ibge_codigo"       => 5007703,
                "ibge_estado_id" => 50,
                "nome"     => "Sete Quedas",
            ],
            [
                "ibge_codigo"       => 5007802,
                "ibge_estado_id" => 50,
                "nome"     => "Selvíria",
            ],
            [
                "ibge_codigo"       => 5007901,
                "ibge_estado_id" => 50,
                "nome"     => "Sidrolândia",
            ],
            [
                "ibge_codigo"       => 5007935,
                "ibge_estado_id" => 50,
                "nome"     => "Sonora",
            ],
            [
                "ibge_codigo"       => 5007950,
                "ibge_estado_id" => 50,
                "nome"     => "Tacuru",
            ],
            [
                "ibge_codigo"       => 5007976,
                "ibge_estado_id" => 50,
                "nome"     => "Taquarussu",
            ],
            [
                "ibge_codigo"       => 5008008,
                "ibge_estado_id" => 50,
                "nome"     => "Terenos",
            ],
            [
                "ibge_codigo"       => 5008305,
                "ibge_estado_id" => 50,
                "nome"     => "Três Lagoas",
            ],
            [
                "ibge_codigo"       => 5008404,
                "ibge_estado_id" => 50,
                "nome"     => "Vicentina",
            ],
            [
                "ibge_codigo"       => 5100102,
                "ibge_estado_id" => 51,
                "nome"     => "Acorizal",
            ],
            [
                "ibge_codigo"       => 5100201,
                "ibge_estado_id" => 51,
                "nome"     => "Água Boa",
            ],
            [
                "ibge_codigo"       => 5100250,
                "ibge_estado_id" => 51,
                "nome"     => "Alta Floresta",
            ],
            [
                "ibge_codigo"       => 5100300,
                "ibge_estado_id" => 51,
                "nome"     => "Alto Araguaia",
            ],
            [
                "ibge_codigo"       => 5100359,
                "ibge_estado_id" => 51,
                "nome"     => "Alto Boa Vista",
            ],
            [
                "ibge_codigo"       => 5100409,
                "ibge_estado_id" => 51,
                "nome"     => "Alto Garças",
            ],
            [
                "ibge_codigo"       => 5100508,
                "ibge_estado_id" => 51,
                "nome"     => "Alto Paraguai",
            ],
            [
                "ibge_codigo"       => 5100607,
                "ibge_estado_id" => 51,
                "nome"     => "Alto Taquari",
            ],
            [
                "ibge_codigo"       => 5100805,
                "ibge_estado_id" => 51,
                "nome"     => "Apiacás",
            ],
            [
                "ibge_codigo"       => 5101001,
                "ibge_estado_id" => 51,
                "nome"     => "Araguaiana",
            ],
            [
                "ibge_codigo"       => 5101209,
                "ibge_estado_id" => 51,
                "nome"     => "Araguainha",
            ],
            [
                "ibge_codigo"       => 5101258,
                "ibge_estado_id" => 51,
                "nome"     => "Araputanga",
            ],
            [
                "ibge_codigo"       => 5101308,
                "ibge_estado_id" => 51,
                "nome"     => "Arenápolis",
            ],
            [
                "ibge_codigo"       => 5101407,
                "ibge_estado_id" => 51,
                "nome"     => "Aripuanã",
            ],
            [
                "ibge_codigo"       => 5101605,
                "ibge_estado_id" => 51,
                "nome"     => "Barão de Melgaço",
            ],
            [
                "ibge_codigo"       => 5101704,
                "ibge_estado_id" => 51,
                "nome"     => "Barra do Bugres",
            ],
            [
                "ibge_codigo"       => 5101803,
                "ibge_estado_id" => 51,
                "nome"     => "Barra do Garças",
            ],

            [
                "ibge_codigo"       => 0,
                "ibge_estado_id" => 51,
                "nome"     => "Boa esperança do Norte",
            ],

            [
                "ibge_codigo"       => 5101852,
                "ibge_estado_id" => 51,
                "nome"     => "Bom Jesus do Araguaia",
            ],
            [
                "ibge_codigo"       => 5101902,
                "ibge_estado_id" => 51,
                "nome"     => "Brasnorte",
            ],
            [
                "ibge_codigo"       => 5102504,
                "ibge_estado_id" => 51,
                "nome"     => "Cáceres",
            ],
            [
                "ibge_codigo"       => 5102603,
                "ibge_estado_id" => 51,
                "nome"     => "Campinápolis",
            ],
            [
                "ibge_codigo"       => 5102637,
                "ibge_estado_id" => 51,
                "nome"     => "Campo Novo do Parecis",
            ],
            [
                "ibge_codigo"       => 5102678,
                "ibge_estado_id" => 51,
                "nome"     => "Campo Verde",
            ],
            [
                "ibge_codigo"       => 5102686,
                "ibge_estado_id" => 51,
                "nome"     => "Campos de Júlio",
            ],
            [
                "ibge_codigo"       => 5102694,
                "ibge_estado_id" => 51,
                "nome"     => "Canabrava do Norte",
            ],
            [
                "ibge_codigo"       => 5102702,
                "ibge_estado_id" => 51,
                "nome"     => "Canarana",
            ],
            [
                "ibge_codigo"       => 5102793,
                "ibge_estado_id" => 51,
                "nome"     => "Carlinda",
            ],
            [
                "ibge_codigo"       => 5102850,
                "ibge_estado_id" => 51,
                "nome"     => "Castanheira",
            ],
            [
                "ibge_codigo"       => 5103007,
                "ibge_estado_id" => 51,
                "nome"     => "Chapada dos Guimarães",
            ],
            [
                "ibge_codigo"       => 5103056,
                "ibge_estado_id" => 51,
                "nome"     => "Cláudia",
            ],
            [
                "ibge_codigo"       => 5103106,
                "ibge_estado_id" => 51,
                "nome"     => "Cocalinho",
            ],
            [
                "ibge_codigo"       => 5103205,
                "ibge_estado_id" => 51,
                "nome"     => "Colíder",
            ],
            [
                "ibge_codigo"       => 5103254,
                "ibge_estado_id" => 51,
                "nome"     => "Colniza",
            ],
            [
                "ibge_codigo"       => 5103304,
                "ibge_estado_id" => 51,
                "nome"     => "Comodoro",
            ],
            [
                "ibge_codigo"       => 5103353,
                "ibge_estado_id" => 51,
                "nome"     => "Confresa",
            ],
            [
                "ibge_codigo"       => 5103361,
                "ibge_estado_id" => 51,
                "nome"     => "Conquista d'Oeste",
            ],
            [
                "ibge_codigo"       => 5103379,
                "ibge_estado_id" => 51,
                "nome"     => "Cotriguaçu",
            ],
            [
                "ibge_codigo"       => 5103403,
                "ibge_estado_id" => 51,
                "nome"     => "Cuiabá",
            ],
            [
                "ibge_codigo"       => 5103437,
                "ibge_estado_id" => 51,
                "nome"     => "Curvelândia",
            ],
            [
                "ibge_codigo"       => 5103452,
                "ibge_estado_id" => 51,
                "nome"     => "Denise",
            ],
            [
                "ibge_codigo"       => 5103502,
                "ibge_estado_id" => 51,
                "nome"     => "Diamantino",
            ],
            [
                "ibge_codigo"       => 5103601,
                "ibge_estado_id" => 51,
                "nome"     => "Dom Aquino",
            ],
            [
                "ibge_codigo"       => 5103700,
                "ibge_estado_id" => 51,
                "nome"     => "Feliz Natal",
            ],
            [
                "ibge_codigo"       => 5103809,
                "ibge_estado_id" => 51,
                "nome"     => "Figueirópolis d'Oeste",
            ],
            [
                "ibge_codigo"       => 5103858,
                "ibge_estado_id" => 51,
                "nome"     => "Gaúcha do Norte",
            ],
            [
                "ibge_codigo"       => 5103908,
                "ibge_estado_id" => 51,
                "nome"     => "General Carneiro",
            ],
            [
                "ibge_codigo"       => 5103957,
                "ibge_estado_id" => 51,
                "nome"     => "Glória d'Oeste",
            ],
            [
                "ibge_codigo"       => 5104104,
                "ibge_estado_id" => 51,
                "nome"     => "Guarantã do Norte",
            ],
            [
                "ibge_codigo"       => 5104203,
                "ibge_estado_id" => 51,
                "nome"     => "Guiratinga",
            ],
            [
                "ibge_codigo"       => 5104500,
                "ibge_estado_id" => 51,
                "nome"     => "Indiavaí",
            ],
            [
                "ibge_codigo"       => 5104526,
                "ibge_estado_id" => 51,
                "nome"     => "Ipiranga do Norte",
            ],
            [
                "ibge_codigo"       => 5104542,
                "ibge_estado_id" => 51,
                "nome"     => "Itanhangá",
            ],
            [
                "ibge_codigo"       => 5104559,
                "ibge_estado_id" => 51,
                "nome"     => "Itaúba",
            ],
            [
                "ibge_codigo"       => 5104609,
                "ibge_estado_id" => 51,
                "nome"     => "Itiquira",
            ],
            [
                "ibge_codigo"       => 5104807,
                "ibge_estado_id" => 51,
                "nome"     => "Jaciara",
            ],
            [
                "ibge_codigo"       => 5104906,
                "ibge_estado_id" => 51,
                "nome"     => "Jangada",
            ],
            [
                "ibge_codigo"       => 5105002,
                "ibge_estado_id" => 51,
                "nome"     => "Jauru",
            ],
            [
                "ibge_codigo"       => 5105101,
                "ibge_estado_id" => 51,
                "nome"     => "Juara",
            ],
            [
                "ibge_codigo"       => 5105150,
                "ibge_estado_id" => 51,
                "nome"     => "Juína",
            ],
            [
                "ibge_codigo"       => 5105176,
                "ibge_estado_id" => 51,
                "nome"     => "Juruena",
            ],
            [
                "ibge_codigo"       => 5105200,
                "ibge_estado_id" => 51,
                "nome"     => "Juscimeira",
            ],
            [
                "ibge_codigo"       => 5105234,
                "ibge_estado_id" => 51,
                "nome"     => "Lambari d'Oeste",
            ],
            [
                "ibge_codigo"       => 5105259,
                "ibge_estado_id" => 51,
                "nome"     => "Lucas do Rio Verde",
            ],
            [
                "ibge_codigo"       => 5105309,
                "ibge_estado_id" => 51,
                "nome"     => "Luciára",
            ],
            [
                "ibge_codigo"       => 5105507,
                "ibge_estado_id" => 51,
                "nome"     => "Vila Bela da Santíssima Trindade",
            ],
            [
                "ibge_codigo"       => 5105580,
                "ibge_estado_id" => 51,
                "nome"     => "Marcelândia",
            ],
            [
                "ibge_codigo"       => 5105606,
                "ibge_estado_id" => 51,
                "nome"     => "Matupá",
            ],
            [
                "ibge_codigo"       => 5105622,
                "ibge_estado_id" => 51,
                "nome"     => "Mirassol d'Oeste",
            ],
            [
                "ibge_codigo"       => 5105903,
                "ibge_estado_id" => 51,
                "nome"     => "Nobres",
            ],
            [
                "ibge_codigo"       => 5106000,
                "ibge_estado_id" => 51,
                "nome"     => "Nortelândia",
            ],
            [
                "ibge_codigo"       => 5106109,
                "ibge_estado_id" => 51,
                "nome"     => "Nossa Senhora do Livramento",
            ],
            [
                "ibge_codigo"       => 5106158,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Bandeirantes",
            ],
            [
                "ibge_codigo"       => 5106174,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Nazaré",
            ],
            [
                "ibge_codigo"       => 5106182,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Lacerda",
            ],
            [
                "ibge_codigo"       => 5106190,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Santa Helena",
            ],
            [
                "ibge_codigo"       => 5106208,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Brasilândia",
            ],
            [
                "ibge_codigo"       => 5106216,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Canaã do Norte",
            ],
            [
                "ibge_codigo"       => 5106224,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Mutum",
            ],
            [
                "ibge_codigo"       => 5106232,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Olímpia",
            ],
            [
                "ibge_codigo"       => 5106240,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Ubiratã",
            ],
            [
                "ibge_codigo"       => 5106257,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Xavantina",
            ],
            [
                "ibge_codigo"       => 5106265,
                "ibge_estado_id" => 51,
                "nome"     => "Novo Mundo",
            ],
            [
                "ibge_codigo"       => 5106273,
                "ibge_estado_id" => 51,
                "nome"     => "Novo Horizonte do Norte",
            ],
            [
                "ibge_codigo"       => 5106281,
                "ibge_estado_id" => 51,
                "nome"     => "Novo São Joaquim",
            ],
            [
                "ibge_codigo"       => 5106299,
                "ibge_estado_id" => 51,
                "nome"     => "Paranaíta",
            ],
            [
                "ibge_codigo"       => 5106307,
                "ibge_estado_id" => 51,
                "nome"     => "Paranatinga",
            ],
            [
                "ibge_codigo"       => 5106315,
                "ibge_estado_id" => 51,
                "nome"     => "Novo Santo Antônio",
            ],
            [
                "ibge_codigo"       => 5106372,
                "ibge_estado_id" => 51,
                "nome"     => "Pedra Preta",
            ],
            [
                "ibge_codigo"       => 5106422,
                "ibge_estado_id" => 51,
                "nome"     => "Peixoto de Azevedo",
            ],
            [
                "ibge_codigo"       => 5106455,
                "ibge_estado_id" => 51,
                "nome"     => "Planalto da Serra",
            ],
            [
                "ibge_codigo"       => 5106505,
                "ibge_estado_id" => 51,
                "nome"     => "Poconé",
            ],
            [
                "ibge_codigo"       => 5106653,
                "ibge_estado_id" => 51,
                "nome"     => "Pontal do Araguaia",
            ],
            [
                "ibge_codigo"       => 5106703,
                "ibge_estado_id" => 51,
                "nome"     => "Ponte Branca",
            ],
            [
                "ibge_codigo"       => 5106752,
                "ibge_estado_id" => 51,
                "nome"     => "Pontes e Lacerda",
            ],
            [
                "ibge_codigo"       => 5106778,
                "ibge_estado_id" => 51,
                "nome"     => "Porto Alegre do Norte",
            ],
            [
                "ibge_codigo"       => 5106802,
                "ibge_estado_id" => 51,
                "nome"     => "Porto dos Gaúchos",
            ],
            [
                "ibge_codigo"       => 5106828,
                "ibge_estado_id" => 51,
                "nome"     => "Porto Esperidião",
            ],
            [
                "ibge_codigo"       => 5106851,
                "ibge_estado_id" => 51,
                "nome"     => "Porto Estrela",
            ],
            [
                "ibge_codigo"       => 5107008,
                "ibge_estado_id" => 51,
                "nome"     => "Poxoréo",
            ],
            [
                "ibge_codigo"       => 5107040,
                "ibge_estado_id" => 51,
                "nome"     => "Primavera do Leste",
            ],
            [
                "ibge_codigo"       => 5107065,
                "ibge_estado_id" => 51,
                "nome"     => "Querência",
            ],
            [
                "ibge_codigo"       => 5107107,
                "ibge_estado_id" => 51,
                "nome"     => "São José dos Quatro Marcos",
            ],
            [
                "ibge_codigo"       => 5107156,
                "ibge_estado_id" => 51,
                "nome"     => "Reserva do Cabaçal",
            ],
            [
                "ibge_codigo"       => 5107180,
                "ibge_estado_id" => 51,
                "nome"     => "Ribeirão Cascalheira",
            ],
            [
                "ibge_codigo"       => 5107198,
                "ibge_estado_id" => 51,
                "nome"     => "Ribeirãozinho",
            ],
            [
                "ibge_codigo"       => 5107206,
                "ibge_estado_id" => 51,
                "nome"     => "Rio Branco",
            ],
            [
                "ibge_codigo"       => 5107248,
                "ibge_estado_id" => 51,
                "nome"     => "Santa Carmem",
            ],
            [
                "ibge_codigo"       => 5107263,
                "ibge_estado_id" => 51,
                "nome"     => "Santo Afonso",
            ],
            [
                "ibge_codigo"       => 5107297,
                "ibge_estado_id" => 51,
                "nome"     => "São José do Povo",
            ],
            [
                "ibge_codigo"       => 5107305,
                "ibge_estado_id" => 51,
                "nome"     => "São José do Rio Claro",
            ],
            [
                "ibge_codigo"       => 5107354,
                "ibge_estado_id" => 51,
                "nome"     => "São José do Xingu",
            ],
            [
                "ibge_codigo"       => 5107404,
                "ibge_estado_id" => 51,
                "nome"     => "São Pedro da Cipa",
            ],
            [
                "ibge_codigo"       => 5107578,
                "ibge_estado_id" => 51,
                "nome"     => "Rondolândia",
            ],
            [
                "ibge_codigo"       => 5107602,
                "ibge_estado_id" => 51,
                "nome"     => "Rondonópolis",
            ],
            [
                "ibge_codigo"       => 5107701,
                "ibge_estado_id" => 51,
                "nome"     => "Rosário Oeste",
            ],
            [
                "ibge_codigo"       => 5107743,
                "ibge_estado_id" => 51,
                "nome"     => "Santa Cruz do Xingu",
            ],
            [
                "ibge_codigo"       => 5107750,
                "ibge_estado_id" => 51,
                "nome"     => "Salto do Céu",
            ],
            [
                "ibge_codigo"       => 5107768,
                "ibge_estado_id" => 51,
                "nome"     => "Santa Rita do Trivelato",
            ],
            [
                "ibge_codigo"       => 5107776,
                "ibge_estado_id" => 51,
                "nome"     => "Santa Terezinha",
            ],
            [
                "ibge_codigo"       => 5107792,
                "ibge_estado_id" => 51,
                "nome"     => "Santo Antônio do Leste",
            ],
            [
                "ibge_codigo"       => 5107800,
                "ibge_estado_id" => 51,
                "nome"     => "Santo Antônio do Leverger",
            ],
            [
                "ibge_codigo"       => 5107859,
                "ibge_estado_id" => 51,
                "nome"     => "São Félix do Araguaia",
            ],
            [
                "ibge_codigo"       => 5107875,
                "ibge_estado_id" => 51,
                "nome"     => "Sapezal",
            ],
            [
                "ibge_codigo"       => 5107883,
                "ibge_estado_id" => 51,
                "nome"     => "Serra Nova Dourada",
            ],
            [
                "ibge_codigo"       => 5107909,
                "ibge_estado_id" => 51,
                "nome"     => "Sinop",
            ],
            [
                "ibge_codigo"       => 5107925,
                "ibge_estado_id" => 51,
                "nome"     => "Sorriso",
            ],
            [
                "ibge_codigo"       => 5107941,
                "ibge_estado_id" => 51,
                "nome"     => "Tabaporã",
            ],
            [
                "ibge_codigo"       => 5107958,
                "ibge_estado_id" => 51,
                "nome"     => "Tangará da Serra",
            ],
            [
                "ibge_codigo"       => 5108006,
                "ibge_estado_id" => 51,
                "nome"     => "Tapurah",
            ],
            [
                "ibge_codigo"       => 5108055,
                "ibge_estado_id" => 51,
                "nome"     => "Terra Nova do Norte",
            ],
            [
                "ibge_codigo"       => 5108105,
                "ibge_estado_id" => 51,
                "nome"     => "Tesouro",
            ],
            [
                "ibge_codigo"       => 5108204,
                "ibge_estado_id" => 51,
                "nome"     => "Torixoréu",
            ],
            [
                "ibge_codigo"       => 5108303,
                "ibge_estado_id" => 51,
                "nome"     => "União do Sul",
            ],
            [
                "ibge_codigo"       => 5108352,
                "ibge_estado_id" => 51,
                "nome"     => "Vale de São Domingos",
            ],
            [
                "ibge_codigo"       => 5108402,
                "ibge_estado_id" => 51,
                "nome"     => "Várzea Grande",
            ],
            [
                "ibge_codigo"       => 5108501,
                "ibge_estado_id" => 51,
                "nome"     => "Vera",
            ],
            [
                "ibge_codigo"       => 5108600,
                "ibge_estado_id" => 51,
                "nome"     => "Vila Rica",
            ],
            [
                "ibge_codigo"       => 5108808,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Guarita",
            ],
            [
                "ibge_codigo"       => 5108857,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Marilândia",
            ],
            [
                "ibge_codigo"       => 5108907,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Maringá",
            ],
            [
                "ibge_codigo"       => 5108956,
                "ibge_estado_id" => 51,
                "nome"     => "Nova Monte verde",
            ],
            [
                "ibge_codigo"       => 5200050,
                "ibge_estado_id" => 52,
                "nome"     => "Abadia de Goiás",
            ],
            [
                "ibge_codigo"       => 5200100,
                "ibge_estado_id" => 52,
                "nome"     => "Abadiânia",
            ],
            [
                "ibge_codigo"       => 5200134,
                "ibge_estado_id" => 52,
                "nome"     => "Acreúna",
            ],
            [
                "ibge_codigo"       => 5200159,
                "ibge_estado_id" => 52,
                "nome"     => "Adelândia",
            ],
            [
                "ibge_codigo"       => 5200175,
                "ibge_estado_id" => 52,
                "nome"     => "Água Fria de Goiás",
            ],
            [
                "ibge_codigo"       => 5200209,
                "ibge_estado_id" => 52,
                "nome"     => "Água Limpa",
            ],
            [
                "ibge_codigo"       => 5200258,
                "ibge_estado_id" => 52,
                "nome"     => "Águas Lindas de Goiás",
            ],
            [
                "ibge_codigo"       => 5200308,
                "ibge_estado_id" => 52,
                "nome"     => "Alexânia",
            ],
            [
                "ibge_codigo"       => 5200506,
                "ibge_estado_id" => 52,
                "nome"     => "Aloândia",
            ],
            [
                "ibge_codigo"       => 5200555,
                "ibge_estado_id" => 52,
                "nome"     => "Alto Horizonte",
            ],
            [
                "ibge_codigo"       => 5200605,
                "ibge_estado_id" => 52,
                "nome"     => "Alto Paraíso de Goiás",
            ],
            [
                "ibge_codigo"       => 5200803,
                "ibge_estado_id" => 52,
                "nome"     => "Alvorada do Norte",
            ],
            [
                "ibge_codigo"       => 5200829,
                "ibge_estado_id" => 52,
                "nome"     => "Amaralina",
            ],
            [
                "ibge_codigo"       => 5200852,
                "ibge_estado_id" => 52,
                "nome"     => "Americano do Brasil",
            ],
            [
                "ibge_codigo"       => 5200902,
                "ibge_estado_id" => 52,
                "nome"     => "Amorinópolis",
            ],
            [
                "ibge_codigo"       => 5201108,
                "ibge_estado_id" => 52,
                "nome"     => "Anápolis",
            ],
            [
                "ibge_codigo"       => 5201207,
                "ibge_estado_id" => 52,
                "nome"     => "Anhanguera",
            ],
            [
                "ibge_codigo"       => 5201306,
                "ibge_estado_id" => 52,
                "nome"     => "Anicuns",
            ],
            [
                "ibge_codigo"       => 5201405,
                "ibge_estado_id" => 52,
                "nome"     => "Aparecida de Goiânia",
            ],
            [
                "ibge_codigo"       => 5201454,
                "ibge_estado_id" => 52,
                "nome"     => "Aparecida do Rio Doce",
            ],
            [
                "ibge_codigo"       => 5201504,
                "ibge_estado_id" => 52,
                "nome"     => "Aporé",
            ],
            [
                "ibge_codigo"       => 5201603,
                "ibge_estado_id" => 52,
                "nome"     => "Araçu",
            ],
            [
                "ibge_codigo"       => 5201702,
                "ibge_estado_id" => 52,
                "nome"     => "Aragarças",
            ],
            [
                "ibge_codigo"       => 5201801,
                "ibge_estado_id" => 52,
                "nome"     => "Aragoiânia",
            ],
            [
                "ibge_codigo"       => 5202155,
                "ibge_estado_id" => 52,
                "nome"     => "Araguapaz",
            ],
            [
                "ibge_codigo"       => 5202353,
                "ibge_estado_id" => 52,
                "nome"     => "Arenópolis",
            ],
            [
                "ibge_codigo"       => 5202502,
                "ibge_estado_id" => 52,
                "nome"     => "Aruanã",
            ],
            [
                "ibge_codigo"       => 5202601,
                "ibge_estado_id" => 52,
                "nome"     => "Aurilândia",
            ],
            [
                "ibge_codigo"       => 5202809,
                "ibge_estado_id" => 52,
                "nome"     => "Avelinópolis",
            ],
            [
                "ibge_codigo"       => 5203104,
                "ibge_estado_id" => 52,
                "nome"     => "Baliza",
            ],
            [
                "ibge_codigo"       => 5203203,
                "ibge_estado_id" => 52,
                "nome"     => "Barro Alto",
            ],
            [
                "ibge_codigo"       => 5203302,
                "ibge_estado_id" => 52,
                "nome"     => "Bela Vista de Goiás",
            ],
            [
                "ibge_codigo"       => 5203401,
                "ibge_estado_id" => 52,
                "nome"     => "Bom Jardim de Goiás",
            ],
            [
                "ibge_codigo"       => 5203500,
                "ibge_estado_id" => 52,
                "nome"     => "Bom Jesus de Goiás",
            ],
            [
                "ibge_codigo"       => 5203559,
                "ibge_estado_id" => 52,
                "nome"     => "Bonfinópolis",
            ],
            [
                "ibge_codigo"       => 5203575,
                "ibge_estado_id" => 52,
                "nome"     => "Bonópolis",
            ],
            [
                "ibge_codigo"       => 5203609,
                "ibge_estado_id" => 52,
                "nome"     => "Brazabrantes",
            ],
            [
                "ibge_codigo"       => 5203807,
                "ibge_estado_id" => 52,
                "nome"     => "Britânia",
            ],
            [
                "ibge_codigo"       => 5203906,
                "ibge_estado_id" => 52,
                "nome"     => "Buriti Alegre",
            ],
            [
                "ibge_codigo"       => 5203939,
                "ibge_estado_id" => 52,
                "nome"     => "Buriti de Goiás",
            ],
            [
                "ibge_codigo"       => 5203962,
                "ibge_estado_id" => 52,
                "nome"     => "Buritinópolis",
            ],
            [
                "ibge_codigo"       => 5204003,
                "ibge_estado_id" => 52,
                "nome"     => "Cabeceiras",
            ],
            [
                "ibge_codigo"       => 5204102,
                "ibge_estado_id" => 52,
                "nome"     => "Cachoeira Alta",
            ],
            [
                "ibge_codigo"       => 5204201,
                "ibge_estado_id" => 52,
                "nome"     => "Cachoeira de Goiás",
            ],
            [
                "ibge_codigo"       => 5204250,
                "ibge_estado_id" => 52,
                "nome"     => "Cachoeira Dourada",
            ],
            [
                "ibge_codigo"       => 5204300,
                "ibge_estado_id" => 52,
                "nome"     => "Caçu",
            ],
            [
                "ibge_codigo"       => 5204409,
                "ibge_estado_id" => 52,
                "nome"     => "Caiapônia",
            ],
            [
                "ibge_codigo"       => 5204508,
                "ibge_estado_id" => 52,
                "nome"     => "Caldas Novas",
            ],
            [
                "ibge_codigo"       => 5204557,
                "ibge_estado_id" => 52,
                "nome"     => "Caldazinha",
            ],
            [
                "ibge_codigo"       => 5204607,
                "ibge_estado_id" => 52,
                "nome"     => "Campestre de Goiás",
            ],
            [
                "ibge_codigo"       => 5204656,
                "ibge_estado_id" => 52,
                "nome"     => "Campinaçu",
            ],
            [
                "ibge_codigo"       => 5204706,
                "ibge_estado_id" => 52,
                "nome"     => "Campinorte",
            ],
            [
                "ibge_codigo"       => 5204805,
                "ibge_estado_id" => 52,
                "nome"     => "Campo Alegre de Goiás",
            ],
            [
                "ibge_codigo"       => 5204854,
                "ibge_estado_id" => 52,
                "nome"     => "Campo Limpo de Goiás",
            ],
            [
                "ibge_codigo"       => 5204904,
                "ibge_estado_id" => 52,
                "nome"     => "Campos Belos",
            ],
            [
                "ibge_codigo"       => 5204953,
                "ibge_estado_id" => 52,
                "nome"     => "Campos Verdes",
            ],
            [
                "ibge_codigo"       => 5205000,
                "ibge_estado_id" => 52,
                "nome"     => "Carmo do Rio Verde",
            ],
            [
                "ibge_codigo"       => 5205059,
                "ibge_estado_id" => 52,
                "nome"     => "Castelândia",
            ],
            [
                "ibge_codigo"       => 5205109,
                "ibge_estado_id" => 52,
                "nome"     => "Catalão",
            ],
            [
                "ibge_codigo"       => 5205208,
                "ibge_estado_id" => 52,
                "nome"     => "Caturaí",
            ],
            [
                "ibge_codigo"       => 5205307,
                "ibge_estado_id" => 52,
                "nome"     => "Cavalcante",
            ],
            [
                "ibge_codigo"       => 5205406,
                "ibge_estado_id" => 52,
                "nome"     => "Ceres",
            ],
            [
                "ibge_codigo"       => 5205455,
                "ibge_estado_id" => 52,
                "nome"     => "Cezarina",
            ],
            [
                "ibge_codigo"       => 5205471,
                "ibge_estado_id" => 52,
                "nome"     => "Chapadão do Céu",
            ],
            [
                "ibge_codigo"       => 5205497,
                "ibge_estado_id" => 52,
                "nome"     => "Cidade Ocidental",
            ],
            [
                "ibge_codigo"       => 5205513,
                "ibge_estado_id" => 52,
                "nome"     => "Cocalzinho de Goiás",
            ],
            [
                "ibge_codigo"       => 5205521,
                "ibge_estado_id" => 52,
                "nome"     => "Colinas do Sul",
            ],
            [
                "ibge_codigo"       => 5205703,
                "ibge_estado_id" => 52,
                "nome"     => "Córrego do Ouro",
            ],
            [
                "ibge_codigo"       => 5205802,
                "ibge_estado_id" => 52,
                "nome"     => "Corumbá de Goiás",
            ],
            [
                "ibge_codigo"       => 5205901,
                "ibge_estado_id" => 52,
                "nome"     => "Corumbaíba",
            ],
            [
                "ibge_codigo"       => 5206206,
                "ibge_estado_id" => 52,
                "nome"     => "Cristalina",
            ],
            [
                "ibge_codigo"       => 5206305,
                "ibge_estado_id" => 52,
                "nome"     => "Cristianópolis",
            ],
            [
                "ibge_codigo"       => 5206404,
                "ibge_estado_id" => 52,
                "nome"     => "Crixás",
            ],
            [
                "ibge_codigo"       => 5206503,
                "ibge_estado_id" => 52,
                "nome"     => "Cromínia",
            ],
            [
                "ibge_codigo"       => 5206602,
                "ibge_estado_id" => 52,
                "nome"     => "Cumari",
            ],
            [
                "ibge_codigo"       => 5206701,
                "ibge_estado_id" => 52,
                "nome"     => "Damianópolis",
            ],
            [
                "ibge_codigo"       => 5206800,
                "ibge_estado_id" => 52,
                "nome"     => "Damolândia",
            ],
            [
                "ibge_codigo"       => 5206909,
                "ibge_estado_id" => 52,
                "nome"     => "Davinópolis",
            ],
            [
                "ibge_codigo"       => 5207105,
                "ibge_estado_id" => 52,
                "nome"     => "Diorama",
            ],
            [
                "ibge_codigo"       => 5207253,
                "ibge_estado_id" => 52,
                "nome"     => "Doverlândia",
            ],
            [
                "ibge_codigo"       => 5207352,
                "ibge_estado_id" => 52,
                "nome"     => "Edealina",
            ],
            [
                "ibge_codigo"       => 5207402,
                "ibge_estado_id" => 52,
                "nome"     => "Edéia",
            ],
            [
                "ibge_codigo"       => 5207501,
                "ibge_estado_id" => 52,
                "nome"     => "Estrela do Norte",
            ],
            [
                "ibge_codigo"       => 5207535,
                "ibge_estado_id" => 52,
                "nome"     => "Faina",
            ],
            [
                "ibge_codigo"       => 5207600,
                "ibge_estado_id" => 52,
                "nome"     => "Fazenda Nova",
            ],
            [
                "ibge_codigo"       => 5207808,
                "ibge_estado_id" => 52,
                "nome"     => "Firminópolis",
            ],
            [
                "ibge_codigo"       => 5207907,
                "ibge_estado_id" => 52,
                "nome"     => "Flores de Goiás",
            ],
            [
                "ibge_codigo"       => 5208004,
                "ibge_estado_id" => 52,
                "nome"     => "Formosa",
            ],
            [
                "ibge_codigo"       => 5208103,
                "ibge_estado_id" => 52,
                "nome"     => "Formoso",
            ],
            [
                "ibge_codigo"       => 5208152,
                "ibge_estado_id" => 52,
                "nome"     => "Gameleira de Goiás",
            ],
            [
                "ibge_codigo"       => 5208301,
                "ibge_estado_id" => 52,
                "nome"     => "Divinópolis de Goiás",
            ],
            [
                "ibge_codigo"       => 5208400,
                "ibge_estado_id" => 52,
                "nome"     => "Goianápolis",
            ],
            [
                "ibge_codigo"       => 5208509,
                "ibge_estado_id" => 52,
                "nome"     => "Goiandira",
            ],
            [
                "ibge_codigo"       => 5208608,
                "ibge_estado_id" => 52,
                "nome"     => "Goianésia",
            ],
            [
                "ibge_codigo"       => 5208707,
                "ibge_estado_id" => 52,
                "nome"     => "Goiânia",
            ],
            [
                "ibge_codigo"       => 5208806,
                "ibge_estado_id" => 52,
                "nome"     => "Goianira",
            ],
            [
                "ibge_codigo"       => 5208905,
                "ibge_estado_id" => 52,
                "nome"     => "Goiás",
            ],
            [
                "ibge_codigo"       => 5209101,
                "ibge_estado_id" => 52,
                "nome"     => "Goiatuba",
            ],
            [
                "ibge_codigo"       => 5209150,
                "ibge_estado_id" => 52,
                "nome"     => "Gouvelândia",
            ],
            [
                "ibge_codigo"       => 5209200,
                "ibge_estado_id" => 52,
                "nome"     => "Guapó",
            ],
            [
                "ibge_codigo"       => 5209291,
                "ibge_estado_id" => 52,
                "nome"     => "Guaraíta",
            ],
            [
                "ibge_codigo"       => 5209408,
                "ibge_estado_id" => 52,
                "nome"     => "Guarani de Goiás",
            ],
            [
                "ibge_codigo"       => 5209457,
                "ibge_estado_id" => 52,
                "nome"     => "Guarinos",
            ],
            [
                "ibge_codigo"       => 5209606,
                "ibge_estado_id" => 52,
                "nome"     => "Heitoraí",
            ],
            [
                "ibge_codigo"       => 5209705,
                "ibge_estado_id" => 52,
                "nome"     => "Hidrolândia",
            ],
            [
                "ibge_codigo"       => 5209804,
                "ibge_estado_id" => 52,
                "nome"     => "Hidrolina",
            ],
            [
                "ibge_codigo"       => 5209903,
                "ibge_estado_id" => 52,
                "nome"     => "Iaciara",
            ],
            [
                "ibge_codigo"       => 5209937,
                "ibge_estado_id" => 52,
                "nome"     => "Inaciolândia",
            ],
            [
                "ibge_codigo"       => 5209952,
                "ibge_estado_id" => 52,
                "nome"     => "Indiara",
            ],
            [
                "ibge_codigo"       => 5210000,
                "ibge_estado_id" => 52,
                "nome"     => "Inhumas",
            ],
            [
                "ibge_codigo"       => 5210109,
                "ibge_estado_id" => 52,
                "nome"     => "Ipameri",
            ],
            [
                "ibge_codigo"       => 5210158,
                "ibge_estado_id" => 52,
                "nome"     => "Ipiranga de Goiás",
            ],
            [
                "ibge_codigo"       => 5210208,
                "ibge_estado_id" => 52,
                "nome"     => "Iporá",
            ],
            [
                "ibge_codigo"       => 5210307,
                "ibge_estado_id" => 52,
                "nome"     => "Israelândia",
            ],
            [
                "ibge_codigo"       => 5210406,
                "ibge_estado_id" => 52,
                "nome"     => "Itaberaí",
            ],
            [
                "ibge_codigo"       => 5210562,
                "ibge_estado_id" => 52,
                "nome"     => "Itaguari",
            ],
            [
                "ibge_codigo"       => 5210604,
                "ibge_estado_id" => 52,
                "nome"     => "Itaguaru",
            ],
            [
                "ibge_codigo"       => 5210802,
                "ibge_estado_id" => 52,
                "nome"     => "Itajá",
            ],
            [
                "ibge_codigo"       => 5210901,
                "ibge_estado_id" => 52,
                "nome"     => "Itapaci",
            ],
            [
                "ibge_codigo"       => 5211008,
                "ibge_estado_id" => 52,
                "nome"     => "Itapirapuã",
            ],
            [
                "ibge_codigo"       => 5211206,
                "ibge_estado_id" => 52,
                "nome"     => "Itapuranga",
            ],
            [
                "ibge_codigo"       => 5211305,
                "ibge_estado_id" => 52,
                "nome"     => "Itarumã",
            ],
            [
                "ibge_codigo"       => 5211404,
                "ibge_estado_id" => 52,
                "nome"     => "Itauçu",
            ],
            [
                "ibge_codigo"       => 5211503,
                "ibge_estado_id" => 52,
                "nome"     => "Itumbiara",
            ],
            [
                "ibge_codigo"       => 5211602,
                "ibge_estado_id" => 52,
                "nome"     => "Ivolândia",
            ],
            [
                "ibge_codigo"       => 5211701,
                "ibge_estado_id" => 52,
                "nome"     => "Jandaia",
            ],
            [
                "ibge_codigo"       => 5211800,
                "ibge_estado_id" => 52,
                "nome"     => "Jaraguá",
            ],
            [
                "ibge_codigo"       => 5211909,
                "ibge_estado_id" => 52,
                "nome"     => "Jataí",
            ],
            [
                "ibge_codigo"       => 5212006,
                "ibge_estado_id" => 52,
                "nome"     => "Jaupaci",
            ],
            [
                "ibge_codigo"       => 5212055,
                "ibge_estado_id" => 52,
                "nome"     => "Jesúpolis",
            ],
            [
                "ibge_codigo"       => 5212105,
                "ibge_estado_id" => 52,
                "nome"     => "Joviânia",
            ],
            [
                "ibge_codigo"       => 5212204,
                "ibge_estado_id" => 52,
                "nome"     => "Jussara",
            ],
            [
                "ibge_codigo"       => 5212253,
                "ibge_estado_id" => 52,
                "nome"     => "Lagoa Santa",
            ],
            [
                "ibge_codigo"       => 5212303,
                "ibge_estado_id" => 52,
                "nome"     => "Leopoldo de Bulhões",
            ],
            [
                "ibge_codigo"       => 5212501,
                "ibge_estado_id" => 52,
                "nome"     => "Luziânia",
            ],
            [
                "ibge_codigo"       => 5212600,
                "ibge_estado_id" => 52,
                "nome"     => "Mairipotaba",
            ],
            [
                "ibge_codigo"       => 5212709,
                "ibge_estado_id" => 52,
                "nome"     => "Mambaí",
            ],
            [
                "ibge_codigo"       => 5212808,
                "ibge_estado_id" => 52,
                "nome"     => "Mara Rosa",
            ],
            [
                "ibge_codigo"       => 5212907,
                "ibge_estado_id" => 52,
                "nome"     => "Marzagão",
            ],
            [
                "ibge_codigo"       => 5212956,
                "ibge_estado_id" => 52,
                "nome"     => "Matrinchã",
            ],
            [
                "ibge_codigo"       => 5213004,
                "ibge_estado_id" => 52,
                "nome"     => "Maurilândia",
            ],
            [
                "ibge_codigo"       => 5213053,
                "ibge_estado_id" => 52,
                "nome"     => "Mimoso de Goiás",
            ],
            [
                "ibge_codigo"       => 5213087,
                "ibge_estado_id" => 52,
                "nome"     => "Minaçu",
            ],
            [
                "ibge_codigo"       => 5213103,
                "ibge_estado_id" => 52,
                "nome"     => "Mineiros",
            ],
            [
                "ibge_codigo"       => 5213400,
                "ibge_estado_id" => 52,
                "nome"     => "Moiporá",
            ],
            [
                "ibge_codigo"       => 5213509,
                "ibge_estado_id" => 52,
                "nome"     => "Monte Alegre de Goiás",
            ],
            [
                "ibge_codigo"       => 5213707,
                "ibge_estado_id" => 52,
                "nome"     => "Montes Claros de Goiás",
            ],
            [
                "ibge_codigo"       => 5213756,
                "ibge_estado_id" => 52,
                "nome"     => "Montividiu",
            ],
            [
                "ibge_codigo"       => 5213772,
                "ibge_estado_id" => 52,
                "nome"     => "Montividiu do Norte",
            ],
            [
                "ibge_codigo"       => 5213806,
                "ibge_estado_id" => 52,
                "nome"     => "Morrinhos",
            ],
            [
                "ibge_codigo"       => 5213855,
                "ibge_estado_id" => 52,
                "nome"     => "Morro Agudo de Goiás",
            ],
            [
                "ibge_codigo"       => 5213905,
                "ibge_estado_id" => 52,
                "nome"     => "Mossâmedes",
            ],
            [
                "ibge_codigo"       => 5214002,
                "ibge_estado_id" => 52,
                "nome"     => "Mozarlândia",
            ],
            [
                "ibge_codigo"       => 5214051,
                "ibge_estado_id" => 52,
                "nome"     => "Mundo Novo",
            ],
            [
                "ibge_codigo"       => 5214101,
                "ibge_estado_id" => 52,
                "nome"     => "Mutunópolis",
            ],
            [
                "ibge_codigo"       => 5214408,
                "ibge_estado_id" => 52,
                "nome"     => "Nazário",
            ],
            [
                "ibge_codigo"       => 5214507,
                "ibge_estado_id" => 52,
                "nome"     => "Nerópolis",
            ],
            [
                "ibge_codigo"       => 5214606,
                "ibge_estado_id" => 52,
                "nome"     => "Niquelândia",
            ],
            [
                "ibge_codigo"       => 5214705,
                "ibge_estado_id" => 52,
                "nome"     => "Nova América",
            ],
            [
                "ibge_codigo"       => 5214804,
                "ibge_estado_id" => 52,
                "nome"     => "Nova Aurora",
            ],
            [
                "ibge_codigo"       => 5214838,
                "ibge_estado_id" => 52,
                "nome"     => "Nova Crixás",
            ],
            [
                "ibge_codigo"       => 5214861,
                "ibge_estado_id" => 52,
                "nome"     => "Nova Glória",
            ],
            [
                "ibge_codigo"       => 5214879,
                "ibge_estado_id" => 52,
                "nome"     => "Nova Iguaçu de Goiás",
            ],
            [
                "ibge_codigo"       => 5214903,
                "ibge_estado_id" => 52,
                "nome"     => "Nova Roma",
            ],
            [
                "ibge_codigo"       => 5215009,
                "ibge_estado_id" => 52,
                "nome"     => "Nova Veneza",
            ],
            [
                "ibge_codigo"       => 5215207,
                "ibge_estado_id" => 52,
                "nome"     => "Novo Brasil",
            ],
            [
                "ibge_codigo"       => 5215231,
                "ibge_estado_id" => 52,
                "nome"     => "Novo Gama",
            ],
            [
                "ibge_codigo"       => 5215256,
                "ibge_estado_id" => 52,
                "nome"     => "Novo Planalto",
            ],
            [
                "ibge_codigo"       => 5215306,
                "ibge_estado_id" => 52,
                "nome"     => "Orizona",
            ],
            [
                "ibge_codigo"       => 5215405,
                "ibge_estado_id" => 52,
                "nome"     => "Ouro Verde de Goiás",
            ],
            [
                "ibge_codigo"       => 5215504,
                "ibge_estado_id" => 52,
                "nome"     => "Ouvidor",
            ],
            [
                "ibge_codigo"       => 5215603,
                "ibge_estado_id" => 52,
                "nome"     => "Padre Bernardo",
            ],
            [
                "ibge_codigo"       => 5215652,
                "ibge_estado_id" => 52,
                "nome"     => "Palestina de Goiás",
            ],
            [
                "ibge_codigo"       => 5215702,
                "ibge_estado_id" => 52,
                "nome"     => "Palmeiras de Goiás",
            ],
            [
                "ibge_codigo"       => 5215801,
                "ibge_estado_id" => 52,
                "nome"     => "Palmelo",
            ],
            [
                "ibge_codigo"       => 5215900,
                "ibge_estado_id" => 52,
                "nome"     => "Palminópolis",
            ],
            [
                "ibge_codigo"       => 5216007,
                "ibge_estado_id" => 52,
                "nome"     => "Panamá",
            ],
            [
                "ibge_codigo"       => 5216304,
                "ibge_estado_id" => 52,
                "nome"     => "Paranaiguara",
            ],
            [
                "ibge_codigo"       => 5216403,
                "ibge_estado_id" => 52,
                "nome"     => "Paraúna",
            ],
            [
                "ibge_codigo"       => 5216452,
                "ibge_estado_id" => 52,
                "nome"     => "Perolândia",
            ],
            [
                "ibge_codigo"       => 5216809,
                "ibge_estado_id" => 52,
                "nome"     => "Petrolina de Goiás",
            ],
            [
                "ibge_codigo"       => 5216908,
                "ibge_estado_id" => 52,
                "nome"     => "Pilar de Goiás",
            ],
            [
                "ibge_codigo"       => 5217104,
                "ibge_estado_id" => 52,
                "nome"     => "Piracanjuba",
            ],
            [
                "ibge_codigo"       => 5217203,
                "ibge_estado_id" => 52,
                "nome"     => "Piranhas",
            ],
            [
                "ibge_codigo"       => 5217302,
                "ibge_estado_id" => 52,
                "nome"     => "Pirenópolis",
            ],
            [
                "ibge_codigo"       => 5217401,
                "ibge_estado_id" => 52,
                "nome"     => "Pires do Rio",
            ],
            [
                "ibge_codigo"       => 5217609,
                "ibge_estado_id" => 52,
                "nome"     => "Planaltina",
            ],
            [
                "ibge_codigo"       => 5217708,
                "ibge_estado_id" => 52,
                "nome"     => "Pontalina",
            ],
            [
                "ibge_codigo"       => 5218003,
                "ibge_estado_id" => 52,
                "nome"     => "Porangatu",
            ],
            [
                "ibge_codigo"       => 5218052,
                "ibge_estado_id" => 52,
                "nome"     => "Porteirão",
            ],
            [
                "ibge_codigo"       => 5218102,
                "ibge_estado_id" => 52,
                "nome"     => "Portelândia",
            ],
            [
                "ibge_codigo"       => 5218300,
                "ibge_estado_id" => 52,
                "nome"     => "Posse",
            ],
            [
                "ibge_codigo"       => 5218391,
                "ibge_estado_id" => 52,
                "nome"     => "Professor Jamil",
            ],
            [
                "ibge_codigo"       => 5218508,
                "ibge_estado_id" => 52,
                "nome"     => "Quirinópolis",
            ],
            [
                "ibge_codigo"       => 5218607,
                "ibge_estado_id" => 52,
                "nome"     => "Rialma",
            ],
            [
                "ibge_codigo"       => 5218706,
                "ibge_estado_id" => 52,
                "nome"     => "Rianápolis",
            ],
            [
                "ibge_codigo"       => 5218789,
                "ibge_estado_id" => 52,
                "nome"     => "Rio Quente",
            ],
            [
                "ibge_codigo"       => 5218805,
                "ibge_estado_id" => 52,
                "nome"     => "Rio Verde",
            ],
            [
                "ibge_codigo"       => 5218904,
                "ibge_estado_id" => 52,
                "nome"     => "Rubiataba",
            ],
            [
                "ibge_codigo"       => 5219001,
                "ibge_estado_id" => 52,
                "nome"     => "Sanclerlândia",
            ],
            [
                "ibge_codigo"       => 5219100,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Bárbara de Goiás",
            ],
            [
                "ibge_codigo"       => 5219209,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Cruz de Goiás",
            ],
            [
                "ibge_codigo"       => 5219258,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Fé de Goiás",
            ],
            [
                "ibge_codigo"       => 5219308,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Helena de Goiás",
            ],
            [
                "ibge_codigo"       => 5219357,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Isabel",
            ],
            [
                "ibge_codigo"       => 5219407,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Rita do Araguaia",
            ],
            [
                "ibge_codigo"       => 5219456,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Rita do Novo Destino",
            ],
            [
                "ibge_codigo"       => 5219506,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Rosa de Goiás",
            ],
            [
                "ibge_codigo"       => 5219605,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Tereza de Goiás",
            ],
            [
                "ibge_codigo"       => 5219704,
                "ibge_estado_id" => 52,
                "nome"     => "Santa Terezinha de Goiás",
            ],
            [
                "ibge_codigo"       => 5219712,
                "ibge_estado_id" => 52,
                "nome"     => "Santo Antônio da Barra",
            ],
            [
                "ibge_codigo"       => 5219738,
                "ibge_estado_id" => 52,
                "nome"     => "Santo Antônio de Goiás",
            ],
            [
                "ibge_codigo"       => 5219753,
                "ibge_estado_id" => 52,
                "nome"     => "Santo Antônio do Descoberto",
            ],
            [
                "ibge_codigo"       => 5219803,
                "ibge_estado_id" => 52,
                "nome"     => "São Domingos",
            ],
            [
                "ibge_codigo"       => 5219902,
                "ibge_estado_id" => 52,
                "nome"     => "São Francisco de Goiás",
            ],
            [
                "ibge_codigo"       => 5220009,
                "ibge_estado_id" => 52,
                "nome"     => "São João d'Aliança",
            ],
            [
                "ibge_codigo"       => 5220058,
                "ibge_estado_id" => 52,
                "nome"     => "São João da Paraúna",
            ],
            [
                "ibge_codigo"       => 5220108,
                "ibge_estado_id" => 52,
                "nome"     => "São Luís de Montes Belos",
            ],
            [
                "ibge_codigo"       => 5220157,
                "ibge_estado_id" => 52,
                "nome"     => "São Luíz do Norte",
            ],
            [
                "ibge_codigo"       => 5220207,
                "ibge_estado_id" => 52,
                "nome"     => "São Miguel do Araguaia",
            ],
            [
                "ibge_codigo"       => 5220264,
                "ibge_estado_id" => 52,
                "nome"     => "São Miguel do Passa Quatro",
            ],
            [
                "ibge_codigo"       => 5220280,
                "ibge_estado_id" => 52,
                "nome"     => "São Patrício",
            ],
            [
                "ibge_codigo"       => 5220405,
                "ibge_estado_id" => 52,
                "nome"     => "São Simão",
            ],
            [
                "ibge_codigo"       => 5220454,
                "ibge_estado_id" => 52,
                "nome"     => "Senador Canedo",
            ],
            [
                "ibge_codigo"       => 5220504,
                "ibge_estado_id" => 52,
                "nome"     => "Serranópolis",
            ],
            [
                "ibge_codigo"       => 5220603,
                "ibge_estado_id" => 52,
                "nome"     => "Silvânia",
            ],
            [
                "ibge_codigo"       => 5220686,
                "ibge_estado_id" => 52,
                "nome"     => "Simolândia",
            ],
            [
                "ibge_codigo"       => 5220702,
                "ibge_estado_id" => 52,
                "nome"     => "Sítio d'Abadia",
            ],
            [
                "ibge_codigo"       => 5221007,
                "ibge_estado_id" => 52,
                "nome"     => "Taquaral de Goiás",
            ],
            [
                "ibge_codigo"       => 5221080,
                "ibge_estado_id" => 52,
                "nome"     => "Teresina de Goiás",
            ],
            [
                "ibge_codigo"       => 5221197,
                "ibge_estado_id" => 52,
                "nome"     => "Terezópolis de Goiás",
            ],
            [
                "ibge_codigo"       => 5221304,
                "ibge_estado_id" => 52,
                "nome"     => "Três Ranchos",
            ],
            [
                "ibge_codigo"       => 5221403,
                "ibge_estado_id" => 52,
                "nome"     => "Trindade",
            ],
            [
                "ibge_codigo"       => 5221452,
                "ibge_estado_id" => 52,
                "nome"     => "Trombas",
            ],
            [
                "ibge_codigo"       => 5221502,
                "ibge_estado_id" => 52,
                "nome"     => "Turvânia",
            ],
            [
                "ibge_codigo"       => 5221551,
                "ibge_estado_id" => 52,
                "nome"     => "Turvelândia",
            ],
            [
                "ibge_codigo"       => 5221577,
                "ibge_estado_id" => 52,
                "nome"     => "Uirapuru",
            ],
            [
                "ibge_codigo"       => 5221601,
                "ibge_estado_id" => 52,
                "nome"     => "Uruaçu",
            ],
            [
                "ibge_codigo"       => 5221700,
                "ibge_estado_id" => 52,
                "nome"     => "Uruana",
            ],
            [
                "ibge_codigo"       => 5221809,
                "ibge_estado_id" => 52,
                "nome"     => "Urutaí",
            ],
            [
                "ibge_codigo"       => 5221858,
                "ibge_estado_id" => 52,
                "nome"     => "Valparaíso de Goiás",
            ],
            [
                "ibge_codigo"       => 5221908,
                "ibge_estado_id" => 52,
                "nome"     => "Varjão",
            ],
            [
                "ibge_codigo"       => 5222005,
                "ibge_estado_id" => 52,
                "nome"     => "Vianópolis",
            ],
            [
                "ibge_codigo"       => 5222054,
                "ibge_estado_id" => 52,
                "nome"     => "Vicentinópolis",
            ],
            [
                "ibge_codigo"       => 5222203,
                "ibge_estado_id" => 52,
                "nome"     => "Vila Boa",
            ],
            [
                "ibge_codigo"       => 5222302,
                "ibge_estado_id" => 52,
                "nome"     => "Vila Propício",
            ],
            [
                "ibge_codigo"       => 5300108,
                "ibge_estado_id" => 53,
                "nome"     => "Brasília",
            ],
        ];
    }
}
