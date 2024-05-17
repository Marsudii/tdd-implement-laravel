<?php

test('Test Coverage 100% Tidak Menjamin', function () {

    $mathController = new \App\Http\Controllers\API\Math();


    $result1 = $mathController->pembagian(4, 2);
    expect($result1)->toBe(2);














});


