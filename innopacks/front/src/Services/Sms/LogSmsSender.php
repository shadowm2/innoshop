<?php

namespace InnoShop\Front\Services\Sms;

use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Http;

class LogSmsSender implements SmsSenderInterface
{

    private $from, $username, $password, $isFlash, $api, $templates;
    function configure()
    {
        // $this->from     = config('payamoon.from');
        $this->username = config('payamoon.username');
        $this->password = config('payamoon.password');
        // $this->isFlash  = config('payamoon.isFlash');
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


    public function send($to, $text): mixed
    {
        if (!$this->from || !$this->username || !$this->password || !$this->isFlash || !$this->api) {
            $this->configure();
        }

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
        if (!$this->from || !$this->username || !$this->password || !$this->isFlash || !$this->api) {
            $this->configure();
        }
        
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
