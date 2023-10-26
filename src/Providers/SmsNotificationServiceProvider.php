<?php

namespace AlifSmsNotification\Providers;

use Illuminate\Support\ServiceProvider;

class SmsNotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $config = config_path('sms-notification.php');
        $localConfig = __DIR__ . '/../../config/sms-notification.php';

        if (!file_exists($config)) {
            copy($localConfig, $config);
        }

        $this->publishes([
            $localConfig => $config,
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/sms-notification.php', 'sms-notification');
    }
}
