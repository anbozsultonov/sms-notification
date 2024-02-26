# CELL PHONE SMS NOTIFICATION

> prerequisites

<u>To use this package you need:</u>
- composer 2.2 and above
- php 8.1 and above
- guzzlehttp/guzzle
- laravel 9 and above

> Installation

install package by running the below commands:

```
 composer require alif/alif-sms-notification
```

it will create and past the following code in the file named `config/sms-notification.php`

```php
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
```

> Usage

-  simple send
```php
$smsSender = new SmsNotificationSender(); 
//OR
$smsSender = SmsNotificationSender::make(); 

$smsSender->from('John Doe')
    ->to('123456789')
    ->send('Message text');
    
//or
SmsNotificationSender::make()
    ->from('John Doe')
    ->to('123456789')
    ->send('Message text');    
```

-  send async

```php
$smsSender = new SmsNotificationSender();
//OR
$smsSender = SmsNotificationSender::make(); 

$smsSender->from('John Doe')
    ->to('123456789')
    ->sendAsinc('Message text');
```
- handle exceptions

```php
$smsSender = SmsNotificationSender::make();

$smsSender->from('John Doe')
    ->to('123456789')    
    ->onFail(function(Exception $e) {
        // do something ...
    })->onSuccess(function(ResponseInterface $response) {
        // do smth ...
    })->send('Message text');

```



- with headers

```php
$smsSender = SmsNotificationSender::make();

$smsSender->from('John Doe')
    ->to('123456789')    
    ->headers($headers)
    ->onFail(function(Exception $e) {
        //...
    })->onSuccess(function(ResponseInterface $response) {
        //...
    })->send('Message text');
```



- set priority
- priority: integer|min:0|max:2
![img_1.png](img_1.png)
 ```php
 $smsSender = SmsNotificationSender::make();
 
 $smsSender->from('John Doe')
    ->to('123456789')    
    ->priority($priority)
    ->onFail(function(Exception $e) {
        //...
    })->onSuccess(function(ResponseInterface $response) {
        //...
    })->send('Message text'); 

```

- set expiresIn
```php
$smsSender->from('John Doe')
    ->to('123456789')    
    ->expiresIn($expiresIn)
    ->onFail(function(Exception $e) {
        //...
    })->onSuccess(function(ResponseInterface $response) {
        //...
    })->send('Message text'); 
```

- set countryCode
 ```php
 $smsSender->from('John Doe')
    ->to('123456789')
    ->countryCode($countryCode)
    ->onFail(function(Exception $e) {
        //...
    })->onSuccess(function(ResponseInterface $response) {
        //...
    })->send('Message text');                
```