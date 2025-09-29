<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProtocoloController extends Controller
{
    public function criar(Request $request)
    {
        // Lógica para criar um novo protocolo
        return response()->json(['message' => 'Protocolo criado com sucesso!'], 201);
    }
}
