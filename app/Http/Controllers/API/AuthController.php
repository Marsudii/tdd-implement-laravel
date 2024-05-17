<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'password.required' => 'Password is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validation passed, get validated data
        // Authentication
        if ($request->email === "admin@example.com" && $request->password === "abcdefgh") {
            // Generate JWT token
            $token = $this->JWTEncode($request->all());
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Login Successfully',
                'data' => [
                    "authorization" => [
                        'token' => $token,
                        'type' => 'Bearer',
                    ],
                    'user' => [
                        'name' => "Admin",
                        'email' => $request->email,
                    ]
                ]
            ], 200);
        }

        // Authentication failed due to incorrect email or password
        return response()->json([
            'success' => false,
            'code' => 401,
            'message' => 'Unauthorized',
        ], 401);
    }


    static function JWTEncode($data)
    {
        $token = JWT::encode([
            'name' => "Admin",
            'email' => $data['email'],
            'iat' => time(),
            'exp' => null
        ], env('JWT_SECRET_ACCESS_TOKEN'), 'HS256');
        return $token;
    }



    function test(){
        return "ok";
    }




}
