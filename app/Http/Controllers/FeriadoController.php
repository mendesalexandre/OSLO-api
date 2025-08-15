<?php

namespace App\Http\Controllers;

use App\Models\Feriado;
use Illuminate\Http\Request;

class FeriadoController extends Controller
{
    public function index()
    {
        $feriados = Feriado::query()->get();
        return response()->json($feriados);
    }
    public function create(Request $request)
    {
        $feriado = Feriado::create($request->all());
        return response()->json($feriado, 201);
    }

    public function show($id)
    {
        $feriado = Feriado::findOrFail($id);
        return response()->json($feriado);
    }

    public function update(Request $request, $id)
    {
        $feriado = Feriado::findOrFail($id);
        $feriado->update($request->all());
        return response()->json($feriado);
    }

    public function destroy($id)
    {
        $feriado = Feriado::findOrFail($id);
        $feriado->delete();
        return response()->json(null, 204);
    }
}
