<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->bearerToken();
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'code' => 401,
                    'message' => 'Unauthorized.',
                ], 401);
            }
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET_ACCESS_TOKEN'), env('JWT_ALGO')));
            $request->user = $decoded->name;
            $request->email = $decoded->email;
            return $next($request);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
