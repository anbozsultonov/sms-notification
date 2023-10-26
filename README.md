# CELL PHONE SMS NOTIFICATION

> prerequisites

<u>To use this package you need:</u>
- composer 2.2 and above
- php 8.1 and above
- guzzlehttp/guzzle
- laravel 9 and above

> Installation

install package by running the below commands:

````
 composer require alif/alif-sms-notification
````

it will create and past the following code in the file named `config/sms-notification.php`

````
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
````

> Usage

-  simple send
````
$smsSender = new SmsNotificationSender();

$smsSender->from('John Doe')
    ->to('123456789')
    ->send('Message text');
````

-  send async

````
$smsSender = new SmsNotificationSender();

$smsSender->from('John Doe')
    ->to('123456789')
    ->sendAsinc('Message text');
````
- handle exceptions

````
$smsSender = new SmsNotificationSender();

$smsSender->from('John Doe')
    ->to('123456789')    
    ->onFail(function(Exception $e) {
        // do something ...
    })->onSuccess(function(ResponseInterface $response) {
        // do smth ...
    })->send('Message text');

````



- with headers

````
$smsSender = new SmsNotificationSender();

$smsSender->from('John Doe')
    ->to('123456789')    
    ->headers($headers)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text');
````



- set priority
 ````
 $smsSender->from('John Doe')
    ->to('123456789')    
    ->priority(int $priority)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text'); 

````

- set expiresIn
````
$smsSender->from('John Doe')
    ->to('123456789')    
    ->expiresIn($expiresIn)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text'); 
````

- set countryCode
 ````
 $smsSender->from('John Doe')
    ->to('123456789')
    ->countryCode($countryCode)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text');                
````