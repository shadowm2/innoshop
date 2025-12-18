@extends('layouts.app')
@section('body-class', 'page-login')

@section('content')
  @if (!request('iframe'))
    <x-front-breadcrumb type="route" value="login.index" title="{{ __('front/account.login') }}" />
  @endif

  @hookinsert('account.login.top')

  <div class="container">
    <div class="login-register-box {{ request('iframe') ? 'iframe' : '' }}">
      <div class="login-title">{{ __('front/login.login') }}</div>
      <div class="login-sub-title">{{ __('front/login.login_text') }}</div>
      <form action="{{ front_route('login.store') }}" class="needs-validation form-wrap" novalidate>
        @csrf
        <div class="form-group mb-4">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('front/login.email') }}" />
          <span class="invalid-feedback" role="alert"><strong>{{ __('front/login.email_required') }}</strong></span>
        </div>

        <div class="form-group mb-4">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="new-password" placeholder="{{ __('front/login.password') }}" />
          <span class="invalid-feedback" role="alert"><strong>{{ __('front/login.password_required') }}</strong></span>
        </div>
        @if (!request('iframe'))
          <a href="{{ front_route('forgotten.index') }}"
            class="text-secondary mt-n2 d-block">{{ __('front/login.forget_password') }} <i
              class="bi bi-question-circle"></i></a>
        @endif

        <div class="btn-submit" style="display: flex !important; flex-direction: column; gap: 12px; width: 100%;">
          <button type="button" class="btn btn-primary form-submit btn-lg" style="width: 100% !important; display: block !important; visibility: visible !important;">{{ __('front/login.login_submit') }}</button>
          <a href="{{ front_route('register.index') }}{{ request('iframe') ? '?iframe=true' : '' }}" style="display: block !important; visibility: visible !important; text-align: center; padding: 8px 0;">{{ __('front/login.no_account') }}
            <i class="bi bi-arrow-up-right-square"></i></a>
        </div>
      </form>

      <div class="otp-section">
        <div class="login-title">{{ __('front/login.login_with_phone') }}</div>
        <div class="form-group mb-3">
          <input id="otp_phone" type="text" class="form-control" name="phone" placeholder="{{ __('front/login.phone') }}"/>
        </div>
        <div class="form-group mb-3" style="display: flex; flex-wrap: wrap; gap: 8px;">
          <input id="otp_code" type="text" class="form-control" placeholder="{{ __('front/login.code') }}" style="flex: 1 1 auto; min-width: 100%;"/>
          <button id="btn_request_otp" class="btn btn-outline-primary" style="flex: 1 1 48%; min-width: 48%; display: block !important; visibility: visible !important;">{{ __('front/login.request_code') }}</button>
          <button id="btn_verify_otp" class="btn btn-primary" style="flex: 1 1 48%; min-width: 48%; display: block !important; visibility: visible !important;">{{ __('front/login.verify_code') }}</button>
        </div>
      </div>

      @include('account/_social')

    </div>
  </div>

  @hookinsert('account.login.bottom')

@endsection

@push('footer')
  <script>
    const iframe = @json(request('iframe', false));

    inno.validateAndSubmitForm('.form-wrap', function(data) {
      layer.load(2, {
        shade: [0.3, '#fff']
      })
      axios.post($('.form-wrap').attr('action'), data).then(function(res) {
        if (res.success) {
          if (iframe) {
            setTimeout(() => {
              parent.layer.closeAll()
              parent.window.location.reload()
            }, 400);
          } else {
            layer.msg(res.message, {
              icon: 1
            })
            if (res.data.redirect_uri) {
              location.href = res.data.redirect_uri;
            } else {
              location.href = '{{ front_route('account.index') }}';
            }
          }
        } else {
          layer.msg(res.message, {
            icon: 2
          });
        }
      }).finally(function() {
        layer.closeAll('loading')
      });
    });
  </script>
  <script>
    // OTP handlers
    $('#btn_request_otp').on('click', function (e) {
      e.preventDefault();
      const phone = $('#otp_phone').val();
      if (!phone) {
        layer.msg('{{ __('front/login.phone_required') }}', {icon: 2});
        return;
      }
      layer.load(2, {shade: [0.3, '#fff']});
      const $btn = $(this);
      axios.post('{{ front_route('login.otp.request') }}', {phone: phone}).then(function (res) {
        if (res.success) {
          layer.msg(res.message, {icon: 1});
          startOtpCooldown($btn, 60);
        } else {
          layer.msg(res.message, {icon: 2});
        }
      }).finally(function () { layer.closeAll('loading') });
    });

    $('#btn_verify_otp').on('click', function (e) {
      e.preventDefault();
      const phone = $('#otp_phone').val();
      const code = $('#otp_code').val();
      if (!phone || !code) {
        layer.msg('{{ __('front/login.phone_and_code_required') }}', {icon: 2});
        return;
      }
      layer.load(2, {shade: [0.3, '#fff']});
      axios.post('{{ front_route('login.otp.verify') }}', {phone: phone, code: code}).then(function (res) {
        if (res.success) {
          layer.msg(res.message, {icon: 1});
          if (res.data.redirect_uri) {
            location.href = res.data.redirect_uri;
          } else {
            location.href = '{{ front_route('account.index') }}';
          }
        } else {
          layer.msg(res.message, {icon: 2});
        }
      }).finally(function () { layer.closeAll('loading') });
    });

    function startOtpCooldown($btn, seconds) {
      $btn.prop('disabled', true);
      const original = $btn.text();
      let remaining = seconds;
      $btn.text(original + ' (' + remaining + 's)');
      const t = setInterval(function () {
        remaining--;
        if (remaining <= 0) {
          clearInterval(t);
          $btn.prop('disabled', false);
          $btn.text(original);
          return;
        }
        $btn.text(original + ' (' + remaining + 's)');
      }, 1000);
    }
  </script>
@endpush
