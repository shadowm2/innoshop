@if (!empty($content['rows']))
  <section class="module-line py-5">
    <div class="module-four-image">
      <div class="{{ $content['width_class'] ?? 'container' }}">
        @if(isset($content['title']))
          @php
            $titleValue = is_array($content['title']) ? ($content['title'][front_locale_code()] ?? array_first($content['title'])) : $content['title'];
          @endphp
          @if(!empty($titleValue))
            <div class="module-title-wrap text-center mb-4">
              <div class="module-title h3">{{ $titleValue }}</div>
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

        @php
          $hasImages = false;
          foreach ($content['rows'] as $row) {
            if (!empty($row['images']) && count($row['images']) > 0) {
              $hasImages = true;
              break;
            }
          }
        @endphp

        @if ($hasImages)
          @foreach ($content['rows'] as $row)
            <div class="row g-4 mb-4">
              @for ($i = 0; $i < $row['count']; $i++)
                <div class="col">
                  <div class="ratio ratio-1x1 position-relative">
                    @if (!empty($row['images'][$i]))
                      <a href="{{ $row['images'][$i]['link']['value'] ?? 'javascript:void(0)' }}"
                        class="d-block h-100 w-100">
                        <img src="{{ image_resize($row['images'][$i]['image'] ?? '') }}"
                          class="w-100 h-100 object-fit-cover rounded" alt="">
                        @php
                          $descBgColor = $row['images'][$i]['descBgColor'] ?? 'rgba(255,255,255,0.75)';
                          $descTextColor = $row['images'][$i]['descTextColor'] ?? '#222';
                          $descFontSize = $row['images'][$i]['descFontSize'] ?? 14;
                        @endphp
                        @if (isset($row['images'][$i]['description']))
                          @php
                            $descValue = is_array($row['images'][$i]['description']) ? ($row['images'][$i]['description'][front_locale_code()] ?? array_first($row['images'][$i]['description'])) : $row['images'][$i]['description'];
                          @endphp
                          @if(!empty($descValue))
                            <div class="position-absolute bottom-0 start-0 w-100 text-center text-break p-2"
                              style="background: {{ $descBgColor }}; color: {{ $descTextColor }}; font-size: {{ $descFontSize }}px; line-height: 1.4;">
                              {{ $descValue }}
                            </div>
                          @endif
                        @endif
                      </a>
                    @endif
                  </div>
                </div>
              @endfor
            </div>
          @endforeach
        @elseif (request('design'))
          <div class="module-multi-row-images-empty">
            <div class="module-multi-row-images-empty-text">
              <i class="bi bi-grid-3x3"></i>
              <span>هیچ تصویری وجود ندارد، لطفاً محتوای تصویر را پیکربندی کنید</span>
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>
  <style>
    .module-four-image .module-sub-title {
      color: #6c757d !important;
      display: block !important;
      margin-top: 8px;
    }
  </style>
@endif
