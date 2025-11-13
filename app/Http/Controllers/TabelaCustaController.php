<?php

namespace App\Http\Controllers;

use App\Models\TabelaCusta;
use Illuminate\Http\Request;

class TabelaCustaController extends Controller
{
    public function index()
    {
        $tabelaCustas = TabelaCusta::query()->get();

        return response()->json($tabelaCustas);
    }
}
