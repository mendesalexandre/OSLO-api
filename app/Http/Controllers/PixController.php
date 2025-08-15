<?php

namespace App\Http\Controllers;

use App\Services\Pix\PixService;
use Illuminate\Http\Request;

class PixController extends Controller
{
    public function criar(Request $request)
    {
        $dados = $request->validate([
            'ordem_servico_id' => 'nullable|integer',
            'chave_pix' => 'nullable|string|max:255',
        ]);

        $pixService = app()->make('App\Services\Pix\PixService');
        /**
         * Cria um novo registro de Pix com os dados fornecidos.
         * @var PixService $pixService
         */
        $pix = $pixService->criar($dados);

        return response()->json($pix, 201);
    }
}
