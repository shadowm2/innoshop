@hookinsert('layout.footer.top')

<footer id="appFooter" style="background-color: {{ system_setting('footer_bg_color', '#b62323') }};">
  <div class="footer-box">
    <div class="container">
      <div class="footer-top-links">
        <div class="row">
          <div class="col-12 col-md-4 footer-item">
            <div class="about">
              <div class="footer-link-title" style="color: {{system_setting('footer_header_color')}}">
                <span>{{ __('front/common.about_us') }}</span>
                <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
              </div>
              <div class="about-text footer-item-content">
                <p>
                  <b
                    style="color: {{system_setting('footer_color')}}">{{ system_setting_locale('meta_description', '') }}</b>
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-8">
            <div class="row">
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title" style="color: {{system_setting('footer_header_color')}}">
                    <span>{{ __('front/common.products') }}</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    @foreach ($footerMenus['categories'] as $item)
                      <li>
                        <a
                          style="color: {{system_setting('footer_color')}};"
                          href="{{ $item['url'] }}"
                        >
                          {{ $item['name'] }}
                        </a></li>

                    @endforeach
                  </ul>
                </div>
              </div>
              <div class=" col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title" style="color: {{system_setting('footer_header_color')}}">
                    <span>{{ __('front/common.news') }}</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    @foreach ($footerMenus['catalogs'] as $item)
                      <li>
                        <a
                          style="color: {{system_setting('footer_color')}};"
                          href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>

                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title" style="color: {{system_setting('footer_header_color')}}">
                    <span>{{ __('front/common.pages') }}</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    @foreach ($footerMenus['pages'] as $item)
                      <li>
                        <a
                          style="color: {{system_setting('footer_color')}};"
                          href="{{ $item['url'] }}">{{ $item['name'] }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title" style="color: {{system_setting('footer_header_color')}}">
                    <span>{{ __('front/common.specials') }}</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    @foreach ($footerMenus['specials'] as $item)
                      <li><a style="color: {{system_setting('footer_color')}};"
                             href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom-box">
        <div class="row">
          <div class="col-md-6">
            <div class="left-links">
              {!! innoshop_brand_link() !!}
              <!-- Powered By InnoShop {{ innoshop_version() }} -->
              <span class="copyright-text" style="color: {{system_setting('footer_color')}}">
                                <a href="{{ front_route('home.index') }}" class="ms-2"
                                   target="_blank">{{ config('app.name') }}</a>
                                &copy; {{ date('Y') }} تمام حقوق مادی و معنوی سایت محفوظ است
                            </span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="payment-icon">
              <!--<img src="{{ asset('images/demo/payment/1.png') }}" class="img-fluid">-->
              <!--<img src="{{ asset('images/demo/payment/2.png') }}" class="img-fluid">-->
              <!--<img src="{{ asset('images/demo/payment/3.png') }}" class="img-fluid">-->
              <!--<img src="{{ asset('images/demo/payment/4.png') }}" class="img-fluid">-->
              <!--<img src="{{ asset('images/demo/payment/5.png') }}" class="img-fluid">-->
              <a referrerpolicy='origin' target='_blank'
                 href='https://trustseal.enamad.ir/?id=659878&Code=IfDIxnaP2VzCQZBi64mCdFKvaTr8t5Go'>
                <img style="cursor:pointer; min-width: 100px; min-height: 100px" referrerpolicy='origin'
                     src='https://trustseal.enamad.ir/logo.aspx?id=659878&Code=IfDIxnaP2VzCQZBi64mCdFKvaTr8t5Go'
                     alt='' code='IfDIxnaP2VzCQZBi64mCdFKvaTr8t5Go'>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

@hookinsert('layout.footer.bottom')

@if (system_setting('js_code', ''))
  {!! system_setting('js_code', '') !!}
@endif
