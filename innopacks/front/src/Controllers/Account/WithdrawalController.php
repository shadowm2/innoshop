<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.sibzard.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace InnoShop\Front\Controllers\Account;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use InnoShop\Common\Models\Customer\Withdrawal;
use InnoShop\Common\Repositories\Customer\WithdrawalRepo;
use InnoShop\Front\Controllers\BaseController;

class WithdrawalController extends BaseController
{
    /**
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request): View
    {
        $customer       = current_customer();
        $withdrawalRepo = new WithdrawalRepo;

        $withdrawals = $withdrawalRepo->getByCustomer($customer->id);

        $data = [
            'customer'    => $customer,
            'withdrawals' => $withdrawals,
        ];

        return view('account.withdrawals_index', $data);
    }

    /**
     * @param  Request  $request
     * @return View
     */
    public function create(Request $request): View
    {
        $customer       = current_customer();
        $withdrawalRepo = new WithdrawalRepo;

        // Check if there is a pending withdrawal request
        $hasPendingWithdrawal = $withdrawalRepo->hasPendingWithdrawal($customer->id);

        // Calculate available balance
        $customer->syncBalance();
        $balance          = $customer->balance;
        $freezeBalance    = $withdrawalRepo->getFrozenAmount($customer->id);
        $availableBalance = $balance - $freezeBalance;

        $data = [
            'customer'               => $customer,
            'available_balance'      => $availableBalance,
            'has_pending_withdrawal' => $hasPendingWithdrawal,
            'account_types'          => $this->getAccountTypeOptions(),
        ];

        return view('account.withdrawals_create', $data);
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        try {
            $customer       = current_customer();
            $withdrawalRepo = new WithdrawalRepo;
            // Normalize amount input to support localized digits and separators
            if ($request->has('amount')) {
                $raw = (string) $request->input('amount');
                // replace Arabic/Persian digits with ASCII
                $digitMap = [
                    '\u06F0'=>'0','\u06F1'=>'1','\u06F2'=>'2','\u06F3'=>'3','\u06F4'=>'4','\u06F5'=>'5','\u06F6'=>'6','\u06F7'=>'7','\u06F8'=>'8','\u06F9'=>'9',
                    '\u0660'=>'0','\u0661'=>'1','\u0662'=>'2','\u0663'=>'3','\u0664'=>'4','\u0665'=>'5','\u0666'=>'6','\u0667'=>'7','\u0668'=>'8','\u0669'=>'9',
                ];
                // apply replacements for Persian/Arabic digits (fallback to mb_ functions)
                $normalized = $raw;
                $normalized = str_replace(["\u00A0", ' '], '', $normalized); // remove NBSP and spaces
                // Replace Persian digits
                $persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
                $arabicDigits  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                foreach ($persianDigits as $i => $d) { $normalized = str_replace($d, (string)$i, $normalized); }
                foreach ($arabicDigits as $i => $d) { $normalized = str_replace($d, (string)$i, $normalized); }
                // Remove thousands separators (commas, thin space, Arabic thousands separator)
                $normalized = str_replace([',', '٬', ' ', "\u200F"], '', $normalized);
                // Replace comma decimal separator with dot
                $normalized = preg_replace('/,(?=\d{1,2}$)/u', '.', $normalized);
                // Trim
                $normalized = trim($normalized);
                // If resulting string is empty or not numeric, leave as-is (validation will catch)
                $request->merge(['amount' => $normalized]);
            }

            // Validate request data
            $validated = $request->validate([
                'amount'         => 'required|numeric|min:0.01',
                'account_type'   => 'required|in:'.implode(',', Withdrawal::ACCOUNT_TYPES),
                'account_number' => 'required|string|max:100',
                'bank_name'      => 'nullable|string|max:100',
                'bank_account'   => 'nullable|string|max:100',
                'comment'        => 'nullable|string|max:500',
            ]);

            // Check if there is a pending withdrawal request
            if ($withdrawalRepo->hasPendingWithdrawal($customer->id)) {
                return back()->withErrors(['amount' => trans('front/withdrawal.has_pending_withdrawal')]);
            }

            // Check if balance is sufficient
            $customer->syncBalance();
            $balance          = $customer->balance;
            $freezeBalance    = $withdrawalRepo->getFrozenAmount($customer->id);
            $availableBalance = $balance - $freezeBalance;
            if ($validated['amount'] > $availableBalance) {
                return back()->withErrors(['amount' => trans('front/withdrawal.insufficient_balance')]);
            }

            // Create withdrawal request
            $withdrawalData = [
                'customer_id'    => $customer->id,
                'amount'         => $validated['amount'],
                'account_type'   => $validated['account_type'],
                'account_number' => $validated['account_number'],
                'bank_name'      => $validated['bank_name'] ?? null,
                'bank_account'   => $validated['bank_account'] ?? null,
                'comment'        => $validated['comment'] ?? null,
                'status'         => Withdrawal::STATUS_PENDING,
            ];

            $withdrawal = $withdrawalRepo->create($withdrawalData);

            return redirect()
                ->route('account.wallet.withdrawals.index')
                ->with('success', trans('front/withdrawal.create_success'));

        } catch (Exception $e) {
            return back()
                ->withErrors(['error' => trans('front/withdrawal.create_failed')])
                ->withInput();
        }
    }

    /**
     * @param  Request  $request
     * @param  Withdrawal  $withdrawal
     * @return View
     */
    public function show(Request $request, Withdrawal $withdrawal): View
    {
        $customer = current_customer();

        // Ensure users can only view their own withdrawal requests
        if ($withdrawal->customer_id !== $customer->id) {
            abort(403);
        }

        $data = [
            'customer'   => $customer,
            'withdrawal' => $withdrawal,
        ];

        return view('account.withdrawals_show', $data);
    }

    /**
     * Get account type options
     *
     * @return array
     */
    private function getAccountTypeOptions(): array
    {
        $options = [];
        foreach (Withdrawal::ACCOUNT_TYPES as $type) {
            $options[] = [
                'value' => $type,
                'label' => trans('front/withdrawal.'.$type),
            ];
        }

        return $options;
    }
}
