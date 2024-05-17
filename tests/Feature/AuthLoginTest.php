<?php

use Firebase\JWT\JWT;

describe("Login Negative Test Case", function () {



    it('Login Required', function () {
        // Mengirimkan permintaan HTTP POST ke endpoint /api/v1/login dengan email dan password kosong

        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/login', [
            'email' => '',
            'password' => ''
        ]);

        // Test bahwa respons sesuai dengan yang diharapkan
        $response->assertJson([
            "success" => false,
            "code" => 422,
            "message" => "Validation error",
            "errors" => [
                "email" => [
                    "Email is required"
                ],
                "password" => [
                    "Password is required"
                ]
            ]
        ]);
        // Memeriksa kode status respons
        $response->assertStatus(422);
    });








    it('Login Email Empty', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/login', [
            'email' => '',
            'password' => 'abcdefghijklmnopqrstuvwxyz'
        ]);

        $response->assertJson([
            "success" => false,
            "code" => 422,
            "message" => "Validation error",
            "errors" => [
                "email" => [
                    "Email is required"
                ]
            ]
        ])->assertStatus(422);
    });

    it('Login Email Not Valid', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/login', [
            'email' => 'admincom',
            'password' => 'abcdefghijklmnopqrstuvwxyz'
        ]);
        $response->assertJson([
            "success" => false,
            "code" => 422,
            "message" => "Validation error",
            "errors" => [
                "email" => [
                    "Email is not valid"
                ]
            ]
        ])->assertStatus(422);
    });

    it('Login Password Empty', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/login', [
            'email' => 'admin@example.com',
            'password' => ''
        ]);
        $response->assertJson([
            "success" => false,
            "code" => 422,
            "message" => "Validation error",
            "errors" => [
                "password" => [
                    "Password is required"
                ]
            ]
        ])->assertStatus(422);
    });

    it('Login Email and Password Wrong', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'abcdefgsh'
        ]);

        $response->assertJson([

            "success" => false,
            "code" => 401,
            "message" => "Unauthorized"
        ])->assertStatus(401);
    });




});


describe("Login Positive Test Case", function () {

    it('Login Success', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/login', [
            'email' => 'admin@example.com',
            'password' => 'abcdefgh'
        ]);

        $token = JWT::encode([
            'name' => "Admin",
            'email' => 'admin@example.com',
            'iat' => time(),
            'exp' => null
        ], env('JWT_SECRET_ACCESS_TOKEN'), 'HS256');


        $response->assertJson([
            "success" => true,
            "code" => 200,
            "message" => "Login Successfully",
            "data" => [
                "authorization" => [
                    "token" => $token,
                    "type" => "Bearer"
                ],
                "user" => [
                    "name" => "Admin",
                    "email" => "admin@example.com"
                ]
            ]
        ])->assertStatus(200);
    });

    it('Login Failed', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/login', [
            'email' => 'admin@example.com',
            'password' => 'abcdefghs'
        ]);

        $response->assertJson([
            "success" => false,
            "code" => 401,
            "message" => "Unauthorized",

        ])->assertStatus(401);
    });
});


test("test login", function () {
    $controllerTest = new \App\Http\Controllers\API\AuthController();

    $test = $controllerTest->test();

    expect($test)->toBe("ok");

});










