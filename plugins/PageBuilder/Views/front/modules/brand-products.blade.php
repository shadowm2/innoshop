@if (!empty($content['products']))
  <section class="module-line">
    <div class="module-brand-products">
      <div class="{{ pb_get_width_class($content['width'] ?? 'wide') }}">
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

        @if (!empty($content['products']) && $content['products']->count() > 0)
          @php
            $columns = $content['columns'] ?? 4;
            $colClass = pb_get_bootstrap_columns($columns);
          @endphp
          <div class="row gx-3 gx-lg-4">
            @foreach ($content['products'] as $product)
              <div class="{{ $colClass }}">
                @include('shared.product', ['product' => $product])
              </div>
            @endforeach
          </div>
        @elseif (request('design'))
          <div class="module-brand-products-empty">
            <div class="module-brand-products-empty-text">
              <i class="bi bi-award"></i>
              <span>هیچ محصولی موجود نیست، لطفاً برند را پیکربندی کنید</span>
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>
@endif 