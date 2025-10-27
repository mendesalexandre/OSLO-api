<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $configuracoes = Configuracao::query()->get();
        return response()->json($configuracoes);
    }

    public function update(Request $request)
    {
        $chave = $request->input('chave');
        $valor = $request->input('valor');


        $configuracao = Configuracao::query()
            ->where('chave', '=', $chave)
            ->update([
                'valor' => $valor
            ]);

        $configuracao = Configuracao::query()->where('chave', '=', $chave)->first();
        return response()->json($configuracao);
    }
}
