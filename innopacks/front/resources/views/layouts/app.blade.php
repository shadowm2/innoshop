<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ front_locale_direction() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="{{ front_route('home.index') }}">
  <title>@yield('title', system_setting_locale('meta_title', 'InnoShop - سیستم تجارت الکترونیک منبع باز نوآورانه | سیستم سایت مستقل منبع باز | Laravel 12، پشتیبانی چند زبانه و چند ارزی'))</title>
  <meta name="description" content="@yield('description', system_setting_locale('meta_description', 'innoshop یک پلتفرم تجارت الکترونیک منبع باز نوآورانه است که بر اساس Laravel 12 توسعه یافته و دارای ویژگی‌های پشتیبانی چند زبانه و چند ارزی است. این سیستم از معماری افزونه‌ای قدرتمند و انعطاف‌پذیر مبتنی بر Hook استفاده می‌کند و قابلیت‌های غنی سفارشی‌سازی و توسعه را برای کاربران فراهم می‌کند. innoshop را تجربه کنید و پلتفرم تجارت الکترونیک خود را بسازید!'))">
  <meta name="keywords" content="@yield('keywords', system_setting_locale('meta_keywords', 'innoshop, نوآورانه, منبع باز, تجارت الکترونیک, تجارت الکترونیک بین‌المللی, سایت مستقل منبع باز, Laravel 12, چند زبانه, چند ارزی, Hook, معماری افزونه, انعطاف‌پذیر, قدرتمند'))">
  <meta name="generator" content="InnoShop {{ innoshop_version() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="api-token" content="{{ session('front_api_token') }}">
  <link rel="shortcut icon" href="{{ image_origin(system_setting('favicon', 'images/favicon.png')) }}">
  @if (front_locale_direction() == 'ltr')
    <link rel="stylesheet" href="{{ mix('build/front/css/bootstrap.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.rtl.min.css') }}">
  @endif
  <script src="{{ mix('build/front/js/app.js') }}"></script>
  <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('vendor/layer/3.5.1/layer.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <link rel="stylesheet" href="{{ mix('build/front/css/app.css') }}">
  <script>
    let urls = {
      api_base: '{{ route('api.home.base') }}',
      base_url: '{{ front_route('home.index') }}',
      upload_images: '{{ front_root_route('upload.images') }}',
      cart_add: '{{ front_route('carts.store') }}',
      cart_mini: '{{ front_route('carts.mini') }}',
      cart: '{{ front_route('carts.index') }}',
      checkout: '{{ front_route('checkout.index') }}',
      login: '{{ front_route('login.index') }}',
      favorites: '{{ account_route('favorites.index') }}',
      favorite_cancel: '{{ account_route('favorites.cancel') }}',
    }

    let config = {
      isLogin: !!{{ current_customer()->id ?? 'null' }},
      currency: {
        code: '{{ current_currency_code() }}',
        symbol_left: '{{ default_currency()->symbol_left ?? "$" }}',
        symbol_right: '{{ default_currency()->symbol_right ?? '' }}',
        decimal_place: {{ default_currency()->decimal_place ?? 2 }},
        rate: {{ default_currency()->value ?? 1 }}
      }
    }

    let asset_url = '{{ asset('') }}';
  </script>
  @stack('header')
  @hookinsert('front.layout.app.head.bottom')
</head>

<body class="@yield('body-class')">
  @if (!request('iframe'))
    <x-front-header />
  @endif

  <div class="m-0 p-0" id="appContent">
    @yield('content')
  </div>

  @if (!request('iframe'))
    <x-front-footer />
  @endif

  @if (!request('iframe'))
    @include('components.mini-cart')
  @endif

  @stack('footer')
</body>

</html>
