<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VersaoController extends Controller
{
    use ApiResponseTrait;

    public function version(): JsonResponse
    {
        return $this->successResponse([
            'version' => config('app.version'),
            'name' => config('app.name'),
            'environment' => app()->environment(),
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'build_date' => config('app.build_date'),
            'commit_hash' => config('app.commit_hash'),
        ]);


        public function info(): JsonResponse
    {
        return $this->successResponse([
            'app' => [
                'name' => config('app.name'),
                'version' => config('app.version'),
                'environment' => app()->environment(),
            ],
            'system' => [
                'laravel' => app()->version(),
                'php' => PHP_VERSION,
                'timezone' => config('app.timezone'),
            ],
            'build' => [
                'date' => config('app.build_date'),
                'commit' => config('app.commit_hash'),
            ]
        ]);
    }
}
