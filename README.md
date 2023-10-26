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
    ->send('Message text')
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    });

//set headers
$smsSender->from('from')
    ->to('123456789')
    ->send('Message text')
    ->headers(array $headers)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    });
     
//set priority
 $smsSender->from('from')
    ->to('123456789')
    ->send('Message text')
    ->priority(int $priority)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    }); 
    
//set expiresIn
$smsSender->from('from')
    ->to('123456789')
    ->send('Message text')
    ->expiresIn(int $expiresIn)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    }); 
    
//set countryCode
 $smsSender->from('from')
    ->to('123456789')
    ->send('Message text')
    ->countryCode(string $countryCode)
    ->onFail(function(Exception $e){
        //...
    })->onSuccess(function(ResponseInterface $response){
        //...
    });                
````