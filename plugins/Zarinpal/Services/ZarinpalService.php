<?php

namespace Plugin\Zarinpal\Services;

use Exception;
use InnoShop\Front\Services\PaymentService;
use InnoShop\Common\Models\Order;
use Illuminate\Support\Facades\Log;

class ZarinpalService extends PaymentService
{
    protected array $setting;

    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->setting = plugin_setting('zarinpal');
    }

    public function getPaymentUrl(): array
    {
        $order = $this->order;
        // Use order total in order currency. Zarinpal expects integer amount (unit depends on your account currency).
        $amount = (int) round($order->total);

        $callbackUrl = front_route('zarinpal.callback', ['order_number' => $order->number]);

        $callbackUrl = str_replace("localhost:8000", "localhost:3000", $callbackUrl);
        $description = "Payment for order {$order->number}";

        $requestData = [
            'merchant_id' => $this->setting['merchant_id'] ?? '',
            'amount'     => $amount,
            'callback_url' => $callbackUrl,
            'description' => $description,
        ];

        $endpoint = $this->setting['sandbox_mode'] ? 'https://sandbox.zarinpal.com/pg/v4/payment/request.json' : 'https://api.zarinpal.com/pg/v4/payment/request.json';

        Log::info('zarinpal.request', ['endpoint' => $endpoint, 'payload' => $requestData, 'order' => $order->number]);
        $result = $this->postJson($endpoint, $requestData);
        Log::info('zarinpal.response', ['endpoint' => $endpoint, 'response' => $result, 'order' => $order->number]);

        if (isset($result['data'])) {
            $result = $result['data'];
        }

        if (! isset($result['code']) || $result['code'] != 100) {
            throw new Exception('Zarinpal request failed: ' . json_encode($result));
        }

        $authority = $result['authority'];
        $payUrl = $this->setting['sandbox_mode'] ? 'https://sandbox.zarinpal.com/pg/StartPay/' . $authority : 'https://www.zarinpal.com/pg/StartPay/' . $authority;

        return ['url' => $payUrl, 'authority' => $authority];
    }

    public function verify(array $query): array
    {
        // Expect 'Authority' and 'Status'
        $authority = $query['Authority'] ?? null;
        $status = $query['Status'] ?? null;

        if ($status !== 'OK') {
            return ['ok' => false, 'message' => 'Payment not successful'];
        }

        $amount = (int) round($this->order->total);
        $endpoint = $this->setting['sandbox_mode'] ? 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json' : 'https://api.zarinpal.com/pg/v4/payment/verify.json';

        $requestData = [
            'merchant_id' => $this->setting['merchant_id'] ?? '',
            'authority'  => $authority,
            'amount'     => $amount,
        ];

        Log::info('zarinpal.verify.request', ['endpoint' => $endpoint, 'payload' => $requestData, 'order' => $this->order->number]);
        $result = $this->postJson($endpoint, $requestData);
        Log::info('zarinpal.verify.response', ['endpoint' => $endpoint, 'response' => $result, 'order' => $this->order->number]);

        if (isset($result['data'])) {
            $result = $result['data'];
        }
        if (! isset($result['code'])) {
            return ['ok' => false, 'message' => 'Invalid Zarinpal response'];
        }

        if ($result['code'] == 100 || $result['code'] == 101) {
            return ['ok' => true, 'ref_id' => $result['RefID'] ?? null];
        }

        return ['ok' => false, 'message' => 'Zarinpal verification failed: ' . json_encode($result)];
    }

    protected function postJson(string $url, array $data): array
    {
        $payload = json_encode($data);

        // Try using curl if available
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $resp = curl_exec($ch);
            Log::error($resp);
            curl_close($ch);
            return json_decode($resp, true) ?: [];
        }

        // fallback to file_get_contents
        $opts = ['http' => ['method'  => 'POST', 'header'  => "Content-Type: application/json\r\n", 'content' => $payload]];
        $context = stream_context_create($opts);
        $resp = @file_get_contents($url, false, $context);

        return json_decode($resp, true) ?: [];
    }
}
