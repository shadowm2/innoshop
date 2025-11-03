<?php

return [
    'api' => 'http://rest.payamak-panel.com/api',
    'username' => env('PAYAMOON_USERNAME'),
    'password' => env('PAYAMOON_PASSWORD'),
    'from'     => env('PAYAMOON_FROM'),
    'isFlash'  => env('PAYAMOON_IS_FLASH', false),
    'templates' => [
        'auth-code' => [
            'code' => '388092'
        ]
    ]
];
