<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'profiles',
        ],
    ],

    'providers' => [
        'profiles' => [
            'driver' => 'eloquent',
            'model' => \App\Models\Profile::class,
        ],
    ],
];
