@hookinsert('layout.header.top')
<style>
  .dropdown-menu .dropdown-item {
    direction: rtl !important;
    text-align: right !important;
  }
</style>

<header id="appHeader">
  <div class="header-top">
    <div class="container d-flex justify-content-between align-items-center">
      {{-- <div class="language-switch d-flex align-items-center">
        <div class="dropdown">
          <a class="btn dropdown-toggle" href="javascript:void(0)">
            <img src="{{ asset($currentLocale->image) }}" class="img-fluid"> {{ $currentLocale->name }}
          </a>
          <div class="dropdown-menu">
            @foreach (locales() as $locale)
              <a class="dropdown-item d-flex" href="{{ front_route('locales.switch', ['code' => $locale->code]) }}">
                <div class="wh-20 me-2"><img src="{{ image_origin($locale['image']) }}" class="img-fluid border">
                </div>
                {{ $locale->name }}
              </a>
            @endforeach
          </div>
        </div>
        <div class="dropdown ms-4">
          <a class="btn dropdown-toggle" href="javascript:void(0)">
            {{ current_currency()->name }}
          </a>
          <div class="dropdown-menu">
            @foreach (currencies() as $currency)
              <a class="dropdown-item" href="{{ front_route('currencies.switch', ['code' => $currency->code]) }}">
                {{ $currency->name }} ({{ $currency->symbol_left }})
              </a>
            @endforeach
          </div>
        </div>
        @hookinsert('layouts.header.currency.after')
      </div> --}}

      <div class="top-info">
        @hookinsert('layouts.header.news.before')
        <a href="{{ front_route('articles.index') }}">{{ trans('front/common.telephone') }}</a>

        @hookupdate('layouts.header.telephone')
        @if (system_setting('telephone'))
          <a href="tel:{{ system_setting('telephone') }}">
            <span><i class="bi bi-telephone-outbound"></i> {{ system_setting('telephone') }}</span>
          </a>
        @endif
        @endhookupdate
      </div>
    </div>
  </div>
  <div class="header-desktop">
    <div class="container-fluid d-flex justify-content-between align-items-center" style="flex-wrap:nowrap;">
      <div class="left">
        <h1 class="logo">
          <a href="{{ front_route('home.index') }}">
            <img src="{{ image_origin(system_setting('front_logo', 'images/logo.svg')) }}" class="img-fluid">
          </a>
        </h1>
        <div class="menu">
          <nav class="navbar navbar-expand-md navbar-light">
            <ul class="navbar-nav" style="display:flex;flex-wrap:nowrap;align-items:center;">
              <li class="nav-item">
                <a class="nav-link" aria-current="page"
                  href="{{ front_route('home.index') }}">{{ __('front/common.home') }}</a>
              </li>

              @hookupdate('layouts.header.menu.pc')
                @foreach ($headerMenus as $menu)
                  @if ($menu['children'] ?? [])
                    <li class="nav-item">
                      <div class="dropdown">
                        @if ($menu['name'])
                          <a class="nav-link {{ equal_url($menu['url']) ? 'active' : '' }}"
                            href="{{ $menu['url'] }}">{{ $menu['name'] }}</a>
                        @endif
                        <ul class="dropdown-menu">
                          @foreach ($menu['children'] as $child)
                            @if ($child['name'])
                              <li><a class="dropdown-item" href="{{ $child['url'] }}">{{ $child['name'] }}</a></li>
                            @endif
                          @endforeach
                        </ul>
                      </div>
                    </li>
                  @else
                    @if ($menu['name'])
                      <li class="nav-item">
                        <a class="nav-link {{ equal_url($menu['url']) ? 'active' : '' }}"
                          href="{{ $menu['url'] }}">{{ $menu['name'] }}</a>
                      </li>
                    @endif
                  @endif
                @endforeach
              @endhookupdate
            </ul>
          </nav>
        </div>
      </div>
      <div class="right">
        <form action="{{ front_route('products.index') }}" method="get" class="search-group">
          <input type="text" class="form-control" name="keyword" placeholder="{{ __('front/common.search') }}"
            value="{{ request('keyword') }}">
          <button type="submit" class="btn"><i class="bi bi-search"></i></button>
        </form>
        <div class="icons">
          <div class="item">
            <div class="dropdown account-icon">
              <a class="btn dropdown-toggle px-0" href="{{ front_route('account.index') }}">
                <img src="{{ asset('images/icons/account.svg') }}" class="img-fluid">
              </a>

              <div class="dropdown-menu dropdown-menu-end">
                @if ($customer)
                  <a href="{{ front_route('account.index') }}"
                    class="dropdown-item">{{ __('front/account.account') }}</a>
                  <a href="{{ front_route('account.orders.index') }}"
                    class="dropdown-item">{{ __('front/account.orders') }}</a>
                  <a href="{{ front_route('account.favorites.index') }}"
                    class="dropdown-item">{{ __('front/account.favorites') }}</a>
                  <a href="{{ front_route('account.logout') }}"
                    class="dropdown-item">{{ __('front/account.logout') }}</a>
                @else
                  <a href="{{ front_route('login.index') }}" class="dropdown-item">{{ __('front/common.login') }}</a>
                  <a href="{{ front_route('register.index') }}"
                    class="dropdown-item">{{ __('front/common.register') }}</a>
                @endif
              </div>
            </div>
          </div>
          <div class="item">
            <a href="{{ account_route('favorites.index') }}"><img src="{{ asset('images/icons/love.svg') }}"
                class="img-fluid"><span class="icon-quantity">{{ $favTotal }}</span></a>
          </div>
          <div class="item">
            <a href="javascript:void(0)" class="header-cart-icon" data-bs-toggle="offcanvas" data-bs-target="#miniCart"
              aria-controls="miniCart">
              <img src="{{ asset('images/icons/cart.svg') }}" class="img-fluid">
              <span class="icon-quantity">0</span>
            </a>
          </div>
          @hookinsert('layouts.header.cart.after')
        </div>
      </div>
    </div>
  </div>
  <div class="header-mobile">
    <div class="mobile-header-container">
      <div style="display: flex; flex-direction: row">
        <div class="mobile-menu-toggle" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas">
          <i class="bi bi-list"></i>
        </div>
        
        <div class="mobile-logo">
          <a href="{{ front_route('home.index') }}">
            <img src="{{ image_origin(system_setting('front_logo', 'images/logo.svg')) }}" alt="Logo">
          </a>
        </div>
      </div>
      
      <div class="mobile-icons">
        <a href="{{ front_route('account.index') }}" class="mobile-icon">
          <i class="bi bi-person"></i>
        </a>
        <a href="{{ front_route('carts.index') }}" class="mobile-icon">
          <i class="bi bi-cart"></i>
          <span class="cart-badge">0</span>
        </a>
      </div>
    </div>
    
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenuOffcanvas">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">{{ __('front/common.menu') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <div class="mobile-menu-content">
          <div class="mobile-search">
            <form action="{{ front_route('products.index') }}" method="get">
              <div class="input-group">
                <input type="text" class="form-control" name="keyword" placeholder="{{ __('front/common.search') }}">
                <button class="btn btn-outline-primary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>
          </div>
          
          <nav class="mobile-nav">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ equal_route_name('home.index') ? 'active' : '' }}" href="{{ front_route('home.index') }}">
                  <i class="bi bi-house-door me-2"></i>
                  {{ __('front/common.home') }}
                </a>
              </li>
              
              @hookupdate('layouts.header.menu.mobile')
                @foreach ($headerMenus as $menu)
                  @if ($menu['name'])
                    <li class="nav-item">
                      <a class="nav-link" href="{{ $menu['url'] }}">
                        @if (isset($menu['icon']) && $menu['icon'])
                          <i class="{{ $menu['icon'] }} me-2"></i>
                        @else
                          <i class="bi bi-grid me-2"></i>
                        @endif
                        {{ $menu['name'] }}
                      </a>
                    </li>
                  @endif
                @endforeach
              @endhookupdate
              
              @if ($customer)
                <li class="nav-item">
                  <a class="nav-link" href="{{ front_route('account.index') }}">
                    <i class="bi bi-person me-2"></i>
                    {{ __('front/account.account') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ front_route('account.orders.index') }}">
                    <i class="bi bi-clipboard-check me-2"></i>
                    {{ __('front/account.orders') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ front_route('account.favorites.index') }}">
                    <i class="bi bi-heart me-2"></i>
                    {{ __('front/account.favorites') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ front_route('account.logout') }}">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    {{ __('front/account.logout') }}
                  </a>
                </li>
              @else
                <li class="nav-item">
                  <a class="nav-link" href="{{ front_route('login.index') }}">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    {{ __('front/common.login') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ front_route('register.index') }}">
                    <i class="bi bi-person-plus me-2"></i>
                    {{ __('front/common.register') }}
                  </a>
                </li>
              @endif
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</header>

@hookinsert('layout.header.bottom')