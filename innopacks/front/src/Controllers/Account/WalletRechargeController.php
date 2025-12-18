<?php
namespace InnoShop\Front\Controllers\Account;

use App\Models\WalletRecharge;
use Illuminate\Http\Request;
use InnoShop\Front\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletRechargeController extends BaseController
{
    // فرم شارژ
    public function form()
    {
        return view('account.wallet_recharge');
    }
    
    // آغاز پرداخت
    public function pay(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1000']);
        $customer = current_customer();
        $recharge = WalletRecharge::create([
            'customer_id' => $customer->id,
            'amount' => $request->amount,
            'status' => WalletRecharge::STATUS_PENDING,
            'gateway' => 'zarinpal',
        ]);

        // نمونه ساده پرداخت زرین پال
        // Resolve Zarinpal from the container so the configured merchant ID and driver are injected.
        // The vendor library requires constructor params and a service provider binds the key 'Zarinpal'.
        try {
            $zp = app('Zarinpal');
        } catch (\Throwable $e) {
            Log::error('Zarinpal binding not available: ' . $e->getMessage());
            $recharge->status = WalletRecharge::STATUS_FAILED;
            $recharge->error = 'درگاه پرداخت پیکربندی نشده است';
            $recharge->save();
            return back()->withErrors(['amount' => 'درگاه پرداخت پیکربندی نشده است']);
        }
        $desc = 'شارژ کیف پول';
        $result = $zp->request(
            url(route('front.account.wallet.recharge.callback', [$recharge->id])),
            $recharge->amount,
            $desc,
            $customer->email,
            $customer->mobile
        );
        if ($result['status'] == 100) {
            $recharge->authority = $result['authority'];
            $recharge->save();
            return redirect($zp->redirectUrl($result['authority']));
        } else {
            $recharge->status = WalletRecharge::STATUS_FAILED;
            $recharge->error = $result['error'];
            $recharge->save();
            return back()->withErrors(['amount' => $result['error']]);
        }
    }

    //callback
    public function callback(Request $request, $id)
    {
        $recharge = WalletRecharge::findOrFail($id);
        if (!$request->has('Authority')) {
            return redirect()->route('account.wallet.index')->withErrors(['msg'=>'تراکنش نامعتبر']);
        }
        try {
            $zp = app('Zarinpal');
        } catch (\Throwable $e) {
            Log::error('Zarinpal binding not available on callback: ' . $e->getMessage());
            $recharge->status = WalletRecharge::STATUS_FAILED;
            $recharge->save();
            return redirect()->route('account.wallet.index')->withErrors(['msg'=>'درگاه پرداخت پیکربندی نشده است']);
        }
        $status = $request->input('Status');
        if ($status == 'OK') {
            $result = $zp->verify($recharge->authority, $recharge->amount);
            if ($result['status'] == 100) {
                DB::transaction(function () use ($recharge, $result) {
                    $recharge->status = WalletRecharge::STATUS_PAID;
                    $recharge->ref_id = $result['ref_id'];
                    $recharge->paid_at = now();
                    $recharge->save();
                    // تراکنش کیف پول ثبت شود:
                    $customer = $recharge->customer;
                    $customer->transactions()->create([
                        'amount' => $recharge->amount,
                        'type' => 'recharge',
                        'comment' => 'شارژ موفق از زرین پال: ' . $result['ref_id'],
                    ]);
                    $customer->syncBalance();
                });
                return redirect()->route('account.wallet.index')->with('success', 'شارژ با موفقیت انجام شد');
            } else {
                $recharge->status = WalletRecharge::STATUS_FAILED;
                $recharge->error = $result['error'];
                $recharge->save();
                return redirect()->route('account.wallet.index')->withErrors(['msg'=>$result['error']]);
            }
        } else {
            $recharge->status = WalletRecharge::STATUS_FAILED;
            $recharge->save();
            return redirect()->route('account.wallet.index')->withErrors(['msg'=>'پرداخت لغو شد']);
        }
    }
}
