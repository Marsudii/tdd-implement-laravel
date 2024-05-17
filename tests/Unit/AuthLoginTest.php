<?php


beforeEach(function () {
    $this->authLogin = new \App\Http\Controllers\API\AuthController();
    $this->request = new \Illuminate\Http\Request();
});

it('Login User Failed', function () {

    $dataRequest = $this->request->merge([
        'email' => 'admin@example.com',
        'password' => 'adaw'
    ]);

    // Call the login method and capture the response
    $response = $this->authLogin->login($dataRequest);

    //expect jika login fail wajib response JSON
    expect($response)->toBeInstanceOf(\Illuminate\Http\JsonResponse::class);

    //convert JSON to Array
    $responseContent = json_decode($response->getContent(), true);

    expect($responseContent)
        ->toHaveKey('success', false)
        ->toHaveKey('code', 401)
        ->toHaveKey('message','Unauthorized');


});
