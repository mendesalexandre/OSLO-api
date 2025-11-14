<?php

namespace App\Http\Controllers;

use App\Models\TabelaCustaAto;
use Illuminate\Http\Request;

class TabelaCustaAtoController extends Controller
{
    public function show($id)
    {
        return TabelaCustaAto::query()
            ->where('uuid', '=', $id)
            ->first();
    }
}
