<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;

class Math extends Controller
{


    public function pembagian($a, $b)
    {

        try {
            $token = JWT::encode([
                'name' => "Admin",
                'email' => "test@gmail.com",
                'iat' => time(),
                'exp' => null
            ], env('JWT_SECRET_ACCESS_TOKEN'), 'HS256');


            $result = $a/$b;
            return $result;

        }catch (\DivisionByZeroError $e) {
            return "Error Karena Zero";
        }

    }





}
