@php
  $order = $order ?? null;
  $setting = $payment_setting ?? plugin_setting('zarinpal');
  $sandbox = $setting['sandbox_mode'] ?? false;
@endphp

<div class="mt-4">
  <button id="zarinpayBtn" class="btn btn-primary">{{ __('front/payment.pay_now') }}</button>
</div>

<script>
  $('#zarinpayBtn').on('click', function() {
    const token = $('meta[name="csrf-token"]').attr('content');
    layer.load(2, {
      shade: [0.3, '#fff']
    });
    fetch('{{ front_route('zarinpal.create') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': token
      },
      body: JSON.stringify({
        orderNumber: '{{ $order->number }}'
      })
    }).then(r => r.json()).then(function(data) {
      layer.closeAll('loading');
      if (data.url) {
        window.location.href = data.url;
      } else {
        layer.alert('خطا در ایجاد پرداخت', {
          title: 'خطا'
        });
      }
    }).catch(function() {
      layer.closeAll('loading');
      layer.alert('خطا در اتصال', {
        title: '{{ __('front/common.error') }}',
        btn: ['{{ __('front/common.confirm') }}']
      });
    });
  });
</script>
