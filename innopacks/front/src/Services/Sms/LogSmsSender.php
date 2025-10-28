<?php
namespace InnoShop\Front\Services\Sms;

use Illuminate\Support\Facades\Log;

class LogSmsSender implements SmsSenderInterface
{
    public function send(string $phone, string $message): bool
    {
        // Default behaviour: log SMS instead of sending. Real provider can be implemented later.
        Log::info('SMS_SEND', ['phone' => $phone, 'message' => $message]);
        return true;
    }
}
