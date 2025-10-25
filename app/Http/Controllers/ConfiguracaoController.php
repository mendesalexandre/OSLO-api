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
}
