<?php

namespace AlifSmsNotification\UseCases;

use Closure;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ResponseInterface;

class SmsNotificationSender
{
    private bool $successClosureCalled = false;

    private bool $failClosureCalled = false;

    private string $url;

    private string $method;

    private array $options = [
        'json' => [
            'PhoneNumber' => null,
            'SenderAddress' => null,
            'text' => null,
            'priority' => 2,
            'ExpiresIn' => 0,
            'sms_type' => 1
        ],
        'headers' => []
    ];

    private string $countryCode = '992';

    private ?Closure $onSuccessClosure = null;

    private ?Closure $onFailClosure = null;

    private ?ResponseInterface $response = null;

    private ?Exception $exception = null;

    public function __construct()
    {
        $config = config('sms-notification');

        $this->url = $config['host'] . $config['routes']['send_sms'];
        $this->method = $config['method'];
        $this->options['headers'] = $config['headers'];
    }

    public function send(string $text): SmsNotificationSender
    {
        try {
            $this->options['json']['text'] = $text;

            $this->validateOptions();

            $client = new Client(['base_uri' => $this->url]);
            $response = $client->request($this->method, '', $this->options);

            $this->response = $response;

            $this->callSuccess();
        } catch (Exception $exception) {
            $this->exception = $exception;

            $this->callFail();
        }
        return $this;
    }

    public function headers(array $headers): SmsNotificationSender
    {
        $this->options['headers'] = $headers;

        return $this;
    }

    public function from(string $from): SmsNotificationSender
    {
        $this->options['json']['SenderAddress'] = $from;

        return $this;
    }

    public function to(string $phone): SmsNotificationSender
    {
        if (\strlen($phone) <= 9) {
            $phone = $this->countryCode . $phone;
        }

        $this->options['json']['PhoneNumber'] = trim($phone);

        return $this;
    }

    public function onSuccess(Closure $onSuccessClosure): SmsNotificationSender
    {
        $this->onSuccessClosure = $onSuccessClosure;

        return $this;
    }

    public function onFail(Closure $onFailClosure): SmsNotificationSender
    {
        $this->onFailClosure = $onFailClosure;

        return $this;
    }

    public function priority(int $priority = 2): SmsNotificationSender
    {
        $this->options['json']['priority'] = $priority;

        return $this;
    }

    public function expiresIn(int $expiresIn = 0): SmsNotificationSender
    {
        $this->options['json']['ExpiresIn'] = $expiresIn;

        return $this;
    }

    public function smsType(int $smsType = 1): SmsNotificationSender
    {
        $this->options['json']['sms_type'] = $smsType;

        return $this;
    }

    public function countryCode(int $countryCode): SmsNotificationSender
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function withOptions(array $options): SmsNotificationSender
    {
        $this->options = $options;

        return $this;
    }

    private function callSuccess(): void
    {
        if (!$this->response) {
            return;
        }

        if (!$this->successClosureCalled && $onSuccessClosure = $this->onSuccessClosure) {
            $onSuccessClosure($this->response);
            $this->successClosureCalled = true;
        }
    }

    private function callFail(): void
    {
        if (!$this->exception) {
            return;
        }

        if (!$this->failClosureCalled && $onFileClosure = $this->onFailClosure) {
            $onFileClosure($this->exception);
            $this->failClosureCalled = true;
        }
    }

    private function validateOptions(): void
    {
        Validator::make($this->options['json'], [
            'PhoneNumber' => 'required|string',
            'SenderAddress' => 'required|string',
            'text' => 'required|string',
            'priority' => 'required|integer',
            'ExpiresIn' => 'required|integer',
            'sms_type' => 'required|integer'
        ])->validate();
    }

    public function __destruct()
    {
        $this->callSuccess();
        $this->callFail();
    }

    public function sendAsync(string $text): void
    {
        Bus::chain([
            function () use ($text): void {
                $this->send($text);
            }
        ])->dispatch();
    }
}
