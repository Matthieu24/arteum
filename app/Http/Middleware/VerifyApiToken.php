<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyApiToken
{
    public function handle(Request $request, Closure $next)
    {

        if (!$request->header('Authorization')) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        $token = $request->header('Authorization');
        $appToken = config('app.api_token');

        if ($token !== $appToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}