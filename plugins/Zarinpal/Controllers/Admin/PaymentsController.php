<?php
namespace Plugin\Zarinpal\Controllers\Admin;

use InnoShop\Common\Repositories\Order\PaymentRepo;
use InnoShop\Common\Repositories\OrderRepo;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = \InnoShop\Common\Models\Order\Payment::query()->with('order')->orderByDesc('id')->paginate(20);

        return view('Zarinpal::admin.payments', ['payments' => $payments]);
    }
}
