@php
    $categories = $content['categories'] ?? collect();
    $blockId = $module_id ?? uniqid();
@endphp

@if ($categories->count() > 0)
    <section class="module-line">
      <div class="module-category-carousel">
        <div class="container">
          <div class="module-title-wrap">
              @php
                  $titleValue = $content['title'] ?? '';
                  if (is_array($titleValue)) {
                       $titleValue = $titleValue[front_locale_code()] ?? array_first($titleValue);
                  }
                  
                  $subtitleValue = $content['subtitle'] ?? '';
                   if (is_array($subtitleValue)) {
                       $subtitleValue = $subtitleValue[front_locale_code()] ?? array_first($subtitleValue);
                  }
              @endphp
            @if(!empty($titleValue))
            <div class="module-title">{{ $titleValue }}</div>
            @endif
            @if(!empty($subtitleValue))
            <div class="module-sub-title">{{ $subtitleValue }}</div>
            @endif
          </div>
          
          <div class="swiper" id="module-category-swiper-{{ $blockId }}">
            <div class="swiper-wrapper">
              @foreach ($categories as $category)
                <div class="swiper-slide">
                  <a href="{{ $category->url ?? '#' }}" class="category-item">
                    <div class="category-image-wrap">
                      @if(!empty($content['showImage']))
                        @if($category->image)
                          <img src="{{ image_resize($category->image, 200, 200) }}" class="category-image" alt="{{ $category->fallbackName() }}">
                        @else
                          <img src="{{ asset('images/no-image.png') }}" class="category-image" alt="{{ $category->fallbackName() }}">
                        @endif
                      @endif
                    </div>
                    @if(!empty($content['showName']))
                    <div class="category-name">{{ $category->fallbackName() }}</div>
                    @endif
                  </a>
                </div>
              @endforeach
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </section>
    <script>
      new Swiper('#module-category-swiper-{{ $blockId }}', {
        slidesPerView: 2,
        spaceBetween: 15,
        loop: {{ $categories->count() > ($content['columns'] ?? 6) ? 'true' : 'false' }},
        autoplay: {
          delay: {{ $content['autoplaySpeed'] ?? 3000 }},
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        breakpoints: {
          640: {
            slidesPerView: 3,
          },
          768: {
            slidesPerView: 4,
          },
          1024: {
            slidesPerView: {{ $content['columns'] ?? 6 }},
          },
        },
      });
    </script>
@else
    @if(request('design'))
    <div class="module-category-empty">
        <div class="module-category-empty-text">
            <span>لطفاً دسته‌بندی‌ها را برای نمایش در اسلایدر انتخاب کنید</span>
        </div>
    </div>
    @endif
@endif
