<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.sibzard.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace InnoShop\Front\Controllers\Account;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use InnoShop\Common\Repositories\Customer\TransactionRepo;
use InnoShop\Common\Repositories\Customer\WithdrawalRepo;
use InnoShop\Front\Controllers\BaseController;

class WalletController extends BaseController
{
    /**
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request): View
    {
        $customer        = current_customer();
        $transactionRepo = new TransactionRepo;
        $withdrawalRepo  = new WithdrawalRepo;

        // Sync and get correct balance information
        $customer->syncBalance();
        $balance          = $customer->balance;
        $freezeBalance    = $withdrawalRepo->getFrozenAmount($customer->id);
        $availableBalance = $balance - $freezeBalance;

        // Get recent transaction records
        $recentTransactions = $transactionRepo->builder(['customer_id' => $customer->id])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Get withdrawal statistics
        $withdrawalStats = [
            'pending'  => $withdrawalRepo->builder(['customer_id' => $customer->id, 'status' => 'pending'])->count(),
            'approved' => $withdrawalRepo->builder(['customer_id' => $customer->id, 'status' => 'approved'])->count(),
            'rejected' => $withdrawalRepo->builder(['customer_id' => $customer->id, 'status' => 'rejected'])->count(),
            'paid'     => $withdrawalRepo->builder(['customer_id' => $customer->id, 'status' => 'paid'])->count(),
        ];

        // Check if there are pending withdrawal requests
        $hasPendingWithdrawal = $withdrawalRepo->hasPendingWithdrawal($customer->id);

        $data = [
            'customer'               => $customer,
            'balance'                => $balance,
            'freeze_balance'         => $freezeBalance,
            'available_balance'      => $availableBalance,
            'recent_transactions'    => $recentTransactions,
            'withdrawal_stats'       => $withdrawalStats,
            'has_pending_withdrawal' => $hasPendingWithdrawal,
        ];

        return view('account.wallet_index', $data);
    }

    /**
     * نمایش فرم شارژ کیف پول
     */
    public function rechargeForm(Request $request): \Illuminate\Contracts\View\View
    {
        $customer = current_customer();
        return view('account.wallet_recharge', ['customer' => $customer]);
    }

    /**
     * ثبت درخواست و هدایت به درگاه پرداخت
     */
    public function rechargePay(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);
        $customer = current_customer();
        // فرض: جدول به نام customer_recharges یا مشابه آن ایجاد کنید - فعلا فقط ذخیره session و هدایت به صفحه پرداخت
        $recharge = [
            'customer_id' => $customer->id,
            'amount' => $request->input('amount'),
            'status' => 'pending',
            'comment' => 'شارژ کیف پول توسط درگاه',
            'created_at' => now(),
        ];
        session(['wallet_recharge' => $recharge]);
        // در این مرحله باید به پرداخت متصل شوید، موقتا به صفحه موفقیت پرداخت می‌فرستیم
        return redirect()->route('payment.success');
    }
}
