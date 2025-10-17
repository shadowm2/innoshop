<?php

namespace Plugin\Zarinpal;

use Exception;

class Boot
{
    public function init(): void
    {
        // Provide mobile payment data hook if needed later
        listen_hook_filter('service.payment.mobile_pay.data', function ($data) {
            $order = $data['order'];
            if ($order->payment_method_code != 'zarinpal') {
                return $data;
            }

            // No mobile SDK for now; let PaymentService apiPay handle params
            return $data;
        });
    }
}
