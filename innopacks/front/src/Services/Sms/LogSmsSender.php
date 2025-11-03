<?php

namespace InnoShop\Front\Services\Sms;

use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Http;

class LogSmsSender implements SmsSenderInterface
{

    private $username, $password, $api, $templates;
    function configure()
    {
        $this->username = config('payamoon.username');
        $this->password = config('payamoon.password');
        $this->api      = config('payamoon.api');

        $templates = config('payamoon.templates');

        $this->templates = collect($templates);
    }

    private function getCommonData(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

    public function configureMissing(): bool
    {
        if (!$this->username || !$this->password || !$this->api) {
            $this->configure();
            return true;
        }
        return false;
    }


    public function send($to, $text): mixed
    {


        $sendSMSUrl = $this->api . "/SendSMS/SendSMS";
        $data = array_merge($this->getCommonData(), [
            'to'       => $to,
            'text'     => $text,
        ]);
        Log::info('SMS_SEND $data', ['data' => $data]);
        $response   = Http::post($sendSMSUrl, $data)->json();
        Log::info('SMS_SEND $response', ['response' => $response]);
        Log::info("------------------------------------------------------------------------");
        return $response;
    }

    public function sendSMSTemplate($templateName, $to, $params): mixed
    {
        $this->configureMissing();

        if (!$this->templates->has($templateName)) {
            throw new Exception("پترن پایامون " . $templateName . " یافت نشد");
        }
        $template = $templateCode = $this->templates->get($templateName);
        $templateSmsUrl = $this->api . "/SendSMS/BaseServiceNumber";

        $data = array_merge($this->getCommonData(), [
            'bodyId'       => $template['code'],
            'to'     => $to,
            'text' => implode(';', $params),
        ]);

        Log::info('SMS_SEND_TEMPLATE $data|$template', ['templateCode' => $templateCode, ...$data]);
        $response = Http::post($templateSmsUrl, $data)->json();
        Log::info('SMS_SEND_TEMPLATE $response', ['response' => $response]);
        Log::info('----------------------------------------');

        return $response;
    }
}
