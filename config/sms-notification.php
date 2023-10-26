<?php

return [
    'host' => env('SMS_NOTIFICATION_HOST'),
    'method' => 'POST',
    'headers' => [
        'X-Api-Key' => env('SMS_NOTIFICATION_API_KEY'),
        'Content-type' => 'application/json',
        'charset' => 'utf-8'
    ],

    'routes' => [
        'send_sms' => '/api/v1/Sms'
    ],
];
