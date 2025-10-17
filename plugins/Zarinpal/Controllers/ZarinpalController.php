<?php
namespace Plugin\Zarinpal\Controllers;

use App\Http\Controllers\Controller;
use AWS\CRT\Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as FacadesLog;
use InnoShop\Common\Repositories\OrderRepo as OrderRepoClass;
use InnoShop\Common\Repositories\Order\PaymentRepo;
use InnoShop\Common\Services\StateMachineService;
use InnoShop\Common\Repositories\OrderRepo;
use Plugin\Zarinpal\Services\ZarinpalService;

class ZarinpalController extends Controller
{
    /**
     * Create payment and return redirect URL
     */
    public function create(Request $request)
    {
        $requestData = json_decode($request->getContent(), true) ?: [];
        $orderNumber = $requestData['orderNumber'] ?? ($request->get('orderNumber') ?? '');

        $order = OrderRepo::getInstance()->getOrderByNumber($orderNumber);
        if (! $order) {
            return response()->json(['error' => 'order_not_found'], 404);
        }

        $service = new ZarinpalService($order);
        $data = $service->getPaymentUrl();

        // Store the request to payment repo for traceability
        try {
            \InnoShop\Common\Repositories\Order\PaymentRepo::getInstance()->createOrUpdatePayment($order->id, ['request' => ['authority' => $data['authority'], 'payload' => $data]]);
        } catch (\Exception $e) {
            // ignore save error but log
            \Illuminate\Support\Facades\Log::error('zarinpal.create.save_failed', ['order' => $order->number, 'error' => $e->getMessage()]);
        }

        return response()->json(['url' => $data['url'], 'authority' => $data['authority']]);
    }

    /**
     * Callback from Zarinpal
     */
    public function callback(Request $request)
    {
        FacadesLog::info(['Callback Info => ', $request->all()]);
        $orderNumber = $request->get('order_number') ?: $request->get('orderNumber');
        $order = OrderRepo::getInstance()->getOrderByNumber($orderNumber);

        if (! $order) {
            return redirect(front_route('payment.fail', ['order_number' => $orderNumber]));
        }

        $service = new ZarinpalService($order);
        $verify = $service->verify($request->all());

        // Persist request and verification response using PaymentRepo and use StateMachine to change status
        try {
            DB::beginTransaction();

            // store request payload
            PaymentRepo::getInstance()->createOrUpdatePayment($order->id, ['request' => $request->all()]);

            if ($verify['ok']) {
                // store verification response and ref id
                PaymentRepo::getInstance()->createOrUpdatePayment($order->id, ['response' => $verify, 'paid' => true, 'reference' => ['ref_id' => $verify['ref_id'] ?? null]]);

                // change order status to PAID via state machine
                StateMachineService::getInstance($order)->setPayment(['amount' => $order->total, 'reference' => ['ref_id' => $verify['ref_id'] ?? null]])->changeStatus(StateMachineService::PAID);

                DB::commit();

                return redirect(front_route('payment.success', ['order_number' => $order->number]));
            }

            DB::rollBack();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect(front_route('payment.fail', ['order_number' => $order->number]));
    }

    /**
     * Server-to-server notify
     */
    public function notify(Request $request)
    {
        // Zarinpal notify payload may vary; we'll treat it similar to callback verification
        $orderNumber = $request->get('order_number') ?: $request->get('orderNumber');
        $order = OrderRepo::getInstance()->getOrderByNumber($orderNumber);

        if (! $order) {
            return response('order_not_found', 404);
        }

        $service = new ZarinpalService($order);
        $verify = $service->verify($request->all());

        try {
            \InnoShop\Common\Repositories\Order\PaymentRepo::getInstance()->createOrUpdatePayment($order->id, ['request' => $request->all()]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('zarinpal.notify.save_failed', ['order' => $order->number, 'error' => $e->getMessage()]);
        }

        if ($verify['ok']) {
            try {
                \InnoShop\Common\Repositories\Order\PaymentRepo::getInstance()->createOrUpdatePayment($order->id, ['response' => $verify, 'paid' => true, 'reference' => ['ref_id' => $verify['ref_id'] ?? null]]);
                \InnoShop\Common\Services\StateMachineService::getInstance($order)->setPayment(['amount' => $order->total, 'reference' => ['ref_id' => $verify['ref_id'] ?? null]])->changeStatus(\InnoShop\Common\Services\StateMachineService::PAID);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('zarinpal.notify.process_failed', ['order' => $order->number, 'error' => $e->getMessage()]);
            }
            return response('OK', 200);
        }

        return response('FAILED', 400);
    }
}
