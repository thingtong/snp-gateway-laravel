<?php

namespace App\Http\Middleware;

use App\Enums\StaticToken;
use Closure;
use Illuminate\Http\Request;
use App\Models\MetaData;
use App\Traits\UseResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class StaticTokenAuth
{
    use UseResponse;

    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('X-API-Key');
        $token = $request->header('X-API-Token');
        $staticToken = StaticToken::PrefixKey->value . $key;

        if (!$key) {
            return $this->error(message: 'API key is missing', code: 401);
        }

        if (!$token) {
            return $this->error(message: 'API token is missing', code: 401);
        }

        $storedToken = Cache::remember($staticToken, 3600, function () use ($key) {
            return MetaData::where('key', $key)->value('value');
        });

        if (!$storedToken || $token !== $storedToken) {
            return $this->error(message: 'Invalid API token', code: 401);
        }

        return $next($request);
    }
}
