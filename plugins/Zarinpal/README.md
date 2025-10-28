ZarinPal payment plugin for InnoShop

Installation
- Place the plugin under `plugins/Zarinpal`
- Configure merchant id in admin panel (Settings -> Plugins -> Zarinpal)

How it works
- On pay, the plugin requests an Authority from ZarinPal and redirects the user to the gateway URL.
- ZarinPal redirects back to `/zarinpal/callback` with Authority and Status, then plugin verifies the payment.

Notes
- This implementation uses cURL or file_get_contents for HTTP calls. For production consider error handling, logging and verification of amounts/currencies.

Testing (sandbox)
- Set `sandbox_mode` = true in plugin settings and enter your sandbox `merchant_id`.
- Create an order in the frontend with billing_method_code = `zarinpal` and click pay.
- After completing the sandbox payment, ZarinPal will redirect to `/zarinpal/callback?Authority=...&Status=OK&order_number=...`.

Server notifications
- If you want server-to-server notifications, configure ZarinPal to POST to `/zarinpal/notify` (this plugin exposes that endpoint). The notify handler will verify and mark the order as paid.

Notes
- For production use consider switching HTTP calls to Guzzle and enabling robust logging/monitoring.
