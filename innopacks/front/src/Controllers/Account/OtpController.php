<?php

namespace InnoShop\Front\Controllers\Account;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InnoShop\Common\Models\Customer;
use InnoShop\Common\Services\CartService;
use InnoShop\Front\Requests\OtpRequest;
use InnoShop\Front\Requests\VerifyOtpRequest;
use InnoShop\Front\Services\Sms\SmsSenderInterface;

class OtpController extends Controller
{
 protected SmsSenderInterface $smsSender;

 public function __construct(SmsSenderInterface $smsSender)
 {
  $this->smsSender = $smsSender;
 }

 /**
  * Request OTP to be sent to a phone number.
  */
 public function request(OtpRequest $request): mixed
 {
  try {
   $phone = $this->normalizePhone($request->get('phone'));

   // Rate limit: allow one send per 60 seconds per phone
   $lastKey = "sms_otp_last:{$phone}";
   if (Cache::has($lastKey)) {
    return json_fail(front_trans('login.otp_sent_recently'));
   }

   $code = $this->generateCode();
   $key  = "sms_otp:{$phone}";

   // Store code in cache for 5 minutes
   Cache::put($key, $code, now()->addMinutes(5));
   Cache::put($lastKey, true, now()->addSeconds(60));

   $message = str_replace(['{code}'], [$code], front_trans('login.otp_message'));

   $this->smsSender->send($phone, $message);

   return json_success(front_trans('login.otp_sent'));
  } catch (Exception $e) {
   Log::error('otp.request.failed', ['error' => $e->getMessage()]);

   return json_fail($e->getMessage());
  }
 }

 /**
  * Verify OTP and login/create customer if necessary.
  */
 public function verify(VerifyOtpRequest $request): mixed
 {
  try {
   $phone = $this->normalizePhone($request->get('phone'));
   $code  = $request->get('code');

   $key    = "sms_otp:{$phone}";
   $cached = Cache::get($key);

   if (! $cached || $cached !== $code) {
    return json_fail(front_trans('login.otp_invalid'));
   }

   // find customer by phone
   $customer = Customer::where('phone', $phone)->first();
   if (! $customer) {
    // Optionally auto-create a customer record. We'll create a minimal account.
    $customer = Customer::create([
     'email'    => "{$phone}@phone.local",
     'password' => '',
     'name'     => substr($phone, -6),
     'phone'    => $phone,
     'active'   => true,
    ]);
   }

   // login the customer
   auth('customer')->loginUsingId($customer->id);

   // merge cart
   $oldGuestId = session('guest_id') ?? null;
   CartService::getInstance(current_customer_id())->mergeCart($oldGuestId);

   // cleanup
   Cache::forget($key);

   $redirectUri = session('front_redirect_uri');
   session()->forget('front_redirect_uri');

   return json_success(front_trans('login.login_success'), ['redirect_uri' => $redirectUri]);
  } catch (Exception $e) {
   Log::error('otp.verify.failed', ['error' => $e->getMessage()]);

   return json_fail($e->getMessage());
  }
 }

 protected function generateCode(): string
 {
  return (string) random_int(100000, 999999);
 }

 protected function normalizePhone(string $phone): string
 {
  // Basic normalization: remove spaces, dashes. Caller should ensure E.164 ideally.
  return preg_replace('/[^+0-9]/', '', $phone);
 }
}
