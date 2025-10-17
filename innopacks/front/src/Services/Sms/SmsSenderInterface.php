<?php
namespace InnoShop\Front\Services\Sms;

interface SmsSenderInterface
{
    /**
     * Send SMS to given phone with message.
     * Return true on success, false or throw exception on failure.
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function send(string $phone, string $message): bool;
}
