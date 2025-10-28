@extends('panel::layouts.app')

@section('content')
  <div class="container-fluid">
    <h3>{{ __('Zarinpal::fa.name') }} - پرداخت‌ها</h3>
    <div class="card">
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>سفارش</th>
              <th>مبلغ</th>
              <th>وضعیت</th>
              <th>ارجاع (RefID)</th>
              <th>زمان</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
              <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->order->number ?? '-' }}</td>
                <td>{{ $payment->amount_format }}</td>
                <td>{{ $payment->paid ? 'موفق' : 'ناموفق' }}</td>
                <td>{{ data_get($payment->reference, 'ref_id', '-') }}</td>
                <td>{{ $payment->created_at }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{ $payments->links() }}
      </div>
    </div>
  </div>
@endsection
