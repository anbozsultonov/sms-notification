## sms-notification


**installing**
````
composer require alif/alif-sms-notification
````
````
<?php

//config/sms-notification.php

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
# Use
````
$smsSender = SmsNotificationSender();

$smsSender->from('from')->to('123456789')->send('Message text');
//or 
$smsSender->from('from')->to('123456789')->sendAsinc('Message text');
// You can use withOptions(array $options)
//for changing request body
$smsSender->from('from')
    ->to('123456789')    
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text');

//set headers
$smsSender->from('from')
    ->to('123456789')    
    ->headers(array $headers)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text');
     
//set priority
 $smsSender->from('from')
    ->to('123456789')    
    ->priority(int $priority)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text'); 
    
//set expiresIn
$smsSender->from('from')
    ->to('123456789')    
    ->expiresIn(int $expiresIn)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text'); 
    
//set countryCode
 $smsSender->from('from')
    ->to('123456789')
    ->countryCode(string $countryCode)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    })->send('Message text');                
````