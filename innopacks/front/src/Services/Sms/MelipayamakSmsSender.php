<?php

namespace InnoShop\Front\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MelipayamakSmsSender implements SmsSenderInterface
{
    protected string $username;
    protected string $password;
    protected string $apiUrl;
    protected ?int $bodyId;

    public function __construct()
    {
        $this->username = config('sms.melipayamak.username', env('SMS_USERNAME', '09358233996sbz'));
        $this->password = config('sms.melipayamak.password', env('SMS_PASSWORD', '4kV34)0py099q'));
        $this->bodyId = config('sms.melipayamak.body_id', env('SMS_BODY_ID', null));
        
        // REST API endpoint for Base Service Number (خط خدماتی اشتراکی)
        // If bodyId is set, use BaseServiceNumber endpoint
        // Otherwise, use SendSimple for direct text messages
        if ($this->bodyId) {
            $this->apiUrl = config('sms.melipayamak.api_url', 'https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
        } else {
            // Use SendSimple for direct messages without pattern
            $this->apiUrl = config('sms.melipayamak.api_url', 'https://rest.payamak-panel.com/api/SendSMS/SendSimple');
        }
    }

    public function send(string $phone, string $message): bool
    {
        try {
            // Normalize phone number (remove spaces, ensure it starts with 0)
            $phone = $this->normalizePhone($phone);

            // Prepare parameters based on API endpoint
            if ($this->bodyId) {
                // Use BaseServiceNumber endpoint (requires bodyId)
                // For SendByBaseNumber/SendByBaseNumber2: text should contain variables separated by semicolon
                // Example: if pattern has {code}, send: "123456" or just the code
                $params = [
                    'username' => $this->username,
                    'password' => $this->password,
                    'to' => $phone,
                    'bodyId' => $this->bodyId,
                    'text' => $message, // Variables separated by semicolon for SendByBaseNumber2 format
                ];
            } else {
                // Use SendSimple for direct text messages (without pattern)
                // Note: For OTP, it's recommended to use BaseServiceNumber with bodyId
                $params = [
                    'username' => $this->username,
                    'password' => $this->password,
                    'to' => $phone,
                    'from' => config('sms.melipayamak.from', '5000'), // Sender number
                    'text' => $message,
                ];
            }

            $response = Http::timeout(30)->post($this->apiUrl, $params);

            $statusCode = $response->status();
            $result = $response->json() ?? $response->body();

            // Parse response according to Payamoon API documentation
            if ($statusCode === 200) {
                // For BaseServiceNumber API, response format is:
                // { "RetStatus": 1, "StrRetStatus": "OK", "Value": "message_id_or_error_code" }
                if (is_array($result)) {
                    $retStatus = $result['RetStatus'] ?? null;
                    $strRetStatus = $result['StrRetStatus'] ?? null;
                    $value = $result['Value'] ?? null;

                    // Success: RetStatus = 1 and StrRetStatus = "OK"
                    // Or Value contains a number > 15 digits (message ID)
                    if ($retStatus === 1 && strtoupper($strRetStatus) === 'OK') {
                        Log::info('SMS sent successfully', [
                            'phone' => $phone,
                            'message_id' => $value,
                            'response' => $result
                        ]);
                        return true;
                    } elseif (is_string($value) && strlen($value) > 15 && is_numeric($value)) {
                        // Message ID received (more than 15 digits)
                        Log::info('SMS sent successfully', [
                            'phone' => $phone,
                            'message_id' => $value,
                            'response' => $result
                        ]);
                        return true;
                    } else {
                        // Error code received
                        $errorCode = is_numeric($value) ? (int)$value : $value;
                        $errorMessage = $this->getErrorMessage($errorCode);
                        Log::error('SMS sending failed', [
                            'phone' => $phone,
                            'error_code' => $errorCode,
                            'error_message' => $errorMessage,
                            'response' => $result
                        ]);
                        return false;
                    }
                } elseif (is_string($result) && strlen($result) > 15 && is_numeric($result)) {
                    // Direct numeric response (message ID > 15 digits)
                    Log::info('SMS sent successfully', [
                        'phone' => $phone,
                        'message_id' => $result
                    ]);
                    return true;
                } elseif (is_numeric($result)) {
                    // Numeric error code
                    $errorCode = (int)$result;
                    $errorMessage = $this->getErrorMessage($errorCode);
                    Log::error('SMS sending failed', [
                        'phone' => $phone,
                        'error_code' => $errorCode,
                        'error_message' => $errorMessage
                    ]);
                    return false;
                }
            }

            Log::error('SMS sending failed', [
                'phone' => $phone,
                'status_code' => $statusCode,
                'response' => $result,
                'api_url' => $this->apiUrl
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('SMS sending exception', [
                'phone' => $phone,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Get error message based on Payamoon API error codes
     */
    protected function getErrorMessage($errorCode): string
    {
        $errors = [
            0 => 'نام کاربری یا رمز عبور صحیح نمی باشد',
            -1 => 'دسترسی برای استفاده از این وبسرویس غیرفعال است',
            -2 => 'محدودیت تعداد شماره، محدودیت هر بار ارسال 1 شماره موبایل می باشد',
            -3 => 'خط ارسالی در سیستم تعریف نشده است',
            -4 => 'کد متن ارسالی صحیح نمی باشد یا توسط مدیر سامانه تایید نشده است',
            -5 => 'متن ارسالی با توجه به متغیرهای مشخص شده در متن پیشفرض همخوانی ندارد',
            -6 => 'خطای داخلی رخ داده است',
            -7 => 'متن حاوی کلمه فیلتر شده می باشد',
            -8 => 'متن ارسالی طبق راهنمای مستندات باید با @ شروع شود (برای SendByBaseNumber3)',
            -9 => 'خط ارسالی در سیستم تعریف نشده است',
            -10 => 'ممنوعیت ارسال لینک در متغیرها یا کاربر مورد نظر فعال نمی باشد',
            2 => 'اعتبار کافی نمی باشد',
            6 => 'سامانه در حال بروزرسانی می باشد',
            7 => 'متن حاوی کلمه فیلتر شده می باشد',
            10 => 'کاربر مورد نظر فعال نمی باشد',
            11 => 'ارسال نشده',
            12 => 'مدارک کاربر کامل نمی باشد',
            18 => 'شماره موبایل معتبر نمی باشد',
        ];

        return $errors[$errorCode] ?? "خطای ناشناخته با کد: {$errorCode}";
    }

    protected function normalizePhone(string $phone): string
    {
        // Remove spaces, dashes, and other non-numeric characters except +
        $phone = preg_replace('/[^+0-9]/', '', $phone);

        // Convert +98 to 0 format if needed
        if (str_starts_with($phone, '+98')) {
            $phone = '0' . substr($phone, 3);
        } elseif (str_starts_with($phone, '98') && !str_starts_with($phone, '098')) {
            $phone = '0' . substr($phone, 2);
        }

        // Ensure phone starts with 0
        if (!str_starts_with($phone, '0')) {
            $phone = '0' . $phone;
        }

        return $phone;
    }
}

