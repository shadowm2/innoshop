@php
  // بررسی وجود داده‌های محصول
  $hasProducts = false;
  if (!empty($content['screens'])) {
    foreach ($content['screens'] as $screen) {
      if (!empty($screen['products'])) {
        $hasProducts = true;
        break;
      }
    }
  }
  
  // بررسی حالت طراحی
  $isDesignMode = request()->has('design') && request()->get('design') == 1;
@endphp

@if ($hasProducts)
  <section class="module-line">
    <div class="module-product">
      <div class="{{ $content['width_class'] ?? 'container' }}">
        @if(isset($content['title']))
          @php
            $titleValue = is_array($content['title']) ? ($content['title'][front_locale_code()] ?? array_first($content['title'])) : $content['title'];
          @endphp
          @if(!empty($titleValue))
            <div class="module-title-wrap text-center">
              <div class="module-title">{{ $titleValue }}</div>
              @if(isset($content['subtitle']))
                @php
                  $subtitleValue = is_array($content['subtitle']) ? ($content['subtitle'][front_locale_code()] ?? array_first($content['subtitle'])) : $content['subtitle'];
                @endphp
                @if(!empty($subtitleValue))
                  <div class="module-sub-title">{{ $subtitleValue }}</div>
                @endif
              @endif
            </div>
          @endif
        @endif

        <div class="card-slider-container position-relative overflow-hidden">
          <div class="card-slider-wrapper d-flex" style="transition: transform 0.5s ease;">
            @foreach ($content['screens'] as $screen)
              @if (!empty($screen['products']))
                <div class="screen-section flex-fill" data-screen-index="{{ $loop->index }}">
                  <div class="row gx-3 gx-lg-4">
                    @foreach ($screen['products'] as $product)
                      <div class="col-{{ 12 / ($content['items_per_row'] ?? 4) }}">
                        <div class="product-grid-item">
                          <div class="image">
                            <img src="{{ $product['image_big'] ?? plugin_asset('PageBuilder', 'images/placeholder.png') }}"
                              class="img-fluid">
                          </div>
                          <div class="product-item-info">
                            <div class="product-name">
                              {{ $product['name'] ?? '' }}
                            </div>
                            <div class="product-bottom">
                              <div class="product-price">
                                @if (isset($product['origin_price']))
                                  <div class="price-old">{{ $product['origin_price_format'] ?? '' }}</div>
                                @endif
                                <div class="price-new">{{ $product['price_format'] ?? '' }}</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif
            @endforeach
          </div>
          @php
            $screenCount = 0;
            foreach ($content['screens'] as $screen) {
              if (!empty($screen['products'])) {
                $screenCount++;
              }
            }
          @endphp
          @if ($screenCount > 1)
            <div class="slider-controls position-absolute top-50 start-0 end-0 d-flex justify-content-between align-items-center px-4" style="transform: translateY(-50%);">
              <button class="slider-prev btn btn-light rounded-circle border-0 shadow-sm" style="width: 50px; height: 50px; font-size: 20px;">❮</button>
              <button class="slider-next btn btn-light rounded-circle border-0 shadow-sm" style="width: 50px; height: 50px; font-size: 20px;">❯</button>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  <script>
    $(document).ready(function() {
      $('.card-slider-container').each(function() {
        const $container = $(this);
        const $wrapper = $container.find('.card-slider-wrapper');
        const $slides = $container.find('.screen-section');
        const $prevBtn = $container.find('.slider-prev');
        const $nextBtn = $container.find('.slider-next');
        let currentSlide = 0;
        let autoplayInterval;

        function updateSlider() {
          $wrapper.css('transform', `translateX(-${currentSlide * 100}%)`);
        }

        function startAutoplay() {
          if (autoplayInterval) clearInterval(autoplayInterval);
          autoplayInterval = setInterval(() => {
            currentSlide = (currentSlide + 1) % $slides.length;
            updateSlider();
          }, 3000);
        }

        function stopAutoplay() {
          if (autoplayInterval) clearInterval(autoplayInterval);
        }

        if ($slides.length > 1) {
          $prevBtn.on('click', function() {
            currentSlide = (currentSlide - 1 + $slides.length) % $slides.length;
            updateSlider();
          });

          $nextBtn.on('click', function() {
            currentSlide = (currentSlide + 1) % $slides.length;
            updateSlider();
          });

          // بر اساس تنظیمات autoplay تصمیم‌گیری برای چرخش خودکار
          @if (!empty($content['autoplay']) && $content['autoplay'])
            startAutoplay();
          @endif

          $wrapper.on('mouseenter', stopAutoplay).on('mouseleave', function() {
            @if (!empty($content['autoplay']) && $content['autoplay'])
              startAutoplay();
            @endif
          });
        }
      });
    });
  </script>
@elseif ($isDesignMode)
  {{-- پیام خالی بودن داده‌ها در حالت طراحی --}}
  <section class="module-line">
    <div class="module-product">
      <div class="{{ $content['width_class'] ?? 'container' }}">
        @if(isset($content['title']))
          @php
            $titleValue = is_array($content['title']) ? ($content['title'][front_locale_code()] ?? array_first($content['title'])) : $content['title'];
          @endphp
          @if(!empty($titleValue))
            <div class="module-title-wrap text-center">
              <div class="module-title">{{ $titleValue }}</div>
              @if(isset($content['subtitle']))
                @php
                  $subtitleValue = is_array($content['subtitle']) ? ($content['subtitle'][front_locale_code()] ?? array_first($content['subtitle'])) : $content['subtitle'];
                @endphp
                @if(!empty($subtitleValue))
                  <div class="module-sub-title">{{ $subtitleValue }}</div>
                @endif
              @endif
            </div>
          @endif
        @endif
        
        <div class="text-center py-5">
          <div class="d-inline-block">
            <div class="mb-3">
              <i class="el-icon-shopping-cart-2" style="font-size: 48px; color: #dee2e6;"></i>
            </div>
            <div>
              <p class="text-muted mb-1">هیچ داده محصولی موجود نیست</p>
              <p class="text-muted small">لطفاً در ویرایشگر پنل مدیریت محصولات اضافه کنید</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
