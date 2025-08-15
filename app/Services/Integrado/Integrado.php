<?php

namespace App\Services\Integrado;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Integrado
{
    public static function request(): PendingRequest
    {
        $url = config('app.env') === 'local' ? 'http://integrado.laboratorio.com.br' : config('cartorio.online.integrado');

        $client = Http::withHeaders([
            'accept' => 'application/json',
        ])->baseUrl($url);

        return $client;
    }
}
