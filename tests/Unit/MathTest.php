<?php

test('Test Coverage 100% Tidak Menjamin', function () {

    $mathController = new \App\Http\Controllers\API\Math();


    $result1 = $mathController->pembagian(4, 2);
    expect($result1)->toBe(2);


    $result2 = $mathController->pembagian(-4,2);
    expect($result2)->toBe(-2);


    $result3 = $mathController->pembagian(4,0);
    expect($result3)->toBe("Error Karena Zero");



});


