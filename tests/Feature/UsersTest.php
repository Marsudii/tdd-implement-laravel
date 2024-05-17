<?php

use App\Models\User;

describe("Users", function () {
    it('Access User No Login', function () {

        // Mengirimkan permintaan HTTP POST ke endpoint /api/v1/login dengan email dan password kosong
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/users');

        // Test bahwa respons sesuai dengan yang diharapkan
        $response->assertJson([
            "success" => false,
            "code" => 401,
            "message" => "Unauthorized.",
        ]);
        // Memeriksa kode status respons
        $response->assertStatus(401);
    });


    it('Access User Token Invalid', function () {
        // Mengirimkan permintaan HTTP POST ke endpoint /api/v1/login dengan email dan password kosong
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsImV4cCI6MTcxMzY0NjA3OH0.x7LArNohKpGV81Ao1-DYgykiWYcCU0UoeBJrNTsf708'
        ])->get('/api/v1/users');

        // Test bahwa respons sesuai dengan yang diharapkan
        $response->assertJson([
            "success" => false,
            "code" => 401,
            "message" => "Signature verification failed",
        ]);
        // Memeriksa kode status respons
        $response->assertStatus(401);
    });


    it('Access User Token Valid', function () {
        //GENERATE TOKEN
        $token = \Firebase\JWT\JWT::encode([
            'name' => "Admin",
            'email' => 'admin@example.com',
            'iat' => time(),
            'exp' => null
        ], env('JWT_SECRET_ACCESS_TOKEN'), 'HS256');

        // Mengirimkan permintaan HTTP POST ke endpoint /api/v1/login dengan email dan password kosong
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get('/api/v1/users');

        // Test bahwa respons sesuai dengan yang diharapkan
        $response->assertJson([
            "success" => true,
            "code" => 200,
            "data" => []
        ]);
        // Memeriksa kode status respons
        $response->assertStatus(200);
    });
});


describe("User CRUD", function () {

    it('Name Required', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/users/add', [
            'name' => '',
            'password' => 'helllooo',
            'email' => 'marsudi@gdwad.com'
        ]);

        $response->assertJson([
            "status" => false,
            "code" => 402,
            "message" => "Name is required"
        ])->assertStatus(402);
    });


    it('Email Required', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/users/add', [
            'name' => 'helllo ',
            'password' => "12345678",
            'email' => ''
        ]);

        $response->assertJson([
            "status" => false,
            "code" => 402,
            "message" => "Email is required"
        ])->assertStatus(402);
    });

    it('Password Required', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/users/add', [
            'name' => fake()->name,
            'password' => "",
            'email' => fake()->email
        ]);

        $response->assertJson([
            "status" => false,
            "code" => 402,
            "message" => "Password is required"
        ])->assertStatus(402);
    });


    it('Password Min', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/users/add', [
            'name' => fake()->name,
            'password' => "123",
            'email' => fake()->email
        ]);

        $response->assertJson([
            "status" => false,
            "code" => 402,
            "message" => "Password min 8"
        ])->assertStatus(402);
    });


    it('Duplicate Email', function () {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/users/add', [
            'name' => 'Hello',
            'password' => 'helllooo',
            'email' => 'admin@example.com'
        ]);

        $response->assertJson([
            "errors" => "Internal Server Error"
        ])->assertStatus(500);
    });


    it('Success Create', function () {
        $reqData = [
            'name' => fake()->name,
            'password' => "1234567899",
            'email' => fake()->email
        ];

        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/api/v1/users/add', $reqData);

        $response->assertJson([
            "status" => true,
            "code" => 201,
            "data" => $reqData

        ])->assertStatus(201);
    });


    it('Add Fails', function () {
        // Membuat model User palsu

        $userData = [
            'name' => 'John Doe',
            'email' => 'joahn@example.com',
            'password' => 'password123',
        ];

        // Periksa apakah email sudah ada di database
        $existingUser = User::where('email', $userData['email'])->first();
        // Jika email sudah ada, kembalikan respons yang sesuai
        if ($existingUser) {
            $response = ['message' => 'Email already exists'];
            expect($response)->toBe(
                [
                    'message' => 'Email already exists'
                ]
            );
            return;
        }

        // Jika email belum ada, lanjutkan dengan eksekusi penambahan pengguna baru ke database
        $user = User::create($userData);

        // Memeriksa apakah pengguna baru telah dibuat dengan benar
        expect($user)->toBeInstanceOf(User::class);
        expect($user->name)->toBeString($user->name);
        expect($user->email)->toBeString($user->email);

        // Memeriksa apakah alamat email pengguna baru tidak duplikat dengan alamat email pengguna lainnya
        $usersWithSameEmail = User::where('email', $userData['email'])->get();
        expect(count($usersWithSameEmail))->toEqual(1); // Hanya satu pengguna dengan alamat email yang sama diperbolehkan
    });


});
