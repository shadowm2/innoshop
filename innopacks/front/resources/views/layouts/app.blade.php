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
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}">
  <script src="{{ mix('build/front/js/app.js') }}"></script>
  <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('vendor/layer/3.5.1/layer.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <link rel="stylesheet" href="{{ mix('build/front/css/app.css') }}">
  <!-- Persian font: Vazirmatn -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700&display=swap" rel="stylesheet">

  <style>
    /* Apply Persian font site-wide (includes form controls and buttons) */
    html, body, input, textarea, select, button, .btn, a, p, h1, h2, h3, h4, h5, h6, .nav-link {
      font-family: 'Vazirmatn', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
    }
    /* Improve fallback rendering while the webfont loads */
    @media (prefers-reduced-motion: no-preference) {
      body { font-family: 'Vazirmatn', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif; }
    }
    /* Immediate header layout fix: force desktop header container to a single non-wrapping row */
    .header-desktop > .container.d-flex.justify-content-between.align-items-center {
      display: flex !important;
      flex-wrap: nowrap !important;
      align-items: center !important;
      justify-content: space-between !important;
      gap: 12px;
      min-width: 0;
    }
    .header-desktop .left { display:flex; align-items:center; gap:12px; min-width:0; }
  .header-desktop .left .menu { flex:1 1 auto; min-width:0; margin-left:12px; }
  .header-desktop .left .menu .navbar-nav { display:flex; flex-wrap:nowrap; gap:8px; min-width:0; }
  .header-desktop .left .menu .nav-link { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; min-width:0; }
  .header-desktop .right { display:flex; align-items:center; gap:10px; flex:0 0 auto; }
  /* Prevent overlap: give search a fixed width and don't let it shrink */
  .header-desktop .right .search-group { flex: 0 0 260px; max-width: 35%; min-width: 180px; position: relative; z-index: 5; }
  .header-desktop .right .search-group input { width: 100%; box-sizing: border-box; }
  /* If space is tight, allow menu items to shrink earlier */
  .header-desktop .left .menu { flex: 1 1 40%; }
  </style>
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
